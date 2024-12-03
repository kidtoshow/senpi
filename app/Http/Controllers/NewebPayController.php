<?php

namespace App\Http\Controllers;

use App\PayOrder;
use App\PayProduct;
use App\Services\NewebPayService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewebPayController extends Controller
{
    protected $newebPayService;

    public function __construct(NewebPayService $newebPayService){
        $this->newebPayService = $newebPayService;
    }

    public function createPaymentForm($id)
    {
        $product = PayProduct::find($id);
        if(is_null($product)) {
            return back()->with(['message' => '產品錯誤請重新選擇']);
        }

        if(!preg_match("/^[0][1-9]{1,3}[0-9]{6,8}$/", auth()->user()->phone) ||
            strlen(auth()->user()->phone) < 10 || strlen(auth()->user()->phone) > 11) {
            return back()->with(['message' => '電話號碼格式有誤，請更新電話後再進行操作']);
        }

        $order = PayOrder::create([
            'user_id' => auth()->user()->id,
            'pay_product_id' => $id,
            'is_sandbox' => env('NEWEBPAY_TEST_MODE')
        ]);

        $sn = "SN".date('YmdHis').$order->id;
        $order->update([
            'transactionId' => $sn
        ]);

        $form = $this->newebPayService->generatePaymentForm($order);

        return view('newebpay.form', ['form' => $form]);
    }

    public function handleNewebPaymentCallback(Request $request)
    {
        $parameters = $request->all();

        $service = new NewebPayService();

        $result = json_decode($service->decodeResult($parameters['TradeInfo']), true);

        // 根據回傳的資料更新訂單狀態
        if ($result['Status'] === 'SUCCESS') {
            // 支付成功，更新訂單狀態，
            $order = PayOrder::where('transactionId', $result['Result']['MerchantOrderNo'])->get();
            if(!is_null($order)) {
                $order->first()->update([
                    'order_status' => 4
                ]);
            }
            $user = User::find($order->first()->user_id);
            if($user->expired >= now()){
                $add_time = Carbon::parse($user->expired)->addMonth($order->first()->product->pay_time);
                $remark = $user->expired . '->' .$add_time;
                $user->update([
                    'role' => 'vip',
                    'expired' => $add_time
                ]);
                $order->first()->update([
                    'remark' => $remark
                ]);
            } else {
                $add_time = now()->addMonth($order->first()->product->pay_time);
                $remark = $user->expired . '->' .$add_time;
                $user->update([
                    'role' => 'vip',
                    'expired' => $add_time
                ]);
                $order->first()->update([
                    'remark' => $remark
                ]);
            }
        } else {
            // 支付失敗
            $order = PayOrder::where('transactionId', $result['Result']['MerchantTradeNo'])->get();
            if(is_null($order)){
                return route('pay-product-list')->with(['message' =>'未查詢到'.$result['Result']['MerchantTradeNo']]);
            }
            $order->first()->update([
                'order_status' => 3
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function returnUrl(Request $request)
    {
        logger($request->all());
        return redirect(route('pay-order-list'));
    }
}

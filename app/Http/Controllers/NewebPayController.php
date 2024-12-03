<?php

namespace App\Http\Controllers;

use App\PayOrder;
use App\PayProduct;
use App\Services\NewebPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        // 檢查簽名是否正確
        $checkValue = $parameters['CheckValue'];
        unset($parameters['CheckValue']);  // 移除原有的 CheckValue 參數

        // 重新生成 CheckValue 並比對
        $service = new NewebPayService();
        $generatedCheckValue = $service->generateCheckValue($parameters);

        if ($checkValue !== $generatedCheckValue) {
            Log::error('NewebPay - CheckValue mismatch!');
            return response()->json(['error' => 'Invalid response from payment gateway.']);
        }

        // 根據回傳的資料更新訂單狀態
        if ($parameters['TradeStatus'] === '1') {
            // 支付成功，更新訂單狀態，
            logger('藍新交易完成');
        } else {
            // 支付失敗
            logger('藍新交易失敗');
        }

        return response()->json(['status' => 'success']);
    }

    public function returnUrl(Request $request)
    {
        logger($request->all());
    }
}

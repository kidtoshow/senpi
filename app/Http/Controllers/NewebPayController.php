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
            //電子發票
            if(!env('NEWEBPAY_TEST_MODE')) {
                $post_data_array = array(
                    //post_data 欄位資料
                    'RespondType' => 'JSON',
                    'Version' => '1.5',
                    'TimeStamp' => time(), //請以 time() 格式
                    'TransNum' => '',
                    'MerchantOrderNo' => $order->first()->transactionId,
                    'BuyerName' => $order->first()->user->name,
                    'BuyerAddress' => $order->first()->user->address,
                    'BuyerEmail' => $order->first()->user->email,
                    'Category' => 'B2C',
                    'TaxType' => '1',
                    'TaxRate' => '5',
                    'Amt' => $order->first()->product->price*0.95,
                    'TaxAmt' => $order->first()->product->price*0.05,
                    'TotalAmt' => $order->first()->product->price,
                    'CarrierType' => '',
                    'CarrierNum' => rawurlencode(''),
                    'LoveCode' => '',
                    'PrintFlag' => 'Y',
                    'ItemName' => $order->first()->product->name,
                    'ItemCount' => '1',
                    'ItemUnit' => '份',
                    'ItemPrice' => $order->first()->product->price,
                    'ItemAmt' => $order->first()->product->price,
                    'Comment' => '',
                    'CreateStatusTime' => '',
                    'Status' => '1'
                );
                $post_data_str = http_build_query($post_data_array);
                $post_data = trim(bin2hex(openssl_encrypt($this->addpadding($post_data_str), 'AES-256-CBC', env('INV_HASH_KEY'), OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, env('INV_HASH_IV'))));
                $url = 'https://inv.ezpay.com.tw/Api/invoice_issue';
                $MerchantID = env('EZPAY_MERCHANT_ID');
                $transaction_data_array = array(
                    'MerchantID_' => $MerchantID,
                    'PostData_' => $post_data
                );
                $transaction_data_str = http_build_query($transaction_data_array);
                $result = $this->curl_work($url, $transaction_data_str);
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

    protected function addpadding($string, $blocksize = 32)
    {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    protected function curl_work($url = '', $parameter = '')
    {
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'ezPay',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POST => '1',
            CURLOPT_POSTFIELDS => $parameter
        );
        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        $result = curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_errno($ch);
        curl_close($ch);
        $return_info = array(
            'url' => $url,
            'sent_parameter' => $parameter,
            'http_status' => $retcode,
            'curl_error_no' => $curl_error,
            'web_info' => $result
        );
        return $return_info;
    }
}

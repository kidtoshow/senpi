<?php

namespace App\Services;

class NewebPayService
{
    protected $merchantId;
    protected $hashKey;
    protected $hashIv;
    protected $testMode;
    protected $notifyUrl;
    protected $returnUrl;

    public function __construct(){
        $this->merchantId = env('NEWEBPAY_TEST_MODE') ? env('NEWEBPAY_TEST_MERCHANT_ID') :env('NEWEBPAY_MERCHANT_ID');
        $this->hashKey = env('NEWEBPAY_TEST_MODE') ? env('NEWEBPAY_TEST_HASH_KEY') :env('NEWEBPAY_HASH_KEY');
        $this->hashIv = env('NEWEBPAY_TEST_MODE') ? env('NEWEBPAY_TEST_HASH_IV') :env('NEWEBPAY_HASH_IV');
        $this->testMode = env('NEWEBPAY_TEST_MODE');
        $this->notifyUrl = route('newebpay-notify-url');
        $this->returnUrl = route('newebpay-return-url');
    }

    public function generatePaymentForm($order)
    {
        // 產生藍新金流的參數
        $parameters = [
            'MerchantID' => $this->merchantId,
            'TimeStamp'=>time(),
            'Version'=>'2.2',
            'RespondType'=>'JSON',
            'MerchantOrderNo' => $order->transactionId,
            'Amt' => $order->product->price,
            'ReturnURL' => $this->returnUrl,
            'NotifyURL' => $this->notifyUrl,
            'ItemDesc' => strip_tags($order->product->description),
        ];

        // 產生簽名
        $checkValue = $this->generateCheckValue($parameters);

        return $this->buildForm($checkValue);
    }

    public function generateCheckValue($parameters)
    {
        // 對藍新金流參數進行加密
        $data = http_build_query($parameters);
        $edata = bin2hex(openssl_encrypt($data, 'AES-256-CBC', $this->hashKey, OPENSSL_RAW_DATA, $this->hashIv));

        $hashs = 'HashKey='.$this->hashKey .'&'. $edata .'&HashIV='. $this->hashIv;
        $hash =  strtoupper(hash('sha256',$hashs));

        return ['TradeInfo' => $edata, 'TradeSha' => $hash];
    }

    public function buildForm($parameters)
    {
        if($this->testMode){
            $formHtml = '<form action="https://ccore.newebpay.com/MPG/mpg_gateway" method="POST" name="newebform">';
            $formHtml .= '<input type="hidden" name="MerchantID" value="'.$this->merchantId.'">';
            $formHtml .= '<input type="hidden" name="Version" value="2.2">';
            $formHtml .= '<input type="hidden" name="TradeInfo" value="'.$parameters['TradeInfo'].'">';
            $formHtml .= '<input type="hidden" name="TradeSha" value="'.$parameters['TradeSha'].'">';
            $formHtml .= '<input type="submit" value="前往藍新金流" style="visibility: hidden;">';
            $formHtml .= '</form>';
        } else {
            $formHtml = '<form action="https://core.newebpay.com/MPG/mpg_gateway" method="POST" name="newebform">';
            $formHtml .= '<input readonly name="MerchantID" value="'.$this->merchantId.'">';
            $formHtml .= '<input readonly name="Version" value="2.2">';
            $formHtml .= '<input readonly name="TradeInfo" value="'.$parameters['TradeInfo'].'">';
            $formHtml .= '<input readonly name="TradeSha" value="'.$parameters['TradeSha'].'">';
            $formHtml .= '<input type="submit" value="前往藍新金流" style="visibility: hidden;">';
            $formHtml .= '</form>';
        }

        return $formHtml;
    }

    public function decodeResult($data1)
    {
        logger($data1);
        $edata1=$this->strippadding(openssl_decrypt(hex2bin($data1), "AES-256-CBC", $this->hashKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $this->hashIv));

        return $edata1;
    }

    protected function strippadding($string) {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }}
}
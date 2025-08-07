<?php
require 'Signature.php';
include "ConstantV2.php";

class PayInRequestDemo
{
    /**
     * @throws Exception
     */
    public function doTransaction($env, $merchant_id, $merchant_secret,
                                  $private_key, $payment_method, $pix_account,
                                  $amount)
    {

        //production
        $requestPath = "";
        if ($env == "production") {
            $requestPath = BASE_URL . "/v2.0/transaction/pay-in";
        }
        if ($env == "sandbox") {
            $requestPath = BASE_URL_SANDBOX . "/v2.0/transaction/pay-in";
        }


        //get time
        $currentTime = new DateTime('now', new DateTimeZone('UTC'));
        $currentTime->setTimezone(new DateTimeZone('Asia/Bangkok'));
        $timestamp = $currentTime->format('Y-m-d\TH:i:sP');
        $signUtils = new Signature();

        echo "timestamp=" . $timestamp . PHP_EOL;

        //generate parameter
        $merchantOrderNo = str_replace("-", "", $merchant_id) . $signUtils->uuidv4();
        $purpose = "Purpose For Transaction from PHP SDK";

        //$moneyReq
        $moneyReq = array(
            'currency' => CURRENCY_BRL,
            'amount' => $amount
        );

        //$merchantReq
        $merchantReq = array(
            'merchantId' => $merchant_id,
            'merchantName' => ''
        );

        //$payer_req
        $payer_req = array(
            'pixAccount' => $pix_account
        );


        //$payinReq
        $payinReq = array(
            'orderNo' => substr($merchantOrderNo, 0, 32),
            'purpose' => $purpose,
            'money' => $moneyReq,
            'merchant' => $merchantReq,
            'payer' => $payer_req,
            'paymentMethod' => $payment_method,
        );

        //json
        $jsonString = $signUtils->minify($payinReq);
        echo "jsonString=" . $jsonString . PHP_EOL;

        //build
        $stringToSign = $timestamp . "|" . $merchant_secret . "|" . $jsonString;
        echo "stringToSign=" . $stringToSign . PHP_EOL;

        //********** begin signature ***************
        $signatureValue = $signUtils->sha256RsaSignature($stringToSign, $private_key);
        echo "signatureValue=" . $signatureValue . PHP_EOL;
        echo "request path=" . $requestPath . PHP_EOL;
        //********** end signature ***************


        //********** begin post ***************

        // Create a cURL handle
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $requestPath);  // API URL
        curl_setopt($ch, CURLOPT_POST, true);  // POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);  // JSON Data
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-TIMESTAMP: ' . $timestamp,
            'X-SIGNATURE: ' . $signatureValue,
            'X-PARTNER-ID: ' . $merchant_id,
        ));

        // Execute the request and get the response
        $response = curl_exec($ch);
        echo $response . PHP_EOL;

        // Check for errors
        if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            // Process response result
            echo PHP_EOL;
            echo "response=" . $response . PHP_EOL;
        }

        // Close cURL handle
        curl_close($ch);

        echo "=====>  end " . PHP_EOL;
    }

}

$obj = new PayInRequestDemo();
try {
    $obj->doTransaction("sandbox", "", "", "", "", "", "");
} catch (Exception $e) {
    echo 'do transaction error'. $e;
}



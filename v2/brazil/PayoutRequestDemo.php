<?php
require 'Signature.php';
include "ConstantV2.php";


class PayoutRequestDemo
{

    public function doDisbursement($env, $merchant_id, $merchant_secret,
                                   $private_key, $payment_method, $cash_account,
                                   $tax_number, $amount)
    {
        //production
        $requestPath = "";
        if ($env == "production") {
            $requestPath = BASE_URL . "/v2.0/disbursement/pay-out";
        }
        if ($env == "sandbox") {
            $requestPath = BASE_URL_SANDBOX . "/v2.0/disbursement/pay-out";
        }

        echo "=====>TheSmilePay Payout" . PHP_EOL;

        //get time
        $currentTime = new DateTime('now', new DateTimeZone('UTC'));
        $currentTime->setTimezone(new DateTimeZone('Asia/Bangkok'));
        $timestamp = $currentTime->format('Y-m-d\TH:i:sP');

        $signUtils = new Signature();

        //generate parameter
        // just for case. length less than 32
        $merchantOrderNo = str_replace("sandbox-", "S", $merchant_id) . $signUtils->uuidv4();

        $purpose = "Purpose For Disbursement from PHP SDK";

        $paymentMethod = $payment_method;

        //$moneyReq
        $moneyReq = array(
            'currency' => CURRENCY_BRL,
            'amount' => $amount
        );

        //$merchantReq
        $merchantReq = array(
            'merchantId' => $merchant_id
        );

        $receiver_Req = array(
            'taxNumber' => $tax_number
        );
        //$pay out Req
        $payOutReq = array(
            'orderNo' => substr($merchantOrderNo, 0, 32),
            'purpose' => $purpose,
            'money' => $moneyReq,
            'merchant' => $merchantReq,
            'paymentMethod' => $paymentMethod,
            'cashAccount' => $cash_account,
            'receiver' => $receiver_Req,

        );

        //json
        $jsonString = json_encode($payOutReq);
        echo "jsonString=" . $jsonString . PHP_EOL;

        //build
        $stringToSign = $timestamp . "|" . $merchant_secret . "|" . $jsonString;
        echo "stringToSign=" . $stringToSign . PHP_EOL;


        //********** begin signature ***************
        $signatureValue = $signUtils->sha256RsaSignature($stringToSign, $private_key);
        echo "signatureValue=" . $signatureValue . PHP_EOL;
        echo "request path =" . $requestPath . PHP_EOL;
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

        echo "=====> end " . PHP_EOL;

    }
}

$obj = new PayoutRequestDemo();
try {
    $obj->doDisbursement("sandbox", "", "", "", "", "", "", "");
} catch (Exception $e) {
    echo 'doDisbursement error' . $e;
}

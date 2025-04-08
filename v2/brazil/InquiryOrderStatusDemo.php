<?php
require 'Signature.php';
include "ConstantV2.php";

class InquiryOrderStatusDemo
{

    public function doInquiryOrderStatus($env, $merchant_id, $merchant_secret, $private_key, $trade_type, $trade_no, $order_no)
    {
        //production
        $requestPath = "";
        if ($env == "production") {
            $requestPath = BASE_URL . "/v2.0/inquiry-status";
        }
        if ($env == "sandbox") {
            $requestPath = BASE_URL_SANDBOX . "/v2.0/inquiry-status";
        }

        //get time
        $currentTime = new DateTime('now', new DateTimeZone('UTC'));
        $currentTime->setTimezone(new DateTimeZone('Asia/Bangkok'));
        $timestamp = $currentTime->format('Y-m-d\TH:i:sP');

        echo "timestamp=" . $timestamp . PHP_EOL;

        //generate parameter $inquiryOrderStatusReq
        $inquiryOrderStatusReq = array(
            'tradeType' => $trade_type,
            'tradeNo' => $trade_no,
            'orderNo' => $order_no
        );
        $signUtils = new Signature();

        //json
        $jsonString = $signUtils->minify($inquiryOrderStatusReq);
        echo "request parameters jsonString=" . $jsonString . PHP_EOL;

        //build
        $stringToSign = $timestamp . "|" . $merchant_secret . "|" . $jsonString;
        echo "before sign stringToSign=" . $stringToSign . PHP_EOL;

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

$obj = new InquiryOrderStatusDemo();
$obj -> doInquiryOrderStatus("sandbox", "", "", "", "", "", "");


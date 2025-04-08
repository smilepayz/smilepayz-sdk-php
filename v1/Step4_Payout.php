<?php
include "Constant.php";

echo "=====> step4 : TheSmilePay Payout" . PHP_EOL;

//get accessToken.  from step2
$accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYmYiOjE3MDE3NTk1NDIsImV4cCI6MTcwMTc2MDQ0MiwiaWF0IjoxNzAxNzU5NTQyLCJNRVJDSEFOVF9JRCI6InNhbmRib3gtMTAwMDEifQ.pyCMUmOcQjAGya9weWW05o-GfV4WNxxUmQciNj8qZ4k';

//url
$endPointUlr = PAY_OUT_API;
$url = BASE_SANDBOX_URL . $endPointUlr;

//get time
$timestamp = "2023-12-05T10:07:46+07:00";

//get merchantId from merchant platform
$partnerId = MERCHANT_ID;

//generate parameter
$merchantOrderNo = "D_" . time();
$purpose = "Purpose For Disbursement from PHP SDK";
$paymentMethod = "BCA";
$cashAccount = "23472432978";
$area = '10';

//$moneyReq
$moneyReq = array(
    'currency' => 'IDR',
    'amount' => 10000
);

//$merchantReq
$merchantReq = array(
    'merchantId' => $partnerId
);

//$payerReq
$payerReq = array(
    'name' => "Jef-fer",
    'phone' => "82-3473829260",
    'address' => "Jalan Pantai Mutiara TG6, Pluit, Jakarta",
    'email' => "jef.gt@gmail.com",
);

//$receiverReq
$receiverReq = array(
    'name' => "Viva in",
    'phone' => "82-3473233732",
    'address' => "Jl. Pluit Karang Ayu 1 No.B1 Pluit",
    'email' => "Viva@mir.com",
);

//$itemDetailReq
$itemDetailReq = array(
    'name' => "mac A1",
    'quantity' => 1,
    'price' => 100000
);

//$billingAddress
$billingAddress = array(
    'countryCode' => "Indonesia",
    'city' => "jakarta",
    'address' => "Jl. Pluit Karang Ayu 1 No.B1 Pluit",
    'phone' => "82-3473233732",
    'postalCode' => "14450"
);

//$shippingAddress
$shippingAddress = array(
    'countryCode' => "Indonesia",
    'city' => "jakarta",
    'address' => "Jl. Pluit Karang Ayu 1 No.B1 Pluit",
    'phone' => "82-3473233732",
    'postalCode' => "14450"
);

//$payinReq
$payinReq = array(
    'orderNo' => $merchantOrderNo,
    'purpose' => $purpose,
    'productDetail' => "Product details",
    'additionalParam' => "other descriptions",
    'itemDetailList' => array($itemDetailReq),
    'billingAddress' => $billingAddress,
    'shippingAddress' => $shippingAddress,
    'money' => $moneyReq,
    'merchant' => $merchantReq,
    'paymentMethod' => $paymentMethod,
    'cashAccount' => $cashAccount,
    'payer' => $payerReq,
    'receiver' => $receiverReq,
    'area' => $area,

);

//json
$jsonString = json_encode($payinReq);
echo "jsonString=" . $jsonString . PHP_EOL;

//sh256 -> hex
$hash = hash('sha256', $jsonString, true);
$hex = bin2hex($hash);
echo "hex=" . $hex . PHP_EOL;

//toLowerCase
$lowercase = strtolower($hex);

//build
$stringToSign = "POST" . ":" . $endPointUlr . ":" . $accessToken . ":" . $lowercase . ":" . $timestamp;
echo "stringToSign=" . $stringToSign . PHP_EOL;

//signature
$sha512 = hash_hmac("sha512", $stringToSign, MERCHANT_SECRET, true);
$signature = base64_encode($sha512);
echo "signature=" . $signature . PHP_EOL;

//********** begin post ***************

// Create a cURL handle
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);  // API URL
curl_setopt($ch, CURLOPT_POST, true);  // POST
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);  // JSON Data
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken,
    'X-TIMESTAMP: ' . $timestamp,
    'X-SIGNATURE: ' . $signature,
    'ORIGIN: www.yourDomain.com',
    'X-PARTNER-ID: ' . $partnerId,
    'X-EXTERNAL-ID: 123729342472347234236',
    'CHANNEL-ID: 95221',
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

echo "=====> Now. You get the AccessToken. So you can access other TheSmilePay API" . PHP_EOL;
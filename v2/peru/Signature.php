<?php

class Signature
{

    public function minify($payinReq){
        //minify
        $jsonString = json_encode($payinReq);
        echo "jsonString=" . $jsonString . PHP_EOL;
        return $jsonString;
    }

    public function sha256RsaSignature($signToStr,$privateKey){
        $privateKeyPem = chunk_split($privateKey, 64);
        $privateKeyPem = "-----BEGIN PRIVATE KEY-----\n" . $privateKeyPem . "-----END PRIVATE KEY-----\n";
        $r = openssl_sign($signToStr, $signature, $privateKeyPem, OPENSSL_ALGO_SHA256);
        $signatureValue = base64_encode($signature) ;
        echo "signatureValue=" . $signatureValue . PHP_EOL;
        return $signatureValue;
    }

    function checkSha256RsaSignature($data, $publicKeyDer, $signature) {
        $publicKey = openssl_pkey_get_public('-----BEGIN PUBLIC KEY-----' . "\n" .
            chunk_split($publicKeyDer, 64, "\n") .
            '-----END PUBLIC KEY-----');
        if ($publicKey === false) {
            throw new Exception("Failed to get public key");
        }
        $result = openssl_verify($data, base64_decode($signature), $publicKey, OPENSSL_ALGO_SHA256);
        return $result;
    }

    function uuidv4() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); //  0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); //  10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}


$privateKeyStr = "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC3LbmfPhjGXJ+a6NVKyRWEfCpsKfl9UFnMRltNosJv+7qd6OUK3t7Q8fKX8rxuJBeXLLWrOZvjoGlP3ybvvhUSGKH+BLcN1k2eJbcKuThvXvKQvd7pXolY91gkF8V78FX+TKegZupbeji0XUGXCBNyShocYM6Cvailf0Iyv49dcktJmi4drBKfgj5l4HUY9TaDuCZOrhvFZfZZxBK1zkm72k0ZLfqTGmG8O2tsByndCTH2aPLT9odR8/O4qfoTG+vV9HivIKKOI2h0kZfQBOqWD4/ofwu9PNoRRzGgzfRpF3GhnKa3bRVSpCUuBtHfotQfFxbjaDk0s3K5BhQE7HxzAgMBAAECggEARHhaBxUeC595pVzcxVyOp3wGG3JBKL9NIZc277kj9tngcsAoRTzziqS1qmh4WK8zBjYXHg6ln5tJYiqmkjy6AY6llp7KkeiGENRGLEL5vl9+Se4/EXpd2pxyHOOp1N8MNccPbVyqw1DXO0wUhVDme/UI94yUBLjB/kKoSvHhs+qwJ8cz9C8sF3Zs/zF6Te/f+Z+HrIbVj4vlx6DYBs3pWe7J+XYg3XXpbvIBJVTN0lreQAjtopic0F7o1EULnllJmOqy+kiRMuSi5ESrWFOnuCrY0iz/C8LJKlqWa3d+1jVLPvKYucXvddYrwjyu8kYHZAenKWKkLPlQkQxGUFcX8QKBgQDYSCsgg7tDlXTw1P9Z2BhkVo1ugYWA1FcxqTY2sTOMOwCTt3QZAFEqofbNvdjZbk7vu8gh5LyxbWAr/sNqOXH5915a6DZKBGl+qBTH2TZZKmhCUWlmn8T7ySYclfsgIZsUxHaDfY+otiXGtNegSX9US9/AFVSMdiQBCmr5/i48mQKBgQDY0U5+MDl6GnbDH/hCT+YMq/m5W58m7ehJfG6jPtLQkPPvMq2Oj5HUeXx4vDdUxzaRlC9fICwe2KgKiGYpJsRPte6JfO6te7wsO2lDk0oBiw+jewm4CwZ5KeDYyReha8Hc2H1j5hllVx5DIZiage2ZswS5+kCNgzf4QbdAOd886wKBgAo5TyCYWY/WTtLbnr6GgpCrrr/ci40NfJmyYAex1Lf6Sgqxj2FnLG8RfPM42DlfB4g5njpL78eLXhJ2VpJ86LBiSymM9JQHJV2BYIoZ8IHCiW8pHgxl3Q/x8EVFqbtZG1Wd++Q3WUUmZx6/ibnf/47ij08rMvX417bc4TW0GEdxAoGAPX3nUBynQH0e76oyg8QbT766nZphoe3ZcnYK/tuDeMmTlWR/Gq6XQnaOGcPvwWiajmFDqiv6t2jlB8+1gbhP9vd3RqEbJDKypKzY5uRwGc3xyoDLudnOpTB+Z51oyUxBeDwiG+IXk8lIeOufVzrAQ1YlYgWap0fu6MbijSGcsa8CgYEA0OolBxRKdBSxmwMbXDocg5HtHd15UgJdlgL9GFjDZPisUvM7LWK97E5QPhY2IEIcv0EW9jM62bc1uPMhwDuN1dzmLafQIivGsIj5qUy18CoE4KJHsTeKLeHkrd6/nBd4da4A37+ksJ1t/sgZpjl40ShrxTV+OtzzY/kuQ4Uqc9g=";
$publicKeyStr = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAty25nz4YxlyfmujVSskVhHwqbCn5fVBZzEZbTaLCb/u6nejlCt7e0PHyl/K8biQXlyy1qzmb46BpT98m774VEhih/gS3DdZNniW3Crk4b17ykL3e6V6JWPdYJBfFe/BV/kynoGbqW3o4tF1BlwgTckoaHGDOgr2opX9CMr+PXXJLSZouHawSn4I+ZeB1GPU2g7gmTq4bxWX2WcQStc5Ju9pNGS36kxphvDtrbAcp3Qkx9mjy0/aHUfPzuKn6Exvr1fR4ryCijiNodJGX0ATqlg+P6H8LvTzaEUcxoM30aRdxoZymt20VUqQlLgbR36LUHxcW42g5NLNyuQYUBOx8cwIDAQAB";
$merchantSecret = "95b57c46b8c2e068982be23fb669a80612cad68e6ce6ba4f5af9ec20d23bb274";

//$moneyReq
$moneyReq = array(
    'currency' => 'IDR',
    'amount' => 10000
);
//$merchantReq
$merchantReq = array(
    'merchantId' => "20019"
);
//$payinReq
$payinReq = array(
    'orderNo' => "orderNO-123456789",
    'purpose' => 'for test',
    'money' => $moneyReq,
    'merchant' => $merchantReq,
    'paymentMethod' => 'BCA',
    'area' => '10',
);

$obj = new Signature();
$minifyStr = $obj->minify($payinReq);
echo "minifyStr=" . $minifyStr . PHP_EOL;

$currentTime = new DateTime('now', new DateTimeZone('UTC'));
$currentTime->setTimezone(new DateTimeZone('Asia/Bangkok'));
$timestamp = $currentTime->format('Y-m-d\TH:i:sP');
$stringToSign =  $timestamp . "|" . $merchantSecret . "|" . $minifyStr;
echo "stringToSign=" . $stringToSign . PHP_EOL;

$signatureValue = $obj->sha256RsaSignature($stringToSign,$privateKeyStr);
echo "signatureValue=" . $signatureValue . PHP_EOL;

$checkResult = $obj->checkSha256RsaSignature($stringToSign,$publicKeyStr,$signatureValue);
echo "checkResult=" . $checkResult . PHP_EOL;


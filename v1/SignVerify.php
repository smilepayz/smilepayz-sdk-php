<?php
// Data
$data = '10120005240129142234801|2024-01-29T16:37:52+07:00';
// DER Public Key
$publicKeyDer = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA6WFQboS6zWaybvIY+t8LUuk+MI0D+/IYlirrTOZ9Hq5UJLj2R5Z1Aq5tO3mkIBPhCu4OvPCIC4VgqVKFNC7XN8vpKHIRo9+fln+G//euEIAOg8bHBQ3qTJAPP6686VimxXknKlsef3bFni4UwPaZHhkTTIbXOgj46QHICo08iAIKicVhMKVshX2LGKk8jrs9IcA+x9wmRltcWEQ9AEU60CSomRawyfeDF7oJUrI+Uf8kkLHRbAcYwNbtkM9XJVscKo2mDG1YmLxQKP8E3562sZwZYWYTIu8VNkkEQwAE62ch1a74HvrvTp6C2C7gK2vzGx7e1kepZ4W/xsqVo+yTBwIDAQAB';
// Sign Str
$sign = 'no3PsLJZwtNv/rTtibky8Z8e0QqVsfNuoAseMfynEw7/yYubCwmZ+5/C2+eJXKEbb2Wgzlpb4cLBoidWOvoyiys0XoLaRKpJf0gaLuIq3qah2GMNi+99W1mwAGNXvEr0I+mPW6SljELm5t24NzwxVUEVcQaYFuQ7iU2j91e5NJFIdDxeGL9Z6p3CecOarZQZAaBcjnZGOG3Zk0o4V7MLul89tUwN9R2zDWdpptxHYHkMlx2KQmCGFuagwxx6IfXV2SPFuVBGTmCI6YKrrgjb2NMjgWuurG6zX+Q0b7Pbnj+rCxxHXf1pgFUujcuL4kODOQ35ZB8V1+JDTqB4vpI9FQ==';

function verifyDataWithPublicKeyDer($data, $publicKeyDer, $signature) {

    $publicKey = openssl_pkey_get_public('-----BEGIN PUBLIC KEY-----' . "\n" .
        chunk_split($publicKeyDer, 64, "\n") .
        '-----END PUBLIC KEY-----');
    if ($publicKey === false) {
        throw new Exception("Failed to get public key");
    }

    $result = openssl_verify($data, base64_decode($signature), $publicKey, OPENSSL_ALGO_SHA256);

    //openssl_free_key($publicKey);

    return $result;
}

$verificationResult = verifyDataWithPublicKeyDer($data, $publicKeyDer, $sign);
if ($verificationResult === 1) {
    echo "PASS";
} elseif ($verificationResult === 0) {
    echo "NO PASS";
} else {
    echo "ERROR";
}

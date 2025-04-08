<?php

// note: https://blog.csdn.net/weixin_39934453/article/details/128091552
echo "=====> begin Test" . PHP_EOL;

// get publicKey privateKey from step1
$publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA5bzVTjSDD8UWiMSzxlh7ra/q4mPitAvp6LAMhN4Kv+EloUCWluPqB2leJIBIO8+1Ke3Xs8mt6QXbnKIRri0JwPRMmxUDLUnuROTuXqMUZ4Ssbyv5/stnk52Ug1NEECBf2kJ1MmH512VQShNstM/BBtw8Qqsw9MnXsECkAMxX20ES6RS1RYyQanwigW/L/j+sqN0YFILslOBg/+G6TfxXIwc/UFVqlbpvGuovqdXlQsbBZ6YCu6K8g1NoRHos0vChutT38b2FL5AaJ77AwPihZxJ5gdT1WIVWXEos8zUZRtIYyDozEONsZzxsEKYvTEf9yRG3tapkHXXLIS9jYmBnpQIDAQAB';
$privateKeyStr = 'MIIEwAIBADANBgkqhkiG9w0BAQEFAASCBKowggSmAgEAAoIBAQDlvNVONIMPxRaIxLPGWHutr+riY+K0C+nosAyE3gq/4SWhQJaW4+oHaV4kgEg7z7Up7dezya3pBducohGuLQnA9EybFQMtSe5E5O5eoxRnhKxvK/n+y2eTnZSDU0QQIF/aQnUyYfnXZVBKE2y0z8EG3DxCqzD0ydewQKQAzFfbQRLpFLVFjJBqfCKBb8v+P6yo3RgUguyU4GD/4bpN/FcjBz9QVWqVum8a6i+p1eVCxsFnpgK7oryDU2hEeizS8KG61PfxvYUvkBonvsDA+KFnEnmB1PVYhVZcSizzNRlG0hjIOjMQ42xnPGwQpi9MR/3JEbe1qmQddcshL2NiYGelAgMBAAECggEBALN3PDqHkwqyr9PPtZBwds1L63VHCkYUOHnpbR4uRr92Jms9hWYCTUPU8BIblFIFBETo4+Qy3IR4awKFKMKjtEbjkSRk2cJ7SoLPQ9byFnJ3liyScgy04QjTxLyCQ11FrRtXZy4gk4fMQVhcrELjOKsfSIPcL7ZKJxAsrvFgsBE53Zgn++JhEtggnJvM0dT+G4TyxVhTsQiOymi2y2DPePXNIclboIR7OTaBVHYrIdHP91VdQ+u9HlEN3pixzzZ6eFyrrs94PKNbhjBvZpfShb8lNu/hxvwziluYClWS4bNk4W8aY0VZhe1mFN5VZHPn0FnWPwQ595DmAwtP9HKO0dECgYEA9gIKpaIrfL7BjduaCy7CR1Qlz2JulNU3qQaEy685EdK0rZCiRWi1LvFn0jGX0VnfOuCSp0AtB8/8yAcalgeJuzfzxLB1HpEImDvXh0t17Szw5qn+RJAo8qTGsLFSx+J8w29s1BRZNglZYS2pFxNI+AdYL3TrOtEno72ZdFat8ssCgYEA7xGdX1Ul91KVp3J726S/LavZ72nExQ5TeibXLmMalra4Vt8s2GjJVmUuYjuKLwwUBfNw6xGGvKZ5+G8OJKTpGK3xXTPYtirhJZMRfhu3zOFzDK/pdSsJNdFNu0YyxJHN0ZOgshgjWRMpN3fUN625VfRqa/p00Qluov32dmdZEU8CgYEAigc9OA/UfIp/CPv0419Z7DF/gWuGBgXX1ANvUOVAjQp/C39CPNVyCyOxj9L5jqHxSRSl1CeC3IZLG2Q4+4LBOYU8RdiH7h2MB/ZTiHrDcM6tX45ztr536ySewpbLjpE6VWFYW2oLX/FA7/Bxlhvg7iEYzo+4R+kAZ7PCvO7BbJ8CgYEAxpXEOtd5JRuVsrVXi1krcV2qN8SNLf87emFfJ2otQPpg39Cc6NsKO9jqkbDRlUkcLOFOcAVr/bLv6F0fy3KtKdH7h6c0ogW2ZkbnJfESWX8A2Y4aiDiKewj039Zs/3n6FNfjiWyhmDFhcHD6eJG3PV49NJqkhKuoGn6JR0uL4eMCgYEAxU9HlSqN4ECqM3lfcQeaPtbBEzKDqzQBcph4cRV0aih9SXRoFyJHKTXyFOZ/OCERqLjlPymckwDF2Xc6VwCApsfgeo1UUIhTlQgUrV1fasddyLEDiHPptrfQAbqyBAfMdEyN1dXESZpYXhssw1ULIxAT8M8LtjkL/9sWRge11wM=';

//build string to sign
$stringToSign = "Testing";
echo "stringToSign=" . $stringToSign . PHP_EOL;

//********** begin signature ***************
// DER -> PEM
$privateKeyPem = chunk_split($privateKeyStr, 64);
$privateKeyPem = "-----BEGIN PRIVATE KEY-----\n" . $privateKeyPem . "-----END PRIVATE KEY-----\n";
echo $privateKeyPem . PHP_EOL;

$r = openssl_sign($stringToSign, $signature, $privateKeyPem, OPENSSL_ALGO_SHA256);
$base64Sign = base64_encode($signature) ;
echo $base64Sign . PHP_EOL;
//********** end signature ***************


//********** begin verify ***************
$signature = base64_decode($base64Sign);

// DER -> PEM
$publicKeyPem = chunk_split($publicKey, 64);
$publicKeyPem = "-----BEGIN PUBLIC KEY-----\n" . $publicKeyPem . "-----END PUBLIC KEY-----\n";
echo $publicKeyPem . PHP_EOL;

$publicKey = openssl_pkey_get_public($publicKeyPem);
// verify
$result = openssl_verify($stringToSign, $signature, $publicKey, OPENSSL_ALGO_SHA256);
// result
if ($result === 1) {
    echo 'verify success！';
} elseif ($result === 0) {
    echo 'verify failed！';
} else {
    echo 'verify error：' . openssl_error_string();
}
//********** end verify ***************

echo "=====> end Test" . PHP_EOL;
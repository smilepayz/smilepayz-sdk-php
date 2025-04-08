<?php

echo "=====> step1 : Generate RSA Key Pair" . PHP_EOL;
// 生成 RSA 密钥对
$config = [
    "digest_alg" => "sha256",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
];

$rsaKey = openssl_pkey_new($config);

// Obtain private key information
openssl_pkey_export($rsaKey, $privateKey);

// Obtain public key information
$keyDetails = openssl_pkey_get_details($rsaKey);
$publicKey = $keyDetails['key'];

// Remove the start and end tags from the PEM private key
$encodedPrivateKey = str_replace(["-----BEGIN PRIVATE KEY-----", "-----END PRIVATE KEY-----", "\n"], '', $privateKey);

// Remove the start and end tags from the PEM public key
$encodedPublicKey = str_replace(["-----BEGIN PUBLIC KEY-----", "-----END PUBLIC KEY-----", "\n"], '', $publicKey);

// Output modified private key and public key string.
echo "privateKey: " . $encodedPrivateKey . PHP_EOL;
echo "publicKey: " . $encodedPublicKey . PHP_EOL;

echo "\n";
echo "=====> Please note this set of [RSA Key Pair] and send the [public key] to TheSmilePay." .
    "so that TheSmilePay can verify the request" . PHP_EOL;

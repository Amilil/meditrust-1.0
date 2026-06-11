<?php

// Ganti kunci ini dengan nilai acak yang kuat sebelum deploy.
define('ENCRYPTION_KEY', 'M3diTru$t-4u7h-K3y!2026@');

function encryptValue(string $plaintext): string
{
    $key = hash('sha256', ENCRYPTION_KEY, true);
    $iv = openssl_random_pseudo_bytes(16);
    $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $ciphertext);
}

function decryptValue(string $ciphertextB64): string
{
    $data = base64_decode($ciphertextB64, true);
    if ($data === false || strlen($data) < 17) {
        return '';
    }

    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    $key = hash('sha256', ENCRYPTION_KEY, true);

    $plaintext = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $plaintext === false ? '' : $plaintext;
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

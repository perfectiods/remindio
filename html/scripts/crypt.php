<?php
/** 
*  Функция шифровки-расшифровки имен
* на основе документации РНР - http://php.net/manual/ru/function.openssl-encrypt.php
**/

/* Переделать с исп-ем библиотеки
https://stackoverflow.com/questions/16600708/how-do-you-encrypt-and-decrypt-a-php-string   ПРИМЕРЫ НАСТРОЙКИ
https://paragonie.com/blog/2017/05/building-searchable-encrypted-databases-with-php-and-sql
https://github.com/defuse/php-encryption

Libsodiom, Halite - библиотека, сипользующая Libsodium
Defuse
*/


/*
* Ключ генерируется 1 раз и хранится
* Способ генерации: $key = openssl_random_pseudo_bytes(16);
*/

//Чтобы ключ был одинаковый для функции шифровки и расшифровки, его объявляем константой
// (найти другой вариант)
define("MYKEY_", base64_decode('CaWEPKd7iQRrft8mATzpzb=='));

function encryptName($plaintext) {

  $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
  $iv = openssl_random_pseudo_bytes($ivlen);

  $ciphertext_raw = openssl_encrypt($plaintext, $cipher, MYKEY_, $options=OPENSSL_RAW_DATA, $iv);
  $hmac = hash_hmac('sha256', $ciphertext_raw, MYKEY_, $as_binary=true);
  $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
  return $ciphertext;
}

 function decryptName($ciphertext) {

    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);

    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);

    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, MYKEY_,
    $options=OPENSSL_RAW_DATA, $iv); // | OPENSSL_ZERO_PADDING
    $calcmac = hash_hmac('sha256', $ciphertext_raw, MYKEY_, $as_binary=true);

    //if (hash_equals($hmac, $calcmac)) {
      //echo $original_plaintext."\n";
   // }

    //echo openssl_error_string();
    return $original_plaintext;
}
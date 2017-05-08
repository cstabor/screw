<?php

$pr_bits = '';

// get 128 pseudorandom bits in a string of 16 bytes
// Unix/Linux platform
$fp = @fopen('/dev/urandom','rb');
if ($fp !== FALSE) {
    $pr_bits .= @fread($fp,16);
    @fclose($fp);
}

printf("%s:%d\n", md5($pr_bits), strlen(md5($pr_bits)));
printf("%s:%d\n", sha1($pr_bits), strlen(sha1($pr_bits)));
printf("%s:%d\n", crc32($pr_bits), strlen(crc32($pr_bits)));

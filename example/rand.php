<?php

$max=$argv[1];

for ($i=0; $i<$max; $i++) {
    printf("rand\t%s\n", rand());
    printf("mt_rand\t%s\n", mt_rand());
    printf("randmax\t%s\n", rand(0, PHP_INT_MAX));
}

printf("%s\n", str_repeat("*", 16));
printf("%s\n", getrandmax());
printf("%s\n", PHP_INT_MAX);


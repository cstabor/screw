<?php
/**
 * Created by PhpStorm.
 * User: user_00
 * Date: 11/21/17
 * Time: 5:38 PM
 */

require '../../vendor/autoload.php';

$name = NULL;
println($name);

$name = true;
println($name);

$name = false;
println($name);

$name = 1.23456;
println($name);

$name = 123456;
println($name);

$name = "that's a dog";
println($name);

$name = fopen('/tmp/test.php', 'r');
println($name);

$name = [1, 2, 3];
println($name);

$name = new \stdClass();
$name->age = 5;
println($name);
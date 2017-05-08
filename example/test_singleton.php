<?php
require 'singleton.php';

//$o = new Singleton();
$o = Singleton::getInstance();
print_r($o);

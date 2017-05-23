<?php

$o = new PDO("mysql:host=192.168.1.103", 'root', '');
var_dump($o);
$o = new PDO("mysql:host=192.168.1.103;dbname=YD_User", 'root', '');
var_dump($o);

$ret = $o->query("use YD_BOSS");var_dump($ret);
$ret = $o->query("show tables");var_dump($ret);
$ret = $o->query("use YD_User");var_dump($ret);
$ret = $o->query("show tables");var_dump($ret);
$ret = $o->query("use YD_Agency");var_dump($ret);
$ret = $o->query("show tables");var_dump($ret);

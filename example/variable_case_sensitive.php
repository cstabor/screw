<?php

require __DIR__.'/init.php';

function test() {
    echo __FUNCTION__."\n";
}

println("function name case sensitive test, test() vs TEST() =============");
var_dump(test());
var_dump(TEST());

println("variable name case sensitive test, user vs USER ==========");
$user = 'gavin';
var_dump($user);
var_dump($USER);

println("class name case sensitive test, T1 vs t1 =======");
class T1 {

    public $name = 'gavin';
    #public function __construct() {
    public function __CONSTRUCT() {
        $this->name = 'tan'; 
    }
}



var_dump(new T1());
var_dump(new t1());

var_dump(new stdClass);
var_dump(new StdClass);

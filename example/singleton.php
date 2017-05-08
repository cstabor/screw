<?php

class Singleton {

    static private $instance = NULL;

    public static function getInstance() {
        if(self::$instance === NULL) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}


////////////////////////////////
// private static $_instance;
// public static function getInstance()
// {
//     if (! self::$_instance instanceof self) {
//         self::$_instance = new self();
//     }
//     return self::$_instance;
// }
////////////////////////////////

}

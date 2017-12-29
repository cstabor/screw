<?php


class ClassProperty {
    
    const NAME = 'gavintan';
    
    static $age = 11;
    
    public $publicVar = 1;
    protected $protectedVar = 2;
    private $privateVar = 3;
    
    
    public function getVar() {
        return get_class_vars(get_class($this));
    }
    
    public function testM() {
    
    }
}
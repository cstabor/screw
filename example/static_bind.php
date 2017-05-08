<?php

class A {
    public static function who() {
        echo __CLASS__;
    }
    public static function testSelf() {
        //static::who(); // 延迟静态绑定  
        self::who();
    }
    public static function testStatic() {
        static::who(); // 延迟静态绑定  
    }
}

class B extends A {
    public static function who() {
        echo __CLASS__;
    }
}

printf("self, B extends A: ");
B::testSelf();
printf("\n");

printf("static, B extends A: ");
B::testStatic();
printf("\n");

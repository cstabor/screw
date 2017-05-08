<?php
/**
 * Created by PhpStorm.
 * User: user_00
 * Date: 5/8/17
 * Time: 12:14 PM
 */

namespace ScrewTest;


use PHPUnit\Framework\TestCase;
use Screw\Base64UrlSafe;

class Base64UrlSafeTest extends TestCase
{
    
    // ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=
    
    protected $decoded = '';
    
    protected $encoded = 'abcd++//';
    
    public function testEncode() {
    
//        println(base64_encode($this->decoded));
//        println(Base64UrlSafe::encode($this->decoded));
        println(base64_decode($this->encoded));
        
    }
    
    public function testDecode() {
    
        $encode = Base64UrlSafe::encode($this->decoded);
        
        
    }
    
}
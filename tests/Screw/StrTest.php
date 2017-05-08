<?php
/**
 * Created by PhpStorm.
 * User: user_00
 * Date: 12/20/16
 * Time: 11:10 PM
 */

namespace ScrewTest;


use PHPUnit\Framework\TestCase;
use Screw\Str;


class StrTest extends TestCase
{

    public function testDBC() {

        $str = '!@#%^*()_+{}][;';

        $result = Str::specialCharsToSBC($str);

        $expect = '！＠＃％＾＊（）_＋｛｝〗“;';

        $expect = '！＠＃％＾＊（）_＋｛｝〗“;';

        $this->assertEquals($expect, $result, 'convert to SBC error');

        $str = '腾讯科技(深圳)有限公司';
        $expect = '腾讯科技（深圳）有限公司';

        $result = Str::specialCharsToSBC($str);

        $this->assertEquals($expect, $result, 'name convert to SBC error');

    }
    
    public function testRandom()
    {
        
        $len = 16;
        
        $str = Str::random($len);
        
        $this->assertEquals(16, strlen($str), 'random error');
        println($str);
        
    }


}

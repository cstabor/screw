<?php
/**
 * Created by PhpStorm.
 * User: user_00
 * Date: 11/21/17
 * Time: 3:48 PM
 */

namespace ScrewTest;

use Screw\ProcessUtil;

class ProcessUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testExecTimeout()
    {
        println(__FUNCTION__);
        // sleep 5s
        $cmd = '/usr/local/services/php/bin/php /tmp/test.php';
        $code = 0;
        $timeout = 3;
        $ret = ProcessUtil::exec($cmd, $timeout, $code);
        $this->assertEquals(-11, $code, 'test timeout error');
    }
    
    public function testExecInTime()
    {
        println(__FUNCTION__);
        // sleep 5s
        $cmd = '/usr/local/services/php/bin/php /tmp/test.php';
        $code = 0;
        $timeout = 6;
        $ret = ProcessUtil::exec($cmd, $timeout, $code);
        $this->assertEquals(0, $code, 'test with in timeout error');
        $this->assertEquals('test', $ret, 'test with in timeout return error');
    }
}

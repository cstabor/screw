<?php
/**
 * Created by PhpStorm.
 * User: user_00
 * Date: 6/8/17
 * Time: 8:27 PM
 */


$str = '';
if ($_GET['q']) {
    
    $param = $_GET['q'];
    $req = json_decode($param, true);
    $cmd = "phing -f ".$req['build_file'];
    
    exec($cmd, $out, $ret);
    
    if (is_array($out)) {
        $tmp = [];
        foreach ($out as $line) {
            if (strstr($line, 'distPath')) {
                $tmp[] = $line;
            }
            if (strstr($line, 'wget')) {
                $tmp[] = $line;
            }
        }
        $str = json_encode($tmp);
    }
}

print($str);
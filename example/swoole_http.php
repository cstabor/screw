<?php

$svr = new Swoole\Http\Server('192.168.1.166', 9501);

$svr->on('request', function($request, $response) {
    
    $cmd = '/usr/local/services/php/bin/php -v';
    $cmd = 'phing -f /data/services/yesdatphp/yopen/build.xml';
    
//    exec($cmd, $out, $ret);
//    println($out);d
//    println($ret);
    
//    print_r($request->get);
    println(123);
    $str = '';
    if (isset($request->get)) {
        $param = $request->get;
    
        $req = json_decode($param['q'], true);
        $cmd = "phing -f ".$req['build_file'];
    
//        print_r($cmd);
    
        exec($cmd, $out, $ret);
    
//        print_r($out);
//        print_r($ret);
    
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
    
    $response->end($str);
    

});

$svr->start();

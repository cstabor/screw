<?php

$svr = new Swoole\Server('192.168.2.2', 9501);

$svr->on('connect', function($svr, $fd) {
    echo "client: connected.\n";
});

$svr->on('receive', function($svr, $fd, $form_id, $data){
    $svr->send($fd, 'form id: '.$form_id);
    $svr->send($fd, 'Swoole: '.$data);
    $svr->close($fd);
});

$svr->on('close', function ($svr, $fd) {
    echo "client: closed.\n";
});

$svr->start();

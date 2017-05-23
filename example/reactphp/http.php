<?php

use React\EventLoop\Factory;
use React\Http\Request;
use React\Socket\Server;
use React\Http\Response;

require __DIR__.'/../init.php';

$loop = Factory::create();
$socket = new Server('0.0.0.0:8090', $loop);
$http = new \React\Http\Server($socket);

$http->on('request', function (Request $request, Response $response) {
    $response->writeHead(200, array('Content-Type' => 'text/plain'));
    $response->end("Hello World!\n");
});

$loop->run();

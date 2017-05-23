<?php

$serv = new Swoole\Http\Server('192.168.2.2', 9502);

$serv->set([
    'worker_num' => 10,
    // PHP Warning:  Swoole\Server::taskwait(): Task method cannot use, Please set task_worker_num.
    'task_worker_num' => 5, //database connection pool
]);

function onRequestConnect($request, $response) {
//    global $serv;
//    $sql = $request->post['sql'];
    $link = new PDO("mysql:host=192.168.2.2;dbname=YD_IdGenerator;port=3306", "test", "test@123");
    $sql = 'REPLACE INTO YT_SeqADXInvoiceId (YF_stub, YF_updated_time) VALUES (1, 123)';
    $result = $link->exec($sql);
    $result = $link->lastInsertId();
//    $result = $serv->taskwait($sql);
    $response->end($result);
}

function onRequestHello($request, $response) {
    $response->end('hello world');
}

function onRequestPool($request, $response) {
    global $serv;
//    $sql = $request->post['sql'];
    $sql = 'REPLACE INTO YT_SeqADXInvoiceId (YF_stub, YF_updated_time) VALUES (1, 123)';
    $result = $serv->taskwait($sql);
    $response->end($result);
}


//
function onTask($serv, $task_id, $from_id, $sql)
{
//    static $link = null;
//    if ($link == null) {
//        $link = new PDO("mysql:host=192.168.2.2;dbname=YD_IdGenerator;port=3306", "test", "test@123");
//        if (!$link) {
//            $link = null;
//            $serv->finish("ER:" . $link->errorInfo());
//            return;
//        }
//    }
//    $result = $link->exec($sql);
//    if (!$result) {
//        $serv->finish("ER:" . var_export($link->errorInfo(), true));
//        return;
//    }
//    return $link->lastInsertId();
}

function onFinish($serv, $data)
{
    echo "AsyncTask Finish:Connect.PID=" . posix_getpid() . PHP_EOL;
}


$serv->on('request', 'onRequestHello');
$serv->on('task', 'onTask');
$serv->on('finish', 'onFinish');

$serv->start();


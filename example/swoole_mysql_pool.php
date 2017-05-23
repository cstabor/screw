<?php

$serv = new Swoole\Server('192.168.2.2', 9508);
$serv->set(array(
    'worker_num' => 1,
    'task_worker_num' => 1, //MySQL连接的数量
));

function my_onReceive($serv, $fd, $from_id, $data)
{
    //taskwait就是投递一条任务，这里直接传递SQL语句了
    //然后阻塞等待SQL完成
    $sql = "show tables";
//    $sql = "select abc as 'name'";
//    $sql = 'REPLACE INTO YT_SeqADXInvoiceId (YF_stub, YF_updated_time) VALUES (1, 123)';
//    $sql = 'select * from YT_SeqADXInvoiceId';
//    $result = $serv->taskwait($sql);

    $serv->send($fd, var_export($data, true) . "\n");
    $serv->send($fd, "---------\n");
    $serv->send($fd, var_export($from_id, true) . "\n");


    $serv->close($fd);


    $result = $data;
    if ($result !== false) {
        list($status, $db_res) = explode(':', $result, 2);
        if ($status == 'OK') {
            //数据库操作成功了，执行业务逻辑代码，这里就自动释放掉MySQL连接的占用
//            $serv->send($fd, var_export(unserialize($db_res), true) . "\n");
            $serv->send($fd, var_export(unserialize($data), true) . "\n");
        } else {
            $serv->send($fd, $db_res);
        }
    } else {
        $serv->send($fd, "Error. Task timeout\n");
    }
    $serv->close($fd);
}

function my_onTask($serv, $task_id, $from_id, $sql)
{
    static $link = null;
    if ($link == null) {
        $link = new PDO("mysql:host=192.168.2.2;dbname=YD_IdGenerator;port=3306", "test", "test@123");
        if (!$link) {
            $link = null;
            $serv->finish("ER:" . $link->errorInfo());
            return;
        }
    }
    $result = $link->exec($sql);
    if (!$result) {
        $serv->finish("ER:" . var_export($link->errorInfo(), true));
        return;
    }
    $data = $link->lastInsertId();
    $serv->finish("OK:" . serialize($data));
}

function my_onFinish($serv, $data)
{
    echo "AsyncTask Finish:Connect.PID=" . posix_getpid() . PHP_EOL;
}

$serv->on('Receive', 'my_onReceive');
$serv->on('Task', 'my_onTask');
$serv->on('Finish', 'my_onFinish');
$serv->start();

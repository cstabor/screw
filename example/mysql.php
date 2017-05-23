<?php
$userName = 'test';
$password = 'test@123';
$dsn = 'mysql:host=192.168.2.2;dbname=YD_IdGenerator;port=3306';

$link = new PDO($dsn, $userName, $password);
$sql = 'REPLACE INTO YT_SeqADXInvoiceId (YF_stub, YF_updated_time) VALUES (1, 123)';
$result = $link->exec($sql);
echo $link->lastInsertId();

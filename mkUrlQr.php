<?php
//header("content-type: image/png");
$url = $_GET['url'];
$url = urldecode($url);
$url = urlencode($url);
$url = preg_replace('/http%3A%2F%2F/','http://',$url);
$url = preg_replace('/%3A/',':',$url);
$url = preg_replace('/%2F/','/',$url);
$url = preg_replace('/%3F/','?',$url);
$url = preg_replace('/%3D/','=',$url);
$url = preg_replace('/%26/','&',$url);
/*var_dump($url);
exit();*/
include('lib/qrcode/qrlib.php');
QRcode::png($url,false, QR_ECLEVEL_H,4);

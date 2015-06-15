<?php
header('Content-type:text/json;charset=utf-8');
include('lib/qrcode/qrlib.php');
$folder = iconv('utf-8', 'GBK', $_POST['folder']);
$ds = DIRECTORY_SEPARATOR;
$baseDir = 'upload'.$ds.'test';
$targetPath = dirname( __FILE__ ) . $ds. $baseDir . $ds .$folder . $ds;
//如果目录不存在，创建并初始化index.php
if (!is_dir($targetPath)){
    mkdir($targetPath);
    if(!is_file($targetPath . $ds .'index.php')){
        $type = $_POST['webtype'];
        if($type=='pc'){
            $templateName = 'index_pc.php';
        }
        else{
            $templateName = 'index_mobile.php';
        }
        copy(dirname( __FILE__ ) . $ds. 'template' . $ds.$templateName, $targetPath . $ds .'index.php');
    }
}
//如果是手机项目生成二维码在项目根目录
if(!is_file($targetPath.'quick_mark_address.png') && $_POST['webtype']=='mobile'){
    $host = $_SERVER['HTTP_HOST'];      //10.8.25.25:8080
    $path = $_SERVER['REQUEST_URI'];    // /QuickView/upload.php
    preg_match_all('/(^\/.*\/)/',$path,$match);
    $path =$match[1][0].$baseDir.'/';
    $url = 'http://'. $host . $path .$_POST['folder'].'/'.'index.php';
    var_dump($url);
	//$url = urlencode($url);
    QRcode::png($url, $targetPath.'quick_mark_address.png', QR_ECLEVEL_M, 6);
}
var_dump($_FILES);
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    //$tempFile = iconv('UTF-8','GBK',$tempFile);
    $targetFile =  $targetPath. iconv('utf-8', 'GBK', $_FILES['file']['name']);;
    //var_dump($targetFile);
    //$targetFile = iconv('utf-8', 'GBK', $targetFile);
	//var_dump($tempFile);
   // var_dump($targetFile);
    move_uploaded_file($tempFile,$targetFile);

}
//var_dump($targetFile);
//var_dump($_SERVER);
var_dump($_POST);
?> 

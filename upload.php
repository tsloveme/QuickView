<?php
header('Content-type:text/json;charset=utf-8');
$folder = iconv('utf-8', 'GBK', $_POST['folder']);
$ds = DIRECTORY_SEPARATOR;
$baseDir = 'upload';
$targetPath = dirname( __FILE__ ) . $ds. $baseDir . $ds .$folder . $ds;
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
var_dump($_FILES);
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    //$tempFile = iconv('UTF-8','GBK',$tempFile);
    $targetFile =  $targetPath. iconv('utf-8', 'GBK', $_FILES['file']['name']);;
    //var_dump($targetFile);
    //$targetFile = iconv('utf-8', 'GBK', $targetFile);
	var_dump($tempFile);
    var_dump($targetFile);
    move_uploaded_file($tempFile,$targetFile);

}
//var_dump($targetFile);
//var_dump($_SERVER);
var_dump($_POST);
?> 

<?php
header('Content-type:text/json;charset=utf-8');
/*if (isset($_POST)&&!empty($_POST)){
    var_dump($_POST);
}*/

$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'upload';
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    //$tempFile = iconv('UTF-8','GBK',$tempFile);
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
    $targetFile =  $targetPath. $_FILES['file']['name'];
    var_dump($targetFile);
    $targetFile = iconv('utf-8', 'GBK', $targetFile);
    var_dump($targetFile);
    move_uploaded_file($tempFile,$targetFile);

     
}
//var_dump($targetFile);
//var_dump($_SERVER);
var_dump($_POST);
?> 

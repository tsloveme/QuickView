<?php
/**
 * Created by PhpStorm.
 * User: ts
 * Date: 2015/6/9
 * Time: 12:47
 */
/*var_dump($_SERVER);
exit;*/
include('lib/qrcode/qrlib.php');
$tempDir = 'lib/qrcode/temp/';
$codeContents = '123456DEMO';
// generating

QRcode::png($codeContents, $tempDir.'007_4.png', QR_ECLEVEL_H, 8);
// displaying
echo '<img src="'.$tempDir.'007_4.png" />';

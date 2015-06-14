<?php session_start();
function doAction(){
	if(isset($_GET['action']) && isset($_SESSION['username']) && ($_SESSION['username']=='admin')){
		$dir = getcwd();
		$action = $_GET['action'];
		if(isset($_GET['projectName'])){
			$projectName =$_GET['projectName'];
		}
		if($action == 'puttest'){
			//rename($dir.'\\confirm\\'.$projectName,$dir.'\\test\\'.$projectName.'\\');
			rename('upload/confirm/'.$projectName,'upload/test/'.$projectName);
		}
		if($action == 'putconfirm'){
			//rename($dir.'\\test\\'.$projectName,$dir.'\\confirm\\'.$projectName);
			rename('upload/test/'.$projectName,'upload/confirm/'.$projectName);
		}
		sleep(1.5);		
	}	
}
doAction();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>项目列表</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<style type="text/css">
*{margin:0; padding:0;}
html{font-size:16px;}
table{border-collapse:collapse;}
td,th{padding:.5rem; line-height:1.5; border:1px #ccc solid; word-break:break-all;}
td{padding:.25em .5em;}
td span{font-size:.75rem; float:right; color:#999; text-align:right;}
td span a{font-size:.75rem; color:red; text-decoration:none;}
td span a:hover{text-decoration:underline;}
.test td span a{color:#2C82D8;}
body{font-size:1rem;font-family:'微软雅黑';}
@media screen  and (min-width:359px) and (max-width:414px) {
	body{font-size:1rem;}
}
@media screen  and (max-width:359px){
	body{font-size:.75rem;}
}
@media screen  and (max-width: 799px){
	body{max-width:480px; margin:0 auto;}
	.main{width:auto; max-width:480px; margin:0 .5rem;}
}
@media screen  and (min-width: 1000px){
	.main{width:820px; margin:0 auto;}
}
h1{font-size:1.5rem; line-height:2.4; text-align:center; margin.5rem 0; padding-top:1rem;}

</style>
</head>
<body>
	<div class="main">
		<h1>项目列表(已确认)</h1>
		<table border="0" cellspacing="0" cellspadding="0" width="100%">
			<tr>
				<th width="50%">PC项目</th>
				<th width="50%">移动端项目</th>
			</tr>
			<?php
				/*
				*按日期获取目录列表并实现排序。
				*返回二维数据。
				*/
				function getDirListByTime($dir,$order){
					$fileArr = scandir($dir);
					if(!is_array($fileArr)){
						return $fileArr;
					}
					$result = array();
					$final = array();
					foreach($fileArr as $fileName){
						if($fileName == '.' || $fileName=='..'){
							continue;
						}
						$ctime = filectime($dir.'\\'.$fileName);
						$fileName = iconv('gbk','utf-8',$fileName);
						$result[$fileName] = $ctime;
					}
					switch (strtolower($order)){
						case 'desc':
						arsort($result);
						break;
						default:
						asort($result);
						break;
					}
					return $result;
					$temArr = array();
					foreach($result as $creatTime => $fName){
						array_push($temArr,array($creatTime,$fName));
					}
					return $temArr;
					/*foreach($result as $f => $ct){
						array_push($final,$f);
					}
					return $final;*/
				}
				
				chdir('./upload/confirm');
				$dir = getcwd();
				$dirList = getDirListByTime($dir,'asc');
				//var_dump($dirList);
				$arrMibile = array();
				$arrPc = array();
				foreach($dirList as $dirname => $ctime){
					if(preg_match('/\d+mobile/',$dirname)){
						$shortName = preg_replace('/^\d+mobile_(.*)(_\d+)$/','$1',$dirname);
						array_push($arrMibile,array($ctime,$dirname,$shortName));
						//$arrMibile[$value[0]] = $value[1];
					}
					else{
						$shortName = preg_replace('/^\d+pc_(.*)(_\d+)$/','$1',$dirname);
						array_push($arrPc,array($ctime,$dirname,$shortName));
						//array_push($arrPc,$fName);
						//$arrPc[$creatTime] = $fName;
					}
				}
				$rowNum = 0; 
				if(isset($_SESSION['username']) && !empty($_SESSION['username'])){
					$session_name = $_SESSION['username'];
				}
				
				while( !empty($arrMibile) || !empty($arrPc)){
					$rowNum +=1;
					//不是第9行和第10行就正常输出列表。
					//第9行用于合并表格放展开按钮
					//第10行之后开始放在一个tbody用于显示隐藏更多列表。
					if(($rowNum != 9) && ($rowNum != 10)){
						echo '<tr><td>';
					}
					//输出展开更多按钮
					if ($rowNum == 9){
						echo '<tr><td align="center" colspan="2"><a id="confirm_more" href="javascript:;">more&gt;&gt;</a></td></tr>';
						continue;
					}
					//超过10个放入tbody
					if ($rowNum == 10){
						echo '<tbody id="confirm_tbody" style="display:none"><tr><td>';
						?>
							<script>
								document.getElementById('confirm_more').onclick = function(){
									this.parentNode.parentNode.style.display='none';
									document.getElementById('confirm_tbody').style.display='';
								}
							</script>
						<?php
					}
					$pc = array_pop($arrPc);
					if($pc){
						$time = date('m月d日 H:i:s',$pc[0]);
						$operation = '';
						if(isset($session_name)){
							$operation = ' <a href="list.php?action=puttest&projectName='.$pc[1].'" title="放回测试文件夹">[放回测试]</a>';
						}
						echo '<a href="detialPC.php?confirm=1&projectName='.$pc[1].'">'.$pc[2].'</a><span>'.$time.$operation.'</span>';
					}
					else{
						echo '';
					}
					echo '</td><td>';
					$mb = array_pop($arrMibile);
					if($mb){
						$time = date('m月d日 H:i:s',$mb[0]);
						$operation = '';
						if(isset($session_name)){
							$operation = ' <a href="list.php?action=puttest&projectName='.$mb[1].'" title="放回测试文件夹">[放回测试]</a>';
						}
						echo '<a href="detialMobile.php?confirm=1&projectName='.$mb[1].'">'.$mb[2].'</a><span>'.$time.$operation.'</span>';
					}
					else{
						echo '';
					}
					echo '</td></tr>';

				}				
				echo '</tbody>';
			?>
		</table>
		<h1>项目列表(测试中)</h1>
		<table border="0" cellspacing="0" cellspadding="0" width="100%" class="test">
			<tr>
				<th width="50%">PC项目</th>
				<th width="50%">移动端项目</th>
			</tr>
			<?php
				chdir('../../upload/test');
				$dir = getcwd();
				$dirList = getDirListByTime($dir,'asc');
				$arrMibile = array();
				$arrPc = array();
				foreach($dirList as $dirname => $ctime){
					if(preg_match('/\d+mobile/',$dirname)){
						$shortName = preg_replace('/^\d+mobile_(.*)(_\d+)$/','$1',$dirname);
						array_push($arrMibile,array($ctime,$dirname,$shortName));
						//$arrMibile[$value[0]] = $value[1];
					}
					else{
						$shortName = preg_replace('/^\d+pc_(.*)(_\d+)$/','$1',$dirname);
						array_push($arrPc,array($ctime,$dirname,$shortName));
					}
				}
				while( !empty($arrMibile) || !empty($arrPc)){
					echo '<tr><td>';
					$pc = array_pop($arrPc);
					if($pc){
						$time = date('m月d日 H:i:s',$pc[0]);
						$operation = '';
						if(isset($session_name)){
							$operation = ' <a href="list.php?action=putconfirm&projectName='.$pc[1].'" title="放入已确认文件夹">[标记为确认]</a>';
						}
						echo '<a href="detialPC.php?confirm=0&projectName='.$pc[1].'">'.$pc[2].'</a><span>'.$time.$operation.'</span>';
					}
					else{
						echo '';
					}
					echo '</td><td>';
					$mb = array_pop($arrMibile);
					if($mb){
						$time = date('m月d日 H:i:s',$mb[0]);
						$operation = '';
						if(isset($session_name)){
							$operation = ' <a href="list.php?action=putconfirm&projectName='.$mb[1].'" title="放入已确认文件夹">[标记为确认]</a>';
						}
						echo '<a href="detialMobile.php?confirm=0&projectName='.$mb[1].'">'.$mb[2].'</a><span>'.$time.$operation.'</span>';
					}
					else{
						echo '';
					}
					echo '</td></tr>';
				}
			?>
		</table>
	</div>
</body>
</html>
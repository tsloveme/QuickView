<?php
$from = '';
if(isset($_GET['from']) && !empty($_GET['from'])){
	$from = $_GET['from'];
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>管理员登录</title>
</head>
<style type="text/css">
td{border:1px #ccc solid;}
input[type="password"],input[type="text"]{border:1px solid #999; padding:5px;}
input[type="submit"]{border-radius: 3px; border: 1px #0266c4 solid; background-color:#017bed ;color:white; font-size: 16px; min-width: 100px; height: 31px;}

</style>
<body>
<form action="login.php?from=<?php echo $from; ?>" method="post" name="form1">
<table width="600" border="1" align="center" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
  <tr>
    <td colspan="2" align="center"><h1>用户登录</h1></td>
  </tr>
  <tr>
    <td align="right">用户 名：</td>
    <td><label for="username"></label>
    <input type="text" name="username" id="username" placeholder="请填写用户名"></td>
  </tr>
  <tr>
    <td align="right">密码：</td>
    <td><label for="password"></label>
    <input type="password" name="password" id="password"></td>
  </tr>
    <tr>
    <td></td>
    <td>
        <input type="submit" name="submit" id="submit" onsubmit="return submit()" value="登 录"> <a href="index.php" style="font-size: .75rem;">[查看项目列表]</a></td>
  </tr>
</table>
</form>
<script>
	function submit(){
		if(document.form1.username.value.replace(/(^\s+)|\s+$/g,'')==''){
			alert('请填用户名');
			return false;
		}
		if(document.form1.password.value.replace(/(^\s+)|\s+$/g,'')==''){
			alert('请填密码');
			return false;
		}
	}
</script>
</body>
</html>
<?php
if(isset($_GET['logout']) && $_GET['logout']=='1'){
	session_start();
	unset($_SESSION['username']);
}
if(!isset($_POST) || empty($_POST)){
	exit;
}
$username = preg_replace('/(^\s+)|(\s+$)/','',$_REQUEST['username']);
$password = preg_replace('/(^\s+)|(\s+$)/','',$_REQUEST['password']);
if(($username === 'admin') && ($password === 'admin888')){
	session_start();
	$_SESSION['username'] =$username;
	if($from!=''){
		header('Location:'.$from);
	}
	else{
		header('Location:admin.php');
	}
}
else{
	echo '<script>alert("用户名或者密码错误！")</script>';
}

?>

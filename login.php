<?php
	session_start();
	date_default_timezone_set('PRC');
	if(!empty($_POST)){
		header("Content-Type:text/json;Charset=utf-8");
		$user = $_POST["user"];
		$password = $_POST["password"];
		if($user=='root' && $password=='abcdefghijk0123456789'){
			$data = [];
			$data["err"] = 0;
			$data["msg"] = '超级管理员,登录成功!';
			$data["root"] = 1;
			echo json_encode($data);	
			$_SESSION["root"] = 1;
			exit();
		}
		$user_data = file_get_contents("user.json");
		$datas = json_decode($user_data, true);
		if(isset($datas[$user])){
			if($datas[$user]==$password){
				$data["err"] = 0;
				$data["msg"] = '登录成功!';
				$data["root"] = 0;
				unset($_SESSION["root"]);
				$_SESSION["user"] = $user;
				echo json_encode($data);	
				exit();
			}
			else{
				if($_SESSION["root"]==1){
					$datas[$user]=$password;
					file_put_contents("user.json", json_encode($datas));
			        $data["err"] = 0;
			        $data["msg"] = '密码修改成功!';
			        $data["root"] = 1; 
			        echo json_encode($data);	
					exit();     
				}
				else{
					$data["err"] = 1;
			        $data["msg"] = '密码错误!'; 
			        echo json_encode($data);	
					exit();     
				}
			}
		}
		if($_SESSION["root"]==1){
			$datas[$user]=$password;
			file_put_contents("user.json", json_encode($datas));
	        $data["err"] = 0;
	        $data["msg"] = '添加用户成功!'; 
	        $data["root"] = 1;
	        echo json_encode($data);	
			exit();     
		}
		else{
			$data["err"] = 1;
	        $data["msg"] = '用户不存在!'; 
	        echo json_encode($data);	
			exit();  
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<meta name=viewport content="width=device-width,initial-scale=1">
	<title>login</title>
	<link href=/static/css/login.css rel=stylesheet>
</head>
<body>
	<div id=app>
		
	</div>
	<script type=text/javascript src=/static/js/manifest.js></script>
	<script type=text/javascript src=/static/js/vendor.js></script>
	<script type=text/javascript src=/static/js/login.js></script>
</body>
</html>
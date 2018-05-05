<?php
	header("Content-Type:text/json;Charset=utf-8");
	session_start();
    if(empty($_SESSION["user"])){
        header('Location:login.php');
        exit();
    }
	date_default_timezone_set('PRC');
	$user = $_SESSION["user"];
    $root = __DIR__."/docs/";
    if($_POST["action"]=='check'){
        $file = urldecode($_POST["file"]);
        $lock_file = str_replace('.qwk', '.lock', $file);
        $lock_path = $root.ltrim($lock_file, '/');
        if(file_exists($lock_path)){
            $lock_info = trim(file_get_contents($lock_path));
            $lock_data = explode("#", $lock_info);
            $lock_time = $lock_data[0];
            $lock = 0;
            //上个人还在编辑，默认2小时内解锁
            if($lock_time + 7200 < time()){
                $lock = 1;
            }
            //自己在编辑
            if($user == $lock_data[1]){
                $lock = 0;
            }
            $data = [];
            if($lock==1){
                $data["err"] = 1;
                $data["msg"] = '文件正在被'.$lock_data[1].'编辑';
                echo json_encode($data);
                exit();
            }
            else{
                $data["err"] = 0;
                $data["msg"] = '';
                file_put_contents($lock_path, time().'#'.$user);
                echo json_encode($data);
                exit();
            }
        }
        else{
            $data["err"] = 0;
            $data["msg"] = '';
            file_put_contents($lock_path, time().'#'.$user);
            echo json_encode($data);
            exit();
        }
    }
    if($_POST["edit"]==1){
        $file = urldecode($_POST["file"]);
        $lock_file = str_replace('.qwk', '.lock', $file);
        $lock_path = $root.ltrim($lock_file, '/');
        if(file_exists($lock_path)){
            $lock_info = trim(file_get_contents($lock_path));
            $lock_data = explode("#", $lock_info);
            $lock_time = $lock_data[0];
            $lock = 0;
            //上个人还在编辑，默认2小时内解锁
            if($lock_time + 7200 < time()){
                $lock = 1;
            }
            //自己在编辑
            if($user == $lock_data[1]){
                $lock = 0;
            }
            $data = [];
            if($lock==1){
                $data["err"] = 1;
                $data["msg"] = '文件正在被'.$lock_data[1].'编辑';
                echo json_encode($data);
                exit();
            }
            @unlink($lock_path);
        }
        $file_path = $root.ltrim($file, '/');
        if(file_exists($file_path)){
            @unlink($file_path);
        }
    }
	$path = $_POST["path"];	
	$title = $_POST["title"];
	$content = $_POST["content"];
	$attachments = $_POST["attachments"];
	//新建文件夹
	$fileDir = $root.ltrim($path, '/');
	if(!file_exists($fileDir)){
        mkdir($fileDir, 0755, true);
    }
    $fileName = time().'_'.$title.'.qwk';
    $file = rtrim($fileDir, '/').'/'.$fileName;
    $contents = $user."\n###QWK###\n".date("Y-m-d H:i:s",time())."\n###QWK###\n".$title."\n###QWK###\n".$attachments."\n###QWK###\n".$content;
    $r = file_put_contents($file, $contents);
    $data = [];
    if($r > 0){
    	$data["err"] = 0;
    	$data["msg"] = "保存成功";
    	$data["to"] = urlencode(trim($path, '/').'/'.$fileName);
    }
    else{
    	$data["err"] = 1;
    	$data["msg"] = "保存失败";
    }
    echo json_encode($data);
?>
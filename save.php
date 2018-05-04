<?php
	header("Content-Type:text/json;Charset=utf-8");
	session_start();
	date_default_timezone_set('PRC');
	$user = $_SESSION["user"];
	$path = $_POST["path"];	
	$title = $_POST["title"];
	$content = $_POST["content"];
	$attachments = $_POST["attachments"];
	//新建文件夹
	$root = __DIR__."/docs/";
	$fileDir = $root.ltrim($path, '/');
	if(!file_exists($fileDir)){
        mkdir($fileDir, 0755, true);
    }
    $fileName = time().'_'.$title.'.qwk';
    $file = rtrim($fileDir, '/').'/'.$fileName;
    $contents = $user."\n#####\n".date("Y-m-d H:i:s",time())."\n#####\n".$title."\n#####\n".$attachments."\n#####\n".$content;
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
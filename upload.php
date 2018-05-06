<?php
	$errors = [
		"1" => 'UPLOAD_ERR_INI_SIZE',
		"2" => 'UPLOAD_ERR_FORM_SIZE',
		"3" => 'UPLOAD_ERR_PARTIAL',
		"4" => 'UPLOAD_ERR_NO_FILE',
		"5" => 'UPLOAD_ERR_NO_TMP_DIR',
		"6" => 'UPLOAD_ERR_CANT_WRITE'
	];
	$allows = ['jpg','jpeg','gif','png','bpm','doc','docx','xls','xlsx','ppt','txt','pdf','csv','ppt','sketch','rar','zip'];
	$file = $_FILES["file"];
    if($_POST['type']=='image'){
        $file = $_FILES["image"];
    }
    if(empty($file)){
    	header('HTTP/1.1 204 No Content');  
    	header("Content-Type:text/json;Charset=utf-8");
    	$data = ["err"=>1, "msg"=>'No Content', "file" =>[]];
    	echo json_encode($data);  	
        exit();
    }
    if($file["error"] > 0){
        header('HTTP/1.1 405 '.$errors[$file["error"]]);  
    	header("Content-Type:text/json;Charset=utf-8");
    	$data = ["err"=>1, "msg"=>$errors[$file["error"]], "file" =>[]];
    	echo json_encode($data);
        exit();
    }
    $file_ext = pathinfo($file["name"])["extension"];
    if(!in_array(strtolower($file_ext), $allows)){
    	header('HTTP/1.1 405 FILE TYPE IS NOT ALLOWED');  
    	header("Content-Type:text/json;Charset=utf-8");
    	$data = ["err"=>1, "msg"=>'FILE TYPE IS NOT ALLOWED', "file" =>[]];
    	echo json_encode($data);  
        exit();
    }
    $saveFileName = time().rand(100,999)."_".$file["name"];
    $saveDir = date("Ymd", time());
    if($_POST['type']=='image'){
        $uploadDir = __DIR__."/images";
    }
    else{
        $uploadDir = __DIR__."/attachments";
    }
    if(!file_exists($uploadDir."/".$saveDir)){
        mkdir($uploadDir."/".$saveDir, 0755, true);
    }
    $saveFile = $uploadDir."/".$saveDir."/".$saveFileName;
    if(!move_uploaded_file($file["tmp_name"], $saveFile)){
        header('HTTP/1.1 405 UPLOAD FAILED');  
    	header("Content-Type:text/json;Charset=utf-8");
    	$data = ["err"=>1, "msg"=>'UPLOAD FAILED', "file" =>[]];
    	echo json_encode($data); 
        exit();
    }
    $filePath = $saveDir."/".$saveFileName;
    header('HTTP/1.1 200 OK');  
    header("Content-Type:text/json;Charset=utf-8");
    $data = ["err"=>0, "file" => ["name"=>$saveFileName, "url"=>$filePath]];
    echo json_encode($data);
    exit();
?>
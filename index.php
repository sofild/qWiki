<?php
	session_start();
	if(empty($_SESSION["user"])){
		header('Location:login.php');
		exit();
	}
	date_default_timezone_set('PRC');
	$dir = __DIR__."/docs";
	$menu = read_dir($dir);
	$path = [];
	$curpath = '';
	if(isset($_GET["to"])){
		$curpath = $_GET["to"];
		$to = urldecode($_GET["to"]);
		$path = explode("/", $to);
		$path_count = count($path);
		$path_last = $path[($path_count-1)];
		$path_last_format = explode("_", $path_last);
		$path_last_name = ltrim($path_last, $path_last_format[0].'_');
		$path_last_name = rtrim($path_last_name, '.qwk');
		$path[($path_count-1)] = $path_last_name;
	}
	$file = $dir.'/'.ltrim($to,'/');
	if(file_exists($file)){
		$contents = file_get_contents($file);
		$datas = explode("\n###QWK###\n", $contents);
		$title = $datas[2];
		$attachments = empty($datas[3]) ? [] : json_decode($datas[3], true);
		$html = json_encode(["html" => $datas[4]]);
	}
	else{
		$title = '未找到该页~';
		$attachments = [];
		$html = json_encode(["html" => '#未找到该页~']);
	}
	function read_dir($dir){
		$files = array();
		if(@$handle = opendir($dir)) {
	        while(($file = readdir($handle)) !== false) {
	            if($file != ".." && $file != ".") {
	                if(is_dir($dir."/".$file)) {
	                    $files[$file] = read_dir($dir."/".$file);
	                } else {
	                	if(strpos($file, "_")===false){
	                		continue;
	                	}
	                	$names = explode("_", $file);
	                	$timestamp = $names[0];
	                    $files[$timestamp] = $file;
	                }
	            }
	        }
	        closedir($handle);
	    }
    	ksort($files);
        return $files;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<meta name=viewport content="width=device-width,initial-scale=1">
	<title><?php echo $title; ?></title>
	<link href=static/css/app.css rel=stylesheet>
	<script>
		window.MENU = <?php echo json_encode($menu); ?>;
		window.TITLE = '<?php echo $title; ?>';
		window.ATTACHMENTS = <?php echo json_encode($attachments); ?>;
		window.HTML = <?php echo $html; ?>;
		window.PATH = <?php echo json_encode($path); ?>;
		window.CURPATH = '<?php echo $curpath; ?>';
	</script>	
</head>
<body>
	<div id=app></div>
	<script type=text/javascript src=static/js/manifest.js></script>
	<script type=text/javascript src=static/js/vendor.js></script>
	<script type=text/javascript src=static/js/app.js></script>
</body>
</html>
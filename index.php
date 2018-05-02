<?php
	$dir = __DIR__."/docs";
	$menu = read_dir($dir);
	$to = urldecode($_GET["to"]);
	$file = $dir.'/'.$to;
	if(file_exists($file)){
		$contents = file_get_contents($file);
		$datas = explode("#####\n");
		$title = $datas[1];
		$attachments = empty($datas[2]) ? [] : json_decode($datas[2], true);
		$html = $datas[3];
	}
	else{
		$title = '未找到该页~';
		$attachments = [];
		$html = '<h1>未找到该页~</h1>';
	}
	function read_dir($dir){
		$files = array();
		if(@$handle = opendir($dir)) {
	        while(($file = readdir($handle)) !== false) {
	            if($file != ".." && $file != ".") {
	                if(is_dir($dir."/".$file)) {
	                    $files[$file] = read_dir($dir."/".$file);
	                } else {
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
	<title>pages</title>
	<link href=static/css/app.css rel=stylesheet>
	<script>
		window.MENU = <?php echo json_encode($menu); ?>;
		window.TITLE = '<?php echo $title; ?>';
		window.ATTACHMENTS = <?php echo json_encode($attachments); ?>;
		window.HTML = '<?php echo $html; ?>';
	</script>	
</head>
<body>
	<div id=app></div>
	<script type=text/javascript src=static/js/manifest.js></script>
	<script type=text/javascript src=static/js/vendor.js></script>
	<script type=text/javascript src=static/js/app.js></script>
</body>
</html>
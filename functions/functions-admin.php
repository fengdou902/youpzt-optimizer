<?php 
// Function: Format Bytes Into KB/MB
if(!function_exists('format_size')) {
	function format_size($rawSize) {
		if($rawSize / 1073741824 > 1)
			return number_format_i18n($rawSize/1048576, 1) . ' '.__('G', 'wp-dbmanager');
		else if ($rawSize / 1048576 > 1)
			return number_format_i18n($rawSize/1048576, 1) . ' '.__('M', 'wp-dbmanager');
		else if ($rawSize / 1024 > 1)
			return number_format_i18n($rawSize/1024, 1) . ' '.__('K', 'wp-dbmanager');
		else
			return number_format_i18n($rawSize, 0) . ' '.__('bytes', 'wp-dbmanager');
	}
}
//获取后台url
function get_optmenupage_url($pageslug){
	return site_url('/wp-admin/admin.php?page=optimize_page&tab='.$pageslug);
}
//提示信息
function youpzt_optimize_showMessage($message, $errormsg = false)
{
	if ($errormsg) {
		echo '<div id="message" class="error">';
	}else{
		echo '<div id="message" class="updated fade">';
	}
	echo "$message</div>";
}
//检查更新
function check_youpzt_plugins_optimize(){
	$check_url="http://www.eacoophp.com/wp-content/update_check_youpzt_json/youpzt-optimizer.json";
	//$check_url=base64_decode($check_url);
	$check_content=geturl_content($check_url);
	$check_obj=json_decode($check_content);
	return $check_obj;
}
//获取远程内容
if ( ! function_exists( 'geturl_content' ) ) :
function geturl_content($url) {
		$url = trim($url);
		$content = '';
		if (extension_loaded('curl')) {
			$ch = @curl_init();
			@curl_setopt($ch, CURLOPT_URL, $url);
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			@curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        		@curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			@curl_setopt($ch, CURLOPT_TIMEOUT_MS, 500);
			@curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
			@curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 500);
			@curl_setopt($ch, CURLOPT_HEADER, 0);
			$content = @curl_exec($ch);
			@curl_close($ch);
		} else {
			$content =@file_get_contents($url);
		}
		return trim($content);
}
endif;
?>

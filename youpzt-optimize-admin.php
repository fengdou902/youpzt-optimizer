<?php 
add_action('admin_menu', 'youpzt_optimize_admin');
add_action( 'admin_head','menu_youpzt_optimize_updatetip');
add_action('admin_menu', 'youpzt_optimize_scripts');
function youpzt_optimize_admin(){
	add_menu_page('youpzt-optimizer', '网站优化工具','edit_private_posts','optimize_page', 'youpzt_optimize_page','dashicons-hammer',73);
	add_action( 'admin_init', 'youpzt_optimize_settings' );
}
function menu_youpzt_optimize_updatetip(){
  global $menu,$submenu;

  $check_obj=check_youpzt_plugins_optimize();
	 $check_version=$check_obj->version;
  if (current_user_can('manage_options')&&$check_version!=WP_YPOPTIMIZE_VERSION) {
    $menu[73][0].= ' <span class="update-plugins update-youpzt-messages"><span class="update-count">新</span></span>';
  }
  
}
function youpzt_optimize_scripts(){	
	$optimize_get = isset($_GET['page'])? $_GET['page']:'';
	if($optimize_get=='optimize_page'){
				wp_enqueue_style('optimize-normalize',WP_YPOPTIMIZE_PLUGIN_URL.'/css/normalize.css', array(), WP_YPOPTIMIZE_VERSION);
				wp_enqueue_style('optimize-checkbox-button',WP_YPOPTIMIZE_PLUGIN_URL.'/css/checkbox-button.css', array(), WP_YPOPTIMIZE_VERSION);
				wp_enqueue_style('style',WP_YPOPTIMIZE_PLUGIN_URL.'/css/style.css', array(), WP_YPOPTIMIZE_VERSION);
				
				wp_enqueue_script( 'jquery2-1',WP_YPOPTIMIZE_PLUGIN_URL.'/js/jquery2.1.min.js', array(), WP_YPOPTIMIZE_VERSION);
				wp_enqueue_script( 'optimize-main',WP_YPOPTIMIZE_PLUGIN_URL.'/js/main.js', array('jquery2-1'), WP_YPOPTIMIZE_VERSION);
	}
}

/*settings*/
function youpzt_optimize_settings() {
	register_setting('youpzt-optimize-options-group', 'optimize_options' );
	register_setting('youpzt-optimize-settings-group', 'optimize_setting' );
}


//check update version 
function ypzt_optimize_showAdminMessages()
{
	 $check_obj=check_youpzt_plugins_optimize();
	 $check_version=$check_obj->version;
		if($check_version==''){
			youpzt_optimize_showMessage('<p>网络连接失败，不能检查插件更新！【youpzt-optimize】</p>', false);
		}elseif($check_version!=WP_YPOPTIMIZE_VERSION){
			
			youpzt_optimize_showMessage('<p>网站优化工具插件最新版本'.$check_version.'，请进入<a class="color-red" href="'.$check_obj->homepage.'" target="_blank" title="更新插件"><strong>插件页面</strong></a>更新版本</p>', false);
		}else{
			if(!function_exists('file_get_contents')){

				echo '如果您看到这句话，证明你的file_get_contents函数被禁用了，请开启此函数！';
			}
		}

}

if(isset($_GET['page'])){
	add_action('admin_notices', 'ypzt_optimize_showAdminMessages');//后台显示更新信息	
}
//激活插件后显示自定义提示信息youpzt.com
add_action('admin_notices', 'admin_subscribe');
if (!function_exists('admin_subscribe')) {
	function admin_subscribe() {
		global $current_user;
	    $user_id = $current_user->ID;
		if(!empty($_COOKIE["subscribe_start"])){
			$subscribe_start=$_COOKIE["subscribe_start"];
		}

		if (!get_user_meta($user_id, 'youpzt-subscribe')&&'off'!=$subscribe_start&&$current_user->user_level>7) {
			
	        echo '<div class="updated subscribe-main"><p>加入邮件订阅列表，获取我们最新内容推送。——<span class="text-ruo">[<a href="http://www.youpzt.com/267.html" target="_blank">youpzt-optimize</a>]</span><i class="fr fb f20 youpzt-close">&#215;</i></p><p>
			<input type="text" name="email_subscribe" id="email_subscribe" class="youpzt-text" value="'.$current_user->user_email.'" placeholder="填写E-mail地址" /><span class="youpzt-submit-subscribe button-primary" id="subscribe-submit" site-url="'.get_option('home').'">订阅</span> <span id="subscribe_msg" class="f12 color-success"></span>
			'; 
	        echo "</p></div>";
			wp_enqueue_style('youpztsubscribe-style',WP_YPOPTIMIZE_PLUGIN_URL.'/css/youpztsubscribe.css', array(), WP_YPOPTIMIZE_VERSION);
			wp_enqueue_script( 'cookies-jquery',WP_YPOPTIMIZE_PLUGIN_URL.'/js/jquery.cookie.js', array(), WP_YPOPTIMIZE_VERSION);
			wp_enqueue_script( 'youpztajax-subscribe',WP_YPOPTIMIZE_PLUGIN_URL.'/js/ajax-subscribe.js', array(), WP_YPOPTIMIZE_VERSION);		
		}
	}
}

function youpzt_optimize_page(){
?>
<div class="wrap">
<h2>网站优化工具<?php echo WP_YPOPTIMIZE_VERSION;?></h2>	

<p class="f13">官方QQ群：519708972  <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=dbf65e2fe706d4a5f798fb98158587c450c30d8df8444fcfe1409c537c828e0b"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="WordPress优品主题" title="WordPress优品主题" style="width:auto;"></a>，进行问题交流与反馈</p>
<?php	
$switch_action=isset($_GET['tab'])? $_GET['tab']:'general';
//切换
if($switch_action=='tables'){//数据库优化
	
	require_once(WP_YPOPTIMIZE_PLUGIN_DIR.'/youpzt-optimize-tables.php');
	
}elseif($switch_action=='general'||$switch_action=='switch'){//开关

	require_once(WP_YPOPTIMIZE_PLUGIN_DIR.'/youpzt-optimize-switch.php');

}elseif($switch_action=='setting'){
	require_once(WP_YPOPTIMIZE_PLUGIN_DIR.'/youpzt-optimize-setting.php');
}

?>
<hr/>
<p style="text-align:center;">&copy; <?php echo date("Y"); ?>专业WordPress高端定制平台， <a href="http://www.youpzt.com" target="_blank" rel="nofollow" title="WordPress优品主题建站平台">优品主题</a>(查看更多)</p>

</div>

<?php };?>
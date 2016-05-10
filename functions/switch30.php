<?php

if(is_admin()){

	// Disables themes preview - themes-preview
	if (isset($youpzt_optimize_options['themes-preview']) && $youpzt_optimize_options['themes-preview'] ==true) :
	if (strpos($_SERVER['REQUEST_URI'], 'wp-admin/themes.php') !== false) {
		wp_deregister_script('theme-preview');
		wp_deregister_script('thickbox');
	}
	endif;
	// Disables the update of the plugins - plugins-update
	if (isset($youpzt_optimize_options['plugins-update']) && $youpzt_optimize_options['plugins-update'] ==true) :
		add_action( 'load-plugins.php', create_function('$a', "remove_action('load-plugins.php', 'wp_update_plugins');"), 3);
		add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;")); // 关闭插件提示
		add_action( 'load-update.php', create_function('$a', "remove_action('load-update.php', 'wp_update_plugins');"), 3);
		add_action( 'load-update-core.php', create_function('$a', "remove_action('load-update-core.php', 'wp_update_plugins');"), 3);
		add_action( 'admin_init', create_function('$a', "remove_action('admin_init', '_maybe_update_plugins');"), 3);
		add_action( 'wp_update_plugins', create_function('$a', "remove_action('wp_update_plugins', 'wp_update_plugins');"), 3);
	endif;	
	// Disables Revisions - revisions
	if (isset($youpzt_optimize_options['revisions']) && $youpzt_optimize_options['revisions'] ==true) :
	//add_action('plugins_loaded', create_function( '$a', "define('WP_POST_REVISIONS', false);"));
		add_action('admin_init', create_function( '$a', "remove_action('post_updated','wp_save_post_revision' );"));//新版
		//add_action('plugins_loaded', create_function( '$a', "remove_action('pre_post_update','wp_save_post_revision' );"));//新版
	endif;
	// Disables the update of the themes - themes-update
	if (isset($youpzt_optimize_options['themes-update']) && $youpzt_optimize_options['themes-update'] ==true) :
		add_action( 'load-themes.php', create_function('$a', "remove_action('load-themes.php', 'wp_update_themes');"), 3);
		add_filter('pre_site_transient_update_themes',  create_function('$a', "return null;")); // 关闭主题提示
		add_action( 'load-update.php', create_function('$a', "remove_action('load-update.php', 'wp_update_themes');"), 3);
		add_action( 'load-update-core.php', create_function('$a', "remove_action('load-update-core.php', 'wp_update_themes');"), 3);
		add_action( 'admin_init', create_function('$a', "remove_action('admin_init', '_maybe_update_themes');"), 3);
		add_action( 'wp_update_themes', create_function('$a', "remove_action('wp_update_themes', 'wp_update_themes');"), 3);
	endif;
	// Disables autosave - autosave
	if (isset($youpzt_optimize_options['autosave']) && $youpzt_optimize_options['autosave'] ==true) :
		create_function( '$a', "wp_deregister_script('autosave');");
	endif;
	
	// Disables the WordPress core update checking and notification system. - core-update
	if (isset($youpzt_optimize_options['core-update']) && $youpzt_optimize_options['core-update']==true) :
		add_action( 'admin_init', create_function('$a', "remove_action('admin_init', '_maybe_update_core');"), 3);// 禁止 WordPress 检查更新	
		add_action( 'wp_version_check', create_function('$a', "remove_action('wp_version_check', 'wp_version_check');"), 3);
		//add_action( 'plugins_loaded', create_function( '$a', "remove_action('init', 'wp_version_check');"), 20);
		add_action( 'init', create_function( '$a', "remove_action('init', 'wp_version_check_mod');"), 3); // For WPCNG
		
		remove_action( 'load-update-core.php', 'wp_update_core' );// 移除核心更新的加载项
		add_filter('pre_site_transient_update_core',create_function('$a', "return null;")); // 关闭核心提示
	//add_action('init', 'wp_version_check_mod');
	//remove_action('init', 'wp_version_check_mod', 13);
	endif;
	//禁用trackbacks
	if (isset($youpzt_optimize_options['trackbacks']) && $youpzt_optimize_options['trackbacks']==true){
		$optimize_get = isset($_GET['page']) ? $_GET['page'] : '';
		if($optimize_get=="optimize_page"){
			update_option("default_ping_status",'closed');
		}
	}
	//启用文章特色图像功能
	if (isset($youpzt_optimize_options['thumbnails']) && $youpzt_optimize_options['thumbnails']==true){
		add_theme_support( 'post-thumbnails' );
	}
	//开启后台链接Links栏目
	if (isset($youpzt_optimize_options['open_links']) && $youpzt_optimize_options['open_links']==true){
			add_filter( 'pre_option_link_manager_enabled', '__return_true');

	}
		//彻底禁止WordPress缩略图
	if (isset($youpzt_optimize_options['close_thumb_size']) && $youpzt_optimize_options['close_thumb_size']==true){
		add_filter( 'add_image_size', create_function( '', 'return 1;' ) );
	}
}else{
	// Don't display the version of WP - wp-generator
	if (isset($youpzt_optimize_options['wp-generator']) && $youpzt_optimize_options['wp-generator'] ==true){
		remove_action( 'wp_head','wp_generator' ); 
	}

	if (isset($youpzt_optimize_options['edit_kaifang']) && $youpzt_optimize_options['edit_kaifang'] ==true){
		//Don't display the wlwmanifest of WP - wlwmanifest_link
		remove_action( 'wp_head','wlwmanifest_link' ); 
		// Don't display the XML-RPC of WP - rsd_link
		remove_action( 'wp_head','rsd_link' ); 
		//add_filter('xmlrpc_enabled', '__return_false');
	}
	// Don't display the 文章和评论feed of WP - wp-generator
	if (isset($youpzt_optimize_options['feed_links']) && $youpzt_optimize_options['feed_links'] ==true){
		remove_action( 'wp_head','feed_links',2); 
	}
	// Don't display the 分类等feed of WP - feed_links_extra
	if (isset($youpzt_optimize_options['feed_links_extra']) && $youpzt_optimize_options['feed_links_extra'] ==true){
		remove_action( 'wp_head','feed_links_extra',3); 
	}
	//  Removes the index link 
	if (isset($youpzt_optimize_options['index_link']) && $youpzt_optimize_options['index_link'] ==true){
		remove_action( 'wp_head','index_rel_link' ); 
		remove_action( 'wp_head','start_post_rel_link', 10, 0 ); 
	}
	// 移除菜单的多余CSS选择器
	if (isset($youpzt_optimize_options['css_attributes']) && $youpzt_optimize_options['css_attributes']==true){
		add_filter('nav_menu_css_class', 'optimizer_css_attributes_filter', 100, 1);
		add_filter('nav_menu_item_id', 'optimizer_css_attributes_filter', 100, 1);
		add_filter('page_css_class', 'optimizer_css_attributes_filter', 100, 1);
		function optimizer_css_attributes_filter($var) {
			return is_array($var) ? array_intersect($var, array('current-menu-item','current-post-ancestor','current-menu-ancestor','current-menu-parent')) : '';
		}
	}		
	
}
//replace google fonts
if (isset($youpzt_optimize_options['google-font'])) {

		function youpzt_replace_open_sans(){
			$youpzt_optimize_options =get_option('optimize_options');//开关
				if($youpzt_optimize_options['google-font']==1){
					$replace_google_font_from=false;
				}elseif($youpzt_optimize_options['google-font']==2){
					$replace_google_font_from='//fonts.useso.com/css?family=Open+Sans:300italic,400italic,600italic,300,400,600';

				}elseif($youpzt_optimize_options['google-font']==3){
						$replace_google_font_from='//fonts.lug.ustc.edu.cn/css?family=Open+Sans:300italic,400italic,600italic,300,400,600';
				}
				  wp_deregister_style('open-sans');
				  wp_register_style( 'open-sans',$replace_google_font_from);
				  if(is_admin()) wp_enqueue_style( 'open-sans');
				}
		add_action( 'init', 'youpzt_replace_open_sans' );
}

//更换avatar头像来源
if (isset($youpzt_optimize_options['gravatar-replace'])){
		function youpzt_replace_get_avatar($avatar){
			$youpzt_optimize_options =get_option('optimize_options');//开关
			if ($youpzt_optimize_options['gravatar-replace'] ==2) {//ssl
				$avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
			}elseif ($youpzt_optimize_options['gravatar-replace'] ==3) {//多说
				$avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "gravatar.duoshuo.com", $avatar);
			}elseif($youpzt_optimize_options['gravatar-replace'] ==4){//qiniu
			  $avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cn.gravatar.com", $avatar);
			}elseif ($youpzt_optimize_options['gravatar-replace'] ==5) {//v2ex
				$avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cdn.v2ex.com", $avatar);
			}
		  return $avatar;
		}
	 add_filter("get_avatar", "youpzt_replace_get_avatar");
}

/**
* Disable the emoji's
 */
if (isset($youpzt_optimize_options['no-emoji']) && $youpzt_optimize_options['no-emoji'] ==true) :
	function youpzt_disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );    
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'tiny_mce_plugins', 'ypzt_disable_emojis_tinymce' );
	}
	add_action( 'init', 'youpzt_disable_emojis' );
	/**
	 * Filter function used to remove the tinymce emoji plugin.
	 * 
	 * @param    array  $plugins  
	 * @return   array             Difference betwen the two arrays
	 */
	function ypzt_disable_emojis_tinymce( $plugins ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}
endif;
// 启用工具栏链接

if (isset($youpzt_optimize_setting['enable-optimize-bar']) && $youpzt_optimize_setting['enable-optimize-bar']!=false){
	add_action( 'wp_before_admin_bar_render', 'youpzt_optimize_bar' );
	function youpzt_optimize_bar() {
	  global $wp_admin_bar,$current_user;;
	  if ($current_user->user_level==10) {
	  //Add a link called at the top admin bar
	  $wp_admin_bar->add_node(array(
		'id'    => 'youpzt-optimize',
		'title' => '网站优化工具',
		'href'  => admin_url( 'admin.php?page=optimize_page', 'http' )
	  ));
	  }
	}
}
// Use the latest JQuery
/*function clss_js_init() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', CLSSURL . 'js/jquery.pack.js', false, '1.2.6');
	wp_enqueue_script( 'jquery' );
}
add_action('wp_print_scripts', 'clss_js_init');
*/

// Custom the widgets of Dashboard
/*function custom_widgets_dashboard() {
	//wp_unregister_sidebar_widget('dashboard_primary');
	//wp_unregister_sidebar_widget('dashboard_secondary');
	wp_unregister_sidebar_widget('dashboard_incoming_links');
	wp_unregister_sidebar_widget('dashboard_plugins');
}
add_action('wp_dashboard_setup', 'custom_widgets_dashboard');
*/



// Disables Browse Happy - browse-happy
if (isset($youpzt_optimize_options['browse-happy']) && $youpzt_optimize_options['browse-happy'] ==true) :
	add_action('admin_init', create_function( '$a', "remove_action('in_admin_footer', 'browse_happy');"));
endif;

/*
function add_management_tab($action_links, $plugin_file, $plugin_data, $context) {
	if (strip_tags($plugin_data['Title']) == 'Super Switch') {
		$tempstr0 = '<a href="' . wp_nonce_url('edit.php?page=' . $plugin_file) . '" title="' . __('Manage') . '" class="edit">' . __('Manage') . '</a>';
		$tempstr1 = '<a href="' . wp_nonce_url('options-general.php?page=' . $plugin_file) . '" title="' . __('Options') . '" class="edit">' . __('Options') . '</a>';
		array_unshift($action_links, $tempstr0, $tempstr1);
	}
	return $action_links;
}
add_filter('plugin_action_links', 'add_management_tab', 10, 4);
*/
//
if (isset($youpzt_optimize_options['recently-active-plugins']) && $youpzt_optimize_options['recently-active-plugins'] ==false) :
	add_action('admin_head', 'disable_recently_active_plugins');
endif;
function disable_recently_active_plugins() {
	update_option('recently_activated', array());
}
?>
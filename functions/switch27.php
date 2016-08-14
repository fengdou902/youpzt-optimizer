<?php
// Don't display the version of WP - wp-generator
if (array_key_exists('wp-generator', $clss_options) && $clss_options['wp-generator'] === false) :
remove_action('wp_head', 'wp_generator');
endif;

// Use the latest JQuery
/*function clss_js_init() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', CLSSURL . 'js/jquery.pack.js', false, '1.2.6');
	wp_enqueue_script( 'jquery' );
}
add_action('wp_print_scripts', 'clss_js_init');
*/

// Disables themes preview - themes-preview
if (array_key_exists('themes-preview', $clss_options) && $clss_options['themes-preview'] === false) :
if (strpos($_SERVER['REQUEST_URI'], 'wp-admin/themes.php') !== false) {
	wp_deregister_script('theme-preview');
	wp_deregister_script('thickbox');
}
endif;

// Custom the widgets of Dashboard
/*function custom_widgets_dashboard() {
	//wp_unregister_sidebar_widget('dashboard_primary');
	//wp_unregister_sidebar_widget('dashboard_secondary');
	wp_unregister_sidebar_widget('dashboard_incoming_links');
	wp_unregister_sidebar_widget('dashboard_plugins');
}
add_action('wp_dashboard_setup', 'custom_widgets_dashboard');
*/

// Disables the WordPress core update checking and notification system. - core-update
if (array_key_exists('core-update', $clss_options) && $clss_options['core-update'] === false) :
add_action( 'plugins_loaded', create_function( '$a', "remove_action('init', 'wp_version_check');"), 20);
add_action( 'init', create_function( '$a', "remove_action('init', 'wp_version_check_mod');"), 3); // For WPCNG
//add_action('init', 'wp_version_check_mod');
//remove_action('init', 'wp_version_check_mod', 13);
endif;

// Disables the update of the plugins - plugins-update
if (array_key_exists('plugins-update', $clss_options) && $clss_options['plugins-update'] === false) :
add_action( 'load-plugins.php', create_function('$a', "remove_action('load-plugins.php', 'wp_update_plugins');"), 3);
add_action( 'load-update.php', create_function('$a', "remove_action('load-update.php', 'wp_update_plugins');"), 3);
add_action( 'admin_init', create_function('$a', "remove_action('admin_init', '_maybe_update_plugins');"), 3);
add_action( 'wp_update_plugins', create_function('$a', "remove_action('wp_update_plugins', 'wp_update_plugins');"), 3);
/*add_action('admin_menu', create_function( '$a', "remove_action('admin_init', 'wp_update_plugins');"));
add_action('admin_menu', create_function( '$a', "remove_action('admin_init', '_maybe_update_plugins');"));
add_action('admin_init', create_function( '$a', "remove_action('load-plugins.php', 'wp_update_plugins');"));
add_action('plugins_loaded', create_function( '$a', "remove_action('init', 'wp_update_plugins');"));
add_action('admin_init', create_function( '$a', "remove_action('after_plugin_row', 'wp_plugin_update_row');"));*/
endif;

// Disables the update of the themes - themes-update
if (array_key_exists('themes-update', $clss_options) && $clss_options['themes-update'] === false) :
add_action( 'admin_init', create_function('$a', "remove_action('admin_init', '_maybe_update_themes');"), 3);
add_action( 'wp_update_themes', create_function('$a', "remove_action('wp_update_themes', 'wp_update_themes');"), 3);
/*add_action('admin_menu', create_function( '$a', "remove_action('admin_init', 'wp_update_plugins');"));
add_action('admin_menu', create_function( '$a', "remove_action('admin_init', '_maybe_update_plugins');"));
add_action('admin_init', create_function( '$a', "remove_action('load-plugins.php', 'wp_update_plugins');"));
add_action('plugins_loaded', create_function( '$a', "remove_action('init', 'wp_update_plugins');"));
add_action('admin_init', create_function( '$a', "remove_action('after_plugin_row', 'wp_plugin_update_row');"));*/
endif;

// Disables Revisions - revisions
if (array_key_exists('revisions', $clss_options) && $clss_options['revisions'] === false) :
add_action('plugins_loaded', create_function( '$a', "define('WP_POST_REVISIONS', false);"));
endif;

// Disables Browse Happy - browse-happy
if (array_key_exists('browse-happy', $clss_options) && $clss_options['browse-happy'] === false) :
add_action('admin_init', create_function( '$a', "remove_action('in_admin_footer', 'browse_happy');"));
endif;

// Disables autosave - autosave
if (array_key_exists('autosave', $clss_options) && $clss_options['autosave'] === false) :
add_action('admin_print_scripts', create_function( '$a', "wp_deregister_script('autosave');"));
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
if (array_key_exists('recently-active-plugins', $clss_options) && $clss_options['recently-active-plugins'] === false) :
add_action('admin_head', 'disable_recently_active_plugins');
endif;

?>
<?php
/*
	Plugin Name: AppAd Manager
	Plugin URI: http://blog.meloniq.net/2012/03/08/wp-plugin-appad-manager/
	Description: Displays google adsense (or other ads) between posts in AppThemes Premium Themes.
	Author: MELONIQ.NET
	Version: 1.0.0
	Author URI: http://blog.meloniq.net
*/


global $appad_dbversion;
$appad_version = '1.0.0';
define('APPAD_VERSION', '1.0.0');
$appad_dbversion = '100';
// Init options & tables during activation & deregister init option
register_activation_hook( plugin_basename(__FILE__), 'appad_activate' );

/* PLUGIN and WP-CONTENT directory constants if not already defined */
if ( ! defined( 'WP_PLUGIN_URL' ) )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
if ( ! defined( 'WP_CONTENT_URL' ) )
	define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );

if ( ! defined( 'APPAD_PLUGIN_BASENAME' ) )
	define( 'APPAD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( ! defined( 'APPAD_PLUGIN_NAME' ) )
	define( 'APPAD_PLUGIN_NAME', trim( dirname( APPAD_PLUGIN_BASENAME ), '/' ) );
if ( ! defined( 'APPAD_PLUGIN_DIR' ) )
	define( 'APPAD_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . APPAD_PLUGIN_NAME );
if ( ! defined( 'APPAD_PLUGIN_URL' ) )
	define( 'APPAD_PLUGIN_URL', WP_PLUGIN_URL . '/' . APPAD_PLUGIN_NAME );

if ( ! defined( 'APPAD_POSITION' ) )
	define('APPAD_POSITION', 9);
if ( ! defined( 'APPAD_FAVICON' ) )
	define('APPAD_FAVICON', APPAD_PLUGIN_URL.'/favicon.png');
	
	
/**
 * Load Text-Domain
 */
load_plugin_textdomain( 'appad', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/**
 * Initialize admin menu
 */
if ( is_admin() ) {	
	add_action('admin_menu', 'appad_add_menu_links');
} else {
	// Add a author to the header
	//add_action('wp_head', create_function('', 'echo "\n<meta name=\'AppAd Manager\' content=\'http://www.meloniq.net\' />\n";') );
}


/**
 * Load scripts
 */
function appad_load_scripts() {
  wp_enqueue_script('jquery');
}		
//add_action('wp_print_scripts', 'appad_load_scripts');

function appad_load_admin_scripts() {
  wp_enqueue_script('jquery-ui-tabs'); 
}
add_action('admin_enqueue_scripts', 'appad_load_admin_scripts');			


/**
 * Load styles
 */
function appad_load_styles() {
	wp_register_style('appad_style', plugins_url(APPAD_PLUGIN_NAME.'/style.css'));
	wp_enqueue_style('appad_style');	
}		
add_action('wp_print_styles', 'appad_load_styles');

function appad_load_admin_styles() {
	wp_register_style('appad_admin_style', plugins_url(APPAD_PLUGIN_NAME.'/admin-style.css'));
	wp_enqueue_style('appad_admin_style');	
}
add_action('admin_enqueue_scripts', 'appad_load_admin_styles');			


/**
 * Load hooks for used theme
 */
function langbf_load_hooks() {
	global $app_theme;
  if(isset($app_theme)){
    switch($app_theme) {
      case 'Clipper':
        require( dirname(__FILE__) . '/clipper/clipper-hooks.php' );
        break;
      case 'ClassiPress':
        require( dirname(__FILE__) . '/classipress/classipress-hooks.php' );
        break;
      case 'JobRoller':
        require( dirname(__FILE__) . '/jobroller/jobroller-hooks.php' );
        break;
      case 'Vantage':
        require( dirname(__FILE__) . '/vantage/vantage-hooks.php' );
        break;
      default:
        // do nothing, no supported theme
        break;
    }
  }
}
add_action('appthemes_init', 'langbf_load_hooks');			


/**
 * Populate administration menu of the plugin
 */
function appad_add_menu_links() {
  if (!current_user_can('manage_options')) return;

  add_menu_page(__('AppAd Manager','appad'), __('AppAd Manager','appad'), 'manage_options', basename(__FILE__) , 'appad_dashboard', APPAD_FAVICON, APPAD_POSITION);
  add_submenu_page(basename(__FILE__), __('Dashboard', 'appad'), __('Dashboard', 'appad'), 'manage_options', basename(__FILE__), 'appad_dashboard');
  add_submenu_page(basename(__FILE__), __('Clipper', 'appad'), __('Clipper', 'appad'), 'manage_options', 'appad-clipper', 'appad_clipper');
  add_submenu_page(basename(__FILE__), __('ClassiPress', 'appad'),  __('ClassiPress', 'appad') , 'manage_options', 'appad-classipress', 'appad_classipress');
  add_submenu_page(basename(__FILE__), __('JobRoller', 'appad'),  __('JobRoller', 'appad') , 'manage_options', 'appad-jobroller', 'appad_jobroller');
  add_submenu_page(basename(__FILE__), __('Vantage', 'appad'),  __('Vantage', 'appad') , 'manage_options', 'appad-vantage', 'appad_vantage');

}


/**
 * Create welcome page in admin
 */
function appad_dashboard() {
	global $app_theme;
	include_once (dirname (__FILE__) . '/appad-welcome.php');
}


/**
 * Create clipper page in admin
 */
function appad_clipper() {
	global $app_theme;
	include_once (dirname (__FILE__) . '/clipper/clipper-admin.php');
}


/**
 * Create classipress page in admin
 */
function appad_classipress() {
	global $app_theme;
	include_once (dirname (__FILE__) . '/classipress/classipress-admin.php');
}


/**
 * Create jobroller page in admin
 */
function appad_jobroller() {
	global $app_theme;
	include_once (dirname (__FILE__) . '/jobroller/jobroller-admin.php');
}


/**
 * Create welcome page in admin
 */
function appad_vantage() {
	global $app_theme;
	include_once (dirname (__FILE__) . '/vantage/vantage-admin.php');
}


/**
 * Helper function, check if string start with given search
 */
function appad_str_starts_with($string, $search) {
    return (strncmp($string, $search, strlen($search)) == 0);
}

/**
 * Helper function, clean string
 */
function appad_clean($string) {
    $string = stripslashes($string);
    $string = trim($string);
    return $string;
}

/**
 * Action on plugin activate
 */
function appad_activate() {
	global $wpdb, $appad_dbversion;

	appad_install_options($appad_dbversion);
	appad_blogroll_links();

}


/**
 * Install default options
 */
function appad_install_options($appad_dbversion) {
	global $wpdb, $app_theme;
	
	$appad_saved_dbversion = get_option('appad_db_version');
	
  // if fresh installation, enable right theme functions
	if(!$appad_saved_dbversion){
  	update_option('appad_clpr_active', 'no');
  	update_option('appad_cp_active', 'no');
  	update_option('appad_jr_active', 'no');
  	update_option('appad_va_active', 'no');
	
    if(isset($app_theme)){
      switch($app_theme) {
        case 'Clipper':
          update_option('appad_clpr_active', 'yes');
          break;
        case 'ClassiPress':
          update_option('appad_cp_active', 'yes');
          break;
        case 'JobRoller':
          update_option('appad_jr_active', 'yes');
          break;
        case 'Vantage':
          update_option('appad_va_active', 'yes');
          break;
        default:
          // do nothing, no supported theme
          break;
      }
    }
	}

  // update db version
  update_option('appad_db_version', $appad_dbversion);
}


/**
 * Adds links to blogroll
 */
function appad_blogroll_links() {
	global $wpdb;

	// first check and make sure this link doesn't already exist
	$wpdb->get_row("SELECT link_id FROM $wpdb->links WHERE link_url = 'http://wordpress.org/extend/plugins/appad-manager/'");

  if($wpdb->num_rows == 0) {
		// get the correct link category id
		$results = $wpdb->get_row("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'link_category' LIMIT 1");
		if($results) $blogroll_id = $results->term_taxonomy_id; else $blogroll_id = '2';

		$default_links = array();
		$default_links[] = array('link_url' => 'http://wordpress.org/extend/plugins/appad-manager/','link_name' => 'AppAd Manager','link_rss' => '','link_notes' =>'');
		//$default_links[] = array('link_url' => 'http://blog.meloniq.net/','link_name' => 'Blog of meloniq','link_rss' => '','link_notes' =>'');

		foreach ($default_links as $link) :
			$wpdb->insert($wpdb->links, $link);
			$wpdb->insert($wpdb->term_relationships, array('term_taxonomy_id' => $blogroll_id, 'object_id' => $wpdb->insert_id));
		endforeach;
	}

}


?>
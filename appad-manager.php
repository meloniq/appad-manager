<?php
/*
Plugin Name: AppAd Manager
Plugin URI: https://blog.meloniq.net/2012/03/08/wp-plugin-appad-manager/
Description: Displays google adsense (or other ads) between posts in AppThemes Premium Themes.

Version: 1.2

Author: MELONIQ.NET
Author URI: https://blog.meloniq.net
Text Domain: appad-manager
Domain Path: /languages

Requires at least: 4.9
Requires PHP: 5.6
*/


define( 'APPAD_VERSION', '1.1' );
define( 'APPAD_TD', 'appad-manager' );
define( 'APPAD_POSITION', 9 );
define( 'APPAD_FAVICON', plugins_url( 'favicon.png', __FILE__ ) );


/**
 * Load Text-Domain.
 */
load_plugin_textdomain( APPAD_TD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/**
 * Setup AppAd Manager.
 *
 * @return void
 */
function appad_manager_setup() {

	// Check for existence of AppThemes compatible product
	if ( ! function_exists( 'appthemes_init' ) ) {
		if ( ! appad_manager_is_network_activated() ) {
			add_action( 'admin_notices', 'appad_manager_display_version_warning' );
		}
		return;
	}

	$themes = array(
		'classipress',
		'clipper',
		'hirebee',
		'ideas',
		'jobroller',
		'qualitycontrol',
		'taskerr',
		'vantage',
	);

	foreach ( $themes as $theme_slug ) {
		$filter_name = 'appthemes_addons_mp_markup_' . $theme_slug . '_page_app-addons-mp';
		add_filter( $filter_name, 'appad_manager_addons_mp_markup', 9, 2 );
	}

}
add_action( 'init', 'appad_manager_setup' );


/**
 * Display warning if AppThemes compatible product not installed.
 *
 * @return void
 */
function appad_manager_display_version_warning() {
	global $pagenow;

	// display only on Plugins, Themes, and Updates pages
	$allowed_pages = array( 'plugins.php', 'themes.php', 'update-core.php' );
	if ( ! in_array( $pagenow, $allowed_pages ) ) {
		return;
	}

	$message = __( 'AppAd Manager for AppThemes does not support the current theme. Please use a compatible AppThemes theme.', APPAD_TD );
	$message .= printf( ' <a target="_blank" href="http://bit.ly/AppThemes-themes">%s</a>', __( 'Buy it now!', APPAD_TD ) );

	echo '<div class="error fade"><p>' . $message . '</p></div>';
}


/**
 * Checks if plugin is network activated.
 *
 * @return bool
 */
function appad_manager_is_network_activated() {
	if ( ! is_multisite() ) {
		return false;
	}

	$plugins = get_site_option( 'active_sitewide_plugins' );

	return isset( $plugins[ plugin_basename( __FILE__ ) ] );
}


/**
 * Load backend scripts.
 *
 * @return void
 */
function appad_load_admin_scripts() {
	wp_enqueue_script( 'jquery-ui-tabs' );
}
add_action( 'admin_enqueue_scripts', 'appad_load_admin_scripts' );


/**
 * Load frontend styles.
 *
 * @return void
 */
function appad_load_styles() {
	wp_register_style( 'appad_style', plugins_url( 'style.css', __FILE__ ) );
	wp_enqueue_style( 'appad_style' );
}
add_action( 'wp_print_styles', 'appad_load_styles' );


/**
 * Load backend styles.
 *
 * @return void
 */
function appad_load_admin_styles() {
	wp_register_style( 'appad_admin_style', plugins_url( 'admin-style.css', __FILE__ ) );
	wp_enqueue_style( 'appad_admin_style' );
}
add_action( 'admin_enqueue_scripts', 'appad_load_admin_styles' );


/**
 * Load hooks for used theme.
 *
 * @return void
 */
function langbf_load_hooks() {
	global $app_theme;

	if ( ! empty( $app_theme ) ) {
		switch( $app_theme ) {
			case 'Clipper':
				require_once( dirname( __FILE__ ) . '/clipper/clipper-hooks.php' );
				break;
			case 'ClassiPress':
				require_once( dirname( __FILE__ ) . '/classipress/classipress-hooks.php' );
				break;
			case 'JobRoller':
				require_once( dirname( __FILE__ ) . '/jobroller/jobroller-hooks.php' );
				break;
			case 'Vantage':
				require_once( dirname( __FILE__ ) . '/vantage/vantage-hooks.php' );
				break;
			default:
				// do nothing, no supported theme
				break;
		}
	}
}
add_action( 'appthemes_init', 'langbf_load_hooks' );


/**
 * Populate administration menu of the plugin.
 *
 * @return void
 */
function appad_add_menu_links() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	add_menu_page( __( 'AppAd Manager', APPAD_TD ), __( 'AppAd Manager', APPAD_TD ), 'manage_options', basename( __FILE__ ), 'appad_dashboard', APPAD_FAVICON, APPAD_POSITION );
	add_submenu_page( basename( __FILE__ ), __( 'Dashboard', APPAD_TD ), __( 'Dashboard', APPAD_TD ), 'manage_options', basename( __FILE__ ), 'appad_dashboard' );
	add_submenu_page( basename( __FILE__ ), __( 'Clipper', APPAD_TD ), __( 'Clipper', APPAD_TD ), 'manage_options', 'appad-clipper', 'appad_clipper' );
	add_submenu_page( basename( __FILE__ ), __( 'ClassiPress', APPAD_TD ), __( 'ClassiPress', APPAD_TD ), 'manage_options', 'appad-classipress', 'appad_classipress' );
	add_submenu_page( basename( __FILE__ ), __( 'JobRoller', APPAD_TD ), __( 'JobRoller', APPAD_TD ), 'manage_options', 'appad-jobroller', 'appad_jobroller' );
	add_submenu_page( basename( __FILE__ ), __( 'Vantage', APPAD_TD ), __( 'Vantage', APPAD_TD ), 'manage_options', 'appad-vantage', 'appad_vantage' );

}
add_action( 'admin_menu', 'appad_add_menu_links' );


/**
 * Create Welcome page in admin.
 *
 * @return void
 */
function appad_dashboard() {
	global $app_theme;

	include_once( dirname( __FILE__ ) . '/appad-welcome.php' );
}


/**
 * Create Clipper page in admin.
 *
 * @return void
 */
function appad_clipper() {
	global $app_theme;

	include_once( dirname( __FILE__ ) . '/clipper/clipper-admin.php' );
}


/**
 * Create ClassiPress page in admin.
 *
 * @return void
 */
function appad_classipress() {
	global $app_theme;

	include_once( dirname( __FILE__ ) . '/classipress/classipress-admin.php' );
}


/**
 * Create JobRoller page in admin.
 *
 * @return void
 */
function appad_jobroller() {
	global $app_theme;

	include_once( dirname( __FILE__ ) . '/jobroller/jobroller-admin.php' );
}


/**
 * Create Vantage page in admin.
 *
 * @return void
 */
function appad_vantage() {
	global $app_theme;

	include_once( dirname( __FILE__ ) . '/vantage/vantage-admin.php' );
}


/**
 * Helper function, check if string start with given search.
 *
 * @param string $string
 * @param string $search
 *
 * @return bool
 */
function appad_str_starts_with( $string, $search ) {
	return ( strncmp( $string, $search, strlen( $search ) ) == 0 );
}


/**
 * Helper function, clean string.
 *
 * @param string $string
 *
 * @return string
 */
function appad_clean( $string ) {
	$string = stripslashes( $string );
	$string = trim( $string );

	return $string;
}


/**
 * AppThemes Addons MP markup.
 *
 * @param string $output
 * @param object $addon
 *
 * @return string
 */
function appad_manager_addons_mp_markup( $output, $addon ) {
	if ( ! is_object( $addon ) || empty( $addon->link ) ) {
		return $output;
	}

	$link_args = array(
		'aid'          => '179',
		'utm_source'   => 'addons',
		'utm_medium'   => 'wp-admin',
		'utm_campaign' => 'AppAd%20Manager',
	);
	$new_url = remove_query_arg( array_keys( $link_args ), $addon->link );
	$new_url = add_query_arg( $link_args, $new_url );

	$output = str_replace( $addon->link, $new_url, $output );
	$output = str_replace( esc_url( $addon->link ), esc_url( $new_url ), $output );

	return $output;
}


/**
 * Action on plugin activate.
 *
 * @return void
 */
function appad_activate() {

	appad_install_options();
}
register_activation_hook( plugin_basename( __FILE__ ), 'appad_activate' );


/**
 * Install default options.
 *
 * @return void
 */
function appad_install_options() {
	global $app_theme;

	$previous_version = get_option( 'appad_db_version' );

	// fresh install
	if ( ! $previous_version ) {
		update_option( 'appad_clpr_active', 'no' );
		update_option( 'appad_cp_active', 'no' );
		update_option( 'appad_jr_active', 'no' );
		update_option( 'appad_va_active', 'no' );

		if ( ! empty( $app_theme ) ) {
			switch( $app_theme ) {
				case 'Clipper':
					update_option( 'appad_clpr_active', 'yes' );
					break;
				case 'ClassiPress':
					update_option( 'appad_cp_active', 'yes' );
					break;
				case 'JobRoller':
					update_option( 'appad_jr_active', 'yes' );
					break;
				case 'Vantage':
					update_option( 'appad_va_active', 'yes' );
					break;
				default:
					// do nothing, no supported theme
					break;
			}
		}
	}

	// update db version
	update_option( 'appad_db_version', APPAD_VERSION );
}



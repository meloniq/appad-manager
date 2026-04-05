<?php
/**
 * Plugin Name: AppAd Manager
 * Plugin URI: https://blog.meloniq.net/2012/03/08/wp-plugin-appad-manager/
 *
 * Description: Displays google adsense (or other ads) between posts in AppThemes Premium Themes.
 * Tags: adsense, advertise, banner, adsense, appthemes
 *
 * Requires at least: 4.9
 * Requires PHP: 5.6
 * Version: 1.3
 *
 * Author: MELONIQ.NET
 * Author URI: https://blog.meloniq.net
 *
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: appad-manager
 * Domain Path: /languages
 *
 * @package AppAdManager
 */

// If this file is accessed directly, then abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin version and textdomain constants.
 */
define( 'APPAD_VERSION', '1.3' );
define( 'APPAD_TD', 'appad-manager' );


/**
 * Setup AppAd Manager.
 *
 * @return void
 */
function appad_manager_setup() {
	global $appad_options;

	require_once __DIR__ . '/src/functions.php';

	// Check for existence of AppThemes compatible product.
	if ( ! function_exists( 'appthemes_init' ) ) {
		if ( ! appad_manager_is_network_activated() ) {
			add_action( 'admin_notices', 'appad_manager_display_version_warning' );
		}
		return;
	}

	require_once __DIR__ . '/src/options.php';

	if ( is_admin() ) {

		if ( ! class_exists( 'APP_Tabs_Page' ) ) {
			add_action( 'admin_notices', 'app_openai_tagger_display_version_warning' );
			return;
		}

		// initialize admin page.
		require_once __DIR__ . '/src/class-admin.php';
		new APP_Ad_Manager_Settings( $appad_options );
	}

	// initialize scanner.
	require_once __DIR__ . '/src/class-hooks.php';
	new APP_Ad_Manager_Hooks( $appad_options );
}
add_action( 'appthemes_init', 'appad_manager_setup' );


/**
 * Load Text-Domain.
 *
 * @return void
 */
function appad_manager_load_textdomain() {
	load_plugin_textdomain( APPAD_TD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'appad_manager_load_textdomain' );


/**
 * Load frontend styles.
 *
 * @return void
 */
function appad_load_styles() {
	wp_register_style( 'appad_style', plugins_url( 'style.css', __FILE__ ), array(), APPAD_VERSION );
	wp_enqueue_style( 'appad_style' );
}
add_action( 'wp_print_styles', 'appad_load_styles' );


/**
 * AppThemes Addons MP markup.
 *
 * @param string $output Addons MP output.
 * @param object $addon Addons MP addon object.
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
	$new_url   = remove_query_arg( array_keys( $link_args ), $addon->link );
	$new_url   = add_query_arg( $link_args, $new_url );

	$output = str_replace( $addon->link, $new_url, $output );
	$output = str_replace( esc_url( $addon->link ), esc_url( $new_url ), $output );

	return $output;
}


/**
 * Add Addons MP markup.
 *
 * @return void
 */
function appad_manager_addons_mp() {
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
add_action( 'appthemes_init', 'appad_manager_addons_mp' );

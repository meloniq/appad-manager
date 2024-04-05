<?php
/*
Plugin Name: AppAd Manager
Plugin URI: https://blog.meloniq.net/2012/03/08/wp-plugin-appad-manager/
Description: Displays google adsense (or other ads) between posts in AppThemes Premium Themes.

Version: 1.3

Author: MELONIQ.NET
Author URI: https://blog.meloniq.net
Text Domain: appad-manager
Domain Path: /languages

Requires at least: 4.9
Requires PHP: 5.6
*/


define( 'APPAD_TD', 'appad-manager' );


/**
 * Setup AppAd Manager.
 *
 * @return void
 */
function appad_manager_setup() {
	global $appad_options;

	require_once( dirname( __FILE__ ) . '/src/functions.php' );

	// Check for existence of AppThemes compatible product
	if ( ! function_exists( 'appthemes_init' ) ) {
		if ( ! appad_manager_is_network_activated() ) {
			add_action( 'admin_notices', 'appad_manager_display_version_warning' );
		}
		return;
	}

	require_once( dirname( __FILE__ ) . '/src/options.php' );

	if ( is_admin() ) {

		if ( ! class_exists( 'APP_Tabs_Page' ) ) {
			add_action( 'admin_notices', 'app_openai_tagger_display_version_warning' );
			return;
		}

		// initialize admin page
		require_once( dirname( __FILE__ ) . '/src/class-admin.php' );
		new APP_Ad_Manager_Settings( $appad_options );
	}

	// initialize scanner
	require_once( dirname( __FILE__ ) . '/src/class-hooks.php' );
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
add_action( 'plugins_loaded', 'appad_manager_load_textdomain' );


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

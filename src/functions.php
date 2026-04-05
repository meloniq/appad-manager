<?php
/**
 * Helper functions.
 *
 * @package AppAdManager
 */

/**
 * Helper function, check if string start with given search.
 *
 * @param string $text   The string to check.
 * @param string $search The string to search for at the start of $text.
 *
 * @return bool
 */
function appad_str_starts_with( $text, $search ) {
	return ( strncmp( $text, $search, strlen( $search ) ) == 0 );
}


/**
 * Helper function, clean string.
 *
 * @param string $text A string to clean.
 *
 * @return string
 */
function appad_clean( $text ) {
	$text = stripslashes( $text );
	$text = trim( $text );

	return $text;
}


/**
 * Display warning if AppThemes compatible product not installed.
 *
 * @return void
 */
function appad_manager_display_version_warning() {
	global $pagenow;

	// display only on Plugins, Themes, and Updates pages.
	$allowed_pages = array( 'plugins.php', 'themes.php', 'update-core.php' );
	if ( ! in_array( $pagenow, $allowed_pages, true ) ) {
		return;
	}

	$message  = __( 'AppAd Manager for AppThemes does not support the current theme. Please use a compatible AppThemes theme.', 'appad-manager' );
	$message .= printf( ' <a target="_blank" href="http://bit.ly/AppThemes-themes">%s</a>', __( 'Buy it now!', 'appad-manager' ) );

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

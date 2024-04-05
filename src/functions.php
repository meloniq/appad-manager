<?php

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



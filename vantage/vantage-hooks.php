<?php
/**
 * AppAd Vantage Hooks
 */
if ( get_option('appad_va_active') == 'yes' ) {

	if ( get_option('appad_va_between_active') == 'yes' )
		add_action( 'appthemes_after_post', 'appad_va_between' );

}


// inserts ads between business listings
function appad_va_between() {
	global $appad_counter;

	if ( ! isset( $appad_counter ) )
		$appad_counter = 0;

	$appad_frequency = get_option('appad_va_between_frequency');
	$appad_counter++;

	if ( $appad_counter == $appad_frequency ) {
		echo '<div class="appad-va-between-box"><div class="appad-va-between-adsense">';
		echo get_option('appad_va_between_code');
		echo '</div></div>';
		$appad_counter = 0;
	}

}


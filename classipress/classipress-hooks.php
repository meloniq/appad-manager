<?php
/**
 * AppAd ClassiPress Hooks
 */
if ( get_option('appad_cp_active') == 'yes' ) {

	if ( get_option('appad_cp_between_active') == 'yes' ) {
		add_action( 'appthemes_after_post', 'appad_cp_between' );
		add_action( 'appthemes_before_loop', 'appad_cp_between_reset' );
	}

}


// inserts ads between ads
function appad_cp_between() {
	global $appad_counter;

	if ( ! isset( $appad_counter ) )
		$appad_counter = 0;

	$appad_frequency = get_option('appad_cp_between_frequency');
	$appad_counter++;

	if ( $appad_counter == $appad_frequency ) {
		echo '<div class="appad-cp-between-box"><div class="appad-cp-between-adsense">';
		echo get_option('appad_cp_between_code');
		echo '</div></div>';
		$appad_counter = 0;
	}

}


// resets between counter
function appad_cp_between_reset() {
	global $appad_counter;
	$appad_counter = 0;
}


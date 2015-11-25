<?php
/**
 * AppAd Vantage Admin.
 */
global $wpdb, $app_theme;

if ( isset( $app_theme ) && $app_theme == 'Vantage' ) :

	echo '<div class="update-nag">';
	printf( __( 'Sorry, %s Theme is not supported yet.', APPAD_TD ), 'Vantage' );
	echo '</div>';
else :
	update_option( 'appad_va_active', 'no' );

	echo '<div class="update-nag">';
	printf( __( 'Sorry, You are not using %s Theme, so You can not access this page.', APPAD_TD ), 'Vantage' );
	printf( __( ' <a target="_blank" href="%s">Buy it now!</a>', APPAD_TD ), 'http://bit.ly/s23oNj' );
	echo '</div>';
endif; //app_theme


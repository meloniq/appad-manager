<?php
/**
 * AppAd JobRoller Hooks
 */
if( get_option('appad_jr_active') == 'yes' ) :

  if( get_option('appad_jr_between_active') == 'yes' ) {
    add_action( 'appthemes_before_job_listing', 'appad_jr_between' );
    //add_action( 'appthemes_before_resume', 'appad_jr_between' );
    add_action( 'appthemes_before_job_listing_loop', 'appad_jr_between_reset' );
    //add_action( 'appthemes_before_resume_loop', 'appad_jr_between_reset' );
  }

endif; //appad_jr_active


// inserts ads between job offers
function appad_jr_between() {
  global $appad_counter;

  if( !isset($appad_counter) )
    $appad_counter = -1;

  $appad_frequency = get_option('appad_jr_between_frequency');
  $appad_counter++;

  if( $appad_counter == $appad_frequency ) {
    echo '<div class="appad-jr-between-box"><div class="appad-jr-between-adsense">';
    echo get_option('appad_jr_between_code');
    echo '</div></div>';
    $appad_counter = 0;
  }

}

// resets between counter
function appad_jr_between_reset() {
  global $appad_counter;
  $appad_counter = -1;
}

?>
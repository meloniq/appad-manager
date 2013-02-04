<?php
/**
 * AppAd Clipper Admin
 */
global $wpdb, $app_theme;

if ( isset( $app_theme ) && $app_theme == 'Clipper' ) :
	//update options
	if ( isset( $_POST['options_update'] ) ) {
		foreach ( $_POST as $key => $value ) {
			if ( appad_str_starts_with( $key, 'appad_' ) )
				update_option( $key, appad_clean( $value ) );
		}
		$appad_message = '<div class="updated"><p><strong>' . __( 'Your settings has been successfully updated.', 'appad' ) . '</strong></p></div>';
	}
?>
<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function() {
		jQuery("#tabs-wrap").tabs({fx: {opacity: 'toggle', duration: 200}});
	});
// ]]>
</script>
<div class="wrap">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2><?php _e( 'General Settings', 'appad' ); ?></h2>
	<?php if( isset( $appad_message ) ) echo $appad_message; ?>
	<form name="mainform" method="post" action="">
		<input type="hidden" value="1" name="options_update">

		<div id="tabs-wrap" class="">
			<ul class="tabs">
				<li class=""><a href="#tab1"><?php _e( 'General', 'appad' ); ?></a></li>
				<li class=""><a href="#tab2"><?php _e( 'Between coupons', 'appad' ); ?></a></li>
			</ul>

			<div id="tab1" class="">
				<table class="widefat fixed" style="width:850px; margin-bottom:20px;">
					<thead>
						<tr>
							<th width="200px" scope="col"><?php _e( 'General', 'appad' ); ?></th>
							<th scope="col">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="titledesc"><?php _e( 'Activate ads?', 'appad' ); ?></td>
							<td class="forminp">
								<select name="appad_clpr_active">
									<option value="no" <?php selected( get_option('appad_clpr_active') == 'no' ); ?> ><?php _e( 'No', 'appad' ); ?></option>
									<option value="yes" <?php selected( get_option('appad_clpr_active') == 'yes' ); ?> ><?php _e( 'Yes', 'appad' ); ?></option>
								</select>
								<br /><small><?php _e( 'Enable or disable all advertise options. Each advertise have as well individual switch.', 'appad' ); ?></small>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- Between coupons -->
			<div id="tab2" class="">
				<table class="widefat fixed" style="width:850px; margin-bottom:20px;">
					<thead>
						<tr>
							<th width="200px" scope="col"><?php _e( 'Ads between coupons', 'appad' ); ?></th>
							<th scope="col">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="titledesc"><?php _e( 'Activate?', 'appad' ); ?></td>
							<td class="forminp">
								<select name="appad_clpr_between_active">
									<option value="no" <?php selected( get_option('appad_clpr_between_active') == 'no' ); ?> ><?php _e( 'No', 'appad' ); ?></option>
									<option value="yes" <?php selected( get_option('appad_clpr_between_active') == 'yes' ); ?> ><?php _e( 'Yes', 'appad' ); ?></option>
								</select>
								<br /><small><?php _e( 'Enable inserting advertise between coupons.', 'appad' ); ?></small>
							</td>
						</tr>
						<tr>
							<td class="titledesc"><?php _e( 'Frequency', 'appad' ); ?></td>
							<td class="forminp">
								<select name="appad_clpr_between_frequency">
									<?php for ( $i = 1; $i <= 10; $i++ ) { ?>
										<option value="<?php echo $i; ?>" <?php selected( get_option('appad_clpr_between_frequency') == $i ); ?> ><?php echo $i; ?></option>
									<?php } ?>
								</select>
								<br /><small><?php _e( 'Choose how often should be inserted advertise. After every X coupon.', 'appad' ); ?></small>
							</td>
						</tr>
						<tr>
							<td class="titledesc"><?php _e( 'Ad Code', 'appad' ); ?></td>
							<td class="forminp">
								<textarea id="appad_clpr_between_code" style="width:500px;height:200px;" name="appad_clpr_between_code"><?php echo get_option('appad_clpr_between_code'); ?></textarea>
								<br /><small><?php _e( 'Paste your ad code here (468x60). Supports many popular providers such as Google AdSense.', 'appad' ); ?></small>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'appad' ); ?>" />
			</p>

		</div>
	</form>
</div>
<div class="clear"></div>

<?php
else :
	update_option( 'appad_clpr_active', 'no' );

	echo '<div class="update-nag">';
	printf( __( 'Sorry, You are not using %s Theme, so You can not access this page.', 'appad' ), 'Clipper' );
	printf( __( ' <a target="_blank" href="%s">Buy it now!</a>', 'appad' ), 'http://bit.ly/oLSh2D' );
	echo '</div>';
endif; //app_theme


<?php
/**
 * Administration page.
 */
class APP_Ad_Manager_Settings extends APP_Tabs_Page {

	/**
	 * Setup settings page.
	 *
	 * @return void
	 */
	function setup() {

		$this->textdomain = APPAD_TD;

		$this->args = array(
			'page_title'  => __( 'AppAd Manager Settings', APPAD_TD ),
			'menu_title'  => __( 'AppAd Manager', APPAD_TD ),
			'page_slug'   => 'app-ad-manager',
			'parent'      => 'app-dashboard',
			'screen_icon' => 'options-general',
			'admin_action_priority' => 11,
		);

	}


	/**
	 * Initialize tabs and options.
	 *
	 * @return void
	 */
	protected function init_tabs() {

		$this->tabs->add( 'between', __( 'Between', APPAD_TD ) );
		$this->tabs->add( 'themes', __( 'Themes', APPAD_TD ) );


		$this->tab_sections['between']['settings'] = array(
			'title' => __( 'Between Settings', APPAD_TD ),
			'fields' => array(
				array(
					'title' => __( 'Enabled', APPAD_TD ),
					'type'  => 'checkbox',
					'name'  => 'between_active',
					'desc'  => __( 'Yes', APPAD_TD ),
					'tip'   => __( 'Enable inserting advertise between listings.', APPAD_TD ),
				),
				array(
					'title'  => __( 'Frequency', APPAD_TD ),
					'type'   => 'select',
					'name'   => 'between_frequency',
					'values' => $this->get_frequency_options(),
					'tip'    => __( 'Choose how often should be inserted advertise. After every X listing.', APPAD_TD ),
				),
				array(
					'title' => __( 'Ad Code', APPAD_TD ),
					'desc'  => __( 'Paste your ad code here (468x60). Supports many popular providers such as Google AdSense.', APPAD_TD ),
					'type'  => 'textarea',
					'name'  => 'between_code',
					'extra' => array(
						'style' => 'width: 500px; height: 200px;'
					),
					'tip'   => __( 'Paste your ad code here (468x60). Supports many popular providers such as Google AdSense.', APPAD_TD ),
				),
			),
		);


		$this->tab_sections['themes']['support'] = array(
			'title' => __( 'Supported Themes', APPAD_TD ),
			'fields' => array(
				array(
					'title' => __( 'Clipper', APPAD_TD ),
					'name'  => '_blank',
					'type'  => '',
					'desc'  => html( 'img', array( 'src' => plugins_url( '/images/clpr-screenshot.png', dirname( __FILE__ ) ), 'width' => '260', 'alt' => 'Clipper' ) ) . '<br />' .
						sprintf( __( '<a target="_blank" href="%s">Buy Theme!</a>', APPAD_TD ), 'https://bit.ly/oLSh2D' ),
					'extra' => array(
						'style' => 'display: none;'
					),
				),
				array(
					'title' => __( 'ClassiPress', APPAD_TD ),
					'name'  => '_blank',
					'type'  => '',
					'desc'  => html( 'img', array( 'src' => plugins_url( '/images/cp-screenshot.png', dirname( __FILE__ ) ), 'width' => '260', 'alt' => 'Clipper' ) ) . '<br />' .
						sprintf( __( '<a target="_blank" href="%s">Buy Theme!</a>', APPAD_TD ), 'https://bit.ly/j5G6mG' ),
					'extra' => array(
						'style' => 'display: none;'
					),
				),
				array(
					'title' => __( 'JobRoller', APPAD_TD ),
					'name'  => '_blank',
					'type'  => '',
					'desc'  => html( 'img', array( 'src' => plugins_url( '/images/jr-screenshot.png', dirname( __FILE__ ) ), 'width' => '260', 'alt' => 'Clipper' ) ) . '<br />' .
						sprintf( __( '<a target="_blank" href="%s">Buy Theme!</a>', APPAD_TD ), 'https://bit.ly/wQt43f' ),
					'extra' => array(
						'style' => 'display: none;'
					),
				),
			),
		);


	}


	/**
	 * Get frequency options.
	 *
	 * @return array
	 */
	protected function get_frequency_options() {
		$options = array();

		for ( $i = 1; $i <= 10; $i++ ) {
			$options[$i] = $i;
		}

		return $options;
	}


	/**
	 * Outputs a page styles.
	 *
	 * @return void
	 */
	function page_head() {
?>
<style type="text/css">
.form-table td label { display: block; }
</style>
<?php
		parent::page_head();
	}


}

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

		$this->textdomain = 'appad-manager';

		$this->args = array(
			'page_title'            => __( 'AppAd Manager Settings', 'appad-manager' ),
			'menu_title'            => __( 'AppAd Manager', 'appad-manager' ),
			'page_slug'             => 'app-ad-manager',
			'parent'                => 'app-dashboard',
			'screen_icon'           => 'options-general',
			'admin_action_priority' => 11,
		);
	}


	/**
	 * Initialize tabs and options.
	 *
	 * @return void
	 */
	protected function init_tabs() {

		$this->tabs->add( 'between', __( 'Between', 'appad-manager' ) );
		$this->tabs->add( 'themes', __( 'Themes', 'appad-manager' ) );

		$this->tab_sections['between']['settings'] = array(
			'title'  => __( 'Between Settings', 'appad-manager' ),
			'fields' => array(
				array(
					'title' => __( 'Enabled', 'appad-manager' ),
					'type'  => 'checkbox',
					'name'  => 'between_active',
					'desc'  => __( 'Yes', 'appad-manager' ),
					'tip'   => __( 'Enable inserting advertise between listings.', 'appad-manager' ),
				),
				array(
					'title'  => __( 'Frequency', 'appad-manager' ),
					'type'   => 'select',
					'name'   => 'between_frequency',
					'values' => $this->get_frequency_options(),
					'tip'    => __( 'Choose how often should be inserted advertise. After every X listing.', 'appad-manager' ),
				),
				array(
					'title' => __( 'Ad Code', 'appad-manager' ),
					'desc'  => __( 'Paste your ad code here (468x60). Supports many popular providers such as Google AdSense.', 'appad-manager' ),
					'type'  => 'textarea',
					'name'  => 'between_code',
					'extra' => array(
						'style' => 'width: 500px; height: 200px;',
					),
					'tip'   => __( 'Paste your ad code here (468x60). Supports many popular providers such as Google AdSense.', 'appad-manager' ),
				),
			),
		);

		$this->tab_sections['themes']['support'] = array(
			'title'  => __( 'Supported Themes', 'appad-manager' ),
			'fields' => array(
				array(
					'title' => __( 'Clipper', 'appad-manager' ),
					'name'  => '_blank',
					'type'  => '',
					'desc'  => html(
						'img',
						array(
							'src'   => plugins_url( '/images/clpr-screenshot.png', __DIR__ ),
							'width' => '260',
							'alt'   => 'Clipper',
						)
					) . '<br />' .
						sprintf( __( '<a target="_blank" href="%s">Buy Theme!</a>', 'appad-manager' ), 'https://bit.ly/oLSh2D' ),
					'extra' => array(
						'style' => 'display: none;',
					),
				),
				array(
					'title' => __( 'ClassiPress', 'appad-manager' ),
					'name'  => '_blank',
					'type'  => '',
					'desc'  => html(
						'img',
						array(
							'src'   => plugins_url( '/images/cp-screenshot.png', __DIR__ ),
							'width' => '260',
							'alt'   => 'Clipper',
						)
					) . '<br />' .
						sprintf( __( '<a target="_blank" href="%s">Buy Theme!</a>', 'appad-manager' ), 'https://bit.ly/j5G6mG' ),
					'extra' => array(
						'style' => 'display: none;',
					),
				),
				array(
					'title' => __( 'JobRoller', 'appad-manager' ),
					'name'  => '_blank',
					'type'  => '',
					'desc'  => html(
						'img',
						array(
							'src'   => plugins_url( '/images/jr-screenshot.png', __DIR__ ),
							'width' => '260',
							'alt'   => 'Clipper',
						)
					) . '<br />' .
						sprintf( __( '<a target="_blank" href="%s">Buy Theme!</a>', 'appad-manager' ), 'https://bit.ly/wQt43f' ),
					'extra' => array(
						'style' => 'display: none;',
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
			$options[ $i ] = $i;
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

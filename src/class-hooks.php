<?php

class APP_Ad_Manager_Hooks {

	/**
	 * Options.
	 *
	 * @var scbOptions
	 */
	protected $options;

	/**
	 * Between counter.
	 *
	 * @var int
	 */
	protected $counter = 0;


	/**
	 * Constructor.
	 *
	 * @param scbOptions $options
	 *
	 * @return void
	 */
	public function __construct( $options ) {

		$this->options = $options;

		// Load hooks
		$this->load_hooks();
	}


	/**
	 * Load hooks.
	 *
	 * @return void
	 */
	protected function load_hooks() {
		global $app_theme;

		if ( empty( $app_theme ) ) {
			return;
		}

		if ( ! $this->options->get( 'between_active' ) ) {
			return;
		}

		switch( $app_theme ) {
			case 'Clipper':
				$this->hooks_clipper();
				break;
			case 'ClassiPress':
				$this->hooks_classipress();
				break;
			case 'JobRoller':
				$this->hooks_jobroller();
				break;
			default:
				// do nothing, no supported theme
				break;
		}
	}


	/**
	 * Clipper hooks.
	 *
	 * @return void
	 */
	protected function hooks_clipper() {
		add_action( 'appthemes_after_post', array( $this, 'between_clipper' ) );
		add_action( 'appthemes_before_loop', array( $this, 'between_reset' ) );
	}


	/**
	 * Inserts ads between coupon listings.
	 *
	 * @return void
	 */
	public function between_clipper() {
		$frequency = $this->options->get( 'between_frequency' );
		$this->counter++;

		if ( $this->counter == $frequency ) {
			echo '<div class="appad-clpr-between-box"><div class="appad-clpr-between-adsense">';
			echo $this->options->get( 'between_code' );
			echo '</div></div>';
			$this->counter = 0;
		}

	}


	/**
	 * ClassiPress hooks.
	 *
	 * @return void
	 */
	protected function hooks_classipress() {
		add_action( 'appthemes_after_post', array( $this, 'between_classipress' ) );
		add_action( 'appthemes_before_loop', array( $this, 'between_reset' ) );
	}


	/**
	 * Inserts ads between ad listings.
	 *
	 * @return void
	 */
	public function between_classipress() {
		$frequency = $this->options->get( 'between_frequency' );
		$this->counter++;

		if ( $this->counter == $frequency ) {
			echo '<div class="appad-cp-between-box"><div class="appad-cp-between-adsense">';
			echo $this->options->get( 'between_code' );
			echo '</div></div>';
			$this->counter = 0;
		}

	}


	/**
	 * JobRoller hooks.
	 *
	 * @return void
	 */
	protected function hooks_jobroller() {
		add_action( 'appthemes_before_job_listing', array( $this, 'between_jobroller' ) );
		add_action( 'appthemes_before_job_listing_loop', array( $this, 'between_reset' ) );
	}


	/**
	 * Inserts ads between job listings.
	 *
	 * @return void
	 */
	public function between_jobroller() {
		// todo: counter -1 ?!

		$frequency = $this->options->get( 'between_frequency' );
		$this->counter++;

		if ( $this->counter == $frequency ) {
			echo '<div class="appad-jr-between-box"><div class="appad-jr-between-adsense">';
			echo $this->options->get( 'between_code' );
			echo '</div></div>';
			$this->counter = 0;
		}

	}


	/**
	 * Resets between counter.
	 *
	 * @return void
	 */
	public function between_reset() {
		$this->counter = 0;
	}

}

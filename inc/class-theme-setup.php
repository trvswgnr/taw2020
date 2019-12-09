<?php
/**
 * Theme Setup Class
 *
 * @package taw
 */

/**
 * Theme Setup
 */
class Theme_Setup {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action(
			'wp_enqueue_scripts',
			array(
				$this,
				'setup',
			)
		);
	}

	/**
	 * Front-end Setup
	 */
	public function setup() {
		if ( ! is_admin() ) {
			$this->styles();
			$this->scripts();
		}
	}

	/**
	 * Front-end Styles
	 */
	public function styles() {
		// add main stylesheet with dynamic versioning based on modified date.
		$handle = 'main-style';
		$ver    = '1.' . filemtime( get_template_directory() . '/style.css' );
		$src    = get_template_directory_uri() . '/style.css?ver=' . $ver;
		$deps   = array();
		$media  = 'all';
		wp_enqueue_style(
			$handle,
			$src,
			$deps,
			"$ver",
			$media
		);

		// add Font Awesome icons.
		wp_enqueue_style(
			'font-awesome',
			'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
			array(),
			'4.7.0',
			'all'
		);
	}

	/**
	 * Front-end Scripts
	 */
	public function scripts() {
		$handle    = 'main-script';
		$ver       = filemtime( get_template_directory() . '/index.js' );
		$src       = get_template_directory_uri() . '/index.js?ver=' . $ver;
		$deps      = array();
		$in_footer = true;
		wp_enqueue_script(
			$handle,
			$src,
			$deps,
			$ver,
			$in_footer
		);
	}
}

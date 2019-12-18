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
		if ( ! is_admin() ) {
			add_action(
				'wp_enqueue_scripts',
				function() {
					$this->styles();
					$this->scripts();
					$this->remove_head_junk();
				}
			);
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
		// add main script file.
		$handle    = 'main-script';
		$ver       = filemtime( get_template_directory() . '/index.js' );
		$src       = get_template_directory_uri() . '/index.js?ver=' . $ver;
		$deps      = array( 'jquery' );
		$in_footer = true;
		wp_enqueue_script(
			$handle,
			$src,
			$deps,
			$ver,
			$in_footer
		);

		// remove default jquery and add our own.
		wp_deregister_script( 'jquery' );
		wp_enqueue_script(
			'jquery',
			'https://code.jquery.com/jquery-3.4.1.slim.min.js',
			array(),
			'3.4.1',
			true
		);
	}

	/**
	 * Theme Support
	 */
	public function theme_support() {
		// translation support.
		load_theme_textdomain( 'taw', get_template_directory() . '/languages' );

		// default posts and comments RSS feed links in head.
		add_theme_support( 'automatic-feed-links' );

		// dynamic title tags.
		add_theme_support( 'title-tag' );

		// featured images.
		add_theme_support( 'post-thumbnails' );

		// wp nav menu.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'taw' ),
				'mobile'  => esc_html__( 'Mobile', 'taw' ),
			)
		);

		// add ACF options page.
		// usage within template file: the_field( 'some_field', 'option' ).
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page();
		}
	}

	/**
	 * Get Rid of Extra Junk in <head>
	 */
	public function remove_head_junk() {
		// remove wp emoji.
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		// remove all the RSS feed links.
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		// remove dns-prefetch, preconnect, prefetch, and prerender.
		remove_action( 'wp_head', 'wp_resource_hints', 2 );

		// remove link header for the REST API.
		remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

		// remove REST API link tag.
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

		// remove discovery links.
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

		// remove WordPress page/post shortlinks.
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );

		// remove Weblog Client Link.
		remove_action( 'wp_head', 'rsd_link' );

		// remove Windows Live Writer Manifest Link.
		remove_action( 'wp_head', 'wlwmanifest_link' );

		// remove WordPress Generator.
		remove_action( 'wp_head', 'wp_generator' );

		// remove adjacent post links.
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

		// remove WP Embed.
		add_action(
			'wp_footer',
			function() {
				wp_deregister_script( 'wp-embed' );
			}
		);
	}
}

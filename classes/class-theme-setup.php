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
					wp_dequeue_style( 'wp-block-library' );
				}
			);
			$this->clean_head();
		}
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
		add_action( 'customize_register', array( $this, 'customizer' ) );
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

		wp_enqueue_style(
			'font-raleway',
			'https://fonts.googleapis.com/css?family=Raleway:200,500,700&display=swap',
			$deps,
			'14',
			$media
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
		wp_deregister_script( 'jquery' ); // phpcs:ignore
		wp_enqueue_script(
			'jquery',
			'https://code.jquery.com/jquery-3.4.1.min.js',
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
		load_theme_textdomain( 'twentytwenty' );

		// default posts and comments RSS feed links in head.
		add_theme_support( 'automatic-feed-links' );

		// dynamic title tags.
		add_theme_support( 'title-tag' );
		add_filter(
			'document_title_separator',
			function() {
				return '|';
			}
		);

		// switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		// featured images.
		add_theme_support( 'post-thumbnails' );

		// full and wide align images.
		add_theme_support( 'align-wide' );

		// adds `async` and `defer` support for scripts registered or enqueued by the theme.
		$loader = new Script_Loader();
		add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

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
	public function clean_head() {
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

	/**
	 * Customizer Settings
	 *
	 * @param Object $wp_customize Customizer object.
	 */
	public function customizer( $wp_customize ) {
		$args = array(
			'label'    => 'Upload Logo',
			'section'  => 'title_tagline',
			'settings' => 'theme_logo',
		);

		// add a setting for the site logo.
		$wp_customize->add_setting( $args['settings'] );

		// Add a control to upload the logo.
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$args['settings'],
				$args
			)
		);
	}
}

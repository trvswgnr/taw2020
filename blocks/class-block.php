<?php
/**
 * Block Class
 *
 * @package taw
 */

/**
 * Gutenberg Block
 */
class Block {
	/**
	 * Constructor
	 *
	 * @param array $args Arguments.
	 */
	public function __construct( $args = array() ) {
		$defaults = array(
			'name'     => false,
			'callback' => false,
			'template' => false,
		);
		$args     = wp_parse_args( $args, $defaults );
		if ( ! $args['name'] ) {
			$args['name'] = get_class( $this );
		}
		$this->template    = $args['template'];
		$this->render_type = $args['template'] ? 'render_template' : 'render_callback';
		$this->name        = ucwords( str_replace( '-', ' ', $args['name'] ) );
		$this->slug        = strtolower( str_replace( ' ', '-', $args['name'] ) );
		$this->cb          = $args['callback'];
		$this->style       = false;
		$style_rel_path    = '/blocks/' . $this->slug . '/style.css';
		if ( file_exists( get_stylesheet_directory() . $style_rel_path ) ) {
			$this->style = get_stylesheet_directory_uri() . $style_rel_path;
		}
		add_action( 'acf/init', array( $this, 'register' ) );
		add_action( 'acf/init', array( $this, 'fields' ) );
	}

	/**
	 * Register ACF Block
	 */
	public function register() {
		acf_register_block_type(
			array(
				'name'             => $this->slug,
				'title'            => $this->name,
				'description'      => 'A custom ' . $this->name . ' block.',
				$this->render_type => $this->render(),
				'keywords'         => array( $this->slug ),
				'enqueue_style'    => $this->style,
			)
		);
	}

	/**
	 * Select render format
	 *
	 * @return $render
	 */
	public function render() {
		$render = array( $this, 'callback' );
		if ( $this->cb ) {
			$render = $this->cb;
		}
		if ( $this->template ) {
			$render = $this->template;
		}
		return $render;
	}

	/**
	 * Register ACF Fields
	 */
	public function fields() {
		return false;
	}

	/**
	 * Callback render
	 *
	 * @param Object $block Block object.
	 */
	public function callback( $block ) {
		return false;
	}
}

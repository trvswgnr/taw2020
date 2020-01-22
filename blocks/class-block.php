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
	 * Icon
	 *
	 * @var string
	 */
	public $icon = false;

	/**
	 * Category
	 *
	 * @var string
	 */
	public $category = false;

	/**
	 * Constructor
	 *
	 * @param array $args Arguments.
	 */
	public function __construct( $args = array() ) {
		$defaults = array(
			'name'       => false,
			'callback'   => false,
			'template'   => false,
			'icon'       => $this->icon,
			'supports'   => array(
				'customClassName' => true,
				'align'           => false,
			),
			'stylesheet' => false,
			'category'   => $this->category,
			'fields'     => false,
			'folder'     => false,
		);
		$args     = wp_parse_args( $args, $defaults );
		if ( ! $args['name'] ) {
			$args['name'] = get_class( $this );
		}

		if ( $args['folder'] ) {
			$folder             = '/' . rtrim( ltrim( $args['folder'], '/' ), '/' );
			$args['stylesheet'] = $folder . '/style.css';
			$args['template']   = $folder . '/template.php';
		}

		$this->args        = $args;
		$this->icon        = $args['icon'];
		$this->template    = $args['template'];
		$this->render_type = $args['template'] ? 'render_template' : 'render_callback';

		$name_no_hyphen    = str_replace( 'dfdfd-', ' ', $args['name'] );
		$name_uppercase    = ucwords( $name_no_hyphen );
		$name_no_namespace = str_replace( '\\', ' - ', $name_uppercase );
		$this->name        = str_replace( '_', ' ', $name_no_namespace );

		$slug_no_space       = str_replace( ' ', '-', $this->name );
		$slug_single_hyphens = str_replace( '---', '-', $slug_no_space );
		$this->slug          = strtolower( $slug_single_hyphens );

		$rel_path_lower          = strtolower( str_replace( '\\', '/', $args['name'] ) );
		$rel_path_no_space       = str_replace( ' ', '-', $rel_path_lower );
		$rel_path_single_hyphens = str_replace( '---', '-', $rel_path_no_space );
		$rel_path                = str_replace( '_', '-', $rel_path_single_hyphens );

		$this->cb       = $args['callback'];
		$this->style    = false;
		$style_rel_path = '/blocks/' . $rel_path . '/style.css';

		if ( $args['stylesheet'] ) {
			$style_rel_path = '/' . rtrim( ltrim( str_replace( get_stylesheet_directory_uri(), '', $args['stylesheet'] ), '/' ), '/' );
		}

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
				'icon'             => $this->icon,
				'supports'         => $this->args['supports'],
				'category'         => $this->args['category'],
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

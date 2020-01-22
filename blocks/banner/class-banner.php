<?php
/**
 * Class Block Banner
 *
 * @package fendz
 */

	/**
	 * Add Banner ACF Block
	 */
class Banner extends \Block {
	/**
	 * Add fields
	 */
	public function fields() {
		acf_add_local_field_group(
			array(
				'key'      => 'group_5e019bd32bb49',
				'title'    => get_class( $this ),
				'fields'   => array(
					array(
						'key'   => 'field_5e019c1566e4d',
						'label' => 'Text',
						'name'  => 'banner_text',
						'type'  => 'wysiwyg',
					),
					array(
						'key'           => 'field_5e019e6a66e4e',
						'label'         => 'Link',
						'name'          => 'banner_link',
						'type'          => 'link',
						'return_format' => 'url',
					),
					array(
						'key'           => 'field_5e019e7e66e4f',
						'label'         => 'Background Image',
						'name'          => 'banner_image',
						'type'          => 'image',
						'return_format' => 'url',
						'preview_size'  => 'medium',
						'library'       => 'all',
					),
					array(
						'key'            => 'field_5e053345f4bfa',
						'label'          => 'Expires',
						'name'           => 'banner_expires',
						'type'           => 'date_picker',
						'display_format' => 'm/d/Y',
						'return_format'  => 'm/d/Y',
						'first_day'      => 1,
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/banner',
						),
					),
				),
			)
		);
	}

	/**
	 * Render callback
	 *
	 * @param Object $block Gutenberg block object.
	 */
	public function callback( $block ) {
		$align        = 'banner-content--wide';
		$align        = $block['align'] ? ' banner__content--' . $block['align'] : $align;
		$class_name   = ! empty( $block['className'] ) ? $this->slug . ' ' . $block['className'] : $this->slug;
		$current_date = gmdate( 'U' );
		$expires_date = get_field( 'banner_expires' ) ? gmdate( 'U', strtotime( get_field( 'banner_expires' ) ) ) : false;
		$inline_style = get_field( 'banner_image' ) ? 'background-image: url(' . get_field( 'banner_image' ) . ');' : '';

		if ( $expires_date && $expires_date <= $current_date ) {
			$inline_style .= is_admin() ? 'opacity: 0.4;' : 'display: none;';
		}
		?>
		<a
			href="<?php the_field( 'banner_link' ); ?>"
			id="<?php echo esc_attr( $block['id'] ); ?>"
			class="<?php echo esc_attr( $class_name ); ?>"
			style="<?php echo esc_attr( $inline_style ); ?>"
			target="_blank">
			<div class="banner__content<?php echo esc_attr( $align ); ?>">
				<span class="banner__text"><?php the_field( 'banner_text' ); ?></span>
			</div>
		</a>
			<?php
	}
}

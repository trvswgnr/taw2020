<?php
/**
 * Class Resume - Chips
 *
 * @package taw
 */

namespace Resume;

/**
 * Chips ACF Gutenberg Block
 */
class Chips extends \Block {
	/**
	 * Icon
	 *
	 * @var string
	 */
	public $icon = 'plus-alt';

	/**
	 * Category
	 *
	 * @var string
	 */
	public $category = 'resume';

	/**
	 * ACF Fields
	 */
	public function fields() {
		acf_add_local_field_group(
			array(
				'key'      => 'group_5e26a1bd48971',
				'title'    => 'Resume - Chips',
				'fields'   => array(
					array(
						'key'          => 'field_5e26a1c33d5e4',
						'label'        => 'Chips',
						'name'         => 'resume_chips',
						'type'         => 'repeater',
						'collapsed'    => 'field_5e26a1d23d5e5',
						'layout'       => 'table',
						'button_label' => 'Add Item',
						'sub_fields'   => array(
							array(
								'key'   => 'field_5e26a1d23d5e5',
								'label' => 'Item',
								'name'  => 'item',
								'type'  => 'text',
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/resume-chips',
						),
					),
				),
			)
		);
	}

	/**
	 * Render Callback
	 *
	 * @param Object $block Gutenberg block object.
	 */
	public function callback( $block ) {
		if ( have_rows( 'resume_chips' ) ) :
			?>
			<ul class="resume-chips">
			<?php
			while ( have_rows( 'resume_chips' ) ) :
				the_row();
				?>
				<li><?php the_sub_field( 'item' ); ?></li>
				<?php
			endwhile;
			?>
			</ul>
			<?php
		endif;

	}
}

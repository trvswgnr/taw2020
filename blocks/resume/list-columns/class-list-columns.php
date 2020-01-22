<?php
/**
 * Class Resume - List Columns
 *
 * @package taw
 */

namespace Resume;

	/**
	 * Add List Columns ACF Gutenberg Block
	 */
class List_Columns extends \Block {
	/**
	 * Icon
	 *
	 * @var string
	 */
	public $icon = 'editor-ul';

	/**
	 * Category
	 *
	 * @var string
	 */
	public $category = 'resume';

	/**
	 * ACF fields
	 */
	public function fields() {
		acf_add_local_field_group(
			array(
				'key'      => 'group_5e1d93fcc62c0',
				'title'    => 'Résumé - List Columns',
				'fields'   => array(
					array(
						'key'          => 'field_5e1d941343742',
						'label'        => 'Items',
						'name'         => 'resume_list_columns',
						'type'         => 'repeater',
						'collapsed'    => 'field_5e1d942f43743',
						'layout'       => 'table',
						'button_label' => 'Add Item',
						'sub_fields'   => array(
							array(
								'key'   => 'field_5e1d942f43743',
								'label' => 'Title',
								'name'  => 'title',
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
							'value'    => 'acf/resume-list-columns',
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
		$class_name = ! empty( $block['className'] ) ? $this->slug . ' ' . $block['className'] : $this->slug;
		$align      = $block['align'] ? $class_name . '--' . $block['align'] : $class_name . '--wide';
		?>
		<ul
			id="<?php echo esc_attr( $block['id'] ); ?>"
			class="<?php echo esc_attr( $class_name ); ?> <?php echo esc_attr( $align ); ?>">
			<?php foreach ( get_field( 'resume_list_columns' ) as $item ) : ?>
			<li class="<?php echo esc_attr( $class_name ); ?>__item"><?php echo esc_html( $item['title'] ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}

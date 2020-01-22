<?php
/**
 * Class Resume - Experience
 *
 * @package taw
 */

namespace Resume;

/**
 * Experience ACF Gutenberg Block
 */
class Experience extends \Block {
	/**
	 * Icon
	 *
	 * @var string
	 */
	public $icon = 'excerpt-view';

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
				'key'      => 'group_5e266198899e4',
				'title'    => 'Resume - Experience',
				'fields'   => array(
					array(
						'key'   => 'field_5e267c3a31752',
						'label' => 'Title',
						'name'  => 'resume_experience_title',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_5e2679f85a890',
						'label' => 'Date',
						'name'  => 'resume_experience_date',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_5e267a075a891',
						'label' => 'Company',
						'name'  => 'resume_experience_company',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_5e267a2e5a892',
						'label' => 'Location',
						'name'  => 'resume_experience_location',
						'type'  => 'text',
					),
					array(
						'key'       => 'field_5e267a3e5a893',
						'label'     => 'Details',
						'name'      => 'resume_experience_details',
						'type'      => 'textarea',
						'rows'      => 2,
						'new_lines' => 'br',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/resume-experience',
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
		?>
		<div class="<?php echo esc_attr( $class_name ); ?>">
			<div class="resume-experience__date"><small><?php the_field( 'resume_experience_date' ); ?></small></div>
			<div class="resume-experience__content">
				<h3 class="resume-experience__title"><?php the_field( 'resume_experience_title' ); ?></h3>
				<?php if ( get_field( 'resume_experience_company' ) ) : ?>
					<h5 class="resume-experience__info"><?php the_field( 'resume_experience_company' ); ?> <span>•</span> <?php the_field( 'resume_experience_location' ); ?></h5>
				<?php endif; ?>
				<p class="resume-experience__details"><?php the_field( 'resume_experience_details' ); ?></p>
			</div>
		</div>
		<?php
	}
}

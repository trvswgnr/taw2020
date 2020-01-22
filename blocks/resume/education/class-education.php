<?php
/**
 * Class Resume - Education
 *
 * @package taw
 */

namespace Resume;

/**
 * Education ACF Gutenberg Block
 */
class Education extends \Block {
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
	 * ACF Fields
	 */
	public function fields() {
		acf_add_local_field_group(
			array(
				'key'      => 'group_5e266198999e4',
				'title'    => 'Resume - Education',
				'fields'   => array(
					array(
						'key'   => 'field_5e267c3a41752',
						'label' => 'School',
						'name'  => 'resume_education_school',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_5e267a076a891',
						'label' => 'Degree',
						'name'  => 'resume_education_degree',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_5e267a2e6a892',
						'label' => 'Location',
						'name'  => 'resume_education_location',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_5e2649bead031',
						'label'         => 'Logo',
						'name'          => 'logo',
						'type'          => 'image',
						'return_format' => 'url',
						'preview_size'  => 'thumbnail',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/resume-education',
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
			<div class="resume-education__content">
				<h3 class="resume-education__title"><?php the_field( 'resume_education_school' ); ?></h3>
				<h5 class="resume-education__info"><?php the_field( 'resume_education_degree' ); ?> <span>•</span> <?php the_field( 'resume_education_location' ); ?></h5>
			</div>
			<div class="resume-education__logo" style="background-image: url(<?php the_field( 'resume_education_logo' ); ?>);"></div>
		</div>
		<?php
	}
}

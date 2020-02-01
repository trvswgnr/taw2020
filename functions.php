<?php
/**
 * Theme Functions
 *
 * @package taw
 */

// local utility functions.
if ( file_exists( dirname( __FILE__ ) . '/functions-local.php' ) ) {
	require_once dirname( __FILE__ ) . '/functions-local.php';
}

// async script loader.
require_once 'classes/class-script-loader.php';

// theme setup.
require_once 'classes/class-theme.php';

// blocks.
require_once 'blocks/class-block.php';
require_once 'blocks/resume/list-columns/class-list-columns.php';
require_once 'blocks/resume/experience/class-experience.php';
require_once 'blocks/resume/chips/class-chips.php';
require_once 'blocks/resume/education/class-education.php';

$taw                 = new Theme();
$resume_list_columns = new Resume\List_Columns();
$resume_experience   = new Resume\Experience();
$resume_chips        = new Resume\Chips();
$resume_education    = new Resume\Education();

Theme::remove_empty_p();
Theme::add_block_category( 'Resume' );

add_action( 'init', 'taw_add_additional_pm_pro_fields' );
function taw_add_additional_pm_pro_fields() {
	// don't break if Register Helper is not loaded
	if ( ! function_exists( 'pmprorh_add_registration_field' ) ) {
		return false;
	}

	/** fields after username */
	// $fields = array();

	// $fields[] = new PMProRH_Field(
	// 'first_name',
	// 'text',
	// array(
	// 'label'    => 'First name',
	// 'required' => true,
	// 'profile'  => false,
	// )
	// );

	// $fields[] = new PMProRH_Field(
	// 'last_name',
	// 'text',
	// array(
	// 'label'    => 'Last name',
	// 'required' => true,
	// 'profile'  => false,
	// )
	// );

	// // add the fields after username
	// foreach ( $fields as $field ) {
	// pmprorh_add_registration_field(
	// 'after_username', // location on checkout page
	// $field            // PMProRH_Field object
	// );
	// }

	/** fields in after email address */
	$fields = array();

	$fields[] = new PMProRH_Field(
		'company',
		'text',
		array(
			'label'   => 'Company',
			'profile' => true,
		)
	);

	$fields[] = new PMProRH_Field(
		'carrier_name',
		'select',
		array(
			'label'   => 'Mobile Carrier',
			'profile' => true,
			'options' => array(
				'Verizon',
				'AT&T',
			),
		)
	);

	// add the fields into a new checkout_boxes are of the checkout page
	foreach ( $fields as $field ) {
		pmprorh_add_registration_field(
			'after_email', // location on checkout page
			$field            // PMProRH_Field object
		);
	}
}

require_once 'inc/custom-pmpro-page.php';

global $wpdb;

$table_name = $wpdb->prefix . 'pmpro_custom_account_fields';

$sql = 'CREATE TABLE ' . $table_name . '(
		id int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(30),
		type VARCHAR(30),
		attr VARCHAR(255),
		location VARCHAR(50),
		UNIQUE (name)
	)';
Theme::maybe_create_table( $table_name, $sql );


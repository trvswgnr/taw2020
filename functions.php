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

/* Add fields to account page */
add_action( 'um_after_profile', 'showExtraFields', 100 );
function showExtraFields() {
	$custom_fields = array(
		'youtube' => 'YouTube',
	);

	foreach ( $custom_fields as $key => $value ) {
		$fields[ $key ] = array(
			'title'   => $value,
			'metakey' => $key,
			'type'    => 'select',
			'label'   => $value,
		);
		$field_value    = get_user_meta( um_user( 'ID' ), $key, true ) ? : '';
		$html           = '<div class="um-field">
	<div class="um-field-label">
	<a href="https://demo.unioncentrics.com/user/?um_action=edit">Edit Profile</a>
	</div>
	</div>';
		echo $html;

	}
	apply_filters( 'um_account_secure_fields', $fields, get_current_user_id() );
}


add_action( 'um_user_edit_profile', 'my_user_edit_profile', 10, 1 );
function my_user_edit_profile( $args ) {
	$html = '<div class="um-field">
	<div class="um-field-label">
	<a href="https://demo.unioncentrics.com/user/?um_action=edit">Edit Profile</a>
	</div>
	</div>';
		echo $html;
}

add_action( 'um_after_profile_name_inline', 'my_admin_custom_profile_metaboxes', 10 );
function my_admin_custom_profile_metaboxes() {
	$html = '
	<a href="https://demo.unioncentrics.com/user/?um_action=edit">Edit Profile</a>';
		echo $html;
}

add_action( 'wp_footer', 'show_carrier_on_profile' );
function show_carrier_on_profile() {
	$dropdown_choice = get_user_meta( get_current_user_id(), 'test_dropdown' );
	$is_editing      = filter_input( INPUT_GET, 'um_action', FILTER_SANITIZE_STRING ) === 'edit' ? true : false;
	if ( $is_editing ) {
		?>
		<style>
			#um_field_33545_carrier {
				display: none;
			}
		</style>
		<?php
	} else {
		?>
		<script>
			jQuery('#carrier').val('<?php echo $dropdown_choice[0]; ?>');
		</script>
		<?php
	}
	?>
	<script>
		jQuery('.um-field-youtube').after('<div id="um_field_33545_carrier" class="um-field"><div class="um-field-label"><label for="um_field_33545_carrier">Mobile Carrier</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value"><span><?php echo esc_js( $dropdown_choice[0] ); ?></span></div></div></div>');
	</script>
	<?php
}

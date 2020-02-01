<?php
/**
 * Add page to plugin
 *
 * @package taw
 */

add_action( 'admin_menu', 'taw_add_pmpro_page_custom_register_fields' );

/**
 * Custom Admin Menu
 *
 * @return void
 */
function taw_add_pmpro_page_custom_register_fields() {
	$function = function() {
		if ( isset( $_POST['add_pmpro_field_submit'] ) ) {
			add_pmpro_custom_field();
		}
		$profile_fields = get_pmpro_custom_fields();
		$field_types    = array(
			'checkbox',
			'checkbox_grouped',
			'date',
			'file',
			'hidden',
			'html',
			'multiselect',
			'radio',
			'readonly',
			'select',
			'select2',
			'text',
			'textarea',
		);
		ob_start();
		?>
		<h1>User Registration Custom Fields</h1>
		<h2>Add Field:</h2>
		<form action="" method="post">
			<table class="form-table">
				<tr>
					<th><label for="field_type_select">Type</label></th>
					<td>
						<!-- <select name="field_type_select" id="field_type_select">
							<option value="">Choose Field Type</option>
							<?php foreach ( $field_types as $field_type ) : ?>
							<option value="<?php echo esc_attr( $field_type ); ?>"><?php echo esc_html( ucwords( str_replace( '_', ' ', $field_type ) ) ); ?></option>
							<?php endforeach; ?>
						</select> -->
						<select name="field_type_select" id="field_type_select">
						<option value="" disabled>Choose Field Type</option>
						<option value="text" selected="selected">Text</option>
						<option value="select">Select</option>
					</td>
				</tr>
				<tr>
					<th><label for="field_text_label">Label</label></th>
					<td><input type="text" name="field_text_label" id="field_text_label" required></td>
				</tr>
				<tr>
					<th><label for="field_text_id">ID/Name</label></th>
					<td><input type="text" name="field_text_id" id="field_text_id" required></td>
				</tr>
				<tr id="field_select_options_wrapper" style="display: none;">
					<th><label for="field_select_options">Options</label></th>
					<td><textarea name="field_select_options" id="field_select_options" cols="30" rows="4"></textarea></td>
				</tr>
				<tr>
					<th><label for="field_is_required"></label></th>
					<td><input type="checkbox" name="field_is_required" id="field_is_required"></td>
				</tr>
			</table>
			<p>
				<input type="submit" name="add_pmpro_field_submit" id="add_pmpro_field_submit" class="button" value="Add Field">
			</p>
		</form>
		<br>
		<hr>
		<h2>Current Fields:</h2>
		<?php
		foreach ( $profile_fields as $field ) :
			?>
			<p><?php echo esc_html( $field['attr']['label'] ); ?></p>
			<?php
		endforeach;
		echo ob_get_clean();
	};
		add_submenu_page( 'pmpro-dashboard', 'Registration Fields', 'Registration Fields', 'pmpro_dashboard', 'pmpro-registration-fields', $function );
}

	add_action( 'admin_footer', 'taw_add_pmpro_page_custom_register_fields_js' );

function taw_add_pmpro_page_custom_register_fields_js() {
	?>
	<script>
		var $ = jQuery;
		$('#field_type_select').change(function() {
		if ( $(this).val() === 'select' ) {
			$('#field_select_options_wrapper').show();
		} else {
			$('#field_select_options_wrapper').hide();
		}
	});

	</script>
	<?php
}

function get_pmpro_custom_fields() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'pmpro_custom_account_fields';
	$results    = $wpdb->get_results( "SELECT * FROM {$table_name}" ); // phpcs:ignore
	$fields     = array();
	foreach ( $results as $result ) {
		$fields[] = array(
			'name' => $result->name,
			'type' => $result->type,
			'attr' => json_decode( $result->attr, true ),
		);
	}
	return $fields;
}

function add_pmpro_custom_field() {
	global $wpdb;
	$table_name          = $wpdb->prefix . 'pmpro_custom_account_fields';
	$select_options      = array();
	$selected_field_type = $_POST['field_type_select'] ?: false;
	$select_options      = $_POST['field_select_options'] ? explode( "\n", $_POST['field_select_options'] ) : false;

	$options = array();
	foreach ( $select_options as $option ) {
		$options[ $option ] = $option;
	}

	$field_id          = $_POST['field_text_id'] ?: '';
	$field_label       = $_POST['field_text_label'] ?: '';
	$field_is_required = ! empty( $_POST['field_is_required'] ) ? true : false;
	$field_type        = $selected_field_type;
	$field_options     = $select_options;
	$field_attr        = array(
		'label'   => $field_label,
		'profile' => true,
	);

	if ( $selected_field_type === 'select' ) {
		$field_attr = array(
			'label'   => $field_label,
			'profile' => true,
			'options' => $field_options,
		);
	}

	$field_attr_json = json_encode( $field_attr );

	$sql = "INSERT INTO {$table_name} (name,type,attr) VALUES (%s,%s,%s) ON DUPLICATE KEY UPDATE name = %s, type = %s, attr = %s";
	$sql = $wpdb->prepare( $sql, $field_id, $field_type, $field_attr_json, $field_id, $field_type, $field_attr_json );
	$wpdb->query( $sql );
}

function register_custom_pmpro_fields() {
	$fields    = array();
	$db_fields = get_pmpro_custom_fields();
	foreach ( $db_fields as $db_field ) {
		$fields[] = new PMProRH_Field(
			$db_field['name'],
			$db_field['type'],
			$db_field['attr']
		);
	}
	foreach ( $fields as $field ) {
		pmprorh_add_registration_field(
			'after_email',
			$field
		);
	}

}
add_action( 'init', 'register_custom_pmpro_fields' );

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
		$profile_fields = get_pmpro_custom_fields();
		$field_types    = array(
			'text',
			'select',
			'select2',
			'checkbox',
			'checkbox_grouped',
			'multiselect',
			'date',
			'file',
			'hidden',
			'html',
			'radio',
			'readonly',
			'textarea',
		);

		$location_options = array(
			'after_username',
			'after_password',
			'after_email',
			'after_captcha',
			'checkout_boxes',
			'after_billing_fields',
			'before_submit_button',
			'just_profile',
		);
		ob_start();
		?>
		<div class="wrap">
		<h1 class="wp-heading-inline">Registration Custom Fields</h1>
		<div class="flex-row">
		<div class="flex-col">
		<?php $nonce = wp_create_nonce( 'taw_pmpro_add_field_nonce' ); ?>
		<form action="?page=pmpro-registration-fields&_wpnonce=<?php echo esc_attr( $nonce ); ?>" method="post" class="card">
			<h2>Add Field to Account Registration</h2>
			<p><em>Entering a field with an ID/Name that already exists will update that field.</em></p>
			<table class="form-table">
				<tr>
					<th><label for="field_type_select">Type</label></th>
					<td>
						<select name="field_type_select" id="field_type_select">
							<option value="" disabled>Choose Field Type</option>
							<?php
							$i = 0;
							foreach ( $field_types as $field_type ) :
								$option_selected = 0 === $i ? 'selected="selected"' : '';
								// todo: make more options available by using conditionals.
								$option_disabled = 5 < $i ? 'disabled' : ''; // limit available options to what has been developed.
								?>
								<option value="<?php echo esc_attr( $field_type ); ?>" <?php echo esc_html( $option_selected ); ?> <?php echo esc_attr( $option_disabled ); ?>><?php echo esc_html( ucwords( str_replace( '_', ' ', $field_type ) ) ); ?></option>
								<?php
								$i++;
							endforeach;
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="field_text_label">Label</label></th>
					<td><input class="regular-text" type="text" name="field_text_label" id="field_text_label" required></td>
				</tr>
				<tr>
					<th><label for="field_text_id">ID/Name</label></th>
					<td><input class="regular-text" type="text" name="field_text_id" id="field_text_id" required></td>
				</tr>
				<tr id="field_select_options_wrapper" style="display: none;">
					<th><label for="field_select_options">Options</label></th>
					<td><textarea placeholder="Enter each option on a new line." name="field_select_options" id="field_select_options" cols="30" rows="4"></textarea></td>
				</tr>
				<tr>
					<th><label for="field_location_select">Location</label></th>
					<td>
						<select name="field_location_select" id="field_location_select">
							<option value="" disabled>Choose Location</option>
							<?php
							$i = 0;
							foreach ( $location_options as $option ) :
								$option_selected = 0 === $i ? 'selected="selected"' : '';
								?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php echo esc_html( $option_selected ); ?>><?php echo esc_html( ucwords( str_replace( '_', ' ', $option ) ) ); ?></option>
								<?php
								$i++;
							endforeach;
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="field_is_required">Required</label></th>
					<td>
						<label for="field_is_required">
							<input type="checkbox" name="field_is_required" id="field_is_required">
							Field is required
						</label>
					</td>
				</tr>
				<tr>
					<th><label for="field_on_profile">Show on Profile</label></th>
					<td>
						<label for="field_on_profile">
							<input type="checkbox" name="field_on_profile" id="field_on_profile" checked="checked">
							Visible on user profile
						</label>
					</td>
				</tr>
			</table>
			<p>
				<input type="submit" name="add_pmpro_field_submit" id="add_pmpro_field_submit" class="button button-primary" value="Add Field">
			</p>
		</form>
		</div>
		<div class="flex-col">
		<h2>Current Fields</h2>
		<table class="wp-list-table widefat fixed striped" style="max-width: 600px;">
			<thead>
			<tr>
			<th><strong>Label</strong></th>
			<th><strong>ID/Name</strong></th>
			<th style="text-align: center;"><strong>Action</strong></th>
			</tr>
			</thead>
		<?php
		foreach ( $profile_fields as $field ) :
			?>
			<tr>
			<th>
			<?php echo esc_html( $field['attr']['label'] ); ?>
			</th>
			<td style="vertical-align: middle;">
			<?php echo esc_html( $field['name'] ); ?>
			</td>
			<td style="text-align: center;">
			<?php $nonce = wp_create_nonce( 'taw_pmpro_delete_field_nonce' ); ?>
			<form action="?page=pmpro-registration-fields&_wpnonce=<?php echo esc_attr( $nonce ); ?>" method="post">
				<button type="submit" value="<?php echo esc_attr( $field['name'] ); ?>" name="delete_pmpro_form_field" id="delete_<?php echo esc_attr( $field['name'] ); ?>" class="button button-danger">Delete</button>
			</form>
			</td>
			</tr>
			<?php
		endforeach;
		?>
		</table>
	</div>
	</div>
	</div>
		<p style="float: right; margin-top: 5em; padding: 10px 20px;"><em>Developed by <a href="https://travisaw.com">Travis A. Wagner</a></em></p>
		<?php
		echo ob_get_clean(); // phpcs:ignore
	};
		add_submenu_page( 'pmpro-dashboard', 'Registration Fields', 'Registration Fields', 'pmpro_dashboard', 'pmpro-registration-fields', $function );
}

	add_action( 'admin_footer', 'taw_add_pmpro_page_custom_register_fields_js' );

function taw_add_pmpro_page_custom_register_fields_js() {
	?>
	<script>
		var $ = jQuery;
		$('#field_type_select').change(function() {
			var $thisVal = $(this).val();
			var typesWithOptions = [
				'select',
				'select2',
				'multiselect',
				'checkbox_grouped'
			];
			var showOptions = false;
			for (var i = 0; i < typesWithOptions.length;i++) {
				if ( typesWithOptions[i] === $thisVal) {
					showOptions = true;
				}
			}
			if ( showOptions ) {
				$('#field_select_options_wrapper').show();
			} else {
				$('#field_select_options_wrapper').hide();
			}
		});
		$('#field_text_label').keyup( function() {
			var $thisVal = $(this)
				.val()
				.toLowerCase()
				.replace(/( |\.|-)/gim, '_')
				.replace(/(\,|\!|\?)/gim, '');
			$('#field_text_id').val($thisVal);
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
			'name'     => $result->name,
			'type'     => $result->type,
			'attr'     => json_decode( $result->attr, true ),
			'location' => $result->location,
		);
	}
	return $fields;
}

function add_pmpro_custom_field() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'pmpro_custom_account_fields';

	$field_id          = $_POST['field_text_id'] ?: '';
	$field_label       = $_POST['field_text_label'] ?: '';
	$field_is_required = ! empty( $_POST['field_is_required'] ) ? true : false;
	$field_on_profile  = ! empty( $_POST['field_on_profile'] ) ? true : false;
	$field_type        = $_POST['field_type_select'] ?: '';
	$field_location    = $_POST['field_location_select'] ?: '';
	$field_options     = 'select' === $field_type ? array( '' => 'Select ' . $field_label ) : array();
	$field_options     = $_POST['field_select_options'] ? array_merge( $field_options, explode( "\n", $_POST['field_select_options'] ) ) : false;

	$field_attr = array(
		'label'    => $field_label,
		'profile'  => $field_on_profile,
		'required' => $field_is_required,
	);

	$show_options = array(
		'select',
		'select2',
		'multiselect',
		'checkbox_grouped',
	);

	if ( in_array( $field_type, $show_options ) ) {
		$field_attr['options'] = $field_options;
	}

	$field_attr_json = json_encode( $field_attr );

	$sql = "REPLACE INTO {$table_name} (name,type,attr,location) VALUES (%s,%s,%s,%s)"; // phpcs:ignore

	$result = $wpdb->query(
		$wpdb->prepare(
			$sql, // phpcs:ignore
			array(
				$field_id,
				$field_type,
				$field_attr_json,
				$field_location,
			)
		)
	);
	return $result;
}

function register_custom_pmpro_fields() {
	$db_fields = get_pmpro_custom_fields();
	foreach ( $db_fields as $db_field ) {
		$field = new PMProRH_Field(
			$db_field['name'],
			$db_field['type'],
			$db_field['attr']
		);
		pmprorh_add_registration_field(
			$db_field['location'],
			$field
		);
	}
}
add_action( 'init', 'register_custom_pmpro_fields' );

function delete_custom_pmpro_field( $name, $table_name = 'pmpro_custom_account_fields' ) {
	global $wpdb;
	$table_name = $wpdb->prefix . $table_name;
	$result     = $wpdb->delete(
		$table_name,
		array(
			'name' => $name,
		)
	);
	return $result;
}

function notice_pmpro_field_actions() {

	global $pagenow;
	$result = false;
	if ( isset( $_POST['add_pmpro_field_submit'] ) ) {
		$nonce = filter_get( '_wpnonce' );
		if ( ! wp_verify_nonce( $nonce, 'taw_pmpro_add_field_nonce' ) ) {
			die( 'Security check' );
		}
		$result  = add_pmpro_custom_field();
		$type    = $result ? 'success' : 'error';
		$label   = filter_post( 'field_text_label' );
		$message = $result ? 'Field "' . $label . '" added successfully.' : 'Error adding field.';
		echo '<div class="notice notice-' . esc_attr( $type ) . ' is-dismissible"><p><strong>' . esc_html( $message ) . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	}
	if ( isset( $_POST['delete_pmpro_form_field'] ) ) {
		$nonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
		if ( ! wp_verify_nonce( $nonce, 'taw_pmpro_delete_field_nonce' ) ) {
			die( 'Security check' );
		}
		$result  = delete_custom_pmpro_field( filter_post( 'delete_pmpro_form_field' ) );
		$type    = $result ? 'success' : 'error';
		$message = $result ? 'Field deleted successfully.' : 'Error deleting field.';
		echo '<div class="notice notice-' . esc_attr( $type ) . ' is-dismissible"><p><strong>' . esc_html( $message ) . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	}
}
add_action( 'admin_notices', 'notice_pmpro_field_actions' );

function filter_get( $input, $filter = FILTER_SANITIZE_STRING ) {
	return filter_input( INPUT_GET, $input, $filter );
}

function filter_post( $input, $filter = FILTER_SANITIZE_STRING ) {
	return filter_input( INPUT_POST, $input, $filter );
}

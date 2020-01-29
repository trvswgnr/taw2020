<?php
add_action( 'show_user_profile', 'add_carrier_name_to_user_admin' );
add_action( 'edit_user_profile', 'add_carrier_name_to_user_admin' );
function add_carrier_name_to_user_admin() {
	$user_id = filter_input( INPUT_GET, 'user_id', FILTER_SANITIZE_STRING ) ?: get_current_user_id();
	$str     = '<div class="um-field um-field-text um-field-type_text user-carrier_name-id">
		<div class="um-field-label"><label for="carrier_name">Carrier</label><div class="um-clear"></div></div>
		<div class="um-field-area">
			<select class="form-control um-form-field valid " name="carrier_name" id="carrier_name" style="color: #666666; border: 2px solid #ddd !important; padding: 0 12px !important; width: 100%; height: 40px; box-sizing: border-box;">
				<option value="">Select carrier</option>
				<option value="Ameritech">Ameritech</option>
				<option value="AT&amp;T">AT&amp;T</option>
				<option value="Bell Mobility - Canada">Bell Mobility - Canada</option>
				<option value="Bellsouth">Bellsouth</option>
				<option value="Boost Mobile">Boost Mobile</option>
				<option value="Cellular One (Canada)">Cellular One (Canada)</option>
				<option value="CellularOne">CellularOne</option>
				<option value="Cincinnati Bell Wireless">Cincinnati Bell Wireless</option>
				<option value="Cingular / AT&amp;T">Cingular / AT&amp;T</option>
				<option value="Credo Mobile">Credo Mobile</option>
				<option value="Cricket">Cricket</option>
				<option value="Edge Wireless">Edge Wireless</option>
				<option value="fido (Canada)">fido (Canada)</option>
				<option value="FirstNet">FirstNet</option>
				<option value="Google Project Fi">Google Project Fi</option>
				<option value="iWireless">iWireless</option>
				<option value="Koodo">Koodo</option>
				<option value="Metro PCS">Metro PCS</option>
				<option value="MobileOne">MobileOne</option>
				<option value="MTS">MTS</option>
				<option value="NexTel">NexTel</option>
				<option value="nTelos">nTelos</option>
				<option value="PCS Wireless">PCS Wireless</option>
				<option value="Qualcomm">Qualcomm</option>
				<option value="Qwest">Qwest</option>
				<option value="Rogers Wireless (Canada)">Rogers Wireless (Canada)</option>
				<option value="Sprint PCS">Sprint PCS</option>
				<option value="T-Mobile">T-Mobile</option>
				<option value="T-Mobile Sidekick">T-Mobile Sidekick</option>
				<option value="Telus Mobility (Canada)">Telus Mobility (Canada)</option>
				<option value="US Cellular">US Cellular</option>
				<option value="Verizon">Verizon</option>
				<option value="Virgin Mobile">Virgin Mobile</option>
				<option value="Virgin Mobile (Canada)">Virgin Mobile (Canada)</option>
				<option value="Xfinity">Xfinity</option>
			</select>
		</div>
	</div>
	<script>jQuery(".user-carrier_name-id").insertAfter(jQuery(".um-field-mobile_number"));
	jQuery("#carrier_name option[value=';
	$str    .= "'";
	$str    .= get_user_meta( $user_id, 'carrier_name' )[0];
	$str    .= "'";
	$str    .= ']").prop("selected",true);</script>';

	echo $str;
}

add_action( 'personal_options_update', 'save_user_carrier_name_field' );
add_action( 'edit_user_profile_update', 'save_user_carrier_name_field' );

function save_user_carrier_name_field( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	// save dropdown.
	update_user_meta( $user_id, 'carrier_name', $_POST['carrier_name'] );
}

$sms_group_ids = array(
	'general_members' => 'General Members',
	'executive_board' => 'Executive Board',
	'retirees'        => 'Retirees',
);

function add_sms_group_id_field( $user ) {
	?>
	<table class="form-table">
		<tr>
			<th>Group</th>
			<td>
				<?php
				global $sms_group_ids;
				foreach ( $sms_group_ids as $key => $value ) {
					$code    = 'group_id_' . $key;
					$lang    = get_the_author_meta( $code, $user->ID );
					$checked = '';
					if ( $lang == 'yes' ) {
						$checked = 'checked="checked"';
					}
					?>
					<label>
						<input type="checkbox" name="<?php echo $code; ?>" <?php echo $checked; ?> value="yes" /> <?php echo $value; ?>
					</label>&nbsp;&nbsp;
					<?php
				}
				?>
			</td>
		</tr>
	</table>
	<?php
}

function save_sms_group_id_field( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	global $sms_group_ids;
	foreach ( $sms_group_ids as $key => $value ) {
		$code = 'group_id_' . $key;
		update_user_meta( $user_id, $code, $_POST[ $code ] );
	}
}

add_action( 'show_user_profile', 'add_sms_group_id_field' );
add_action( 'edit_user_profile', 'add_sms_group_id_field' );
add_action( 'personal_options_update', 'save_sms_group_id_field' );
add_action( 'edit_user_profile_update', 'save_sms_group_id_field' );

/*
 allow saving of carrier in user admin */
// add_action( 'show_user_profile', 'add_carrier_name_to_user_admin' );
// add_action( 'edit_user_profile', 'add_carrier_name_to_user_admin' );


add_action( 'personal_options_update', 'save_user_carrier_name_field' );
add_action( 'edit_user_profile_update', 'save_user_carrier_name_field' );

function save_user_carrier_name_field( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	// save dropdown.
	update_user_meta( $user_id, 'carrier_name', $_POST['carrier_name'] );
}

<?php
function taw_bulk_add_users_group_enqueue() {
	// Enqueue javascript on the frontend.
	wp_enqueue_script(
		'taw-bulk-add-users-group',
		get_template_directory_uri() . '/js/simple-ajax-example.js',
		array( 'jquery' )
	);

	// The wp_localize_script allows us to output the ajax_url path for our script to use.
	wp_localize_script(
		'taw-bulk-add-users-group',
		'taw_bulk_add_users_group_obj',
		array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
	);

}
add_action( 'admin_enqueue_scripts', 'taw_bulk_add_users_group_enqueue' );

function taw_bulk_add_users_group_request() {
	global $wpdb;

	// The $_REQUEST contains all the data sent via ajax
	if ( isset( $_REQUEST ) ) {

		$obj = $_REQUEST['obj'];

		foreach ( $obj['users'] as $key => $val ) {
			$obj_arr              = array();
			$new                  = array( $obj['select'] => $obj['select'] );
			$s                    = array_filter( explode( ',', get_user_meta( $val, 'group_id' )[0] ) );
			$obj['users'][ $key ] = array_unique( array_merge( $new, $s ) );
			sort( $obj['users'][ $key ] );
			foreach ( $obj['users'][ $key ] as $item ) {
				$obj_arr[] = $item;
			}
			$obj['users'][ $key ] = $obj_arr;
		}

		foreach ( $obj['users'] as $uid => $groups ) {
			$groups = ',' . implode( ',', $groups ) . ',';
			$table  = $wpdb->prefix . 'sms_subscribes';
			$wpdb->update(
				$table,
				array(
					'group_ID' => $groups,
				),
				array(
					'name' => $uid,
				),
			);
		}

		// Now we'll return it to the javascript function
		// Anything outputted will be returned in the response.
		echo json_encode( $obj );

	}

	// Always die in functions echoing ajax content
	die();
}

add_action( 'wp_ajax_taw_bulk_add_users_group_request', 'taw_bulk_add_users_group_request' );

// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_taw_bulk_add_users_group_request', 'taw_bulk_add_users_group_request' );


add_action( 'restrict_manage_users', 'taw_bulk_add_to_sms_group_html' );

function taw_bulk_add_to_sms_group_html() {
	global $wpdb;
	$table  = $wpdb->prefix . 'sms_subscribes_group';
	$groups = $wpdb->get_results( "SELECT * FROM {$table}" );

	?>
	<div style="float: right; margin:0 4px">
		<label class="screen-reader-text" for="taw_group_add">Add Users to SMS Group</label>
		<select name="taw_group_add[]" id="taw_group_add" class="" style="width: 200px">
			<option value="null">Add Users to SMS Group</option>
			<?php
			foreach ( $groups as $group ) :
				?>
				<option value="<?php echo $group->ID; ?>"><?php echo $group->name; ?></option>
				<?php
			endforeach;
			?>
		</select>
		<button id="taw_bulk_add_group_submit" class="button" value="Add">Add</button>
	</div>
	<?php
}

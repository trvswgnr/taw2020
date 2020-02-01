jQuery( document ).ready( function( $ ) {
	// This does the ajax request
	$( document ).on( 'click', '#taw_bulk_add_group_submit', function( e ) {
		e.preventDefault();
		var $users = {};
		var obj = {};
		$( '[name="users[]"]:checked' ).each( function( i ) {
			var val = $( this ).attr( 'value' );
			$users[ val ] = val;
		} );
		obj.users = $users;
		obj.select = $( '#taw_group_add' ).val();
		$.ajax( {
			url: taw_bulk_add_users_group_obj.ajaxurl,
			data: {
				action: 'taw_bulk_add_users_group_request',
				obj: obj
			},
			success: function( data ) {
				data = JSON.parse( data );
				// This outputs the result of the ajax request
				console.log( data );
			},
			error: function( errorThrown ) {
				console.log( errorThrown );
			}
		} );
	} );
} );

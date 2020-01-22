/**
 * Main JS
 */

( function( $ ) {
	$( '.spinner a' ).click( function() {
		$( '.spinner' ).addClass( 'is-active' ).fadeOut( 1000 );
	} );

	$( document ).ready( function() {
		if ( $( this ).scrollTop() <= 5 ) {
			$( '#content, #resume' ).addClass( 'is-active' );
		} else {
			$( '#content, #resume' ).addClass( 'is-active no-transition' );
		}
	} );
}( jQuery ) );

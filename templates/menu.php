<?php
/**
 * Template Name: Menu
 *
 * @package taw
 */

get_header();
$appetizers = get_field( 'appetizers' );
if ( $appetizers ) :
	?>
	<ul>
	<?php
	foreach ( $appetizers as $appetizer ) :
		?>
		<li>
			<strong><?php echo esc_html( $appetizer['title'] ); ?>: </strong>
			<span><?php echo esc_html( $appetizer['description'] ); ?></span>
		</li>
		<?php
	endforeach;
	?>
	</ul>
	<?php
endif;
get_footer();

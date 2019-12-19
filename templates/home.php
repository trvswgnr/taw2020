<?php
/**
 * Template Name: Home
 *
 * @package taw
 */

get_header();
?>
<div class="spinner">
	<div class="spinner__container">
		<?php for ( $i = 1; $i <= 15; $i++ ) : ?>
			<div class="spinner__ring spinner__ring--<?php echo esc_attr( $i ); ?>"></div>
		<?php endfor; ?>
	</div>
	<div class="spinner__text">
		<h1 class="spinner__heading">Travis A. Wagner</h1>
		<p class="spinner__desc">Developer <span>/</span> Designer <span>/</span> Producer <span>/</span> Digital Marketer</p>
	</div>
</div>
<?php
get_footer();

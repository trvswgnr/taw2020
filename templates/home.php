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
	<nav class="nav-home">
		<ul class="nav-home__menu">
		<li><a href="<?php echo esc_url( site_url() ); ?>/resume">Résumé</a></li>
		<li><a href="#">Portfolio</a></li>
		<li><a href="#">Articles</a></li>
		<li><a href="#">Music</a></li>
		<li><a href="#">About</a></li>
		<li><a href="#">Contact</a></li>
		</ul>
	</nav>
</div>
<?php
get_footer();

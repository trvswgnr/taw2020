<?php
/**
 * Theme Default Template
 *
 * @package taw
 */

get_header();
?>
<main class="container">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		?>
		<article class="content">
		<?php
		the_post();
		the_content();
		?>
		</article>
		<?php
	endwhile;
endif;
?>
</main>
<?php
get_footer();

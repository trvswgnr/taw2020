<?php
/**
 * Default Template
 *
 * @package taw
 */

get_header();
?>
<main id="main" class="container">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		?>
		<article id="content" class="content rte" role="content">
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

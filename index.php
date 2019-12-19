<?php
/**
 * Default Template
 *
 * @package taw
 */

get_header();
?>
<article id="content" class="content container rte" role="content">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		?>
		<?php
		the_post();
		the_content();
		?>
		<?php
	endwhile;
endif;
?>
</article>
<?php
get_footer();

<?php
/**
 * Blog Posts Template
 *
 * @package taw
 */

get_header();
?>
<section id="content" class="articles content container rte" role="content">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		?>
		<article class="article-preview">
			<?php the_post(); ?>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_category(); ?>
				<?php the_excerpt(); ?>
				<p><a href="<?php the_permalink(); ?>">Read More</a></p>
			</article>
			<hr>
		<?php
	endwhile;
endif;
?>
</section>
<?php
get_footer();

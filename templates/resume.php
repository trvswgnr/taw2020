<?php
/**
 * Template Name: Résumé
 *
 * @package taw
 */

get_header();

$profile     = get_field( 'resume_profile' );
$contact     = get_field( 'resume_contact' );
$recent_work = get_field( 'resume_recent_work' );
?>
<article id="resume" class="resume container">
	<div class="row">
		<div class="col col--sidebar">
			<section class="resume__sidebar">
				<?php if ( $profile ) : ?>
					<div class="profile">
						<a class="profile__pic"><?php echo wp_get_attachment_image( $profile['picture'], 'full' ); ?></a>
						<h1 class="profile__name"><?php echo esc_html( $profile['name'] ); ?></h1>
						<h2 class="profile__title"><?php echo esc_html( $profile['title'] ); ?></h2>
						<?php if ( $profile['objective'] ) : ?>
							<hr class="sidebar__hr">
							<div class="profile__objective">
								<h2 class="profile__heading">Objective</h2>
								<p><?php echo wp_kses_post( $profile['objective'] ); ?></p>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( $contact ) : ?>
					<hr class="sidebar__hr">
					<div class="contact resume__contact">
						<h2 class="sidebar__heading contact__heading">Contact</h2>
						<h4 class="contact__type">Phone</h4>
						<a href="tel:<?php echo esc_attr( $contact['phone'] ); ?>"><?php echo esc_html( $contact['phone'] ); ?></a>
						<h4 class="contact__type">Email</h4>
						<a href="<?php esc_attr( $contact['email'] ); ?>"><?php echo esc_html( $contact['email'] ); ?></a>
						<h4 class="contact__type">Address</h4>
						<address><a href="<?php echo esc_url( Theme::address_map_link( $contact['address'] ) ); ?>"><?php echo wp_kses_post( $contact['address'] ); ?></a></address>
					</div>
				<?php endif; ?>
				<?php if ( $recent_work ) : ?>
					<hr class="sidebar__hr">
					<div class="link-list resume__link-list resume__recent-work">
						<h2 class="sidebar__heading link-list__heading">Recent Work</h2>
						<?php foreach ( $recent_work as $item ) : ?>
							<a href="<?php echo esc_url( $item['link']['url'] ); ?>"><?php echo esc_html( $item['link']['title'] ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</section>
		</div>
		<div class="col col--content">
			<div class="resume__content">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
			endif;
			?>
			</div>
		</div>
	</div>
</article>
<?php
get_footer();

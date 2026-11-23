<?php
/**
 * Single service.
 *
 * @package Bradley_Industrial
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<header class="page-banner page-banner--service" style="--tile:<?php echo esc_attr( bi_service_colour() ); ?>">
		<div class="container">
			<p class="breadcrumbs">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'Our Services', 'bradley-industrial' ); ?></a> /
			</p>
			<h1 class="page-banner__title bi-heading">
				<?php echo bi_icon( bi_service_icon() ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<span><?php the_title(); ?></span>
			</h1>
		</div>
	</header>

	<div class="content-area">
		<div class="container content-layout">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content' ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>
				<?php the_content(); ?>
				<p><a class="bi-button" href="<?php echo esc_url( bi_page_link( 'contact' ) ); ?>"><?php esc_html_e( 'Ask us about this service', 'bradley-industrial' ); ?></a></p>
			</article>
			<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'bradley-industrial' ); ?>">
				<?php get_template_part( 'template-parts/sidebar', 'services' ); ?>
				<?php bi_cta_box(); ?>
			</aside>
		</div>
	</div>
	<?php
endwhile;

get_footer();

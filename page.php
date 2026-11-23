<?php
/**
 * Default page template.
 *
 * @package Bradley_Industrial
 */

get_header();

while ( have_posts() ) :
	the_post();
	bi_page_banner( get_the_title() );
	?>
	<div class="content-area">
		<div class="container content-layout">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content' ); ?>>
				<?php
				the_content();
				wp_link_pages();
				?>
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

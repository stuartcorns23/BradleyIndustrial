<?php
/**
 * Single news post.
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
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<p class="entry-meta">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<?php if ( has_category() ) : ?>
						&middot; <?php the_category( ', ' ); ?>
					<?php endif; ?>
				</p>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>
				<div class="entry-content">
					<?php
					the_content();
					wp_link_pages();
					?>
				</div>
				<?php
				the_post_navigation(
					array(
						'prev_text' => '&larr; %title',
						'next_text' => '%title &rarr;',
					)
				);
				?>
			</article>
			<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'bradley-industrial' ); ?>">
				<?php bi_cta_box(); ?>
				<?php get_template_part( 'template-parts/sidebar', 'services' ); ?>
			</aside>
		</div>
	</div>
	<?php
endwhile;

get_footer();

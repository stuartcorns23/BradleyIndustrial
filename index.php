<?php
/**
 * News listing, archives and search results.
 *
 * @package Bradley_Industrial
 */

get_header();

if ( is_home() ) {
	$bi_posts_page = (int) get_option( 'page_for_posts' );
	$bi_title      = $bi_posts_page ? get_the_title( $bi_posts_page ) : __( 'News & Updates', 'bradley-industrial' );
	$bi_sub        = '';
} elseif ( is_search() ) {
	/* translators: %s: search terms. */
	$bi_title = sprintf( __( 'Search: %s', 'bradley-industrial' ), esc_html( get_search_query() ) );
	$bi_sub   = '';
} else {
	$bi_title = get_the_archive_title();
	$bi_sub   = get_the_archive_description();
}

bi_page_banner( $bi_title, $bi_sub );
?>

<div class="content-area">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="news__grid">
				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/card', 'post' );
				}
				?>
			</div>
			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => __( '&larr; Newer', 'bradley-industrial' ),
					'next_text' => __( 'Older &rarr;', 'bradley-industrial' ),
				)
			);
			?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing to show here yet.', 'bradley-industrial' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();

<?php
/**
 * Not found.
 *
 * @package Bradley_Industrial
 */

get_header();
bi_page_banner( __( 'Page not found', 'bradley-industrial' ), __( 'Sorry, we couldn’t find that page. It may have moved when we updated our website.', 'bradley-industrial' ) );
?>
<div class="content-area">
	<div class="container">
		<p><a class="bi-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the home page', 'bradley-industrial' ); ?></a></p>
		<?php get_search_form(); ?>
	</div>
</div>
<?php
get_footer();

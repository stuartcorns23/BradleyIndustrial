<?php
/**
 * Template Name: Contact
 *
 * Contact details plus the built-in enquiry form.
 *
 * @package Bradley_Industrial
 */

get_header();

$bi_phone   = bi_mod( 'bi_phone' );
$bi_email   = bi_mod( 'bi_email' );
$bi_address = bi_mod( 'bi_address' );

while ( have_posts() ) :
	the_post();
	bi_page_banner( get_the_title() );
	?>
	<div class="content-area">
		<div class="container contact-grid">
			<div>
				<h2 class="bi-heading"><?php esc_html_e( 'Our core details', 'bradley-industrial' ); ?></h2>
				<ul class="contact-details">
					<?php if ( $bi_phone ) : ?>
						<li><strong><?php esc_html_e( 'Call us', 'bradley-industrial' ); ?></strong><a href="<?php echo esc_attr( bi_tel_href( $bi_phone ) ); ?>"><?php echo esc_html( $bi_phone ); ?></a></li>
					<?php endif; ?>
					<?php if ( $bi_email ) : ?>
						<li><strong><?php esc_html_e( 'Email us', 'bradley-industrial' ); ?></strong><a href="mailto:<?php echo esc_attr( antispambot( $bi_email ) ); ?>"><?php echo esc_html( antispambot( $bi_email ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( $bi_address ) : ?>
						<li><strong><?php esc_html_e( 'Find us', 'bradley-industrial' ); ?></strong><?php echo nl2br( esc_html( $bi_address ) ); ?></li>
					<?php endif; ?>
				</ul>
				<div class="entry-content"><?php the_content(); ?></div>
			</div>
			<div id="enquiry">
				<h2 class="bi-heading"><?php esc_html_e( 'Send us an enquiry', 'bradley-industrial' ); ?></h2>
				<?php echo bi_contact_form(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in the form renderer. ?>
			</div>
		</div>
	</div>
	<?php
endwhile;

get_footer();

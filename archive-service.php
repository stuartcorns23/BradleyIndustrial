<?php
/**
 * Services listing (/services/).
 *
 * @package Bradley_Industrial
 */

get_header();

bi_page_banner(
	__( 'Our Services', 'bradley-industrial' ),
	__( 'Everything you’ll need. Our skilled engineers cover a wide range of systems and installations, 24 hours a day, 365 days a year.', 'bradley-industrial' )
);
?>

<div class="content-area">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="service-cards">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<a class="service-card" href="<?php the_permalink(); ?>" style="--tile:<?php echo esc_attr( bi_service_colour() ); ?>">
						<div class="service-card__head">
							<?php echo bi_icon( bi_service_icon() ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							<h2><?php the_title(); ?></h2>
						</div>
						<div class="service-card__body">
							<?php if ( has_excerpt() ) : ?>
								<p><?php echo esc_html( get_the_excerpt() ); ?></p>
							<?php endif; ?>
							<span class="service-card__more"><?php esc_html_e( 'Find out more', 'bradley-industrial' ); ?> &rarr;</span>
						</div>
					</a>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Services will be listed here soon.', 'bradley-industrial' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<section class="cta-band">
	<div class="container cta-band__inner">
		<div>
			<h2 class="bi-heading"><?php esc_html_e( 'Something missing?', 'bradley-industrial' ); ?></h2>
			<p><?php esc_html_e( 'If you can’t see what you need, get in touch and we’ll let you know how we can help.', 'bradley-industrial' ); ?></p>
		</div>
		<a class="bi-button" href="<?php echo esc_url( bi_page_link( 'contact' ) ); ?>"><?php esc_html_e( 'Contact us today', 'bradley-industrial' ); ?></a>
	</div>
</section>

<?php
get_footer();

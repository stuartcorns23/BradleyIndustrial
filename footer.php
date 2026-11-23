<?php
/**
 * Site footer.
 *
 * @package Bradley_Industrial
 */

$bi_phone   = bi_mod( 'bi_phone' );
$bi_email   = bi_mod( 'bi_email' );
$bi_address = bi_mod( 'bi_address' );
?>
</main>

<?php if ( bi_mod( 'bi_show_accreditations' ) ) : ?>
	<section class="accreditations" aria-label="<?php esc_attr_e( 'Accreditations', 'bradley-industrial' ); ?>">
		<div class="container">
			<ul class="accreditations__list">
				<?php foreach ( bi_accreditations() as $bi_file => $bi_alt ) : ?>
					<li><img src="<?php echo esc_url( BI_URI . '/assets/images/accreditations/' . $bi_file ); ?>" width="150" height="150" alt="<?php echo esc_attr( $bi_alt ); ?>" loading="lazy" /></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<footer class="site-footer">
	<div class="container site-footer__top">
		<div>
			<h2><?php esc_html_e( 'Get in touch', 'bradley-industrial' ); ?></h2>
			<ul>
				<?php if ( $bi_phone ) : ?>
					<li><a href="<?php echo esc_attr( bi_tel_href( $bi_phone ) ); ?>"><?php echo esc_html( $bi_phone ); ?></a></li>
				<?php endif; ?>
				<?php if ( $bi_email ) : ?>
					<li><a href="mailto:<?php echo esc_attr( antispambot( $bi_email ) ); ?>"><?php echo esc_html( antispambot( $bi_email ) ); ?></a></li>
				<?php endif; ?>
				<?php if ( $bi_address ) : ?>
					<li><?php echo nl2br( esc_html( $bi_address ) ); ?></li>
				<?php endif; ?>
			</ul>
		</div>
		<div>
			<h2><?php esc_html_e( 'Our services', 'bradley-industrial' ); ?></h2>
			<ul>
				<?php foreach ( array_slice( bi_get_services(), 0, 6 ) as $bi_service ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $bi_service ) ); ?>"><?php echo esc_html( get_the_title( $bi_service ) ); ?></a></li>
				<?php endforeach; ?>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'View all services', 'bradley-industrial' ); ?> &rarr;</a></li>
			</ul>
		</div>
		<div>
			<h2><?php esc_html_e( 'Quick links', 'bradley-industrial' ); ?></h2>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1 ) );
			} else {
				?>
				<ul>
					<li><a href="<?php echo esc_url( bi_page_link( 'about' ) ); ?>"><?php esc_html_e( 'About Us', 'bradley-industrial' ); ?></a></li>
					<li><a href="<?php echo esc_url( bi_news_link() ); ?>"><?php esc_html_e( 'News & Updates', 'bradley-industrial' ); ?></a></li>
					<li><a href="<?php echo esc_url( bi_page_link( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'bradley-industrial' ); ?></a></li>
				</ul>
				<?php
			}
			?>
		</div>
	</div>
	<div class="site-footer__bottom">
		<div class="container">
			<p><?php echo esc_html( str_replace( '{year}', wp_date( 'Y' ), bi_mod( 'bi_copyright' ) ) ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

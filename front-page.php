<?php
/**
 * Home page. Copy is edited in Appearance > Customize > Bradley Industrial.
 *
 * @package Bradley_Industrial
 */

get_header();

$bi_services = bi_get_services();
$bi_news     = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	)
);
$bi_hero_url = bi_mod( 'bi_hero_button_url' );
if ( $bi_hero_url && 0 === strpos( $bi_hero_url, '/' ) ) {
	$bi_hero_url = home_url( $bi_hero_url );
}
?>

<section class="hero">
	<div class="container hero__inner">
		<div class="hero__body">
			<h1 class="hero__title bi-heading"><?php echo esc_html( bi_mod( 'bi_hero_title' ) ); ?></h1>
			<div class="hero__text"><?php echo bi_paragraphs( bi_mod( 'bi_hero_text' ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in helper. ?></div>
			<?php if ( bi_mod( 'bi_hero_button_label' ) && $bi_hero_url ) : ?>
				<a class="bi-button" href="<?php echo esc_url( $bi_hero_url ); ?>"><?php echo esc_html( bi_mod( 'bi_hero_button_label' ) ); ?></a>
			<?php endif; ?>
		</div>
		<div class="hero__media">
			<img src="<?php echo esc_url( bi_mod_image( 'bi_hero_image', 'hero.jpg' ) ); ?>" width="1600" height="1067" alt="" fetchpriority="high" />
		</div>
	</div>
</section>

<?php if ( $bi_services ) : ?>
	<section class="service-tiles" aria-label="<?php esc_attr_e( 'Our services', 'bradley-industrial' ); ?>">
		<div class="container">
			<ul class="service-tiles__list">
				<?php
				foreach ( $bi_services as $bi_service ) {
					bi_service_tile( $bi_service );
				}
				?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<section class="about-split">
	<div class="container about-split__inner">
		<div class="about-split__media">
			<img src="<?php echo esc_url( bi_mod_image( 'bi_about_image', 'about.jpg' ) ); ?>" width="1400" height="934" alt="" loading="lazy" />
		</div>
		<div class="about-split__body">
			<h2 class="bi-heading"><?php echo esc_html( bi_mod( 'bi_about_title' ) ); ?></h2>
			<?php echo bi_paragraphs( bi_mod( 'bi_about_text' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php if ( bi_mod( 'bi_about_button_label' ) ) : ?>
				<a class="bi-button" href="<?php echo esc_url( bi_page_link( 'about' ) ); ?>"><?php echo esc_html( bi_mod( 'bi_about_button_label' ) ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if ( bi_mod( 'bi_testimonial_quote' ) ) : ?>
	<section class="testimonial">
		<div class="container testimonial__inner">
			<div class="testimonial__body">
				<h2 class="bi-heading"><?php echo esc_html( bi_mod( 'bi_testimonial_title' ) ); ?></h2>
				<blockquote>
					<p>&ldquo;<?php echo esc_html( bi_mod( 'bi_testimonial_quote' ) ); ?>&rdquo;</p>
					<?php if ( bi_mod( 'bi_testimonial_author' ) ) : ?>
						<cite><?php echo esc_html( bi_mod( 'bi_testimonial_author' ) ); ?></cite>
					<?php endif; ?>
				</blockquote>
			</div>
			<div class="testimonial__media">
				<img class="testimonial__person" src="<?php echo esc_url( bi_mod_image( 'bi_testimonial_image', 'testimonial.png' ) ); ?>" width="700" height="1052" alt="" loading="lazy" />
				<img class="testimonial__logo" src="<?php echo esc_url( bi_mod_image( 'bi_testimonial_logo', 'midland-heart.png' ) ); ?>" width="962" height="305" alt="<?php esc_attr_e( 'Client logo', 'bradley-industrial' ); ?>" loading="lazy" />
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="news">
	<div class="container">
		<h2 class="bi-heading bi-heading--center"><?php echo esc_html( bi_mod( 'bi_news_title' ) ); ?></h2>
		<?php if ( $bi_news->have_posts() ) : ?>
			<div class="news__grid">
				<?php
				while ( $bi_news->have_posts() ) {
					$bi_news->the_post();
					get_template_part( 'template-parts/card', 'post' );
				}
				wp_reset_postdata();
				?>
			</div>
			<p class="news__footer"><a class="bi-button" href="<?php echo esc_url( bi_news_link() ); ?>"><?php esc_html_e( 'More News', 'bradley-industrial' ); ?></a></p>
		<?php else : ?>
			<p class="news__empty"><?php esc_html_e( 'News and updates will appear here soon.', 'bradley-industrial' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();

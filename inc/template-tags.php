<?php
/**
 * Template helpers.
 *
 * @package Bradley_Industrial
 */

defined( 'ABSPATH' ) || exit;

/**
 * Turn plain textarea copy into paragraphs.
 *
 * @param string $text Plain text with blank lines between paragraphs.
 * @return string
 */
function bi_paragraphs( $text ) {
	return wpautop( esc_html( $text ) );
}

/**
 * Phone number as a tel: href.
 *
 * @param string $phone Display phone number.
 * @return string
 */
function bi_tel_href( $phone ) {
	$digits = preg_replace( '/[^0-9+]/', '', $phone );
	if ( 0 === strpos( $digits, '0' ) ) {
		$digits = '+44' . substr( $digits, 1 );
	}
	return 'tel:' . $digits;
}

/**
 * Fallback primary menu, used until a menu is assigned in Appearance > Menus.
 */
function bi_fallback_menu() {
	$items = array(
		array( home_url( '/' ), __( 'Home', 'bradley-industrial' ), is_front_page(), '' ),
		array( bi_page_link( 'about' ), __( 'About Us', 'bradley-industrial' ), is_page( 'about' ), '' ),
		array( get_post_type_archive_link( 'service' ), __( 'Our Services', 'bradley-industrial' ), is_post_type_archive( 'service' ) || is_singular( 'service' ), '' ),
		array( bi_news_link(), __( 'News & Updates', 'bradley-industrial' ), is_home() || is_singular( 'post' ) || is_category(), '' ),
		array( bi_page_link( 'contact' ), __( 'Contact Us', 'bradley-industrial' ), false, 'menu-button' ),
	);

	echo '<ul id="primary-menu" class="menu">';
	foreach ( $items as $item ) {
		list( $url, $label, $current, $class ) = $item;
		$classes = trim( 'menu-item ' . $class . ( $current ? ' current-menu-item' : '' ) );
		printf(
			'<li class="%1$s"><a href="%2$s"%4$s>%3$s</a></li>',
			esc_attr( $classes ),
			esc_url( $url ),
			esc_html( $label ),
			$current ? ' aria-current="page"' : ''
		);
	}
	echo '</ul>';
}

/**
 * Permalink of a page by slug, or a sensible guess if it doesn't exist yet.
 *
 * @param string $slug Page slug.
 * @return string
 */
function bi_page_link( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/**
 * Link to the news listing (the posts page, or the News category).
 *
 * @return string
 */
function bi_news_link() {
	$posts_page = (int) get_option( 'page_for_posts' );
	if ( $posts_page ) {
		return get_permalink( $posts_page );
	}
	$cat = get_category_by_slug( 'news' );
	return $cat ? get_category_link( $cat ) : home_url( '/' );
}

/**
 * Page banner used at the top of inner pages.
 *
 * @param string $title    Title.
 * @param string $subtitle Optional intro line.
 */
function bi_page_banner( $title, $subtitle = '' ) {
	?>
	<header class="page-banner">
		<div class="container">
			<h1 class="page-banner__title bi-heading"><?php echo wp_kses_post( $title ); ?></h1>
			<?php if ( $subtitle ) : ?>
				<p class="page-banner__sub"><?php echo wp_kses_post( $subtitle ); ?></p>
			<?php endif; ?>
		</div>
	</header>
	<?php
}

/**
 * A single service tile (home page grid).
 *
 * @param WP_Post $service Service post.
 */
function bi_service_tile( $service ) {
	printf(
		'<li><a class="service-tile" href="%1$s" style="--tile:%2$s">%3$s<span>%4$s</span></a></li>',
		esc_url( get_permalink( $service ) ),
		esc_attr( bi_service_colour( $service ) ),
		bi_icon( bi_service_icon( $service ) ), // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG markup.
		esc_html( get_the_title( $service ) )
	);
}

/**
 * Sidebar "call us" box.
 */
function bi_cta_box() {
	$phone = bi_mod( 'bi_phone' );
	?>
	<div class="sidebar-box sidebar-box--cta">
		<h2><?php esc_html_e( 'Talk to us today', 'bradley-industrial' ); ?></h2>
		<p><?php esc_html_e( 'Our engineers cover a wide range of systems and installations, 24 hours a day, 365 days a year.', 'bradley-industrial' ); ?></p>
		<?php if ( $phone ) : ?>
			<p><a class="phone" href="<?php echo esc_attr( bi_tel_href( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
		<?php endif; ?>
		<a class="bi-button" href="<?php echo esc_url( bi_page_link( 'contact' ) ); ?>"><?php esc_html_e( 'Send an enquiry', 'bradley-industrial' ); ?></a>
	</div>
	<?php
}

/**
 * Accreditation logos bundled with the theme.
 *
 * @return array file => alt text.
 */
function bi_accreditations() {
	return apply_filters(
		'bi_accreditations',
		array(
			'chas.png'             => 'CHAS Accredited Contractor',
			'gas-safe.png'         => 'Gas Safe Register',
			'constructionline.png' => 'Constructionline',
			'green-man.png'        => 'Green Man',
			'oftec.png'            => 'OFTEC',
			'aphc.png'             => 'APHC Licensed Member',
		)
	);
}

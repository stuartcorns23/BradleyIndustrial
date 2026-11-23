<?php
/**
 * Bradley Industrial 2026 theme functions.
 *
 * @package Bradley_Industrial
 */

defined( 'ABSPATH' ) || exit;

define( 'BI_VERSION', '1.0.0' );
define( 'BI_DIR', get_template_directory() );
define( 'BI_URI', get_template_directory_uri() );

require BI_DIR . '/inc/icons.php';
require BI_DIR . '/inc/services.php';
require BI_DIR . '/inc/customizer.php';
require BI_DIR . '/inc/template-tags.php';
require BI_DIR . '/inc/contact-form.php';
require BI_DIR . '/inc/starter-content.php';

/**
 * Theme setup.
 */
function bi_setup() {
	load_theme_textdomain( 'bradley-industrial', BI_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 160,
			'width'       => 640,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'editor-color-palette',
		array(
			array( 'name' => __( 'Bradley red', 'bradley-industrial' ), 'slug' => 'bi-red', 'color' => '#e8413a' ),
			array( 'name' => __( 'Black', 'bradley-industrial' ), 'slug' => 'bi-black', 'color' => '#000000' ),
			array( 'name' => __( 'Light grey', 'bradley-industrial' ), 'slug' => 'bi-grey', 'color' => '#e5e5e5' ),
			array( 'name' => __( 'White', 'bradley-industrial' ), 'slug' => 'bi-white', 'color' => '#ffffff' ),
		)
	);

	add_image_size( 'bi-card', 720, 600, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'bradley-industrial' ),
			'footer'  => __( 'Footer menu', 'bradley-industrial' ),
		)
	);
}
add_action( 'after_setup_theme', 'bi_setup' );

/**
 * Front-end assets.
 */
function bi_enqueue_assets() {
	wp_enqueue_style(
		'bi-fonts',
		'https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@800;900&family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'bi-style', get_stylesheet_uri(), array( 'bi-fonts' ), BI_VERSION );
	wp_enqueue_script( 'bi-main', BI_URI . '/assets/js/main.js', array(), BI_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'bi_enqueue_assets' );

/**
 * Preconnect to Google Fonts.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function bi_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'bi_resource_hints', 10, 2 );

/**
 * Use the flame mark as the site icon when none is set.
 */
function bi_default_site_icon() {
	if ( has_site_icon() ) {
		return;
	}
	printf( '<link rel="icon" href="%s" sizes="512x512" />' . "\n", esc_url( BI_URI . '/assets/images/flame.png' ) );
}
add_action( 'wp_head', 'bi_default_site_icon' );

/**
 * Shorter excerpts for cards.
 *
 * @return int
 */
function bi_excerpt_length() {
	return 26;
}
add_filter( 'excerpt_length', 'bi_excerpt_length' );

/**
 * Plain ellipsis for excerpts.
 *
 * @return string
 */
function bi_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'bi_excerpt_more' );

/**
 * Highlight the "Our Services" menu item while viewing a single service.
 *
 * @param array  $classes Menu item classes.
 * @param object $item   Menu item.
 * @return array
 */
function bi_nav_menu_css_class( $classes, $item ) {
	if ( 'service' === get_post_type() && isset( $item->object ) && 'service' === $item->object && 'post_type_archive' === $item->type ) {
		$classes[] = 'current-menu-item';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'bi_nav_menu_css_class', 10, 2 );

/**
 * Show all services on the services archive, ordered by menu order.
 *
 * @param WP_Query $query Main query.
 */
function bi_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'service' ) ) {
		$query->set( 'posts_per_page', -1 );
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
	}
}
add_action( 'pre_get_posts', 'bi_pre_get_posts' );

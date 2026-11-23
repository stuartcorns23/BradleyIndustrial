<?php
/**
 * Site header.
 *
 * @package Bradley_Industrial
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'bradley-industrial' ); ?></a>

<header class="site-header">
	<div class="container site-header__inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( BI_URI . '/assets/images/logo.png' ); ?>" width="640" height="160" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
				</a>
			<?php endif; ?>
		</div>

		<nav class="main-navigation" id="site-navigation" aria-label="<?php esc_attr_e( 'Primary', 'bradley-industrial' ); ?>">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'bradley-industrial' ); ?></span>
				<span class="menu-toggle__bar"></span>
				<span class="menu-toggle__bar"></span>
				<span class="menu-toggle__bar"></span>
			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'fallback_cb'    => 'bi_fallback_menu',
				)
			);
			?>
		</nav>
	</div>
</header>

<main id="main" class="site-main">

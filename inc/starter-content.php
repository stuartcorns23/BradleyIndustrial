<?php
/**
 * One-off content import: the first time the theme is activated it creates the
 * pages, services and menu carried over from the previous site, and sets the
 * home and news pages. Existing pages/services with the same slug are left alone.
 *
 * To run it again, delete the "bi_content_installed" option and re-activate the theme.
 *
 * @package Bradley_Industrial
 */

defined( 'ABSPATH' ) || exit;

/**
 * Block markup helpers.
 */
function bi_block_p( $text ) {
	return "<!-- wp:paragraph -->\n<p>" . $text . "</p>\n<!-- /wp:paragraph -->\n\n";
}

/**
 * Heading block.
 *
 * @param string $text  Heading.
 * @param int    $level Level.
 * @return string
 */
function bi_block_h( $text, $level = 2 ) {
	$attr = 2 === $level ? '' : ' {"level":' . (int) $level . '}';
	return "<!-- wp:heading{$attr} -->\n<h{$level} class=\"wp-block-heading\">" . $text . "</h{$level}>\n<!-- /wp:heading -->\n\n";
}

/**
 * List block.
 *
 * @param array $items Items.
 * @return string
 */
function bi_block_list( $items ) {
	$out = "<!-- wp:list -->\n<ul class=\"wp-block-list\">";
	foreach ( $items as $item ) {
		$out .= "<!-- wp:list-item -->\n<li>" . $item . "</li>\n<!-- /wp:list-item -->";
	}
	return $out . "</ul>\n<!-- /wp:list -->\n\n";
}

/**
 * Services from the previous site.
 *
 * @return array slug => [ title, heading, intro, list items ].
 */
function bi_starter_services() {
	return array(
		'ventilation-services'         => array(
			'Ventilation Services',
			'Ventilation',
			'Installation, servicing and maintenance of ventilation plant, from air handling units to supply and extract systems.',
			array( 'Ventilation services', 'AHU units', 'Filter replacement', 'Maintenance and service', 'Supply and extract systems', 'Ducting and controls' ),
		),
		'renewable-services'           => array(
			'Renewable Services',
			'Renewable',
			'Lower-carbon heating and hot water technologies, installed and maintained by our engineers.',
			array( 'Solar thermal systems', 'Biomass units', 'CHP units', 'Air source heat pumps' ),
		),
		'gas-catering'                 => array(
			'Gas Catering',
			'Gas Catering Services',
			'Keeping commercial kitchens running safely, with servicing, interlocks and fast access to parts.',
			array( 'Appliance maintenance and service', 'Gas interlock and proving systems', 'Direct supplier relationships', 'Spare parts' ),
		),
		'gas-service'                  => array(
			'Gas Service',
			'Gas Services',
			'Servicing, repair and installation across commercial and domestic gas appliances.',
			array( 'Commercial and domestic boilers', 'Water heaters', 'Warm air units', 'Radiant tube heaters', 'Direct fired heaters', 'Domestic cookers', 'Domestic fires', 'Commercial catering appliances', 'Commercial laundry appliances' ),
		),
		'electrical-catering-services' => array(
			'Electrical Catering Services',
			'Electrical Catering',
			'Maintenance and repair of electric catering equipment, backed by direct supplier relationships.',
			array( 'Appliance maintenance and service', 'Interlock and proving systems', 'Direct supplier relationships', 'Spare parts' ),
		),
		'control-systems'              => array(
			'Control Systems',
			'Control Systems Service',
			'From stand-alone controllers to fully integrated building management systems.',
			array( 'Stand-alone optimising compensation units', 'Fully integrated Trend BMS systems', 'Remote connections' ),
		),
		'hot-and-cold-water-services'  => array(
			'Hot and Cold Water Services',
			'Hot and Cold Water Services',
			'Safe, reliable hot and cold water systems for commercial, healthcare and residential buildings.',
			array( 'LPHW storage calorifiers', 'Booster sets', 'Clinical tap replacement', 'Thermostatic mixing valves', 'General plumbing and alterations' ),
		),
		'heating-services'             => array(
			'Heating Services',
			'Heating Services',
			'Design, installation and maintenance of heating systems of every size.',
			array( 'Radiators with thermostatic valves', 'Underfloor heating', 'Air handling units', 'Unit heaters', 'Over door heaters' ),
		),
		'air-conditioning'             => array(
			'Air Conditioning',
			'Air Conditioning Services',
			'Cooling systems designed, installed and maintained to keep buildings comfortable all year.',
			array( 'Maintenance and service', 'Small split units', 'Chilled water systems', 'Multiple fan coil units', 'Installation and design' ),
		),
		'canopy-cleaning-services'     => array(
			'Canopy Cleaning Services',
			'Canopy Cleaning',
			'Thorough kitchen extract cleaning, with photographic records and an air flow report.',
			array( 'Canopy and fan cleaning', 'Ductwork cleaning', 'Non-toxic chemicals', 'Filter cleaning and replacement', 'Before and after photos', 'Air flow report' ),
		),
	);
}

/**
 * Create a page if one with the slug doesn't exist.
 *
 * @param string $slug     Slug.
 * @param string $title    Title.
 * @param string $content  Content.
 * @param string $template Page template file.
 * @return int Page ID.
 */
function bi_ensure_page( $slug, $title, $content = '', $template = '' ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return (int) $existing->ID;
	}
	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $content,
		)
	);
	if ( $id && ! is_wp_error( $id ) && $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Import everything.
 */
function bi_install_starter_content() {
	if ( get_option( 'bi_content_installed' ) ) {
		return;
	}

	bi_register_service_post_type();

	// Pages.
	$home_id = bi_ensure_page( 'home', 'Home' );

	$about = bi_block_h( 'The right relationship is everything' )
		. bi_block_p( 'The right relationship is everything and everything matters. Bradley Industrial Services have acquired over 25 years of experience providing a professionally friendly, reliable, proactive service to our clients.' )
		. bi_block_p( 'We aim to deliver the highest standards and have maintained long standing service and maintenance contracts with several Local Authorities, Academies, NHS, Social Housing, Care Home and Residential Nursing Home providers within the Midlands and surrounding areas.' )
		. bi_block_p( 'We offer our clients flexibility and choice through Service Level Agreements tailored to their needs. Our skilled engineers cover a wide range of systems and installations 24 hours a day, 7 days a week, 365 days a year.' )
		. bi_block_p( 'As a family run business we pair dependable service with a competitive pricing structure.' )
		. bi_block_p( '<strong>Call us today to see how we can help you: <a href="tel:+441384271911">01384 271911</a></strong>' );
	bi_ensure_page( 'about', 'About Us', $about );

	$contact = bi_block_p( 'Whether you need a one-off repair, a planned maintenance contract or a new installation, tell us what you need and one of the team will get back to you.' );
	bi_ensure_page( 'contact', 'Contact Us', $contact, 'page-contact.php' );

	$news_id = bi_ensure_page( 'news', 'News & Updates' );

	// Only take over the reading settings if the site isn't already using a static front page.
	if ( 'page' !== get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
		update_option( 'page_for_posts', $news_id );
	}

	// Services.
	$order = 0;
	foreach ( bi_starter_services() as $slug => $service ) {
		list( $title, $heading, $intro, $items ) = $service;
		$order++;
		$existing = get_page_by_path( $slug, OBJECT, 'service' );
		if ( $existing ) {
			continue;
		}
		wp_insert_post(
			array(
				'post_type'    => 'service',
				'post_status'  => 'publish',
				'post_name'    => $slug,
				'post_title'   => $title,
				'post_excerpt' => $intro,
				'menu_order'   => $order,
				'post_content' => bi_block_h( $heading ) . bi_block_p( $intro ) . bi_block_list( $items ),
			)
		);
	}

	// Primary menu.
	if ( ! has_nav_menu( 'primary' ) ) {
		$menu_id = wp_create_nav_menu( 'Primary' );
		if ( ! is_wp_error( $menu_id ) ) {
			$about_page   = get_page_by_path( 'about' );
			$contact_page = get_page_by_path( 'contact' );
			$items        = array(
				array( 'Home', 'custom', home_url( '/' ), 0, '' ),
				array( 'About Us', 'post_type', '', $about_page ? $about_page->ID : 0, '' ),
				array( 'Our Services', 'custom', get_post_type_archive_link( 'service' ), 0, '' ),
				array( 'News & Updates', 'post_type', '', $news_id, '' ),
				array( 'Contact Us', 'post_type', '', $contact_page ? $contact_page->ID : 0, 'menu-button' ),
			);
			foreach ( $items as $i => $item ) {
				list( $label, $type, $url, $object_id, $class ) = $item;
				$args = array(
					'menu-item-title'    => $label,
					'menu-item-status'   => 'publish',
					'menu-item-position' => $i + 1,
					'menu-item-classes'  => $class,
				);
				if ( 'custom' === $type ) {
					$args['menu-item-type'] = 'custom';
					$args['menu-item-url']  = $url;
				} else {
					$args['menu-item-type']      = 'post_type';
					$args['menu-item-object']    = 'page';
					$args['menu-item-object-id'] = $object_id;
				}
				wp_update_nav_menu_item( $menu_id, 0, $args );
			}
			$locations            = get_theme_mod( 'nav_menu_locations', array() );
			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	update_option( 'bi_content_installed', BI_VERSION );
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'bi_install_starter_content', 10 );

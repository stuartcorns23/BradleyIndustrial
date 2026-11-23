<?php
/**
 * Customizer settings: contact details and home page copy.
 *
 * Everything on the home page can be changed under Appearance > Customize > Bradley Industrial.
 *
 * @package Bradley_Industrial
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default values for every theme setting.
 *
 * @return array
 */
function bi_mod_defaults() {
	return array(
		'bi_phone'             => '01384 271911',
		'bi_email'             => 'office@bradleyindustrialservices.co.uk',
		'bi_address'           => '',
		'bi_form_recipient'    => '',

		'bi_hero_title'        => 'Commercial, industrial and domestic heating specialists',
		'bi_hero_text'         => "The right relationship is everything and everything matters.\n\nBradley Industrial Services have acquired over 25 years of experience providing a professionally friendly reliable proactive service to our clients",
		'bi_hero_button_label' => 'Find out more',
		'bi_hero_button_url'   => '/about/',
		'bi_hero_image'        => '',

		'bi_about_title'       => 'About Bradley Industrial Services',
		'bi_about_text'        => "The right relationship is everything and everything matters. Bradley Industrial Services have acquired over 25 years of experience providing a professionally friendly reliable proactive service to our clients.\n\nWe aim to deliver the highest standards and have maintained long standing service and maintenance contracts with several Local Authorities, Academies, NHS, Social Housing, Care Home and Residential nursing Home providers within the Midlands and surrounding areas.",
		'bi_about_button_label' => 'Read More',
		'bi_about_image'       => '',

		'bi_testimonial_title'  => 'What our clients say',
		'bi_testimonial_quote'  => 'We recently had our boilers serviced by Matt from Bradley Industrial Services, and the experience was excellent from start to finish. They arrived on time, worked efficiently, and explained everything clearly. The job was completed to a high standard, and the heating system is running better than ever. I’d happily recommend them to anyone needing a reliable gas and heating engineer.',
		'bi_testimonial_author' => 'Dean - Midland Heart',
		'bi_testimonial_image'  => '',
		'bi_testimonial_logo'   => '',

		'bi_news_title'        => 'Latest news and updates',
		'bi_show_accreditations' => true,
		'bi_copyright'         => 'Bradley Industrial Services Ltd. Copyright {year} - All Rights Reserved',
	);
}

/**
 * Get a theme setting with its default.
 *
 * @param string $key Setting key.
 * @return mixed
 */
function bi_mod( $key ) {
	$defaults = bi_mod_defaults();
	return get_theme_mod( $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
}

/**
 * Image setting URL, falling back to the bundled image.
 *
 * @param string $key      Setting key.
 * @param string $fallback File name in assets/images.
 * @return string
 */
function bi_mod_image( $key, $fallback ) {
	$url = bi_mod( $key );
	return $url ? $url : BI_URI . '/assets/images/' . $fallback;
}

/**
 * Register Customizer panel, sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function bi_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'bi_panel', array( 'title' => __( 'Bradley Industrial', 'bradley-industrial' ), 'priority' => 30 ) );

	$sections = array(
		'bi_contact'     => __( 'Contact details', 'bradley-industrial' ),
		'bi_hero'        => __( 'Home: hero', 'bradley-industrial' ),
		'bi_about'       => __( 'Home: about', 'bradley-industrial' ),
		'bi_testimonial' => __( 'Home: testimonial', 'bradley-industrial' ),
		'bi_footer'      => __( 'News & footer', 'bradley-industrial' ),
	);
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( $id, array( 'title' => $title, 'panel' => 'bi_panel' ) );
	}

	$fields = array(
		// key => array( section, type, label ).
		'bi_phone'              => array( 'bi_contact', 'text', __( 'Phone number', 'bradley-industrial' ) ),
		'bi_email'              => array( 'bi_contact', 'email', __( 'Email address', 'bradley-industrial' ) ),
		'bi_address'            => array( 'bi_contact', 'textarea', __( 'Postal address (optional)', 'bradley-industrial' ) ),
		'bi_form_recipient'     => array( 'bi_contact', 'email', __( 'Send contact form enquiries to (defaults to the email above)', 'bradley-industrial' ) ),

		'bi_hero_title'         => array( 'bi_hero', 'text', __( 'Heading', 'bradley-industrial' ) ),
		'bi_hero_text'          => array( 'bi_hero', 'textarea', __( 'Text', 'bradley-industrial' ) ),
		'bi_hero_button_label'  => array( 'bi_hero', 'text', __( 'Button label', 'bradley-industrial' ) ),
		'bi_hero_button_url'    => array( 'bi_hero', 'url', __( 'Button link', 'bradley-industrial' ) ),
		'bi_hero_image'         => array( 'bi_hero', 'image', __( 'Image', 'bradley-industrial' ) ),

		'bi_about_title'        => array( 'bi_about', 'text', __( 'Heading', 'bradley-industrial' ) ),
		'bi_about_text'         => array( 'bi_about', 'textarea', __( 'Text', 'bradley-industrial' ) ),
		'bi_about_button_label' => array( 'bi_about', 'text', __( 'Button label', 'bradley-industrial' ) ),
		'bi_about_image'        => array( 'bi_about', 'image', __( 'Image', 'bradley-industrial' ) ),

		'bi_testimonial_title'  => array( 'bi_testimonial', 'text', __( 'Heading', 'bradley-industrial' ) ),
		'bi_testimonial_quote'  => array( 'bi_testimonial', 'textarea', __( 'Quote', 'bradley-industrial' ) ),
		'bi_testimonial_author' => array( 'bi_testimonial', 'text', __( 'Name & organisation', 'bradley-industrial' ) ),
		'bi_testimonial_image'  => array( 'bi_testimonial', 'image', __( 'Photo (transparent PNG works best)', 'bradley-industrial' ) ),
		'bi_testimonial_logo'   => array( 'bi_testimonial', 'image', __( 'Client logo', 'bradley-industrial' ) ),

		'bi_news_title'         => array( 'bi_footer', 'text', __( 'Home page news heading', 'bradley-industrial' ) ),
		'bi_show_accreditations' => array( 'bi_footer', 'checkbox', __( 'Show accreditation logos above the footer', 'bradley-industrial' ) ),
		'bi_copyright'          => array( 'bi_footer', 'text', __( 'Copyright line ({year} is replaced with the current year)', 'bradley-industrial' ) ),
	);

	$defaults = bi_mod_defaults();

	foreach ( $fields as $key => $field ) {
		list( $section, $type, $label ) = $field;

		switch ( $type ) {
			case 'email':
				$sanitize = 'sanitize_email';
				break;
			case 'url':
			case 'image':
				$sanitize = 'esc_url_raw';
				break;
			case 'textarea':
				$sanitize = 'sanitize_textarea_field';
				break;
			case 'checkbox':
				$sanitize = 'wp_validate_boolean';
				break;
			default:
				$sanitize = 'sanitize_text_field';
		}

		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $defaults[ $key ],
				'sanitize_callback' => $sanitize,
			)
		);

		if ( 'image' === $type ) {
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					$key,
					array( 'label' => $label, 'section' => $section )
				)
			);
		} else {
			$wp_customize->add_control( $key, array( 'label' => $label, 'section' => $section, 'type' => $type ) );
		}
	}
}
add_action( 'customize_register', 'bi_customize_register' );

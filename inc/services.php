<?php
/**
 * "Service" post type, with a tile colour and icon per service.
 *
 * Services live at /services/ (archive) and /services/{slug}/ (single),
 * matching the URLs used on the previous site.
 *
 * @package Bradley_Industrial
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the post type.
 */
function bi_register_service_post_type() {
	register_post_type(
		'service',
		array(
			'labels'       => array(
				'name'               => __( 'Services', 'bradley-industrial' ),
				'singular_name'      => __( 'Service', 'bradley-industrial' ),
				'add_new_item'       => __( 'Add new service', 'bradley-industrial' ),
				'edit_item'          => __( 'Edit service', 'bradley-industrial' ),
				'new_item'           => __( 'New service', 'bradley-industrial' ),
				'view_item'          => __( 'View service', 'bradley-industrial' ),
				'all_items'          => __( 'All services', 'bradley-industrial' ),
				'search_items'       => __( 'Search services', 'bradley-industrial' ),
				'not_found'          => __( 'No services found.', 'bradley-industrial' ),
				'menu_name'          => __( 'Services', 'bradley-industrial' ),
			),
			'public'       => true,
			'has_archive'  => 'services',
			'rewrite'      => array( 'slug' => 'services', 'with_front' => false ),
			'menu_icon'    => 'dashicons-admin-tools',
			'menu_position' => 21,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'bi_register_service_post_type' );

/**
 * Flush rewrite rules when the theme is switched on, so /services/ works straight away.
 */
function bi_flush_rewrites() {
	bi_register_service_post_type();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'bi_flush_rewrites', 20 );

/**
 * Default tile colours and icons from the design, keyed by service slug.
 *
 * @return array
 */
function bi_service_defaults() {
	return array(
		'ventilation-services'         => array( '#f47fb0', 'tools' ),
		'renewable-services'           => array( '#2bb24c', 'recycle' ),
		'gas-catering'                 => array( '#f7801f', 'oven' ),
		'gas-service'                  => array( '#a347ae', 'leaf-flame' ),
		'electrical-catering-services' => array( '#b5ab0c', 'oven-bolt' ),
		'control-systems'              => array( '#7fd11b', 'monitor' ),
		'hot-and-cold-water-services'  => array( '#1c6fd6', 'tap' ),
		'heating-services'             => array( '#e8413a', 'radiator' ),
		'air-conditioning'             => array( '#14a7b8', 'snowflake' ),
		'canopy-cleaning-services'     => array( '#4a4a4a', 'canopy' ),
	);
}

/**
 * Tile colour for a service.
 *
 * @param int|WP_Post|null $post Service.
 * @return string Hex colour.
 */
function bi_service_colour( $post = null ) {
	$post   = get_post( $post );
	$colour = $post ? get_post_meta( $post->ID, '_bi_colour', true ) : '';
	if ( ! $colour && $post ) {
		$defaults = bi_service_defaults();
		$colour   = isset( $defaults[ $post->post_name ] ) ? $defaults[ $post->post_name ][0] : '';
	}
	return sanitize_hex_color( $colour ) ? $colour : '#e8413a';
}

/**
 * Icon slug for a service.
 *
 * @param int|WP_Post|null $post Service.
 * @return string
 */
function bi_service_icon( $post = null ) {
	$post = get_post( $post );
	$icon = $post ? get_post_meta( $post->ID, '_bi_icon', true ) : '';
	if ( ! $icon && $post ) {
		$defaults = bi_service_defaults();
		$icon     = isset( $defaults[ $post->post_name ] ) ? $defaults[ $post->post_name ][1] : '';
	}
	return $icon ? $icon : 'tools';
}

/**
 * All published services in display order.
 *
 * @return WP_Post[]
 */
function bi_get_services() {
	return get_posts(
		array(
			'post_type'      => 'service',
			'posts_per_page' => -1,
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'no_found_rows'  => true,
		)
	);
}

/**
 * Meta box: tile colour and icon.
 */
function bi_service_meta_box() {
	add_meta_box( 'bi-service-tile', __( 'Tile appearance', 'bradley-industrial' ), 'bi_render_service_meta_box', 'service', 'side' );
}
add_action( 'add_meta_boxes', 'bi_service_meta_box' );

/**
 * Render the meta box.
 *
 * @param WP_Post $post Current service.
 */
function bi_render_service_meta_box( $post ) {
	wp_nonce_field( 'bi_service_meta', 'bi_service_meta_nonce' );
	$colour = bi_service_colour( $post );
	$icon   = bi_service_icon( $post );
	?>
	<p>
		<label for="bi_colour"><strong><?php esc_html_e( 'Tile colour', 'bradley-industrial' ); ?></strong></label><br />
		<input type="color" id="bi_colour" name="bi_colour" value="<?php echo esc_attr( $colour ); ?>" />
	</p>
	<p>
		<label for="bi_icon"><strong><?php esc_html_e( 'Icon', 'bradley-industrial' ); ?></strong></label><br />
		<select id="bi_icon" name="bi_icon" style="width:100%">
			<?php foreach ( bi_icon_choices() as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $icon, $value ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p class="description"><?php esc_html_e( 'Used on the home page tiles and the service page banner. Use "Order" under Page Attributes to set the tile order.', 'bradley-industrial' ); ?></p>
	<?php
}

/**
 * Save the meta box.
 *
 * @param int $post_id Service ID.
 */
function bi_save_service_meta( $post_id ) {
	if ( ! isset( $_POST['bi_service_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bi_service_meta_nonce'] ) ), 'bi_service_meta' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['bi_colour'] ) ) {
		$colour = sanitize_hex_color( wp_unslash( $_POST['bi_colour'] ) );
		if ( $colour ) {
			update_post_meta( $post_id, '_bi_colour', $colour );
		}
	}
	if ( isset( $_POST['bi_icon'] ) ) {
		$icon = sanitize_key( wp_unslash( $_POST['bi_icon'] ) );
		if ( array_key_exists( $icon, bi_icon_choices() ) ) {
			update_post_meta( $post_id, '_bi_icon', $icon );
		}
	}
}
add_action( 'save_post_service', 'bi_save_service_meta' );

<?php
/**
 * Sidebar list of services.
 *
 * @package Bradley_Industrial
 */

$bi_services = bi_get_services();
if ( ! $bi_services ) {
	return;
}
$bi_current = is_singular( 'service' ) ? get_queried_object_id() : 0;
?>
<div class="sidebar-box">
	<h2><?php esc_html_e( 'Our services', 'bradley-industrial' ); ?></h2>
	<ul>
		<?php foreach ( $bi_services as $bi_service ) : ?>
			<li class="<?php echo $bi_current === $bi_service->ID ? 'is-current' : ''; ?>">
				<a href="<?php echo esc_url( get_permalink( $bi_service ) ); ?>"<?php echo $bi_current === $bi_service->ID ? ' aria-current="page"' : ''; ?>>
					<span class="swatch" style="--tile:<?php echo esc_attr( bi_service_colour( $bi_service ) ); ?>"></span>
					<?php echo esc_html( get_the_title( $bi_service ) ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

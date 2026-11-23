<?php
/**
 * Inline SVG icons used for the service tiles.
 *
 * @package Bradley_Industrial
 */

defined( 'ABSPATH' ) || exit;

/**
 * Available icons, keyed by slug, with a human label for the editor.
 *
 * @return array
 */
function bi_icon_choices() {
	return array(
		'tools'      => __( 'Tools (spanner & screwdriver)', 'bradley-industrial' ),
		'recycle'    => __( 'Recycle', 'bradley-industrial' ),
		'oven'       => __( 'Oven', 'bradley-industrial' ),
		'leaf-flame' => __( 'Flame', 'bradley-industrial' ),
		'oven-bolt'  => __( 'Oven with bolt', 'bradley-industrial' ),
		'monitor'    => __( 'Monitor', 'bradley-industrial' ),
		'tap'        => __( 'Tap', 'bradley-industrial' ),
		'radiator'   => __( 'Radiator', 'bradley-industrial' ),
		'snowflake'  => __( 'Snowflake', 'bradley-industrial' ),
		'canopy'     => __( 'Extractor canopy', 'bradley-industrial' ),
		'fan'        => __( 'Fan', 'bradley-industrial' ),
	);
}

/**
 * Return an inline SVG icon.
 *
 * @param string $name Icon slug.
 * @return string
 */
function bi_icon( $name ) {
	$paths = array(
		'tools'      => '<path d="M14.7 6.3a4 4 0 0 0 5 5L21 12.6 12.6 21l-1.3-1.3a4 4 0 0 0-5-5L5 13.4"/><path d="m4 4 7.5 7.5"/><path d="m3 7 4-4"/><path d="m14 14 6 6"/><path d="M4 20 9 15"/>',
		'recycle'    => '<path d="M7 19H4.8a1.8 1.8 0 0 1-1.6-2.7L7.2 9"/><path d="M11 19h8.2a1.8 1.8 0 0 0 1.6-2.7l-1.2-2.1"/><path d="m14 16-3 3 3 3"/><path d="M8.3 13.6 7.2 9 2.7 10.2"/><path d="m9.3 5.5 1.1-1.9a1.8 1.8 0 0 1 3.1 0l4 7"/><path d="m12.9 9.6 4.6 1.2 1.2-4.6"/>',
		'oven'       => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 8h18"/><circle cx="7" cy="5.5" r=".6"/><circle cx="10" cy="5.5" r=".6"/><circle cx="13" cy="5.5" r=".6"/><rect x="6" y="11" width="12" height="7" rx="1"/>',
		'leaf-flame' => '<path d="M12 22c4 0 7-2.9 7-7 0-3.6-2.4-6.1-4-8-.4 1.8-1.2 3-2.5 3.6C12.7 7.5 11 4.5 8.5 2 8.6 5.6 5 8.6 5 14c0 4.6 3 8 7 8Z"/><path d="M12 22c-1.7 0-3-1.4-3-3.2 0-2.1 1.7-3.2 2.4-5 1.1 1.2 3.6 2.8 3.6 5 0 1.8-1.3 3.2-3 3.2Z"/>',
		'oven-bolt'  => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 8h18"/><circle cx="7" cy="5.5" r=".6"/><circle cx="10" cy="5.5" r=".6"/><path d="m13 10-3 4h4l-3 4"/>',
		'monitor'    => '<rect x="2" y="3" width="20" height="14" rx="1.5"/><path d="M8 21h8"/><path d="M12 17v4"/>',
		'tap'        => '<path d="M4 9h9a4 4 0 0 1 4 4v1"/><path d="M4 6v6"/><path d="M8 9V5"/><path d="M6 5h4"/><path d="M17 17.5c0 1-.7 1.7-1.5 1.7S14 18.5 14 17.5c0-.9 1.5-2.5 1.5-2.5s1.5 1.6 1.5 2.5Z"/>',
		'radiator'   => '<path d="M4 6v12"/><path d="M8 6v12"/><path d="M12 6v12"/><path d="M16 6v12"/><path d="M20 6v12"/><path d="M2 9h20"/><path d="M2 15h20"/><path d="M6 18v2"/><path d="M18 18v2"/>',
		'snowflake'  => '<path d="M12 2v20"/><path d="M4.9 7 19.1 17"/><path d="M4.9 17 19.1 7"/><path d="m9 4 3 2 3-2"/><path d="m9 20 3-2 3 2"/>',
		'canopy'     => '<path d="M9 2h6v5"/><path d="M9 2v5"/><path d="M9 7 3 14h18l-6-7Z"/><path d="M3 14v2h18v-2"/><path d="M7 19v1"/><path d="M12 19v2"/><path d="M17 19v1"/>',
		'fan'        => '<circle cx="12" cy="12" r="1.6"/><path d="M12 10.4C12 6 13.5 3 15.5 3S19 5 17 8s-5 2.4-5 2.4Z"/><path d="M13.6 12c4.4 0 7.4 1.5 7.4 3.5S19 19 16 17s-2.4-5-2.4-5Z"/><path d="M12 13.6c0 4.4-1.5 7.4-3.5 7.4S5 19 7 16s5-2.4 5-2.4Z"/><path d="M10.4 12C6 12 3 10.5 3 8.5S5 5 8 7s2.4 5 2.4 5Z"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		$name = 'tools';
	}

	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
}

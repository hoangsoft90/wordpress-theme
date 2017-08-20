<?php
/**
 * Menus configuration.
 *
 * @package __RT
 */

add_action( 'after_setup_theme', '__rt_register_menus', 5 );
function __rt_register_menus() {

	register_nav_menus( array(
		'primary'            => esc_html__( 'Menu chính', 'rt' ),
		'secondary'          => esc_html__( 'Menu Mobile', 'rt' ),
		'vertical-mega-menu' => esc_html__( 'Vertical Mega Menu', 'rt' ),
	) );
}

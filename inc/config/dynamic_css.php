<?php
/**
 * Dynamic css
 */
global $rt_option;

if (!$rt_option) {
	return;
}

$css = '';



if ( $rt_option['layout_width'] == 'custom' ) {
	$css .= '
		@media (min-width: 1200px) {
			.site.w'.$rt_option['layout_custom'].' .container {
			    width: '.$rt_option['layout_custom'].'px;
			}
		}';
}
// if ($rt_option['site_full'] == true ) {
// 		$css .= '
// 			.site.boxed.w'.$rt_option['layout_custom'].' {
// 			    max-width: '.$rt_option['layout_custom'].'px;
// 			}
// 		';
// 	}

if ( $rt_option['banner_full'] == 'full' ) {
	$css .= '
		@media (min-width: 1200px) {
			.site-branding .container {
			    width: 100% !important;
			}
			.site-branding .container img {
				width:100%;
			}
		}';
}
// if layout full width or header full width and has both logo, banner then use banner as header background
// if ( ($rt_option['box'] == true ) ) {
// 	$css .= '
// 		.site-branding .container {
// 			width: 100% !important;
// 		}
// 	';
// }

/**
 * Main background color
 */
if ( $rt_option['main_color'] != '' ) {
	$css .= '
		.main-navigation, .widget-title, .heading, .site-footer, .top-footer, .copyright, .close-menu, .woocommerce li.product .rt_add_to_cart a.view_product {
			background:' . $rt_option['main_color'] . ';
		}
	';
	$css .= '
		.header-search .search-form .search-submit {
			color:' . $rt_option['main_bg_color'] . ';
		}
	';
}
// Background site
if ( !empty($rt_option['background'] ) ) {

	$body = $rt_option['background'];

	$css .= '
		body {';
		$css .= ( !empty($body['color']) ) ? 'background-color: ' . $body['color'] . ';' : '';
		$css .= ( !empty($body['image']) ) ? 'background-image: url(' . $body['image'] . ');' : '';
		$css .= ( !empty($body['repeat']) ) ? 'background-repeat: ' . $body['repeat'] . ';' : '';
		$css .= ( !empty($body['position']) ) ? 'background-position: ' . $body['position'] . ';' : '';
		$css .= ( !empty($body['size']) ) ? 'background-size: ' . $body['size'] . ';' : '';
	
	$css .= '
		}
	';
}

/**
 * Menu Background gradient or color - image
 */

$menu_selector = ( !$rt_option['header_full'] || $rt_option['box'] ) ? '.main-navigation , .fixed-nav-menu .main-navigation' : '.main-navigation';

if ( $rt_option['bg_menu_type'] === 'gradient' && !empty( $rt_option['gr_mennu'] ) ) {
	$css .= '
		'.$menu_selector.' {
			' . $rt_option['gr_mennu'] . '
		}
	';
}
elseif ( $rt_option['bg_menu_type'] === 'color_bg' && !empty( $rt_option['bg_menu'] ) ) {

	$bg_menu = $rt_option['bg_menu'];

	$css .= '
		'.$menu_selector.' {';

	$css .= ( !empty($bg_menu['color']) ) ? 'background-color: ' . $bg_menu['color'] . ';' : '';
	$css .= ( !empty($bg_menu['image']) ) ? 'background-image: url(' . $bg_menu['image'] . ');' : '';
	$css .= ( !empty($bg_menu['repeat']) ) ? 'background-repeat: ' . $bg_menu['repeat'] . ';' : '';
	$css .= ( !empty($bg_menu['position']) ) ? 'background-position: ' . $bg_menu['position'] . ';' : '';
	$css .= ( !empty($bg_menu['size']) ) ? 'background-size: ' . $bg_menu['size'] . ';' : '';
	
	$css .= '
		}
	';
}

/**
 * Widget Title Background gradient or color - image
 */
if ( $rt_option['bg_widget_type'] === 'gradient' && !empty( $rt_option['gr_widget_title'] ) ) {
	$css .= '
		.widget-title {
			' . $rt_option['gr_widget_title'] . '
		}
	';
}
elseif ( $rt_option['bg_widget_type'] === 'color_bg' && !empty( $rt_option['bg_widget_title'] ) ) {

	$bg_widget_title = $rt_option['bg_widget_title'];

	$css .= '
		.widget-title {';

	$css .= ( !empty($bg_widget_title['color']) ) ? 'background-color: ' . $bg_widget_title['color'] . ';' : '';
	$css .= ( !empty($bg_widget_title['image']) ) ? 'background-image: url(' . $bg_widget_title['image'] . ');' : '';
	$css .= ( !empty($bg_widget_title['repeat']) ) ? 'background-repeat: ' . $bg_widget_title['repeat'] . ';' : '';
	$css .= ( !empty($bg_widget_title['position']) ) ? 'background-position: ' . $bg_widget_title['position'] . ';' : '';
	$css .= ( !empty($bg_widget_title['size']) ) ? 'background-size: ' . $bg_widget_title['size'] . ';' : '';
	
	$css .= '
		}
	';
}

/**
 * Category Background gradient or color - image
 */
if ( $rt_option['bg_category_type'] === 'gradient' && !empty( $rt_option['gr_category_title'] ) ) {
	$css .= '
		.site-main .heading {
			' . $rt_option['gr_category_title'] . '
		}
	';
}
elseif ( $rt_option['bg_category_type'] === 'color_bg' && !empty( $rt_option['bg_category_title'] ) ) {

	$bg_category_title = $rt_option['bg_category_title'];

	$css .= '
		.site-main .heading {';

	$css .= ( !empty($bg_category_title['color']) ) ? 'background-color: ' . $bg_category_title['color'] . ';' : '';
	$css .= ( !empty($bg_category_title['image']) ) ? 'background-image: url(' . $bg_category_title['image'] . ');' : '';
	$css .= ( !empty($bg_category_title['repeat']) ) ? 'background-repeat: ' . $bg_category_title['repeat'] . ';' : '';
	$css .= ( !empty($bg_category_title['position']) ) ? 'background-position: ' . $bg_category_title['position'] . ';' : '';
	$css .= ( !empty($bg_category_title['size']) ) ? 'background-size: ' . $bg_category_title['size'] . ';' : '';
	
	$css .= '
		}
	';
}
/**
 * Footer Background gradient or color - image
 */
if ( $rt_option['bg_footer_type'] === 'gradient' && !empty( $rt_option['gr_footer'] ) ) {
	$css .= '
		.site-footer {
			' . $rt_option['gr_footer'] . '
		}
	';
}
elseif ( $rt_option['bg_footer_type'] === 'color_bg' && !empty( $rt_option['bg_footer'] ) ) {

	$bg_footer = $rt_option['bg_footer'];

	$css .= '
		.site-footer {';

	$css .= ( !empty($bg_footer['color']) ) ? 'background-color: ' . $bg_footer['color'] . ';' : '';
	$css .= ( !empty($bg_footer['image']) ) ? 'background-image: url(' . $bg_footer['image'] . ');' : '';
	$css .= ( !empty($bg_footer['repeat']) ) ? 'background-repeat: ' . $bg_footer['repeat'] . ';' : '';
	$css .= ( !empty($bg_footer['position']) ) ? 'background-position: ' . $bg_footer['position'] . ';' : '';
	$css .= ( !empty($bg_footer['size']) ) ? 'background-size: ' . $bg_footer['size'] . ';' : '';
	
	$css .= '
		}
	';
}
/**
 * Sub menu-top Background gradient or color - image
 */
if  ( !empty( $rt_option['bg_submenu'] ) ) {

	$bg_submenu = $rt_option['bg_submenu'];

	$css .= '
		#primary-menu li ul.sub-menu {';

	$css .= ( !empty($bg_submenu['color']) ) ? 'background-color: ' . $bg_submenu['color'] . ';' : '';
	$css .= ( !empty($bg_submenu['image']) ) ? 'background-image: url(' . $bg_submenu['image'] . ');' : '';
	$css .= ( !empty($bg_submenu['repeat']) ) ? 'background-repeat: ' . $bg_submenu['repeat'] . ';' : '';
	$css .= ( !empty($bg_submenu['position']) ) ? 'background-position: ' . $bg_submenu['position'] . ';' : '';
	$css .= ( !empty($bg_submenu['size']) ) ? 'background-size: ' . $bg_submenu['size'] . ';' : '';
	
	$css .= '
		}
	';
}
if  ( !empty( $rt_option['bg_hover_menu'] ) ) {

	$bg_hover_menu = $rt_option['bg_hover_menu'];

	$css .= '
		.primary-menu li a:hover, .primary-menu li.current-menu-item a {';

	$css .= ( !empty($bg_hover_menu['color']) ) ? 'background-color: ' . $bg_hover_menu['color'] . ';' : '';
	$css .= ( !empty($bg_hover_menu['image']) ) ? 'background-image: url(' . $bg_hover_menu['image'] . ');' : '';
	$css .= ( !empty($bg_hover_menu['repeat']) ) ? 'background-repeat: ' . $bg_hover_menu['repeat'] . ';' : '';
	$css .= ( !empty($bg_hover_menu['position']) ) ? 'background-position: ' . $bg_hover_menu['position'] . ';' : '';
	$css .= ( !empty($bg_hover_menu['size']) ) ? 'background-size: ' . $bg_hover_menu['size'] . ';' : '';
	
	$css .= '
		}
	';
}


/**
 * Footer Background gradient or color - image
 */

$footer_selector = ( $rt_option['footer_full'] ) ? '.site-footer' : '.site-footer > .container';

if ( $rt_option['bg_footer_type'] === 'gradient' && !empty( $rt_option['gr_footer'] ) ) {
	$css .= '
		'.$footer_selector.' {
			' . $rt_option['gr_footer'] . '
		}
	';
}
elseif ( $rt_option['bg_footer_type'] === 'color_bg' && !empty( $rt_option['bg_footer'] ) ) {

	$bg_footer = $rt_option['bg_footer'];

	$css .= '
		'.$footer_selector.' {';

	$css .= ( !empty($bg_footer['color']) ) ? 'background-color: ' . $bg_footer['color'] . ';' : '';
	$css .= ( !empty($bg_footer['image']) ) ? 'background-image: url(' . $bg_footer['image'] . ');' : '';
	$css .= ( !empty($bg_footer['repeat']) ) ? 'background-repeat: ' . $bg_footer['repeat'] . ';' : '';
	$css .= ( !empty($bg_footer['position']) ) ? 'background-position: ' . $bg_footer['position'] . ';' : '';
	$css .= ( !empty($bg_footer['size']) ) ? 'background-size: ' . $bg_footer['size'] . ';' : '';
	
	$css .= '
		}
	';
}

function __rt_minify_dynamic_css($css) {
    /* remove comments */
    $css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
    /* remove tabs, spaces, newlines, etc. */
    $css = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
    $css = str_replace( ', ', ',', $css);
    return trim( $css );
}

__rt_theme()->dynamic_css = __rt_minify_dynamic_css($css);
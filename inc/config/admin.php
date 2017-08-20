<?php
/**
 * Admin hooks
 */

// removing the dashboard widgets
add_action( 'wp_dashboard_setup', 'disable_default_dashboard_widgets' );

// Edit login url / title
add_filter( 'login_headerurl', 'rt_login_url' );
add_filter( 'login_headertitle', 'rt_login_title' );

// Add login page style
add_action( 'login_enqueue_scripts', 'rt_login_stylesheet' );

// Remove wp admin bar logo.
add_action('wp_before_admin_bar_render', 'remove_wp_admin_bar_logo', 0);



/************* DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	global $wp_meta_boxes;
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);    // Right Now Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);        // Activity Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Comments Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);  // Incoming Links Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);         // Plugins Widget

	// unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);    // Quick Press Widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);     // Recent Drafts Widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);           //
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);         //

	// remove plugin dashboard boxes
	unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);           // Yoast's SEO Plugin Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);        // Gravity Forms Plugin Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);   // bbPress Plugin Widget

}

// changing the logo link from wordpress.org to your site
function rt_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function rt_login_title() { return get_option( 'blogname' ); }

/**
 * Enqueue RT login Stylesheet.
 */
function rt_login_stylesheet() {
	wp_enqueue_style( 'rt-login', get_theme_file_uri( 'assets/css/login.css' ) );
}

/**
 * Remove wp admin bar logo.
 */
function remove_wp_admin_bar_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}

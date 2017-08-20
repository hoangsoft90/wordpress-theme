<?php
/**
 * Theme hooks.
 *
 * @package __RT
 */

global $rt_option;

// EditURI link
remove_action( 'wp_head', 'rsd_link' );

// windows live writer
remove_action( 'wp_head', 'wlwmanifest_link' );

// previous link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

// start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

// links for adjacent posts
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// WP version
remove_action( 'wp_head', 'wp_generator' );


// Additional body classes.
add_filter( 'body_class', 'rt_body_classes' );

add_filter( 'frontpage_template',  'rt_front_page_template' );

// Changed excerpt more string.
add_filter( 'excerpt_more', 'rt_excerpt_more' );

// Change Excerpt lenght.
add_filter( 'excerpt_length', 'rt_excerpt_length', 999 );

// Remove script version.
add_filter( 'script_loader_src', 'rt_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'rt_remove_script_version', 15, 1 );

// RT Image
add_filter( 'wp_calculate_image_sizes', 'rt_content_image_sizes_attr', 10, 2 );
add_filter( 'wp_get_attachment_image_attributes', 'rt_post_thumbnail_sizes_attr', 10, 3 );

// Support shortcodes in rt textarea widgets
add_filter('rt_textarea_widget', 'do_shortcode');

// Fix Seo by yoast
add_filter( 'wpseo_canonical', '__return_false' );

// Detect javascript
add_action( 'wp_head', 'rt_javascript_detection', 0 );

// Ping back header
add_action( 'wp_head', 'rt_pingback_header' );

// Adds script on wp_head.
add_action( 'wp_head', 'rt_header_script' );

// Adds script on wp_footer.
add_action( 'wp_footer', 'rt_footer_script' );

// Remove emoji icons
add_action( 'init', 'disable_wp_emojicons' );

// Flush out the transients used in rt-theme_categorized_blog.
add_action( 'edit_category', 'rt_category_transient_flusher' );
add_action( 'save_post',     'rt_category_transient_flusher' );



/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function rt_body_classes( $classes ) {
	// Add class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'rt-customizer';
	}

	// Add class on front page.
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'rt-front-page';
	}

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add class if sidebar is used.
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() ) {
		$classes[] = 'has-sidebar';
	}

	if ( $rt_option['vertical_mega_menu'] && is_active_sidebar( 'vertical-mega-menu' ) ) {
		$classes[] = 'has-vertical-mega-menu';
	}

	return $classes;
}


/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since RT Theme 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function rt_front_page_template( $template ) {
	return is_home() ? '' : $template;
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since RT Theme 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function rt_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<a class="link-more" href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Đọc thêm &raquo;<span class="screen-reader-text"> "%s"</span>', 'rt' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}

/**
 * Excerpt lenght.
 *
 * @param  int $length Number to change excerpt length.
 * @return int         //
 */
function rt_excerpt_length( $length ) {
	return 20;
}

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since RT Theme 1.0
 */
function rt_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function rt_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}


/**
 * Remove script version.
 *
 * @param  string $src //
 * @return string      //
 */
function rt_remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}

/**
 * Adds script on wp_head.
 *
 * @return string //
 */
function rt_header_script() {
	global $rt_option;
	echo $rt_option['header_script'];
}

/**
 * Adds script on wp_footer.
 *
 * @return string //
 */
function rt_footer_script() {
	global $rt_option;
	echo $rt_option['footer_script'];
}

/**
 * Disable WP emojicons.
 */
function disable_wp_emojicons() {

	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	// filter to remove TinyMCE emojis
	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
	add_filter( 'emoji_svg_url', '__return_false' );
}

/**
 * Disable WP emojicons.
 *
 * @param  array $plugins //
 * @return array          //
 */
function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}
/**
 * Flush out the transients used in rt-theme_categorized_blog.
 */
function rt_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'rt_categories' );
}


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since RT Theme 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function rt_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && (! __Rt_Widget_Area::has_sidebar()) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since RT Theme 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function rt_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}

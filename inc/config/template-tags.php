<?php
/**
 * Theme functions.
 *
 * @package __RT
 */
global $rt_option;

/**
 * Adds custom classes to the array of layout classes.
 *
 * @param array $classes Classes for the layout element.
 */
function rt_layout_class( $classes = array() ) {
	$classes = (array) $classes;

	if ( __Rt_Widget_Area::has_sidebar() ) {
		$classes[] = sprintf( 'sidebar-%s', __Rt_Widget_Area::get_sidebar_area() );
	} else {
		$classes[] = 'no-sidebar';
	}

	$classes = apply_filters( 'rt_layout_class', $classes );

	echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
}

/**
 * Rt layout classes.
 *
 * @param array $classes CSS selector for own site.
 */
function rt_layout_classes( $classes = array() ) {
	$classes = (array) $classes;

	global $rt_option;

	if ( $rt_option['site_full'] == false ) {
		$classes[] = 'boxed';
	} else {
		$classes[] = 'full';
	}

	if ( '1000' == $rt_option['layout_width'] ) {
		$classes[] = 'w1000';
	} elseif ( '1170' == $rt_option['layout_width'] ) {
		$classes[] = 'w1170';
	} elseif ( '1200' == $rt_option['layout_width'] ) {
		$classes[] = 'w1200';
	} else {
		$classes[] = 'w'.$rt_option['layout_custom'];
	}

	$classes = apply_filters( 'rt_layout_classes', $classes );

	echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
}

/**
 * Primary menu fallback function.
 */
function primary_menu_fallback() {
	$classes = $rt_option['enable_header_search'] ? 'primary-menu-container visible-lg col-md-9' : 'primary-menu-container visible-lg col-md-12';

	$fallback_menu = '<div class="' . $classes . '"><ul id="primary-menu" class="menu clearfix"><li><a href="%1$s" rel="home">%2$s</a></li></ul></div>';
	printf( $fallback_menu, esc_url( home_url( '/' ) ), esc_html__( 'Trang chủ', 'rt' ) ); // WPCS: XSS OK.
}

/**
 * Mobile menu fallback function.
 */
function mobile_menu_fallback() {
	$fallback_menu = '<ul id="mobile-menu" class="mobile-menu"><li><a href="%1$s" rel="home">%2$s</a></li></ul>';
	printf( $fallback_menu, esc_url( home_url( '/' ) ), esc_html__( 'Trang chủ', 'rt' ) ); // WPCS: XSS OK.
}


if ( ! function_exists( 'rt_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function rt_posted_on() {

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( 'by %s', 'rt' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
	);

	// Finally, let's write all of this to the page.
	echo '<span class="posted-on">' . rt_time_link() . '</span><span class="byline"> ' . $byline . '</span>';
}
endif;


if ( ! function_exists( 'rt_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function rt_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return sprintf(
		/* translators: %s: post date */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'rt' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
}
endif;


if ( ! function_exists( 'rt_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function rt_entry_footer() {

	/* translators: used between list items, there is a space after the comma */
	$separate_meta = __( ', ', 'rt' );

	// Get Categories for posts.
	$categories_list = get_the_category_list( $separate_meta );

	// Get Tags for posts.
	$tags_list = get_the_tag_list( '', $separate_meta );

	// We don't want to output .entry-footer if it will be empty, so make sure its not.
	if ( ( ( rt_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<footer class="entry-footer">';

			if ( 'post' === get_post_type() ) {
				if ( ( $categories_list && rt_categorized_blog() ) || $tags_list ) {
					echo '<span class="cat-tags-links">';

						// Make sure there's more than one category before displaying.
						if ( $categories_list && rt_categorized_blog() ) {
							echo '<span class="cat-links"><span class="screen-reader-text">' . __( 'Danh mục', 'rt' ) . '</span>' . $categories_list . '</span>';
						}

						if ( $tags_list ) {
							echo '<span class="tags-links"><span class="screen-reader-text">' . __( 'Từ khóa', 'rt' ) . '</span>' . $tags_list . '</span>';
						}

					echo '</span>';
				}
			}

			rt_edit_link();

		echo '</footer> <!-- .entry-footer -->';
	}
}
endif;


if ( ! function_exists( 'rt_edit_link' ) ) :
/**
 * Returns an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 */
function rt_edit_link() {

	$link = edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'rt' ),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);

	return $link;
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function rt_categorized_blog() {
	$category_count = get_transient( 'rt_categories' );

	if ( false === $category_count ) {
		// Create an array of all the categories that are attached to posts.
		$categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$category_count = count( $categories );

		set_transient( 'rt_categories', $category_count );
	}

	return $category_count > 1;
}

/**
 * Output a comment in the HTML5 format.
 *
 * @param object $comment Comment to display.
 * @param array  $args    An array of arguments.
 * @param int    $depth   Depth of comment.
 */
function rt_html5_comment( $comment, $args, $depth ) {
	global $post;
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li'; ?>

	<<?php echo esc_html( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'ncn-comment__item' ); ?>>

	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php if ( 0 != $args['avatar_size'] ) : ?>
			<div class="ncn-comment__left">
				<div class="ncn-comment__thumb"><?php echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
			</div><!-- .ncn-comments__left -->
		<?php endif ?>

		<div class="ncn-comment__body">
			<?php if ( $comment->user_id === $post->post_author ) : ?>
				<span class="author-label"><?php esc_html_e( 'Tác giả', 'rt' ); ?></span>
			<?php endif; ?>
			<div class="ncn-comment__action">
				<?php comment_reply_link( array_merge( $args, array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'add_below' => 'div-comment',
				) ) ); ?>

				<?php edit_comment_link( esc_html__( 'Chỉnh sửa', 'rt' ) ); ?>
			</div>

			<div class="comment-metadata ncn-comments__meta">
				<span class="comment-author ncn-comment__name h6">
					<?php echo get_comment_author_link(); ?>
				</span><!-- .comment-author -->

				<span class="ncn-comment__time">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( esc_html__( '%1$s lúc %2$s', 'rt' ), get_comment_date( '', $comment ), get_comment_time() ); ?>
						</time>
					</a>
				</span>

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Bình luận của bạn đang đợi duyệt.', 'rt' ); ?></p>
				<?php endif; ?>
			</div><!-- .comment-metadata -->

			<div class="ncn-comment__content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
		</div>

	</article><!-- .comment-body --><?php
	// Note: No close tag is here.
}

/**
 * Set post view.
 *
 * @param int $postID Post ID.
 */
function rt_postview_set( $postID ) {
	$count_key = 'postview_number';
	$count = get_post_meta( $postID, $count_key, true );

	if ( ! $count ) {
		$count = 0;
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );
	} else {
		$count++;
		update_post_meta( $postID, $count_key, $count );
	}
}

/**
 * Get post view.
 *
 * @param int $postID Post ID.
 */
function rt_postview_get( $postID ){
	$count_key = 'postview_number';
	$count = get_post_meta( $postID, $count_key, true );

	if( ! $count ){
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );

		return '0';
	}

	return $count;
}


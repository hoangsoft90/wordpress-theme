<?php
global $rt_option;
if( $rt_option['on_cart'] == false ) {
	function remove_woo_dashboard_widgets() {
	    remove_meta_box( 'woocommerce_dashboard_status', 'dashboard', 'normal');
	    remove_meta_box( 'woocommerce_dashboard_recent_reviews', 'dashboard', 'normal');
	}
	add_action('wp_dashboard_setup', 'remove_woo_dashboard_widgets', 20);

	function remove_woo_menus() {
	  remove_menu_page( 'woocommerce' );
	}
	add_action( 'admin_menu', 'remove_woo_menus' );

	function remove_woo_sub_menus() {

	  remove_submenu_page( 'edit.php?post_type=product', 'edit-tags.php?taxonomy=product_shipping_class&post_type=product' );
	  remove_submenu_page( 'edit.php?post_type=product', 'product_attributes' );

	}
	add_action( 'admin_menu', 'remove_woo_sub_menus', 999 );
}
//remove display notice - Showing all x results
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
//remove default sorting drop-down from WooCommerce
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'rt_woocommerce_template_loop_product_thumbnail', 10 );

//add_action( 'woocommerce_after_shop_loop_item_title', 'rt_woocommerce_product_excerpt', 20 );

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'rt_woocommerce_template_loop_product_title', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
//add_action( 'woocommerce_after_shop_loop_item_title', 'rt_woocommerce_template_loop_rating', 15 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 6 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// Breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_single_product', 'woocommerce_breadcrumb', 5 );
// add_action( 'init', 'jk_remove_wc_breadcrumbs' );
// function jk_remove_wc_breadcrumbs() {
//     remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
// }
add_action( 'tooltip_woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'tooltip_woocommerce_before_shop_loop_item_title', 'rt_tooltip_woocommerce_template_loop_product_thumbnail', 15 );

if ( ! function_exists( 'rt_woocommerce_get_product_thumbnail' ) ) {

	/**
	 * Get the product thumbnail, or the placeholder if not set.
	 *
	 * @subpackage	Loop
	 * @param string $size (default: 'shop_catalog')
	 * @param int $deprecated1 Deprecated since WooCommerce 2.0 (default: 0)
	 * @param int $deprecated2 Deprecated since WooCommerce 2.0 (default: 0)
	 * @return string
	 */
	function rt_woocommerce_get_product_thumbnail( $size = 'shop_catalog', $deprecated1 = 0, $deprecated2 = 0 ) {
		global $post;
		$image_size = apply_filters( 'rt_single_product_archive_thumbnail_size', $size );

		if ( has_post_thumbnail() ) {
			$props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			return get_the_post_thumbnail( $post->ID, $image_size, array(
				'alt'    => $props['alt'],
			) );
		} elseif ( wc_placeholder_img_src() ) {
			return wc_placeholder_img( $image_size );
		}
	}
}

/**
 * rt_woocommerce_template_loop_product_thumbnail
 *
 * @return [type] [description]
 */
function rt_woocommerce_template_loop_product_thumbnail() {
	echo '<a href="' . get_the_permalink() . '">' . rt_woocommerce_get_product_thumbnail() . '</a>';
}

/**
 * rt_tooltip_woocommerce_template_loop_product_thumbnail
 *
 * @return [type] [description]
 */
function rt_tooltip_woocommerce_template_loop_product_thumbnail() {
	echo "<a class='rt-tooltip' data-tooltip='{\"image\": \"" . esc_attr( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ) . "\"}' href='" . get_the_permalink() . "'><div class='rt-thumb'>" . rt_woocommerce_get_product_thumbnail() . "</div></a>";
}

/**
 * [rt_add_to_cart_text description]
 * @return [type] [description]
 */
function rt_add_to_cart_text() {
	return apply_filters( 'rt_woocommerce_product_add_to_cart_text', esc_html__( 'Đặt mua', 'rt' ) );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'rt_add_to_cart_text' );

/**
 * [rt_woocommerce_product_single_add_to_cart_text description]
 * @return [type] [description]
 */
function rt_woocommerce_product_single_add_to_cart_text() {
	return apply_filters( 'rt_woocommerce_product_single_add_to_cart_text', esc_html__( 'Mua ngay', 'rt' ) );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'rt_woocommerce_product_single_add_to_cart_text' );

/**
 * [rt_woocommerce_product_excerpt description]
 * @return [type] [description]
 */
function rt_woocommerce_product_excerpt() {
	echo '<div class="rt_product_excerpt">';
	echo wp_trim_words( get_the_content(), 13, ' ...' );
	echo '</div>';
}

if ( ! function_exists( 'rt_woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H3.
	 */
	function rt_woocommerce_template_loop_product_title() {
		echo '<h2 class="rt_woocommerce-loop-product__title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
	}
}

/**
 * [rt_woocommerce_template_loop_rating description]
 * @return [type] [description]
 */
function rt_woocommerce_template_loop_rating() {
	echo '<div class="rt_rating"></div>';
}

/**
 * [rt_qv_woocommerce_template_single_title description]
 * @return [type] [description]
 */
function rt_qv_woocommerce_template_single_title() {
	the_title( '<h3 class="product_title entry-title"><a href="' . get_the_permalink() . '">', '</a></h3>' );
}

/**
 * [rt_qv_woocommerce_template_single_price description]
 * @param  [type] $product [description]
 * @return [type]          [description]
 */
function rt_qv_woocommerce_template_single_price() {
	global $product;

	$regular_price = $product->get_regular_price();
	$sale_price = $sale_price = $product->get_sale_price();

	if ( ! empty( $regular_price ) ) { ?>
	<span class="price<?php echo $sale_price ? '' : ' no-sale-price' ?>">
		<?php if ( ! empty( $sale_price ) ) : ?>
		<span class="sale-price">
			Giá: <?php printf( '%sđ', number_format( $sale_price, 0, '.', '.' ) ); ?>
		</span>

		<?php endif; ?>
		<span class="regular-price">
			Giá Km: <?php printf( '%sđ', number_format( $regular_price, 0, '.', '.' ) ); ?>
		</span>
	</span>
	<?php
	}else {
		echo "Liên hệ";
	}
}

/**
 * [rt_qv_woocommerce_template_single_excerpt description]
 * @return [type] [description]
 */
function rt_qv_woocommerce_template_single_excerpt() {
	global $post;

	if ( ! $post->post_excerpt ) {
		return;
	}
	printf( '<div class="woocommerce-product-details__short-description"><strong>%1$s</strong>%2$s</div>', esc_html__( 'Mô tả:', 'rt' ), wp_trim_words( get_the_excerpt(), 40, '<a href="' . get_the_permalink() . '" title="' . esc_html__( 'Xem chi tiết sản phẩm này', 'rt' ) . '">' . esc_html__( '...Xem chi tiết', 'rt' ) . '</a>' ) );
}

/**
 * Single add to cart template.
 *
 * @return string single add to cart template.
 */
function rt_qv_woocommerce_template_single_add_to_cart() { ?>
	<form class="cart" method="post" enctype="multipart/form-data">
		<div class="quantity_wanted_p">
			<div class="quantity">
				<label for="quantity-detail" class="quantity-selector slg_g">Số lượng</label>
				<a class="btn_num button_qty" onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 1 ) result.value--;return false;" type="button">-</a>
				<input id="qty" type="text" class="input-text qty text" name="quantity" value="1" title="SL">
				<a class="btn_num button_qty" onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" type="button">+</a>
			</div>
		</div>

		<button type="submit" name="add-to-cart" value="<?php the_ID(); ?>" class="rt_qv_btn"><?php esc_html_e( 'Mua Ngay', 'rt' ); ?></button>

	</form>
<?php
}

/**
 * Product product images teamplate.
 *
 * @return string Product Images template.
 */
function rt_qv_woocommerce_show_product_images() {
	global $post, $product;

	$attachment_ids = $product->get_gallery_image_ids();

	if ( $attachment_ids && has_post_thumbnail() ) { ?>
		<div class="rt_galleries_products images">
			<div class="rt_product_thumbnails">
				<?php
				foreach ( $attachment_ids as $attachment_id ) {
					$full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
					$thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
					$thumbnail_post   = get_post( $attachment_id );
					$image_title      = $thumbnail_post->post_content;

					$attributes = array(
						'title'                   => $image_title,
						'data-src'                => $full_size_image[0],
						'data-large_image'        => $full_size_image[0],
						'data-large_image_width'  => $full_size_image[1],
						'data-large_image_height' => $full_size_image[2],
					);

					$html  = '<div class="rt-product-gallery__image">';
					$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
					$html .= '</div>';

					echo $html;
				} ?>
			</div>
			<div class="rt_product_thumbnails_gallery">
				<?php
				foreach ( $attachment_ids as $attachment_id ) {
					$full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
					$thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
					$thumbnail_post   = get_post( $attachment_id );
					$image_title      = $thumbnail_post->post_content;

					$attributes = array(
						'title'                   => $image_title,
						'data-src'                => $full_size_image[0],
						'data-large_image'        => $full_size_image[0],
						'data-large_image_width'  => $full_size_image[1],
						'data-large_image_height' => $full_size_image[2],
					);

					$html  = '<div class="rt-product-gallery__image">';
					$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
					$html .= '</div>';

					echo $html;
				} ?>
			</div>
		</div>
	<?php
	}
}

/**
 * Single Product summary template.
 *
 * @return string Woocommerce single product summary html template.
 */
function rt_woocommerce_single_product_summary() { 
	global $rt_option;
	?>
	<div class="rt_woocommerce_single_product_summary clearfix">
		<div class="<?php if($rt_option['info_btn'] == true) { echo 'rt_woocommerce_single_product_summary-left'; }?>">
			<?php woocommerce_template_single_price(); ?>
			<?php 
				if( $rt_option['buy_now_btn'] == true ) {
					woocommerce_template_single_add_to_cart(); 
				}
			?>
			<?php woocommerce_template_single_excerpt(); ?>
		</div>
		<?php if($rt_option['info_btn'] == true) { ?>
			<div class="rt_woocommerce_single_product_summary-right ctsp-thongdiep">
				<div class="ctsp-giaohang">
					<i class="bg-gh"></i>
					<p><?php esc_html_e( 'Giao hàng toàn Quốc', 'rt' ); ?></p>
				</div>
				<div class="ctsp-doihang">
					<i class="bg-dh"></i>
					<p><?php esc_html_e( 'Đổi hàng 07 ngày miễn phí', 'rt' ); ?></p>
				</div>
				<div class="ctsp-chinhhang">
					<i class="bg-ch"></i>
					<p><?php esc_html_e( 'Đảm bảo hàng chính hãng', 'rt' ); ?></p>
				</div>
				<div class="note-ship">
					<span class="money-icon"></span><?php esc_html_e( 'Quý khách có thể "Thanh toán khi nhận hàng', 'rt' ); ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="psupport"><?php $rt_option['rt_product_hotline']; ?></div>
<?php
}
add_action( 'woocommerce_single_product_summary', 'rt_woocommerce_single_product_summary', 20 );

/**
 * Tabs of content product.
 *
 * @param  array  $tabs Tabs of content.
 * @return array       //
 */
function rt_woocommerce_product_tabs( $tabs = array() ) {
	global $product, $post;

	// Description tab - shows product content
	if ( $post->post_content ) {
		$tabs['description'] = array(
			'title'    => esc_html__( 'Mô tả sản phẩm', 'rt' ),
			'priority' => 10,
			'callback' => 'woocommerce_product_description_tab',
		);
	}

	unset($tabs['reviews']);

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'rt_woocommerce_product_tabs' );

//remove tabs woocommerce
function woo_remove_product_tabs( $tabs ) {

    //unset( $tabs['description'] );        // Remove the description tab
    unset( $tabs['reviews'] );      // Remove the reviews tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab

    return $tabs;

}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
/**
 * Under Singular Sidebar.
 */
function rt_under_singular_sidebar() {
	if ( is_active_sidebar( 'under-singular' ) ) {
		dynamic_sidebar( 'under-singular' );
	}
}
add_action( 'woocommerce_after_single_product_summary', 'rt_under_singular_sidebar', 16 );
if ( $rt_option['on_cart'] ) {
if ( $rt_option['buy_now_btn'] ) {
		/**
		 * [rt_enable_disable_buynow_btn description]
		 * @param  array  $args [description]
		 * @return [type]       [description]
		 */
		function rt_enable_disable_buynow_btn( $args = array() ) {
			global $product;

			if ( $product ) {
				$defaults = array(
					'quantity' => 1,
					'class'    => implode( ' ', array_filter( array(
							'button',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
					) ) ),
				);

				$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

				echo apply_filters( 'woocommerce_loop_add_to_cart_link',
					sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
						esc_url( $product->add_to_cart_url() ),
						esc_attr( isset( $quantity ) ? $quantity : 1 ),
						esc_attr( $product->get_id() ),
						esc_attr( $product->get_sku() ),
						esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
						esc_html( $product->add_to_cart_text() )
					),
				$product );
			}
		}
		add_action( 'rt_add_to_cart', 'rt_enable_disable_buynow_btn', 10 );
	}
}

function rt_woocommerce_output_related_products_args( $args ) {
	global $rt_option;
	$args = array(
		'posts_per_page' => $rt_option['related_product_items'],
		'columns'        => 4,
		'orderby'        => 'rand',
	);

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'rt_woocommerce_output_related_products_args' );


// Add comment fb to single woo tab
	if( $rt_option['check_using_cmt_fb'] == true ) {
	add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
	function woo_new_product_tab( $tabs ) {
		// Adds the new tab
		$tabs['test_tab'] = array(
			'title' 	=> __( 'Bình luận Facebook', 'woocommerce' ),
			'priority' 	=> 50,
			'callback' 	=> 'woo_new_product_tab_content'
		);
		return $tabs;
	}
	function woo_new_product_tab_content() {

		?>
		<div id="fb-root"></div>
	    <script>(function(d, s, id) {
	      var js, fjs = d.getElementsByTagName(s)[0];
	      if (d.getElementById(id)) return;
	      js = d.createElement(s); js.id = id;
	      js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.0";
	      fjs.parentNode.insertBefore(js, fjs);
	    }(document, 'script', 'facebook-jssdk'));</script>
	    <div class="fb-comments" data-href="<?php the_permalink() ;?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
		<?php
		}
	}
// remove class layout
add_filter( 'post_class', 'prefix_post_class', 21 );
function prefix_post_class( $classes ) {
    if ( 'product' == get_post_type() ) {
        $classes = array_diff( $classes, array( 'first', 'last' ) );
    }
    return $classes;
}
// hide coupon field on cart page
function hide_coupon_field_on_cart( $enabled ) {
	if ( is_cart() ) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_cart' );

// hide coupon field on checkout page
function hide_coupon_field_on_checkout( $enabled ) {
	if ( is_checkout() ) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );

<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $rt_option;

$sale_price = $product->get_sale_price();
$reg_price = $product->get_regular_price();

$thousands_sep = '.';
$thousands_sep = $rt_option['thousands_sep'];

?>
<p class="price">
	<span class="rt_price_text"><?php esc_html_e( 'Giá bán:', 'rt' ); ?></span>
	<?php if  (! empty($reg_price) ) : ?>
		<span class="rt_single_regular_price<?php echo ( empty( $sale_price ) ) ? ' no_sale' : ''; ?>">
			<?php printf( '%sđ', number_format( $reg_price, 0, '.', '.' ) ); ?>
		</span>
	<?php else : ?>
		<span class="rt_single_sale_price">
			<?php _e( 'Liên hệ', 'rt' ) ?>
		</span>
	<?php endif; ?>
	<?php if ( ! empty( $sale_price ) ) : ?>
	<span class="rt_single_sale_price">
		<?php printf( '%sđ', number_format( $sale_price, 0, '.', '.' ) ); ?>
	</span>
	<?php endif; ?>
</p>

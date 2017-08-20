<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package __RT
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */

$area = __Rt_Widget_Area::get_sidebar( 'area' );

if ( ! is_active_sidebar( __Rt_Widget_Area::get_sidebar( 'left_sidebar_name' ) ) && ! is_active_sidebar( __Rt_Widget_Area::get_sidebar( 'right_sidebar_name' ) ) ) {
	return;
}
?>

<?php if ( is_active_sidebar( $sidebar_left = __Rt_Widget_Area::get_sidebar( 'left_sidebar_name' ) ) && ( 'left' == $area || 'both' == $area ) ) : ?>
	<aside id="secondary-1" class="sidebar widget-area">
		<?php dynamic_sidebar( $sidebar_left ); ?>
	</aside>
<?php endif; ?>

<?php if ( is_active_sidebar( $sidebar_right = __Rt_Widget_Area::get_sidebar( 'right_sidebar_name' ) ) && ( 'right' == $area || 'both' == $area ) ) : ?>
	<?php do_action( '__rt_render_widget_area', $sidebar_right ); ?>
<?php endif; ?>

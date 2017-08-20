<?php
/**
 * @since 1.0
 * @version 1.0
 */
global $rt_option;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( $rt_option['responsive'] ) : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php endif; ?>
	<?php 
		$icon = $rt_option['favicon'];
		if(!empty($icon)) : 
		$favi = wp_get_attachment_image_src( $icon , 'full' );
	?>
    	<link rel="icon" type="image/png" href="<?php echo $favi[0]; ?>" />
    <?php endif; ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action('rt_before_site');  ?>
<div <?php rt_layout_classes( 'site site-container' ); ?>>
	<header class="site-header" role="banner">
		
		<?php get_template_part( 'template-parts/header/top_bar' ); ?>
		<?php dynamic_sidebar( 'header' ); ?>
		<?php get_template_part( 'template-parts/header/'.$rt_option['layout_header'] ); ?>
		

	</header><!-- #masthead -->

	<div id="content" class="site-content">

		<?php do_action( 'rt_before_content' ); ?>

		<?php if ( is_active_sidebar( 'above-content' ) && is_front_page() ) : ?>
		<div class="above-content-section">
			<?php if ( ! $rt_option['above_content_full_width'] ) : ?>
			<div class="container">
				<div class="row">
			<?php endif; ?>
					<?php do_action( '__rt_render_widget_area', 'above-content' ); ?>
					<?php dynamic_sidebar( 'above-content' ); ?>

			<?php if ( ! $rt_option['above_content_full_width'] ) : ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php do_action( 'rt_after_content' ); ?>

		<div class="container">
			<div class="row">
				<div id="layout" <?php rt_layout_class( 'clearfix' ); ?>>

					<?php do_action( 'rt_before_layout' );?>
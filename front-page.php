<?php
/**
 * Trang chủ template
 * Description: Template for home page.
 * Template Name: Trang chủ
 
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
    	<?php do_action('rt_before_main'); ?>

			<?php do_action( '__rt_render_widget_area', 'front-page' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

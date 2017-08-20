<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package __RT
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */

?>
					<?php do_action( 'after_layout' ); ?>

				</div><!-- #layout -->
			</div><!-- .row -->
		</div><!-- .container -->

		<?php do_action( 'rt_under_content_before' ); ?>

		<?php do_action( '__rt_render_widget_area', 'under-content' ); ?>
		
		<?php do_action( 'rt_under_content_after' ); ?>

	</div><!-- #content -->

	<?php get_template_part( 'template-parts/footer/before-footer' ); ?>

	<footer class="site-footer">

		<?php do_action( 'before_site_footer' ); ?>
		
		<div class="container">
			<?php get_template_part( 'template-parts/footer/footer-row' ); ?>
			<?php get_template_part( 'template-parts/footer/footer' ); ?>
			<?php get_template_part( 'template-parts/footer/copyright' ); ?>
		</div>

		<?php do_action( 'rt_site_footer' ); ?>

	</footer><!-- footer -->
	<?php do_action( 'rt_after_footer' ); ?>
	<?php get_template_part( 'template-parts/mobile-menu' ); ?>

	<?php get_template_part( 'template-parts/vertical-mega-mobile-menu' ); ?>

	<div class="overlay"></div>

	<div class="backtotop"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

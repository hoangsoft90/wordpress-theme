<?php
/**
 * Navigation Teamplate
 *
 */

global $rt_option;

if ( $rt_option['vertical_mega_menu'] && $rt_option['enable_header_search'] ) {

	$mega_menu_classes = 'col-lg-3 col-md-2 col-xs-2';
	$nav_menu_classes = 'primary-menu-container visible-lg col-lg-8';
	$header_search = 'col-lg-1 col-md-8 col-sm-8 col-xs-8';
	$button_menu = 'col-md-2 col-sm-2 col-xs-2';

} else if ( $rt_option['vertical_mega_menu'] && ! $rt_option['enable_header_search'] ){

	$mega_menu_classes = 'col-lg-3 col-md-2 col-xs-2';
	$nav_menu_classes = 'primary-menu-container visible-lg col-lg-9';
	$header_search = '';
	$button_menu = 'col-xs-10';

} elseif ( ! $rt_option['vertical_mega_menu'] && ! $rt_option['enable_header_search'] ) {

	$mega_menu_classes = '';
	$nav_menu_classes = 'primary-menu-container visible-lg col-lg-12';
	$header_search = '';
	$button_menu = 'col-xs-12';

} else {

	$mega_menu_classes = '';
	$nav_menu_classes = 'primary-menu-container visible-lg col-lg-9';
	$header_search = 'col-lg-3 col-md-10 col-sm-10 col-xs-10';
	$button_menu = 'col-md-2 col-sm-2 col-xs-2';

}
	$nav = $rt_option['layout_header'];
	if($nav == 'default') {
?>

	<nav id="site-navigation" class="main-navigation">
		<div class="container">
			<div class="row">
				<?php if ( $rt_option['vertical_mega_menu'] ) : ?>
				<div class="vertical-mega-menu <?php echo esc_attr( $mega_menu_classes ); ?>">
					<div class="rt_mega_menu">

						<div class="vertical-mega-menu-title"><?php _e($rt_option['vertical_mega_menu_title']); ?></div>

						<?php
							wp_nav_menu( array(
								'theme_location' => 'vertical-mega-menu',
								'container_class' => 'menu-vertical-mega-menu-container',
								'container_id' => 'vertical-mega-menu',
								'menu_class' => 'menu',
							) );
						?>
					</div>

					<button id="mega-menu-toggle" type="button" class="rt-navbar-toggle hidden-lg">
						<span class="screen-reader-text sr-only"><?php esc_html_e( 'Toggle navigation', 'rt' ); ?></span>
						<span class="icon-bar bar1"></span>
						<span class="icon-bar bar2"></span>
						<span class="icon-bar bar3"></span>
					</button>
				</div>
				<?php endif; ?>

				<?php
					wp_nav_menu( array(
						'theme_location'  => 'primary',
						'menu_id'         => 'primary-menu',
						'menu_class'      => 'primary-menu menu clearfix',
						'container_class' => $nav_menu_classes,
						'fallback_cb'     => 'primary_menu_fallback',
					));
				?>

				<?php if ( $rt_option['enable_header_search'] ) : ?>

				<div class="header-search <?php echo esc_attr( $header_search ); ?>">
					<?php 
					if ( function_exists( 'WC' ) ) {
						get_product_search_form(); 
					}else{
						get_search_form();
					}
					?>
				</div>

				<?php endif; ?>

				<div class="hidden-lg <?php echo esc_attr( $button_menu ); ?>">
					<?php if ( $rt_option['enable_header_search'] == true ) { ?>

					<button id="menu-toggle" type="button" class="rt-navbar-toggle hidden-lg">
						<span class="screen-reader-text sr-only"><?php esc_html_e( 'Toggle navigation', 'rt' ); ?></span>
						<span class="icon-bar bar1"></span>
						<span class="icon-bar bar2"></span>
						<span class="icon-bar bar3"></span>
					</button>

					<?php }else{ ?>

					<div id="menu-toggle" class="mobile-menu-no-search">
						<span id="">Menu</span>
						<button id="" type="button" class="rt-navbar-toggle hidden-lg">
							<span class="screen-reader-text sr-only"><?php esc_html_e( 'Toggle navigation', 'rt' ); ?></span>
							<span class="icon-bar bar1"></span>
							<span class="icon-bar bar2"></span>
							<span class="icon-bar bar3"></span>
						</button>
					</div>
					<?php } ?>
				</div>

			</div><!-- .row -->
		</div><!-- .container -->
	</nav><!-- #site-navigation -->
<?php }else{ ?>
	<nav id="site-navigation" class="main-navigation">
		<div class="container_class">
			<div class="row">
				<?php if ( $rt_option['vertical_mega_menu'] ) : ?>
				<div class="vertical-mega-menu <?php echo esc_attr( $mega_menu_classes ); ?>">
					<div class="rt_mega_menu">

						<div class="vertical-mega-menu-title"><?php _e($rt_option['vertical_mega_menu_title']); ?></div>

						<?php
							wp_nav_menu( array(
								'theme_location' => 'vertical-mega-menu',
								'container_class' => 'menu-vertical-mega-menu-container',
								'container_id' => 'vertical-mega-menu',
								'menu_class' => 'menu',
							) );
						?>
					</div>

					<button id="mega-menu-toggle" type="button" class="rt-navbar-toggle hidden-lg">
						<span class="screen-reader-text sr-only"><?php esc_html_e( 'Toggle navigation', 'rt' ); ?></span>
						<span class="icon-bar bar1"></span>
						<span class="icon-bar bar2"></span>
						<span class="icon-bar bar3"></span>
					</button>
				</div>
				<?php endif; ?>

				<?php
					wp_nav_menu( array(
						'theme_location'  => 'primary',
						'menu_id'         => 'primary-menu',
						'menu_class'      => 'primary-menu menu clearfix',
						'container_class' => $nav_menu_classes,
						'fallback_cb'     => 'primary_menu_fallback',
					));
				?>

				<?php if ( $rt_option['enable_header_search'] ) : ?>

				<div class="header-search <?php echo esc_attr( $header_search ); ?>">
					<?php get_search_form(); ?>
				</div>

				<?php endif; ?>

				<div class="hidden-lg <?php echo esc_attr( $button_menu ); ?>">
					<button id="menu-toggle" type="button" class="rt-navbar-toggle hidden-lg">
						<span class="screen-reader-text sr-only"><?php esc_html_e( 'Toggle navigation', 'rt' ); ?></span>
						<span class="icon-bar bar1"></span>
						<span class="icon-bar bar2"></span>
						<span class="icon-bar bar3"></span>
					</button>
				</div>

			</div><!-- .row -->
		</div><!-- .container -->
	</nav><!-- #site-navigation -->
<?php } ?>
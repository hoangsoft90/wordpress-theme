<?php
/**
 * @package __RT
 * @subpackage header
 * @since 1.0
 * @version 1.0
 */

global $rt_option;

?>
		<div class="site-branding">
			<div class="container">
				<div class="row">
				<?php if( !wp_is_mobile()) { ?>
				<?php if ( !empty($rt_option['logo']) ) : ?>
					<?php $image_logo = wp_get_attachment_image_src( $rt_option['logo'], 'full' ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" >
						<img src="<?php echo esc_url( $image_logo[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
					</a>
				<?php endif; ?>
				<?php }else{ ?>
					<?php 
						$image_logo = wp_get_attachment_image_src( $rt_option['logo'], 'full' );
						$image_mobile = wp_get_attachment_image_src( $rt_option['logo_mobile'], 'full' ); 
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" >
						<img src="<?php if(!empty($image_mobile)) echo esc_url( $image_mobile[0] );else echo esc_url( $image_logo[0] );  ?>" alt="<?php bloginfo( 'name' ); ?>">
					</a>
				<?php } ?>
				<?php
					if ( is_home() ) : ?>
						<h1 class="site-title hidden"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<div class="site-title hidden"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></div>
					<?php
					endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description ) : ?>
						<p class="site-description hidden"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php
				endif; ?>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .site-branding -->
		<?php get_template_part( 'template-parts/header/navigation' ); ?>
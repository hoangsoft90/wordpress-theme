<?php
/**
 * @package __RT
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
    	<?php do_action('rt_before_main'); ?>

			<?php if(have_posts()) : the_post();  ?>
                <h1 class="heading"><?php the_title(); ?></h1>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                    <div class="clear"></div>
            <?php endif; ?>
            <div class="related-post">
                <h3 class="heading-realate">Tin Liên Quan</h3>
	            <ul>
	              <?php
					$category = wp_get_object_terms( $post->ID, 'category',array('orderby' => 'parent', 'order' => 'DESC'));
	    			  global $post;
	    			  $rel = new WP_Query(array(
	    			  	'cat' => $category[0]->cat_ID,
	    			  	'showposts' => 5,
	    			  	'post__not_in' => array($post->ID)
	    		  	    ));
	                	if($rel->have_posts()):
	                    while($rel->have_posts()):
	                        $rel->the_post();  
	                ?>
	                    <li>
	                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                    </li>
	                <?php
	                    endwhile;
	                    endif;
	                ?>
	            </ul>
        	</div><!-- End relate -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

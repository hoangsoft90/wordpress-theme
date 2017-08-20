<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package __RT
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */
global $rt_option;
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
    	<?php do_action('rt_before_main'); ?>

		<div class="product_home clear">
			<?php  
				$product_cat = $rt_option['product_cat'];
		        $num_product = $rt_option['numberproduct'];
		        $style_prd = $rt_option['style_prd'];
		        
		        if($product_cat)
		        foreach($product_cat as $products_cat) :
		        $product = $products_cat['product_cat_sub'];
		    	if(!empty($product)) {
		    	$getcat = get_term_by( 'id', $product , 'product_cat' );
		    ?>
		    	<div class="product_list clear">
		    		<h2 class="heading">
		    			<a href="<?php echo get_term_link( (int) $product, 'product_cat'); ?>">
			           		<?php echo $getcat->name; ?>
			           	</a>
			        </h2>
		            <div class="home-product row">
		                <?php 
		                 $argscat = new WP_Query(array(
		                    'post_type' => 'product',
		                    'tax_query' => array(
		                      	array(
		                          	'taxonomy' => 'product_cat',
		                          	'field' => 'id',
		                          	'terms' => $product
		                      	)
		                  	),
		                  	'posts_per_page' => $num_product
		                  ));
		                ?>
		                <ul class="woocommerce <?php echo $style_prd; ?>">
		                     <?php
		                         while($argscat -> have_posts()):
		                             $argscat -> the_post();
		                     ?>
		                    <?php get_template_part( 'woocommerce/content', 'product' ); ?>
		                    <?php  endwhile; wp_reset_postdata(); ?>
		                </ul>
		            </div>
		    	</div>
			<?php
				}
		        endforeach;
			?>
		</div>
		<div class="clear"></div>
		<!-- End Product -->
		<div class="news-home clear">
			<?php  
				$new = $rt_option['product_category']; 
		        $num_post = $rt_option['numberpost']; 
		    	$style_post = $rt_option['style_category'];
		        if($new)
		        foreach($new as $news) :
		        if(!empty($news)) {
		        $news_post = $news['product_category_sub'];
		    ?>
		    	<div class="list <?php echo $style_post; ?> clear">
		    		<h2 class="heading">
		    			<a href="<?php echo get_category_link($news_post); ?>">
			           		<?php echo get_cat_name($news_post); ?>
			           	</a>
			        </h2>
			        <div class="list-news">
		            	<?php
		            	#_print('template-parts/content/'.$style_post);
		            		get_template_part( 'template-parts/content/'.$style_post.'', get_post_format() );
		            	?>
		            </div>
		    	</div>
		    	<?php
		    		}
		            endforeach;
				?>
		</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package __RT
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */

	get_header(); 
  $current_cat_id = get_query_var('cat');
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
    <?php do_action('rt_before_main'); ?>
		<div class="arc-news">
      <h1 class="heading"><?php echo get_cat_name( $current_cat_id );?></h1>
			<div class="new-list">
                <?php
                    $arg = array(
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'id',
                            'terms' => $current_cat_id
                        )
                    ),
                    'paged'=> get_query_var('paged'),
                    );
                    $news_post = new WP_Query($arg);
                    while($news_post -> have_posts()) :
                        $news_post -> the_post();
                    ?>
                    <div class="news-post">
                           <h2 class="title"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo the_title();?></a></h2>
                           <a href="<?php the_permalink();?>" title="<?php the_title();?>">

                           <?php if(has_post_thumbnail()) the_post_thumbnail("medium",array("alt" => get_the_title()));
                               else echo ""; ?>
                           </a>

                           <?php the_content_limit('400','Đọc Thêm');?>

                    </div>
                    <?php
                        endwhile; 
						if(function_exists('wp_pagenavi')) {wp_pagenavi( array( 'query' => $news_post ) );}
                        wp_reset_postdata();
			     	?>
			    </div>
         </div><!--End #news-wrap-->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

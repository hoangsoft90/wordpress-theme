<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package __RT
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
    		<?php do_action('rt_before_main'); ?>
			<div class="search-result">
				<h2 class="heading">Kết quả tìm kiếm : <?php echo get_query_var('s'); ?></h2>
				<?php
				     if(have_posts()) {
				         while(have_posts()){
				             the_post();
				?>
					<div class="news-post">
				    <h2 class="title"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo the_title();?></a></h2>
				    <a href="<?php the_permalink();?>" title="<?php the_title();?>">

				    <?php if(has_post_thumbnail()) the_post_thumbnail("medium",array("alt" => get_the_title()));
				         else echo $no_thum; ?>
				    </a>
				</div>
				<?php
				        }//End while
				     }//Endif
				?>
	        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

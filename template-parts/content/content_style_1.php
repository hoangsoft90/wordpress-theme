<?php
/**
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */
global $rt_option;
$new = $rt_option['product_category']; 
$num_post = $rt_option['numberpost']; 
?>

<?php  
	$main_post = new WP_Query( 'cat='.$news_post.'&showposts='.$num_post );
    while ( $main_post -> have_posts() ) :
    $main_post -> the_post();
?>
<div class="news-post <?php echo $i; ?>" >
	<?php if ( get_the_post_thumbnail() && ! is_single() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</a>
		</div>
	<?php endif; ?>
	<div class="content">
		<h2 class="news-title">
	        <a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo the_title(); ?></a>
	    </h2>
		<?php the_content_limit('100','Xem thêm');?>
	</div>
</div>
<?php endwhile; wp_reset_postdata(); ?>
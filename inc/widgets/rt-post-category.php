<?php
if( ! class_exists( 'RT_Widget_Post' ) ) {
  class RT_Widget_Post extends WP_Widget {

    function __construct() {

      $widget_ops     = array(
        'classname'   => 'rt-widget rt-post-category',
        'description' => 'Hiển thị danh sách bài viết theo chuyên mục.'
      );

      parent::__construct( 'rt_widget_post', 'RT - Danh sách bài viết', $widget_ops );

    }

    function widget( $args, $instance ) {

      extract( $args );

      echo $before_widget;

      if ( ! empty( $instance['title'] ) ) {
        echo $before_title . $instance['title'] . $after_title;
      }
      ?>
        <!-- start file -->
        <!-- no slide -->
        <?php if($instance['on'] == false) {  ?>
        <div class="news-widget no-slide">
          <?php
              $query = new WP_Query('showposts='.$instance['numberp'].'&cat='.$instance['tax']);
              while($query->have_posts()):
              $query->the_post();
          ?>
              <div class="featured-post">
                <?php 
                  if ( ( $instance['thumbnail'] ) ) :
                  echo '<div class="'.$instance['stthumb'].'">';
                    the_post_thumbnail("medium",array("title" => get_the_title())); 
                  echo '</div>';
                  endif;
                ?>
                <a class="news-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <?php 
                if ( ( $instance['excerpt'] ) ) :
                    echo '<div class="entry-content">';
                      the_content_limit( (int) $instance['nbexerpt'],'' );
                    echo  '</div>';
                endif;
                ?>
              </div>
          <?php  endwhile; wp_reset_postdata(); ?>
        </div>
        <!-- has slide -->
        <?php }else{ ?>
        <div class="news-widget has-slide">
            <?php
                $query = new WP_Query('showposts='.$instance['numberp'].'&cat='.$instance['tax']);
                while($query->have_posts()):
                $query->the_post();
            ?>
                <div class="featured-post">
                  <?php 
                    if ( ( $instance['thumbnail'] ) ) :
                    echo '<div class="'.$instance['stthumb'].'">';
                      the_post_thumbnail("medium",array("title" => get_the_title())); 
                    echo '</div>';
                    endif;
                  ?>
                  <a class="news-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  <?php 
                  if ( ( $instance['excerpt'] ) ) :
                      echo '<div class="entry-content">';
                        the_content_limit( (int) $instance['nbexerpt'],'' );
                      echo  '</div>';
                  endif;
                  ?>
                </div>
            <?php  endwhile; wp_reset_postdata(); ?>
        </div>
        <script type="text/javascript">
          jQuery(document).ready(function($) {
            "use strict";
            $('.news-widget.has-slide').slick({
              speed: <?php echo $instance['speedslide']; ?>,
              vertical: <?php echo 'vertical' == $instance['slide'] ? 'true' : 'false'; ?>,
              slidesToShow: <?php echo absint( $instance['numbshow'] ); ?>,
              slidesToScroll: <?php echo absint( $instance['numbsl'] ); ?>,
              verticalSwiping: <?php echo 'vertical' == $instance['slide'] ? 'true' : 'false'; ?>,
              autoplay: true,
              arrows: true,
              prevArrow: '<button type="button" class="slick-prev"></button>',
              nextArrow: '<button type="button" class="slick-next"></button>',
            });
          });
        </script>
        <?php } ?>
      <?php
      echo $after_widget;

    }

    function update( $new_instance, $old_instance ) {

      $instance            = $old_instance;
      $instance['title']   = $new_instance['title'];
      $instance['on']    = $new_instance['on'];
      $instance['slide']    = $new_instance['slide'];
      $instance['numberp'] = $new_instance['numberp'];
      $instance['numbsl'] = $new_instance['numbsl'];
      $instance['numbshow'] = $new_instance['numbshow'];
      $instance['speedslide'] = $new_instance['speedslide'];
      $instance['tax'] = $new_instance['tax'];
      $instance['thumbnail'] = $new_instance['thumbnail'];
      $instance['stthumb'] = $new_instance['stthumb'];
      $instance['fstthumb'] = $new_instance['fstthumb'];
      $instance['numberp'] = $new_instance['numberp'];
      $instance['excerpt'] = $new_instance['excerpt'];
      $instance['nbexerpt'] = $new_instance['nbexerpt'];

      return $instance;

    }

    function form( $instance ) {

      // title widget
      $title_widget = esc_attr( $instance['title'] );
      $title_field = array(
        'id'    => $this->get_field_name('title'),
        'name'  => $this->get_field_name('title'),
        'type'  => 'text',
        'title' => 'Tiêu đề',
      );
      echo cs_add_element( $title_field, $title_widget );


      // choose category
      $tax_id = esc_attr( $instance['tax'] );
      $tax_field = array(
      	'id'	=> $this->get_field_name('tax'),
      	'name'	=> $this->get_field_name('tax'),
      	'title'	=> 'Chọn chuyên mục hiển thị',
      	'class' => 'chosse_tax',
      	'type'	=> 'select',
      	'options'  => 'categories',
      );
      echo cs_add_element($tax_field, $tax_id);

      // number post 
      $number_post = esc_attr( $instance['numberp'] );
      $number_field = array(
      	'id'	=> $this->get_field_name('numberp'),
      	'name'	=> $this->get_field_name('numberp'),
      	'title'	=> 'Chọn số bài viết hiển thị',
      	'class' => 'chosse_number',
      	'type'	=> 'text',
      );
      echo cs_add_element($number_field, $number_post);

      // post thumbnail
      $thumbnail = esc_attr( $instance['thumbnail'] );
      $thumbnail_field = array(
        'id'    => $this->get_field_name('thumbnail'),
        'name'  => $this->get_field_name('thumbnail'),
        'title' => 'Bật/ Tắt hình ảnh bài viết',
        'type'  => 'switcher',
      );
      echo cs_add_element( $thumbnail_field, $thumbnail );

      // post thumbnail style
      $stthumb = esc_attr( $instance['stthumb'] );
      $stthumb_field = array(
        'id'    => $this->get_field_name('stthumb'),
        'name'  => $this->get_field_name('stthumb'),
        'title' => 'Chọn style hình ảnh',
        'type'  => 'select',
        'options' => array (
          'align-left' =>'Căn lề trái',
          'align-right' =>'Căn lề phải',
        ),
        'default'     => 'align-left',
        'dependency' => array(  $this->get_field_name('thumbnail'), '==', 'true' ),
      );
      echo cs_add_element( $stthumb_field, $stthumb );

      // first post thumbnail style
      $fstthumb = esc_attr( $instance['fstthumb'] );
      $fstthumb_field = array(
        'id'    => $this->get_field_name('fstthumb'),
        'name'  => $this->get_field_name('fstthumb'),
        'title' => 'Bật/ Tắt hình ảnh bài viết đầu tiên',
        'type'  => 'switcher',
        'dependency' => array(  $this->get_field_name('thumbnail'), '==', 'true' ),
      );
      //echo cs_add_element( $fstthumb_field, $fstthumb );

      // excerpt
      $excerpt = esc_attr( $instance['excerpt'] );
      $excerpt_field = array(
        'id'    => $this->get_field_name('excerpt'),
        'name'  => $this->get_field_name('excerpt'),
        'title' => 'Bật/ Tắt mô tả',
        'type'  => 'switcher',
      );
      echo cs_add_element( $excerpt_field, $excerpt );

      // number text excerpt
      $number_excerpt = esc_attr( $instance['nbexerpt'] );
      $nbexert_field = array(
      	'id'	=> $this->get_field_name('nbexerpt'),
      	'name'	=> $this->get_field_name('nbexerpt'),
      	'title'	=> 'Chọn số từ mô tả hiển thị',
      	'class' => 'chosse_number',
      	'type'	=> 'text',
        'dependency'   => array( $this->get_field_name('excerpt'), '==', true),
      );
      echo cs_add_element($nbexert_field, $number_excerpt);

      // bug function
      $on_func = esc_attr( $instance['on'] );
      $on_field = array(
        'id'    => $this->get_field_name('on'),
        'name'  => $this->get_field_name('on'),
        'title' => 'Bật/ Tắt slide',
        'class' => 'admin_slide',
        'type'  => 'switcher',
      );
      echo cs_add_element( $on_field, $on_func );

      // slide style
      $slide = esc_attr( $instance['slide'] );
      $slide_field = array(
        'id'  => $this->get_field_name('slide'),
        'name'  => $this->get_field_name('slide'),
        'title' => 'Chọn chuyên mục hiển thị',
        'class' => 'chosse_tax',
        'type'  => 'select',
        'options'  => array(
          'vertical' => 'Slide dọc',
          'horizon' => 'Slide ngang( Áp dụng cho Content/ Còn Sidebar chỉ áp dụng cho 1 bài viết cuộn slide)',
        ),
        'dependency' => array(  $this->get_field_name('on'), '==', 'true' ),
      );
      echo cs_add_element($slide_field, $slide);

      // number post slide
      $number_slide = esc_attr( $instance['numbsl'] );
      $nbsl_field = array(
        'id'    => $this->get_field_name('numbsl'),
        'name'    => $this->get_field_name('numbsl'),
        'title'   => 'Số bài viết cuộn slide',
        'type'    => 'text',
        'dependency' => array(  $this->get_field_name('on'), '==', 'true' ),
      );
      echo cs_add_element($nbsl_field, $number_slide);

       // number show slide
      $number_numbshow = esc_attr( $instance['numbshow'] );
      $numbshow_field = array(
        'id'    => $this->get_field_name('numbshow'),
        'name'    => $this->get_field_name('numbshow'),
        'title'   => 'Số bài viết hiển thị slide',
        'type'    => 'text',
        'dependency' => array(  $this->get_field_name('on'), '==', 'true' ),
      );
      echo cs_add_element($numbshow_field, $number_numbshow);
      // speed slide 
      $speedslide  = esc_attr( $instance['speedslide'] );
      $speed_field = array(
        'id'     => $this->get_field_name('speedslide'),
        'name'     => $this->get_field_name('speedslide'),
        'title'    => 'Chọn tốc độ slide',
        'type'  => 'select',
        'options' => array(
          '1000'  => '1000',
          '2000'  => '2000',
          '3000'  => '3000',
          '4000'  => '4000',
          '5000'  => '5000',
          ),
        'dependency' => array(  $this->get_field_name('on'), '==', 'true' ),
        );
      echo cs_add_element($speed_field, $speedslide);

    }
  }
}

if ( ! function_exists( 'rt_widget_post' ) ) {
  function rt_widget_post() {
    register_widget( 'RT_Widget_Post' );
  }
  add_action( 'widgets_init', 'rt_widget_post' );
}

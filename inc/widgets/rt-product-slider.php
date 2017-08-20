<?php
if( ! class_exists( 'RT_Widget_Product' ) ) {
  class RT_Widget_Product extends WP_Widget {

    function __construct() {

      $widget_ops     = array(
        'classname'   => 'rt-widget rt-product-category',
        'description' => 'Hiển thị danh sách sản phẩm theo chuyên mục.'
      );

      parent::__construct( 'rt_widget_product', 'RT - Danh sách sản phẩm', $widget_ops );

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
        <div class="product-widget woocommerce no-slide">
          <ul class="products">
          <?php
              $query = new WP_Query(
                array(
                    'post_type' => 'product',
                    'showposts' => $instance['numberp'],
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'id',
                            'terms'    => $instance['tax']
                        )
                    )
                )
            );
            while($query->have_posts()):
            $query->the_post();
          ?>
            <li <?php post_class( 'item' ); ?>>
              <?php 
                  do_action( 'tooltip_woocommerce_before_shop_loop_item_title' );
                  do_action( 'woocommerce_shop_loop_item_title' );
                  do_action( 'woocommerce_after_shop_loop_item_title' );
                  do_action( 'woocommerce_after_shop_loop_item' );
              ?>
            </li>
          <?php  endwhile; wp_reset_postdata(); ?>
          </ul>
        </div>
        <!-- has slide -->
        <?php }else{ ?>
        <div class="product-widget woocommerce has-slide">
            <ul class="products">
            <?php
                $query = new WP_Query(
                  array(
                      'post_type' => 'product',
                      'showposts' => $instance['numberp'],
                      'tax_query' => array(
                          array(
                              'taxonomy' => 'product_cat',
                              'field'    => 'id',
                              'terms'    => $instance['tax']
                          )
                      )
                  )
              );
              while($query->have_posts()):
              $query->the_post();
            ?>
              <li <?php post_class( 'item' ); ?>>
                <?php 
                  do_action( 'tooltip_woocommerce_before_shop_loop_item_title' );
                  do_action( 'woocommerce_shop_loop_item_title' );
                  do_action( 'woocommerce_after_shop_loop_item_title' );
                  do_action( 'woocommerce_after_shop_loop_item' );
                ?>
              </li>
            <?php  endwhile; wp_reset_postdata(); ?>
            </ul>
        </div>
        <script type="text/javascript">
          jQuery(document).ready(function($) {
            "use strict";
            $('.product-widget.has-slide ul').slick({
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
      $instance['tax'] = $new_instance['tax'];
      $instance['on']    = $new_instance['on'];
      $instance['slide']    = $new_instance['slide'];
      $instance['numberp'] = $new_instance['numberp'];
      $instance['numbsl'] = $new_instance['numbsl'];
      $instance['numbshow'] = $new_instance['numbshow'];
      $instance['speedslide'] = $new_instance['speedslide'];

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
      	'title'	=> 'Chọn chuyên mục sản phẩm hiển thị',
      	'type'	=> 'select',
      	'options'  => 'categories',
        'query_args'     => array(
          'taxonomy'     => 'product_cat',
          'order'        => 'DESC',
        ),
      );
      echo cs_add_element($tax_field, $tax_id);

      // number post 
      $number_post = esc_attr( $instance['numberp'] );
      $number_field = array(
      	'id'	=> $this->get_field_name('numberp'),
      	'name'	=> $this->get_field_name('numberp'),
      	'title'	=> 'Chọn số sản phẩm hiển thị',
      	'class' => 'chosse_number',
      	'type'	=> 'text',
      );
      echo cs_add_element($number_field, $number_post);

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
        'type'  => 'select',
        'options'  => array(
          'vertical' => 'Slide dọc',
          'horizon' => 'Slide ngang( Áp dụng cho Content/ Còn Sidebar chỉ áp dụng cho 1 sp cuộn slide)',
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

if ( ! function_exists( 'rt_widget_product' ) ) {
  function rt_widget_product() {
    register_widget( 'RT_Widget_Product' );
  }
  add_action( 'widgets_init', 'rt_widget_product' );
}

<?php 
if( ! class_exists( 'RT_Widget_Archive' ) ) {
  class RT_Widget_Archive extends WP_Widget {

    function __construct() {

      $widget_ops     = array(
        'classname'   => 'rt_widget widget_nav_menu',
        'description' => 'Widget chuyên mục sidebar.'
      );

      parent::__construct( 'rt_widget_archive', 'RT: Chuyên mục trong chuyên mục', $widget_ops );

    }

    function widget( $args, $instance ) {
      if ( $instance['on'] == true) {
      if( is_archive() ){
      $cate = get_queried_object();
      
      extract( $args );
      echo $before_widget;
      // start if
      if($instance['tax'] == '1' ){
        $cateID = $cate->term_id;
        $catpa = get_term_top_most_parent( $cateID, $cate->taxonomy );
        $parent = $catpa->term_id;

      echo $before_title .  $catpa->name . $after_title;
      echo '<div class="parent-widget">';
      ?>
        <ul class="menu">
            <?php
                $category = get_categories('parent='.$parent.'&taxonomy='.$cate->taxonomy.'&hide_empty=0');
                if(count($category) != 0){
                foreach($category as $list){
            ?>
                <li>
                    <a href="<?php echo get_term_link( $list ) ; ?>" title="<?php echo $list->name ;?>"> <?php echo $list->name ;?></a>
                </li>
            <?php
                    }
                }
            ?>
        </ul>
        <?php
      }elseif($instance['tax'] == '2'){

      echo $before_title .  $cate->name . $after_title;
      echo '<div class="parent-widget">';
      ?>
        <ul class="menu">
        <?php
            $category = get_categories('child_of='.$cate->term_id.'&hide_empty=0&taxonomy='.$cate->taxonomy.'&number=6&orderby=rand');
            if(count($category) != 0){
            foreach($category as $list){
        ?>
            <li>
                <a href="<?php echo get_term_link( $list ) ; ?>" title="<?php echo $list->name ;?>"> <?php echo $list->name ;?></a>
            </li>
        <?php
                }
            }
        ?>
            
        </ul>
      <?php
        }else{

      echo $before_title .  $cate->name . $after_title;
      echo '<div class="parent-widget">';
      ?>
      <ul class="menu">
            <?php
            $arg = array(
            'tax_query' => array(
                array(
                    'taxonomy' => $cate->taxonomy,
                    'field' => 'id',
                    'terms' => $cate->term_id,
                )
            ),
            'paged'=> get_query_var('paged'),
            );
            $news_post = new WP_Query($arg);
            while($news_post -> have_posts()) :
                $news_post -> the_post();
                ?>
                    <li><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo the_title();?></a></li>
                <?php
                endwhile; 
            ?>
      </ul>
      <?php
      }
      echo '</div>';
      // end if
      echo $after_widget;
      }
    }
    }

    function update( $new_instance, $old_instance ) {

      $instance            = $old_instance;
      $instance['on']   = $new_instance['on'];
      $instance['tax']   = $new_instance['tax'];
      $instance['x']   = $new_instance['x'];
      return $instance;

    }

    function form( $instance ) {

      $on_value = esc_attr( $instance['on'] );
      $on_field = array(
        'id'    => $this->get_field_name('on'),
        'name'  => $this->get_field_name('on'),
        'title' => 'Bật chuyên mục con',
        'type'  => 'switcher',
      );
      echo cs_add_element( $on_field, $on_value );

      $a_value  = esc_attr( $instance['tax'] );
      $a_field  = array(
      'id'      => $this->get_field_name('tax'),
      'name'    => $this->get_field_name('tax'),
      'title'   => 'Chọn dạng hiển thị',
      'type'  => 'select',
        'options' => array(
          '1'  => 'Chuyên mục / Chuyên mục',
          '2'  => 'Chuyên mục con',
          '3'  => 'Bài viết',
          ),

      'dependency'   => array( $this->get_field_name('on'), '==', 'true' ),
      );

      echo cs_add_element( $a_field, $a_value );
    }
  }
}

if ( ! function_exists( 'rt_widget_archive' ) ) {
  function rt_widget_archive() {
    register_widget( 'RT_Widget_Archive' );
  }
  add_action( 'widgets_init', 'rt_widget_archive' );
}
<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// TAXONOMY OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================

function add_rt_taxonomy_options_fields( $options ) {
  $options     = array();

  $rt_base_sidebar = array(

      array(
        'id'      => 'is_overwrite',
        'type'    => 'switcher',
        'label'   => esc_html__( 'Sử dụng cài đặt Thanh bên?', 'rt-theme' ),
        'default' => false,
      ),
      array(
        'id'        => 'area',
        'type'         => 'image_select',
        'title'        => 'Trang chủ',
        'options'      => array(
          'left'    => __RT_THEME_IMG .'/layout/sidebar_left.png',
          'right'    => __RT_THEME_IMG .'/layout/sidebar_right.png',
          'both'    => __RT_THEME_IMG .'/layout/2_sidebar.png',
          'none'    => __RT_THEME_IMG .'/layout/no_sidebar.png',
        ),
        'default'      => 'left',
        'dependency' => array( 'is_overwrite', '==', 'true' ),
        'attributes'   => array(
          'data-depend-id' => 'area',
        ),
      ),

      array(
        'id'         => 'left_sidebar_name',
        'type'       => 'select',
        'title'      => esc_html__( 'Thanh bên Trái', 'rt-theme' ),
        'options'    => __Rt_Widget_Area::registered_sidebars(),
        'default'    => 'sidebar-1',
        'dependency' => array( 'is_overwrite|area', '==|any', 'true|left,both' ),
      ),
      array(
        'id'         => 'right_sidebar_name',
        'type'       => 'select',
        'title'      => esc_html__( 'Thanh bên Phải', 'rt-theme' ),
        'options'    => __Rt_Widget_Area::registered_sidebars(),
        'default'    => 'sidebar-2',
        'dependency' => array( 'is_overwrite|area', '==|any', 'true|right,both' ),
      ),

  );
  // -----------------------------------------
  // Category Taxonomy                        -
  // -----------------------------------------
  $options[]   = array(
    'id'       => 'rt_sidebar',
    'taxonomy' => 'category', // or array( 'category', 'post_tag' )
    'fields'   => $rt_base_sidebar,
  );
  // -----------------------------------------
  // Taxonomy Options                        -
  // -----------------------------------------
  $options[]   = array(
    'id'       => 'rt_sidebar',
    'taxonomy' => 'product_cat', // or array( 'category', 'post_tag' )
    'fields'   => $rt_base_sidebar,
  );

  return $options;
}

add_filter( 'cs_taxonomy_options', 'add_rt_taxonomy_options_fields' );

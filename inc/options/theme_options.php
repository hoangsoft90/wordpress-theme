<?php if ( ! defined( 'ABSPATH' ) ) { die; }

function rt_theme_options_settings() {
  $settings           = array(
    'menu_title'      => 'RT Options',
    'menu_type'       => 'menu', 
    'menu_slug'       => 'rt-option',
    'menu_icon'       => __RT_THEME_IMG .'/logort.png',
    'ajax_save'       => true,
    'show_reset_all'  => false,
    'framework_title' => 'Cài đặt Website',
  );
  return $settings;
}

add_filter( 'cs_framework_settings', 'rt_theme_options_settings' );

// Options

function rt_theme_options_fields() {

  $active_widgets = apply_filters('__rt_active_widget', 'rt_active_widget');
  $rt_base_sidebar = array(
    'left'    => __RT_THEME_IMG .'/layout/sidebar_left.png',
    'right'   => __RT_THEME_IMG .'/layout/sidebar_right.png',
    'both'    => __RT_THEME_IMG .'/layout/2_sidebar.png',
    'none'    => __RT_THEME_IMG .'/layout/no_sidebar.png',
  );
  $options        = array();

  $options[]    = array(
      'name'      => 'user_option',
      'title'     => 'Cài đặt',
      'fields'    => array(
        // Favicon
        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => 'Ảnh Favicon.',
        ),
        array(
          'id'    => 'favicon',
          'type'  => 'image',
          'title' => 'Favicon',
          'add_title' => 'Chọn ảnh Favicon',
        ),
        // Banner - Logo
        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => 'Chọn ảnh Banner',
        ),
        array(
          'id'    => 'logo',
          'type'  => 'image',
          'title' => 'Banner',
          'add_title' => 'Chọn ảnh Banner',
        ),
        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => 'Chọn ảnh banner mobile.',
        ),
        array(
          'id'    => 'logo_mobile',
          'type'  => 'image',
          'title' => 'Logo mobile',
          'add_title' => 'Chọn ảnh Logo Mobile',
        ),

        // Chọn slide hiển thị
        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => 'Chọn slide hiển thị trang chủ',
        ),
        array(
          'id'             => 'mts_slides',
          'type'           => 'select',
          'title'          => 'Chọn slide hiển thị đã tạo ở Metaslider',
          'options'        => 'posts',
          'query_args'     => array(
              'post_type'    => 'ml-slider',
              'orderby'      => 'post_date',
              'order'        => 'DESC',
          ),
          'default_option' => '',
        ),
        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => 'Chọn danh mục sản phẩm.',
        ),
        // Chuyên mục sản phẩm
        array(
          'id'              => 'product_cat',
          'type'            => 'group',
          'title'           => 'Chọn chuyên mục sản phẩm',
          'button_title'    => 'Thêm chuyên mục',
          'fields'          => array(
            array(
              'id'             => 'product_cat_sub',
              'type'           => 'select',
              'title'          => 'Chọn chuyên mục',
              'options'        => 'categories',
              'query_args'     => array(
                'taxonomy'     => 'product_cat',
                'order'        => 'DESC',
              ),
            'default_option' => '',
            ),
          ),
        ),
        array(
          'id'    => 'numberproduct', 
          'type'  => 'text',
          'title' => 'Số sản phẩm hiển thị',
        ),
        // Chuyên mục bài viết
        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => 'Chọn chuyên mục bài viết.',
        ),
        array(
          'id'             => 'product_category',
          'type'           => 'group',
          'title'           => 'Chọn chuyên mục tin tức',
          'button_title'    => 'Thêm chuyên mục',
          'fields'          => array(
            array(
              'id'             => 'product_category_sub',
              'type'           => 'select',
              'title'          => 'Chọn chuyên mục',
              'options'        => 'categories',
              'query_args'     => array(
                'order'        => 'DESC',
              ),
              'default_option' => '',
            ),
          ),
        ),
        array(
          'id'    => 'numberpost', 
          'type'  => 'text',
          'title' => 'Số bài viết hiển thị',
        ),
      )
    );
      $options[]    = array(
     'name'      => 'admin_setting_option',
     'title'     => 'Admin Setting',
     'sections'  => array(
                // Setting general
                array(
                'name'      => 'setting_general',
                'title'     => 'Cài đặt tổng quan',
                'icon'      => 'fa fa-check',
                'fields'    => array(
                      array(
                        'id'    => 'responsive',
                        'type'  => 'switcher',
                        'title' => 'Bật tắt responsive',
                        'default' => true,
                      ),
                      // array(
                      //   'id'    => 'box',
                      //   'type'  => 'switcher',
                      //   'title' => 'Banner dạng Fullwidth',
                      //   'default' => false,
                      // ),  
                      array(
                        'id'           => 'site_full',
                        'type'         => 'switcher',
                        'title'        => 'Website Fullwidth',
                        'default'      => false,
                      ),
                      array(
                        'id'           => 'banner_full',
                        'type'         => 'switcher',
                        'title'        => 'Banner Fullwidth',
                        'default'      => false,
                        'dependency'   => array( 'site_full', '==', 'true' ),
                      ),                   
                      array(
                        'id'      => 'layout_width',
                        'type'    => 'radio',
                        'title'   => 'Chiều rộng website',
                        'class'   => 'horizontal',
                        'options' => array(
                          '1000'   => '1000px',
                          '1170'    => '1170px',
                          '1200'    => '1200px',
                          'custom'    => 'Tùy chọn',
                        ),
                        'default' => '1000',
                      ),
                      array(
                        'id'      => 'layout_custom',
                        'type'    => 'number',
                        'default'    => 1000,
                        'title'   => 'Chiều rộng tùy chỉnh',
                        'after'   => ' <i class="cs-text-muted">(px)</i>',
                        'dependency'   => array( 'layout_width_custom', '==', 'true' ),
                      ),
                      array(
                          'type'    => 'notice',
                          'class'   => 'info',
                          'content' => 'Lưu nhanh cài đặt',
                        ),
                      array(
                        'id'           => 'layout_home',
                        'type'         => 'image_select',
                        'title'        => 'Trang chủ',
                        'options'      => $rt_base_sidebar,
                        'default'      => 'left'
                      ),
                      array(
                        'id'           => 'layout_category',
                        'type'         => 'image_select',
                        'title'        => 'Chuyên mục',
                        'options'      => $rt_base_sidebar,
                        'default'      => 'left'
                      ),
                      // array(
                      //   'id'           => 'layout_archive',
                      //   'type'         => 'image_select',
                      //   'title'        => 'Lưu trữ chung',
                      //   'options'      => $rt_base_sidebar,
                      //   'default'      => 'left'
                      // ),
                      array(
                        'id'           => 'layout_single',
                        'type'         => 'image_select',
                        'title'        => 'Bài viết,sản phẩm',
                        'options'      => $rt_base_sidebar,
                        'default'      => 'left'
                      ),
                      array(
                        'id'           => 'layout_page',
                        'type'         => 'image_select',
                        'title'        => 'Trang',
                        'options'      => $rt_base_sidebar,
                        'default'      => 'left'
                      ),
                      // array(
                      //   'id'           => 'layout_product_cat',
                      //   'type'         => 'image_select',
                      //   'title'        => 'Danh mục sản phẩm',
                      //   'options'      => $rt_base_sidebar,
                      //   'default'      => 'left'
                      // ),
                      // array(
                      //   'id'           => 'layout_product',
                      //   'type'         => 'image_select',
                      //   'title'        => 'Sản phẩm',
                      //   'options'      => $rt_base_sidebar,
                      //   'default'      => 'left'
                      // ),array(
                      array(
                          'type'    => 'notice',
                          'class'   => 'info',
                          'content' => 'Lưu nhanh cài đặt',
                        ),
                    ),
                  ),
                // background
                array(
                'name'      => 'color_background_setting',
                'title'     => 'Màu nền',
                'icon'      => 'fa fa-check',
                'fields'    => array(
                  array(
                    'id'      => 'main_color',
                    'type'    => 'color_picker',
                    'title'   => 'Chọn màu chủ đạo',
                  ),
                  array(
                    'id'           => 'background',
                    'type'         => 'background',
                    'title'        => 'Màu nền / Ảnh nền website',
                  ),
                  
                  // Background Menu
                  array(
                    'type'    => 'notice',
                    'class'   => 'info',
                    'content' => 'Nền menu top.',
                  ),

                  array(
                    'id'         => 'bg_menu_type',
                    'type'       => 'radio',
                    'title'      => 'Màu nền Menu top',
                    'options' => array(
                      'color_bg'   => 'Màu nền /ảnh nền',
                      'gradient'    => 'Gradient',
                    ),
                  ),
                  array(
                    'id'           => 'gr_mennu',
                    'type'         => 'textarea',
                    'title'        => ' ',
                    'after'        => 'Nền Gradient Menu chính',
                    'default'        => 
                          'background-image: -moz-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);
                          background-image: -webkit-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);
                          background-image: -ms-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);',
                    'dependency'   => array( 'bg_menu_type_gradient', '==', 'true' ),
                  ),
                  array(
                    'id'           => 'bg_menu',
                    'type'         => 'background',
                    'title'        => ' ',
                    'after'        => 'Màu nền / Ảnh nền Menu chính',
                    'dependency'   => array( 'bg_menu_type_color_bg', '==', 'true' ),
                  ),


                  // Background widget title
                  array(
                    'type'    => 'notice',
                    'class'   => 'info',
                    'content' => 'Nền tiêu đề widget.',
                  ),
                  array(
                    'id'         => 'bg_widget_type',
                    'type'       => 'radio',
                    'title'      => 'Màu nền tiêu đề Widget',
                    'options' => array(
                      'color_bg'   => 'Màu nền /ảnh nền',
                      'gradient'    => 'Gradient',
                    ),
                  ),
                  array(
                    'id'           => 'gr_widget_title',
                    'type'         => 'textarea',
                    'title'        => ' ',
                    'after'        => 'Nền Gradient Widget',
                    'default'        => 
                          'background-image: -moz-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);
                          background-image: -webkit-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);
                          background-image: -ms-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);',
                    'dependency'   => array( 'bg_widget_type_gradient', '==', 'true' ),
                  ),
                  array(
                    'id'           => 'bg_widget_title',
                    'type'         => 'background',
                    'title'        => ' ',
                    'after'        => 'Màu nền / Ảnh nền Widget',
                    'dependency'   => array( 'bg_widget_type_color_bg', '==', 'true' ),
                  ),


                  // Background category title
                  array(
                    'type'    => 'notice',
                    'class'   => 'info',
                    'content' => 'Nền tiêu đề danh mục( Content ).',
                  ),
                  array(
                    'id'         => 'bg_category_type',
                    'type'       => 'radio',
                    'title'      => 'Nền tiêu đề danh mục dạng( Content )',
                    'options' => array(
                      'color_bg'   => 'Màu nền /ảnh nền ',
                      'gradient'    => 'Gradient',
                    ),
                  ),
                  array(
                    'id'           => 'bg_category_title',
                    'type'         => 'background',
                    'title'         => ' ',
                    'after'        => 'Màu nền / Ảnh nền Danh mục',
                    'default'      => array(
                      'repeat'     => 'no-repeat',
                      'position'   => 'left center',
                    ),
                    'dependency'   => array( 'bg_category_type_color_bg', '==', 'true' ),
                  ),
                  array(
                    'id'           => 'gr_category_title',
                    'type'         => 'textarea',
                    'title'        => ' ',
                    'after'        => 'Nền Gradient Danh mục',
                    'default'        => 
                    'background-image: -moz-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);
                    background-image: -webkit-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);
                    background-image: -ms-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);',
                    'dependency'   => array( 'bg_category_type_gradient', '==', 'true' ),
                  ),

                  // Background Footer
                  array(
                    'type'    => 'notice',
                    'class'   => 'info',
                    'content' => 'Nền chân trang.',
                  ),
                  
                  array(
                    'id'         => 'bg_footer_type',
                    'type'       => 'radio',
                    'title'      => 'Nền Chân trang dạng',
                    'options' => array(
                      'color_bg'   => 'Màu nền /ảnh nền',
                      'gradient'    => 'Gradient',
                    ),
                  ),
                  array(
                    'id'           => 'bg_footer',
                    'type'         => 'background',
                    'title'         => ' ',
                    'after'        => 'Màu nền / Ảnh nền Chân trang',
                    'default'      => array(
                      'repeat'     => 'no-repeat',
                      'position'   => 'center center',
                    ),
                    'dependency'   => array( 'bg_footer_type_color_bg', '==', 'true' ),
                  ),
                  array(
                    'id'           => 'gr_footer',
                    'type'         => 'textarea',
                    'title'        => ' ',
                    'after'        => 'Nền Gradient Danh mục',
                    'default'        => 
                    'background-image: -moz-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);
                    background-image: -webkit-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);
                    background-image: -ms-linear-gradient( 90deg, rgb(220,34,39) 0%, rgb(238,58,63) 100%);',
                    'dependency'   => array( 'bg_footer_type_gradient', '==', 'true' ),
                  ),

                  
                  array(
                    'id'           => 'bg_submenu',
                    'type'         => 'background',
                    'title'        => 'Màu nền Submenu',
                  ),
                  array(
                    'id'           => 'bg_hover_menu',
                    'type'         => 'background',
                    'title'        => 'Màu nền hover menu',
                  ),
                  array(
                    'type'    => 'notice',
                    'class'   => 'info',
                    'content' => 'Lưu nhanh',
                  ),
                  
                    ),
                  ),
                // header
                array(
                'name'      => 'header_setting',
                'title'     => 'Định dạng Menu',
                'icon'      => 'fa fa-check',
                'fields'    =>  array(
                  array(
                    'id'           => 'layout_header',
                    'type'         => 'image_select',
                    'title'        => 'Giao diện Logo/ Menu',
                    'options'      => array(
                        'default' => __RT_THEME_IMG .'/header/logo-center.gif',
                        'logo_menu' => __RT_THEME_IMG .'/header/logo-left.gif',
                      ),
                    'default'      => 'default'
                  ),

                  //Top bar
                  array(
                    'id'           => 'top_bar',
                    'type'         => 'switcher',
                    'title'        => 'Hiển thị widget Top bar',
                    'default'      => false,
                  ),
                  array(
                      'type'    => 'notice',
                      'class'   => 'info',
                      'content' => 'Lưu nhanh cài đặt',
                    ),
                  //Sticky Nav Menu
                  array(
                    'id'           => 'sticky_nav_menu',
                    'type'         => 'switcher',
                    'title'        => 'Menu Fixed',
                    'default'      => false,
                  ),

                  //Vertical Mega Menu
                  array(
                    'id'           => 'vertical_mega_menu',
                    'type'         => 'switcher',
                    'title'        => 'Mega Menu Ngang',
                    'default'      => false,
                  ),

                  //Vertical Mega Menu Title
                  array(
                    'id'           => 'vertical_mega_menu_title',
                    'type'         => 'text',
                    'title'        => 'Tiêu đề Mega Menu Ngang',
                    'default'      => 'Danh mục sản phẩm',
                    'dependency' => array( 'vertical_mega_menu', '==', 'true' ),

                  ),

                  //Header Search
                  array(
                    'id'           => 'enable_header_search',
                    'type'         => 'switcher',
                    'title'        => 'Hiển thị ô tìm kiếm',
                    'default'      => false,
                  ),

                  ),
                ),
                
                
                  // Product
                  array(
                  'name'      => 'product_setting',
                  'title'     => 'Sản phẩm',
                  'icon'      => 'fa fa-check',
                  'fields'    =>  array(
                    // style prodcut
                    array(
                      'id'             => 'style_prd',
                      'type'           => 'select',
                      'title'          => 'Chọn dạng style hiển thị sản phẩm',
                      'options'        => array(
                        'product_style_1'  => 'Giao diện 1',
                        'product_style_2'  => 'Giao diện 2',
                        'product_style_3'  => 'Giao diện 3',
                        // 'product_style_4'  => 'Giao diện 4',
                        // 'product_style_5'  => 'Giao diện 5',
                        ),
                      'default'            =>'product_style_1',
                      ),
                    array(
                      'id'    => 'thousands_sep',
                      'type'    => 'text',
                      'title'    => 'Ngắn cách phần nghìn của giá sản phẩm',
                      'desc'    => esc_html( 'Điền dấu "." hoặc dấu ","'),
                    ),
                    array(
                      'id'    => 'colums_product_lg',
                      'type'    => 'select',
                      'title'    => esc_html('Số sản phẩm 1 hàng trên màn hình cỡ lớn ( > 1200px )'),
                      'options' => array(
                        'col-lg-3 lg-4-cl'  => esc_html__( '4 Cột', 'rt-theme' ),
                        'col-lg-4 lg-3-cl'  => esc_html__( '3 Cột', 'rt-theme' ),
                      ),
                    ),
                    array(
                        'type'    => 'notice',
                        'class'   => 'info',
                        'content' => 'Lưu nhanh cài đặt',
                      ),
                    array(
                      'id'    => 'colums_product_md',
                      'type'    => 'select',
                      'title'    => esc_html('Số sản phẩm 1 hàng trên màn hình cỡ vừa'),
                      'options' => array(
                        'col-md-3 md-4-cl'  => esc_html__( '4 Cột', 'rt-theme' ),
                        'col-md-4 md-3-cl'  => esc_html__( '3 Cột', 'rt-theme' ),
                        'col-md-6 md-2-cl'  => esc_html__( '2 Cột', 'rt-theme' ),
                      ),
                    ),
                    array(
                      'id'    => 'colums_product_sm',
                      'type'    => 'select',
                      'title'    => esc_html('Số sản phẩm 1 hàng trên màn hình cỡ nhỏ'),
                      'options' => array(
                        'col-sm-4 sm-3-cl'  => esc_html__( '3 Cột', 'rt-theme' ),
                        'col-sm-6 sm-2-cl'  => esc_html__( '2 Cột', 'rt-theme' ),
                        'col-sm-12 sm-1-cl' => esc_html__( '1 Cột', 'rt-theme' ),
                      ),
                    ),     
                    array(
                      'id'    => 'colums_product_xs',
                      'type'    => 'select',
                      'title'    => esc_html('Số sản phẩm 1 hàng trên màn hình điện thoại'),
                      'options' => array(
                        'col-xs-6 xs-2-cl'  => esc_html__( '2 Cột', 'rt-theme' ),
                        'col-xs-12 xs-1-cl' => esc_html__( '1 Cột', 'rt-theme' ),
                      ),
                    ),                      
                    // array(
                    //   'id'    => 'gutter_width',
                    //   'type'    => 'number',
                    //   'title'    => 'Khoảng cách giữa 2 sản phẩm',
                    //   'default'    => '10',
                    //   'attributes' => array(
                    //     'min' => '5',
                    //     'max'    => '60',
                    //   ),
                    //   'after'   => ' <i class="cs-text-muted">(px)</i>',
                    // ),
                    array(
                      'type'    => 'notice',
                      'class'   => 'info',
                      'content' => 'Các chức năng.',
                    ),
                    array(
                      'id'    => 'on_cart',
                      'type'    => 'switcher',
                      'title'    => 'Bật/ tắt các chức năng giỏ hàng',
                      'default'    => false,
                    ),
                    // Buy button          
                    array(
                      'id'    => 'buy_now_btn',
                      'type'    => 'switcher',
                      'title'    => 'Nút mua',
                      'default'    => false,
                      'dependency' => array( 'on_cart', '==', 'true' ),
                    ),
                    // info buy single
                    array(
                      'id'    => 'info_btn',
                      'type'    => 'switcher',
                      'title'    => 'Thông điệp mua hàng(Single)',
                      'default'    => false,
                      'dependency' => array( 'on_cart', '==', 'true' ),
                    ),
                    // Quick view          
                    array(
                      'id'    => 'quickview',
                      'type'    => 'switcher',
                      'title'    => 'Xem nhanh',
                      'default'    => false,
                    ),          
                    array(
                      'id'    => 'quickview_mobile',
                      'type'    => 'switcher',
                      'title'    => 'Xem nhanh trên mobile',
                      'default'    => false,
                      'dependency' => array( 'quickview', '==', 'true' ),
                      'dependency' => array( 'on_cart', '==', 'true' ),
                    ),
                    
                    // Tooltip          
                    array(
                      'id'    => 'tooltip',
                      'type'    => 'switcher',
                      'title'    => 'Tooltip',
                      'default'    => false,
                    ),          
                    array(
                      'id'    => 'tooltip_image',
                      'type'    => 'switcher',
                      'title'    => 'Hình ảnh trong Tooltip',
                      'default'    => false,
                      'dependency' => array( 'tooltip', '==', 'true' ),
                    ),              
                    array(
                      'id'    => 'tooltip_title',
                      'type'    => 'switcher',
                      'title'    => 'Tiêu đề trong Tooltip',
                      'default'    => false,
                      'dependency' => array( 'tooltip', '==', 'true' ),
                    ),
                    array(
                      'id'    => 'tooltip_price',
                      'type'    => 'switcher',
                      'title'    => 'Giá cả trong Tooltip',
                      'default'    => false,
                      'dependency' => array( 'tooltip', '==', 'true' ),
                    ),
                    // cmt fb 
                    array(
                      'id'    => 'check_using_cmt_fb',
                      'type'    => 'switcher',
                      'title'    => 'Comment Facebook',
                      'default'    => false,
                    ),
                    // Zoom and slide product thumbnails
                    array(
                      'type'    => 'notice',
                      'class'   => 'info',
                      'content' => 'Zoom ảnh và slide ảnh sản phẩm',
                    ),
                    // zoom image 
                    array(
                      'id'    => 'zoomimg',
                      'type'    => 'switcher',
                      'title'    => 'Zoom ảnh sản phẩm',
                      'default'    => false,
                    ),

                    ),
                  ),
                // post
                array(
                  'name'     => 'post_setting',
                  'title'    => 'Bài viết + Khác',
                  'icon'     => 'fa fa-check',
                  'fields'   => array(
                      // Style bài viết
                      array(
                      'id'             => 'style_category',
                      'type'           => 'select',
                      'title'          => 'Chọn dạng style hiển thị bài viết',
                      'options'        => array(
                        'content_style_1'  => 'Giao diện 1',
                        'content_style_2'  => 'Giao diện 2',
                        'content_style_3'  => 'Giao diện 3',
                        'content_style_4'  => 'Giao diện 4',
                        'content_style_5'  => 'Giao diện 5',
                        
                        ),
                      ),
                    // breadcrumb
                      array(
                        'id'           => 'enable_breadcrumb',
                        'type'         => 'switcher',
                        'title'        => 'Hiển thị breadcrumb',
                        'default'      => false,
                      ),
                    ),
                  ),

                // footer
                array(
                  'name'      => 'footer_setting',
                  'title'     => 'Chân trang',
                  'icon'      => 'fa fa-check',
                  'fields'    =>  array(
                    array(
                      'id'    => 'before_footer_widget',
                      'type'    => 'number',
                      'title'    => 'Số Sidebar Widget trước chân trang',
                      'default'    => '0',
                      'after'    => 'Tối thiểu: 0, Tối đa: 10',
                      'attributes' => array(
                        'min' => '0',
                        'max'    => '10',
                      ),
                    ),
                    array(
                      'id'    => 'footer_column',
                      'type'    => 'number',
                      'title'    => 'Số cột Widget Chân trang',
                      'default'    => '1',
                      'after'    => 'Tối thiểu: 1, Tối đa: 10',
                      'attributes' => array(
                        'min' => '1',
                        'max'    => '10',
                      ),
                    ),

                    // array(
                    //   'id'           => 'footer_full',
                    //   'type'         => 'switcher',
                    //   'title'        => 'Footer tràn chiều rộng',
                    //   'default'      => false,
                    // ),

                    array(
                      'id'           => 'copyright',
                      'type'         => 'wysiwyg',
                      'title'        => 'Copyright',
                      'settings' => array(
                        'textarea_rows' => 5,
                        'media_buttons' => false,
                      ),
                      'default'      => '<a rel="nofollow" target="_blank" href="http://hoangweb.com/" title="thiet ke website">Hoangweb.com</a>',
                    ),
                  ),
                  ),
                // Code
                array(
                  'name'      => 'code_setting',
                  'title'     => 'Chèn thêm code',
                  'icon'      => 'fa fa-check',
                  'fields'    =>  array(
                    
                    array(
                      'id'    => 'header_script',
                      'type'    => 'textarea',
                      'title'    => 'Chèn code đầu trang',
                      'desc'    => esc_html( 'Code nằm trước thẻ đóng </head>. VD: Google Analytics'),
                    ),

                    array(
                      'id'    => 'footer_script',
                      'type'    => 'textarea',
                      'title'    => 'Chèn code chân trang',
                      'desc'    => esc_html('Code nằm trước thẻ đóng </body>.'),
                    ),
                  ),
                ),

          ),
        );
  


  return $options;
}
add_filter( 'cs_framework_options', 'rt_theme_options_fields' );
<?php
/**
 * Sidebars configuration.
 *
 * @package __RT
 */
global $rt_option;


add_action( 'after_setup_theme', '__rt_register_sidebars' );
function __rt_register_sidebars() {

	__rt_widget_area()->widgets_settings = apply_filters( '__rt_widget_area_default_settings', array(
		'header' => array(
			'name'          => esc_html__( 'Header', 'rt-theme' ),
			'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung header.', 'rt-theme' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
			'before_wrapper' => '<section id="%1$s" class="%2$s">',
			'after_wrapper'  => '</section>',
			'is_global'      => false,
		),
		'sidebar-1' => array(
			'name'           => esc_html__( 'Thanh bên (Trái)', 'rt-theme' ),
			'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị cột bên cạnh nội dung.', 'rt-theme' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
			'before_wrapper' => '<aside id="secondary-1" class="sidebar widget-area">',
			'after_wrapper'  => '</aside>',
			'is_global'      => true,
		),
		'sidebar-2' => array(
			'name'          => esc_html__( 'Thanh bên (Phải)', 'rt-theme' ),
			'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị cột bên cạnh nội dung.', 'rt-theme' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
			'before_wrapper' => '<aside id="secondary-2" class="sidebar widget-area">',
			'after_wrapper'  => '</aside>',
			'is_global'      => true,
		),

		// 'footer' => array(
		// 	'name'          => 'Chân Trang ',
		// 	'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung chân trang.', 'rt-theme' ),
		// 	'before_widget' => '<div id="%1$s" class="widget %2$s '.$sidebar_class.' sb-'.$sidebar_count.'">',
		// 	'after_widget'  => '</div>',
		// 	'before_title'  => '<h3 class="widget-title">',
		// 	'after_title'   => '</h3>',
		// 	'before_wrapper' => '<section id="%1$s" class="%2$s">',
		// 	'after_wrapper'  => '</section>',
		// 	'is_global'      => false,
		// 	'conditional'    => array( 'is_home', 'is_front_page' ),
		// ),
		// 'front-page' => array(
		// 	'name'          => esc_html__( 'Trang chủ', 'rt-theme' ),
		// 	'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung trang chủ.', 'rt-theme' ),
		// 	'before_widget' => '<div id="%1$s" class="widget %2$s">',
		// 	'after_widget'  => '</div>',
		// 	'before_title'  => '<h3 class="widget-title">',
		// 	'after_title'   => '</h3>',
		// 	'before_wrapper' => '<section id="%1$s" class="%2$s">',
		// 	'after_wrapper'  => '</section>',
		// 	'is_global'      => false,
		// 	'conditional'    => array( 'is_home', 'is_front_page' ),
		// ),
		
	) );
	
	rt_set_before_footer_number();
	
	rt_set_footer_number();
	
}
// Widget 
function rt_widgets_init() {
  global $rt_option;
  global $_wp_sidebars_widgets;
  $sidebars_widgets_count = $_wp_sidebars_widgets;
  $sidebar_count_footer = isset($sidebars_widgets_count[ 'footer' ])? count( $sidebars_widgets_count[ 'footer' ] ):0;
  if($sidebar_count_footer == 1){
             $sidebar_class = 'col-md-12';
         } elseif($sidebar_count_footer == 2){
             $sidebar_class = 'col-md-6';
         } elseif($sidebar_count_footer == 3){
             $sidebar_class = 'col-md-4';
         } elseif($sidebar_count_footer == 4){
             $sidebar_class = 'col-md-3';
         }else {
            $sidebar_class = 'col-md-3';
         }
		  // register_sidebar( array(
		  //   'name'          => __( 'Chân trang', 'rt-theme' ),
		  //   'id'            => 'footer',
		  //   'description'   => __( 'Thông tin chân trang', 'rt-theme' ),
		  //   'before_widget' => '<aside id="%1$s" class="widget %2$s '.$sidebar_class.' sb-class-'.$sidebar_count_footer.'-item">',
		  //   'after_widget'  => '</aside>',
		  //   'before_title'  => '<h3 class="widget-title">',
		  //   'after_title'   => '</h3>',
		  // ) );
		  register_sidebar( array(
		    'name'          => __( 'Chèn code', 'rt-theme' ),
		    'id'            => 'footer-code',
		    'description'   => __( 'Chèn code ẩn', 'rt-theme' ),
		    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		    'after_widget'  => '</aside>',
		    'before_title'  => '<h3 class="widget-title">',
		    'after_title'   => '</h3>',
		  ) );
		  
			if ( $rt_option['top_bar'] == true ) {
			  register_sidebar( array(
			  	'name'			=> __('Top Bar', 'rt-theme'),
			  	'id'			=> 'top-bar',
			  	'description'	=> 'Trang chủ',
			  	'before_widget' =>'',
			  	'after_widget'	=>'',
			  	'before_title'	=>'',
			  	'after_widget'	=>'',
			  	) );
			}
}
add_action( 'widgets_init', 'rt_widgets_init' );

// widget before footer
function rt_set_before_footer_number() {
	global $rt_option;
	$number_bf = $rt_option['before_footer_widget'] ;
	$before_ft = ( $rt_option['before_footer_widget'] ) ? intval($rt_option['before_footer_widget']) : 1;
	if( $number_bf != 0 ){
		for ($number_column = 1; $number_column <= $before_ft ; $number_column++) { 
			__rt_widget_area()->widgets_settings['before-footer-'.$number_column] = array(
				'name'          => 'Trước chân trang '.$number_column.'',
				'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung chân trang.', 'rt-theme' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
				'before_wrapper' => '<div id="%1$s" class="rt-before-footer %2$s">',
				'after_wrapper'  => '</div>',
				'is_global'      => true,
			);
		}
	}
}
// column footer

function rt_set_footer_number() {
	global $rt_option;
	
	$column = ( $rt_option['footer_column'] ) ? intval($rt_option['footer_column']) : 1;

	for ($number_column = 1; $number_column <= $column ; $number_column++) { 
		__rt_widget_area()->widgets_settings['footer-'.$number_column] = array(
			'name'          => 'Cột '.$number_column.' Chân Trang',
			'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung chân trang.', 'rt-theme' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
			'before_wrapper' => '<div id="%1$s" class="rt-footer %2$s">',
			'after_wrapper'  => '</div>',
			'is_global'      => true,
		);
	}
}
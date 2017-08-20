<?php
/**
 * RT 2017
 */
// Remove Menu
global $rt_option;
function remove_menus() {
  remove_menu_page( 'edit-comments.php' );          //Comments
  //remove_menu_page( 'plugins.php' );
  remove_menu_page( 'update-core.php' );                  //Plugins
  //remove_menu_page( 'themes.php' );                 //Appearance
  //remove_menu_page( 'tools.php' );
}
add_action( 'admin_menu', 'remove_menus' );

// remove 
function my_remove_sub_menus() {
  global $submenu;
  remove_submenu_page( 'index.php', 'update-core.php' ); 
  if ( isset( $submenu[ 'themes.php' ] ) ) {
      foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) {
          if ( in_array( 'customize', $menu_item ) ) {
              unset( $submenu[ 'themes.php' ][ $index ] );
          }
      }
  }
  remove_submenu_page( 'themes.php', 'themes.php' ); 
  remove_submenu_page( 'users.php', 'users-user-role-editor.php' );
}
add_action( 'admin_menu', 'my_remove_sub_menus', 999 );

// remove widget
// remove widget default
function my_unregister_widgets() {
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Calendar');
}
add_action( 'widgets_init', 'my_unregister_widgets' );

// remove widgets not use to
function remove_woo_widgets() {
  unregister_widget( 'WC_Widget_Recent_Products' );
  unregister_widget( 'WC_Widget_Featured_Products' );
  unregister_widget( 'WC_Widget_Products' );
  unregister_widget( 'WC_Widget_Product_Categories' );
  unregister_widget( 'WC_Widget_Product_Tag_Cloud' );
  unregister_widget( 'WC_Widget_Cart' );
  unregister_widget( 'WC_Widget_Layered_Nav' );
  unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
  //unregister_widget( 'WC_Widget_Price_Filter' );
  unregister_widget( 'WC_Widget_Top_Rated_Products' );
  unregister_widget( 'WC_Widget_Recent_Reviews' );
  unregister_widget( 'WC_Widget_Recently_Viewed' );
  unregister_widget( 'WC_Widget_Best_Sellers' );
  unregister_widget( 'WC_Widget_Onsale' );
  //unregister_widget( 'WC_Widget_Random_Products' );
}
add_action( 'widgets_init', 'remove_woo_widgets' );

// shortcode to widget
add_filter('widget_text', 'do_shortcode');
// add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
add_filter('xmlrpc_enabled', '__return_false');

// the content limit
function the_content_limit($max_char, $more_link_text = '(more)', $stripteaser = 0, $more_file = '') { 
$content = get_the_content($more_link_text, $stripteaser, $more_file); 
$content = apply_filters('the_content', $content); $content = str_replace(']]>', ']]>', $content); 
$content = strip_tags($content); 
 if (strlen($_GET['p']) > 0) {
      echo $content;
   }
else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) { 
$content = substr($content, 0, $espacio); $content = $content; echo "<p>"; 
echo $content;
        echo "";
        echo "<br>";
        echo "<a class='read-more' href='";
        the_permalink();
        echo "'>".$more_link_text."</a></p>";
} }

// Add Metaslider
function add_slide() {
  $idsl = cs_get_option( 'mts_slides' );
  if(is_home() and !wp_is_mobile()) {
	  echo do_shortcode( "[metaslider id={$idsl}]" );
	}
}
add_action( 'rt_before_content', 'add_slide', 1 );

// breadcrumb
function rt_breadcrumb() {
  if(!is_home()) {
    if ( function_exists('yoast_breadcrumb') ) {
    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
    }
  }
}
if($rt_option['enable_breadcrumb']) {
  add_action( 'rt_before_layout', 'rt_breadcrumb', 1  );
}

// Add new Widget
function my_custom_sidebars() {
  /* Custom Widgets */
  $custom_sidebars = cs_get_option('add_widget');
  if ($custom_sidebars) {
   foreach($custom_sidebars as $custom_sidebar) :
   $heading = $custom_sidebar['title_widget'];
   $own_id = preg_replace('/[^a-z]/', "-", strtolower($heading));

  register_sidebar( array(
    'name' => __( $heading, 'text' ),
    'id' => $own_id,
    'description' => __( $custom_sidebar['custom_sidebar_desc'], 'text' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3><div class="title-bar"></div>',
   ) );
  endforeach;
  }
}
//add_action( 'init', 'my_custom_sidebars', 10);

// add css - js to admin
function add_my_js(){
  wp_enqueue_script( "my-upload", get_theme_file_uri( "/assets/js/upload.js"),  'jquery' );
  wp_enqueue_media();
}
add_action('admin_enqueue_scripts','add_my_js');

function my_custom_css() {
  wp_enqueue_style( "my-css", get_theme_file_uri( "/assets/css/admin.css") );
}
add_action('admin_head', 'my_custom_css');

// admin style options
add_action( 'admin_enqueue_scripts', 'load_options_styles' );
 function load_options_styles() {
   wp_enqueue_style( 'admin_css_options', get_template_directory_uri() . '/inc/options.css' );
 } 

if ( ! current_user_can('administrator') ) {
 // admin options
 add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
       function load_admin_styles() {
         wp_enqueue_style( 'admin_css_foo', get_template_directory_uri() . '/inc/options_admin.css' );
       } 
}

// add Widget 
// Wiget rebuild
require_once( dirname( __FILE__ ) . '/widgets/rt-support.php' );
require_once( dirname( __FILE__ ) . '/widgets/rt-image.php' );
require_once( dirname( __FILE__ ) . '/widgets/rt-facebook.php' );
require_once( dirname( __FILE__ ) . '/widgets/rt-product-slider.php' );
require_once( dirname( __FILE__ ) . '/widgets/rt-partner.php' );
require_once( dirname( __FILE__ ) . '/widgets/rt-archive.php' );
require_once( dirname( __FILE__ ) . '/widgets/rt-post-category.php' );


// search
function search_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_search) {
      $query->set('post_type', array( 'post', 'product' ) );
    }
  }
}
add_action('pre_get_posts','search_filter');

// add paren menu 
function get_term_top_most_parent( $term_id, $taxonomy ) {
    $parent  = get_term_by( 'id', $term_id, $taxonomy );
    while ( $parent->parent != 0 ){
        $parent  = get_term_by( 'id', $parent->parent, $taxonomy );
    }
    return $parent;
}  

<?php
/**
 * RT 2017
 */

if ( ! class_exists( 'RT_Theme_Setup' ) ) {

	class RT_Theme_Setup {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Holder for current dynamic_css module instance.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		public $dynamic_css = null;

		/**
		 * Sets up needed actions/filters for the theme to initialize.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			// Set the constants needed by the theme.
			add_action( 'after_setup_theme', array( $this, 'constants' ), -1 );

			// Load the core functions/classes required by the rest of the theme.
			add_action( 'after_setup_theme', array( $this, 'get_core' ), 0 );
			
			if ( ! defined( 'CS_VERSION' ) ) {
				
				// Load the installer codestar framework.
				add_action( 'after_setup_theme', array( $this, 'load_cs_framework' ), 1 );
			}


			// Language functions and translations setup.
			add_action( 'after_setup_theme', array( $this, 'l10n' ), 2 );

			// Handle theme supported features.
			add_action( 'after_setup_theme', array( $this, 'theme_support' ), 3 );

			// Load the theme includes.
			add_action( 'after_setup_theme', array( $this, 'includes' ), 4 );

			// Load function if change
			add_action( 'after_setup_theme', array( $this, 'load_function' ), 5 );

			add_action( 'after_setup_theme', array( $this, 'load_post_type' ), 6 );

			// Initialization of modules.
			add_action( 'after_setup_theme', array( $this, 'init' ), 10 );

			// Load admin files.
			add_action( 'wp_loaded', array( $this, 'admin' ), 1 );

			// Enqueue admin assets.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

			// Register public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 9 );

			// Enqueue public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 10 );

			// Overrides the load textdomain function for the 'cs-framework' domain.
			add_filter( 'override_load_textdomain', array( $this, 'override_load_textdomain' ), 5, 3 );
		}

		/**
		 * Defines the constant paths for use within the core and theme.
		 *
		 * @since 1.0.0
		 */
		public function constants() {
			global $content_width;

			/**
			 * Fires before definitions the constants.
			 *
			 * @since 1.0.0
			 */
			do_action( '__rt_constants_before' );

			$template  = get_template();
			$theme_obj = wp_get_theme( $template );

			/** Sets the theme version number. */
			define( '__RT_THEME_VERSION', $theme_obj->get( 'Version' ) );

			/** Sets the theme directory path. */
			define( '__RT_THEME_DIR', get_template_directory() );

			/** Sets the theme directory URI. */
			define( '__RT_THEME_URI', get_template_directory_uri() );

			/** Sets the theme assets URIs. */
			define( '__RT_THEME_CSS', trailingslashit( __RT_THEME_URI ) . 'assets/css' );
			define( '__RT_THEME_IMG', trailingslashit( __RT_THEME_URI ) . 'assets/images' );
			define( '__RT_THEME_JS', trailingslashit( __RT_THEME_URI ) . 'assets/js' );

			
			define( 'CS_ACTIVE_METABOX',    true );
			define( 'CS_ACTIVE_TAXONOMY',   true );
			define( 'CS_ACTIVE_SHORTCODE',  false );
			define( 'CS_ACTIVE_CUSTOMIZE',  false );
			
			// Sets the content width in pixels, based on the theme's design and stylesheet.
			if ( ! isset( $content_width ) ) {
				$content_width = 1000;
			}
		}

		/**
		 * Loads the core functions. These files are needed before loading anything else in the
		 * theme because they have required functions for use.
		 *
		 * @since  1.0.0
		 */
		public function get_core() {
			/**
			 * Fires before loads the core theme functions.
			 *
			 * @since 1.0.0
			 */
			do_action( '__rt_core_before' );
			
		}

		/**
		 * Include Codestar Framework
		 * @since 1.0.0
		 */
		public function load_cs_framework() {
			require_once trailingslashit( __RT_THEME_DIR ) . 'inc/cs-framework/cs-framework.php';
		}

		/**
		 * Loads the theme translation file.
		 *
		 * @since 1.0.0
		 */
		public function l10n() {
			/*
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 */
			load_theme_textdomain( 'rt', trailingslashit( __RT_THEME_DIR ) . 'languages' );
		}

		// add change function 
		public function load_function() {
			require_once trailingslashit( __RT_THEME_DIR ) . 'inc/function.php';
		}

		// add change function 
		public function load_post_type() {
			//require_once trailingslashit( __RT_THEME_DIR ) . 'inc/post-type.php';
		}
		/**
		 * Adds theme supported features.
		 *
		 * @since 1.0.0
		 */
		public function theme_support() {

			// Enable support for Post Thumbnails on posts and pages.
			add_theme_support( 'post-thumbnails' );

			// Enable HTML5 markup structure.
			add_theme_support( 'html5', array(
				'comment-list', 'comment-form', 'search-form', 'gallery', 'caption',
			) );

			// Enable default title tag.
			add_theme_support( 'title-tag' );

			// Enable post formats.
			add_theme_support( 'post-formats', array(
				'aside', 'gallery', 'image', 'link', 'quote', 'video', 'audio', 'status',
			) );

			// Enable custom background.
			add_theme_support( 'custom-background', array( 'default-color' => 'ffffff', ) );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			// Enable woocommerce
			if ( function_exists( 'WC' ) ) {
				add_theme_support( 'woocommerce' );
				// add_theme_support( 'wc-product-gallery-zoom' );
				// add_theme_support( 'wc-product-gallery-lightbox' );
				// add_theme_support( 'wc-product-gallery-slider' );
			}
		}

		/**
		 * Loads the theme files supported by themes.
		 *
		 * @since 1.0.0
		 */
		public function includes() {
			/**
			 * Include RT_Theme_Includes class
			 */
			require_once trailingslashit( __RT_THEME_DIR ) . 'inc/init.php';
		}

		/**
		 * Run initialization of modules.
		 *
		 * @since 1.0.0
		 */
		public function init() {
			

		}

		/**
		 * Load admin files for the theme.
		 *
		 * @since 1.0.0
		 */
		public function admin() {

			// Check if in the WordPress admin.
			if ( ! is_admin() ) {
				return;
			}
		}

		/**
		 * Enqueue admin-specific assets.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_admin_assets( $hook ) {

			$available_pages = array(
				'widgets.php',
			);

			if ( ! in_array( $hook, $available_pages ) ) {
				return;
			}

			//wp_enqueue_style( '__rt-admin-style', __RT_THEME_CSS . '/admin.min.css', array(), __RT_THEME_VERSION );
		}

		/**
		 * Register assets.
		 *
		 * @since 1.0.0
		 */
		public function register_assets() {
			global $rt_option;

			wp_register_style( 'bootstrap', __RT_THEME_CSS . '/bootstrap.min.css', array(), '3.3.7' );
			wp_register_style( 'font-awesome', __RT_THEME_CSS . '/font-awesome.min.css', array(), '4.7.0' );
			wp_register_style( 'slick', __RT_THEME_CSS . '/slick.min.css', array(), '1.6.0' );
			
			wp_register_style( 'default', __RT_THEME_CSS . '/default.css', array(), '1.0.0' );

			wp_register_style( 'rt-main', __RT_THEME_CSS . '/main.css', array(), '1.0.0' );

			wp_register_style( 'rt-widget', __RT_THEME_CSS . '/widget.css', array(), '1.0.0' );

			wp_register_style( 'rt-woo', __RT_THEME_CSS . '/woo.css', array(), '1.0.0' );

			wp_register_style( 'jquery-ui-base', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), '1.0.0' );
			if ( function_exists( 'WC' ) ) {
				if ( $rt_option['zoomimg'] == true ) {
					wp_register_style( 'cloudzoom', __RT_THEME_CSS . '/cloudzoom.css', array(), '1.0.0' );
					wp_register_style( 'thumbelina', __RT_THEME_CSS . '/thumbelina.css', array(), '1.0.0' );
				}
			}

			if ( ! $rt_option['responsive'] ) {
				wp_enqueue_style( 'rt-non-responsive', __RT_THEME_CSS . '/non-responsive.css', array(), '1.0.0' );
			}
			if ( $rt_option['sticky_nav_menu'] ) {

				wp_register_script( 'headroom',  __RT_THEME_JS . '/headroom.min.js', array( 'jquery' ), '0.9.3', true );

				wp_register_script( 'jQuery.headroom',  __RT_THEME_JS . '/jQuery.headroom.min.js', array( 'jquery' ), '0.9.3', true );

				wp_register_script( 'rt-sticky-nav-menu',  __RT_THEME_JS . '/sticky_nav_menu.min.js', array( 'jquery' ), '1.0.0', true );

			}
			
			if ( function_exists( 'WC' ) ) {

				if ( $rt_option['zoomimg'] == true ) {
					wp_register_script( 'cloudzoom', __RT_THEME_JS . '/cloudzoom.js', array( 'jquery' ), '1.0.0', true );
					wp_register_script( 'thumbelina', __RT_THEME_JS . '/thumbelina.js', array( 'jquery' ), '1.0.0', true );
				}
			}
			wp_register_script( 'slick', __RT_THEME_JS . '/slick.min.js', array( 'jquery' ), '1.0.0', true );
			wp_register_script( 'owl-js',  __RT_THEME_JS . '/owl.carousel.min.js', array( 'jquery' ), '1.0.0', true );
			wp_register_script( 'rt-main',  __RT_THEME_JS . '/main.js', array( 'jquery' ), '1.0.0', true );
			
		}

		/**
		 * Enqueue assets.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_assets() {
			global $rt_option;

			wp_enqueue_style( 'bootstrap' );
			wp_enqueue_style( 'default' );
			wp_enqueue_style( 'font-awesome' );
			wp_enqueue_style( 'slick' );
			wp_enqueue_style( 'jquery-ui-base' );
			if ( function_exists( 'WC' ) ) {
				if ( $rt_option['zoomimg'] == true ) {
					wp_enqueue_style( 'cloudzoom' );
					wp_enqueue_style( 'thumbelina' );
				}
			}
			wp_enqueue_style( 'rt-main' );
			wp_enqueue_style( 'rt-widget' );
			wp_enqueue_style( 'rt-woo' );

			if ( $rt_option['sticky_nav_menu'] ) {

				wp_enqueue_script( 'headroom');
				wp_enqueue_script( 'jQuery.headroom');
				wp_enqueue_script( 'rt-sticky-nav-menu');
			}
			if ( function_exists( 'WC' ) ) {
				if ($rt_option['tooltip']) {
					wp_enqueue_script( 'jquery-ui-tooltip' );
				}
				//if ($rt_option['tooltip']) {
				if(!wp_is_mobile()) {
					if ( $rt_option['zoomimg'] == true ) {
						wp_enqueue_script( 'cloudzoom' );
						wp_enqueue_script( 'thumbelina' );
					}
				}
				//}
				
			}
			
			wp_enqueue_script( 'slick' );
			wp_enqueue_script( 'owl-js');
			wp_enqueue_script( 'rt-main');

			wp_localize_script( 'rt-main', 'rt_main', array(
				'tooltip_on_off' => $rt_option['tooltip'],
				'tooltip_image'  => $rt_option['tooltip_image'],
				'tooltip_title'  => $rt_option['tooltip_title'],
				'tooltip_price'  => $rt_option['tooltip_price'],
				'thumbelina'     => $rt_option['thumbelina'],
			) );

			wp_add_inline_style( 'rt-main', $this->dynamic_css );
		}

		/**
		 * Overrides the load textdomain functionality when 'cs-framework' is the domain in use.
		 *
		 * @since  1.0.0
		 * @link   https://gist.github.com/justintadlock/7a605c29ae26c80878d0
		 * @param  bool   $override
		 * @param  string $domain
		 * @param  string $mofile
		 * @return bool
		 */
		public function override_load_textdomain( $override, $domain, $mofile ) {

			// Check if the domain is our framework domain.
			if ( 'cs-framework' === $domain ) {

				global $l10n;

				// If the theme's textdomain is loaded, assign the theme's translations
				// to the framework's textdomain.
				if ( isset( $l10n['rt'] ) ) {
					$l10n[ $domain ] = $l10n['rt'];
				}

				// Always override.  We only want the theme to handle translations.
				$override = true;
			}

			return $override;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}
}

/**
 * Returns instanse of main theme configuration class.
 *
 * @since  1.0.0
 * @return object
 */
function __rt_theme() {
	return RT_Theme_Setup::get_instance();
}

__rt_theme();

$rt_option = get_option( '_cs_options' );

function _print($s) {
	echo '<textarea>';
	print_r($s);
	echo '</textarea>';
}
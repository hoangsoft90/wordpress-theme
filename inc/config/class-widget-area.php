<?php
/**
 * Class for widget areas registration.
 *
 * @package    __RT
 * @subpackage Class
 */

if ( ! class_exists( '__Rt_Widget_Area' ) ) {

	class __Rt_Widget_Area {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * //
		 *
		 * @var string
		 */
		protected static $cache_setting = array();

		/**
		 * Settings.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		public $widgets_settings = array();

		/**
		 * Public holder thats save widgets state during page loading.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		public $active_sidebars = array();

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 * @since 1.0.1 Removed argument in constructor.
		 */
		function __construct() {
			add_action( 'widgets_init',            array( $this, 'register' ) );
			add_action( '__rt_render_widget_area', array( $this, 'render' ) );
		}

		/**
		 * Register widget areas.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function register() {
			global $wp_registered_sidebars;

			foreach ( $this->widgets_settings as $id => $settings ) {

				$number = ( isset( $settings['number'] ) ) ? $settings['number'] : 1;

				register_sidebars( $number, array(
					'name'          => $settings['name'],
					'id'            => $id,
					'description'   => $settings['description'],
					'before_widget' => $settings['before_widget'],
					'after_widget'  => $settings['after_widget'],
					'before_title'  => $settings['before_title'],
					'after_title'   => $settings['after_title'],
				) );

				if ( isset( $settings['is_global'] ) ) {
					$wp_registered_sidebars[ $id ]['is_global'] = $settings['is_global'];
				}
			}
		}

		/**
		 * Render widget areas.
		 *
		 * @since  1.0.0
		 * @param  string $area_id Widget area ID.
		 * @return void
		 */
		public function render( $area_id ) {

			if ( ! is_active_sidebar( $area_id ) ) {
				$this->active_sidebars[ $area_id ] = false;
				return;
			}

			$this->active_sidebars[ $area_id ] = true;

			// Conditional page tags checking.
			if ( isset( $this->widgets_settings[ $area_id ]['conditional'] )
				&& ! empty( $this->widgets_settings[ $area_id ]['conditional'] )
				) {

				$visibility = false;

				foreach ( $this->widgets_settings[ $area_id ]['conditional'] as $conditional ) {
					if ( is_callable( $conditional ) ) {
						$visibility = call_user_func( $conditional ) ? true : false;
					}

					if ( true === $visibility ) {
						break;
					}
				}

				if ( false === $visibility ) {
					return;
				}
			}

			$area_id        = apply_filters( '__rt_rendering_current_widget_area', $area_id );
			$before_wrapper = isset( $this->widgets_settings[ $area_id ]['before_wrapper'] ) ? $this->widgets_settings[ $area_id ]['before_wrapper'] : '<div id="%1$s" class="%2$s>"';
			$after_wrapper  = isset( $this->widgets_settings[ $area_id ]['after_wrapper'] ) ? $this->widgets_settings[ $area_id ]['after_wrapper'] : '</div>';

			$classes = array( $area_id, 'widget_wrap' );
			$classes = apply_filters( '__rt_widget_area_classes', $classes, $area_id );

			if ( is_array( $classes ) ) {
				$classes = join( ' ', $classes );
			}

			printf( $before_wrapper, $area_id, $classes );
				dynamic_sidebar( $area_id );
			printf( $after_wrapper );
		}

		/**
		 * Check if passed sidebar was already rendered and it's active.
		 *
		 * @since  1.0.0
		 * @param  string    $index Sidebar ID.
		 * @return bool|null
		 */
		public function is_active_sidebar( $index ) {

			if ( isset( $this->active_sidebars[ $index ] ) ) {
				return $this->active_sidebars[ $index ];
			}

			return null;
		}

		/**
		 * Get WP registered sidebar.
		 *
		 * @return array
		 */
		public static function registered_sidebars() {
			global $wp_registered_sidebars;

			$sidebars = array();

			foreach ( $wp_registered_sidebars as $id => $sidebar ) {
				$sidebars[ $id ] = $sidebar['name'];
			}

			return $sidebars;
		}

		/**
		 * Get sidebar name in current screen.
		 *
		 * @param string $name //
		 * @return string
		 */
		public static function get_sidebar( $name = '' ) {
			return static::has_sidebar() ? static::get_setting( $name ) : '';
		}

		/**
		 * Get sidebar area in current screen.
		 *
		 * @return string
		 */
		public static function get_sidebar_area() {
			return static::get_setting( 'area' );
		}

		/**
		 * If current screen is no sidebar.
		 *
		 * @return boolean
		 */
		public static function is_no_sidebar() {
			return static::get_setting( 'area' ) === 'none';
		}

		/**
		 * If current screen have a sidebar.
		 *
		 * @return boolean
		 */
		public static function has_sidebar( $name = '' ) {
			if ( 'left_sidebar_name' == $name ) {
				$sidebar = static::get_setting( 'left_sidebar_name' );
			} elseif ( 'right_sidebar_name' == $name ) {
				$sidebar = static::get_setting( 'right_sidebar_name' );
			} else {
				$sidebar = static::get_setting( 'area' ) !== 'none';
			}

			if ( ! empty( $sidebar ) ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Get sidebar setting in current screen.
		 *
		 * @param  string $get Key name to get.
		 * @return string|array
		 */
		public static function get_setting( $get = null ) {
			if ( $setting = static::$cache_setting ) {
				return isset( $setting[ $get ] ) ? $setting[ $get ] : $setting;
			}

			/**
			 * //
			 *
			 * @var array
			 */
			$default = array(
				'left_sidebar_name'  => 'sidebar-1',
				'right_sidebar_name' => 'sidebar-2',
				'area'               => 'left',
			);

			global $rt_option;

			$options = array(
				'layout_front' => array( 'area' => $rt_option['layout_home']),
				'layout_home' => array( 'area' => $rt_option['layout_home']),
				'layout_category' => array( 'area' => $rt_option['layout_category']),
				'layout_archive' => array( 'area' => $rt_option['layout_archive']),
				'layout_single' => array( 'area' => $rt_option['layout_single']),
				'layout_page' => array( 'area' => $rt_option['layout_page']),
				'layout_product_cat' => array( 'area' => $rt_option['layout_product_cat']),
				'layout_product' => array( 'area' => $rt_option['layout_product']),
			);

			foreach ( static::allowed_pages() as $id => $name ) {
				if ( isset( $options[ $id ] ) ) {
					$options[ $id ] = wp_parse_args( $options[ $id ], $default );
				} else {
					$options[ $id ] = $default;
				}
			}

			/**
			 * //
			 *
			 * @var array
			 */
			$setting = $default;

			if ( is_category() || is_tag() || is_tax() || is_post_type_archive() ) {

				$setting = $options['layout_category']; // Change "archive" to "category" if Category enable.

				$term = get_queried_object();
				$meta_data = get_term_meta( $term->term_id, 'rt_sidebar', true );

				if ( is_array( $meta_data ) && ! empty( $meta_data['is_overwrite'] ) ) {
					unset( $meta_data['is_overwrite'] );
					$setting = wp_parse_args( $meta_data, $options['layout_archive'] ); // Change "archive" to "category" if Category enable.
				}
			} elseif ( is_single() || is_page() || is_search() && ! is_front_page() ) {

				$key = is_single() ? 'layout_single' : 'layout_page';
				$setting = $options[ $key ];

				$meta_data = get_post_meta( get_the_ID(), 'rt_sidebar', true );

				if ( is_array( $meta_data ) && ! empty( $meta_data['is_overwrite'] ) ) {
					unset( $meta_data['is_overwrite'] );
					$setting = wp_parse_args( $meta_data, $options[ $key ] );
				}
			} elseif ( is_archive() || is_search() ) {

				$setting = $options['layout_archive'];

			} elseif ( is_home() ) {

				$setting = $options['layout_home'];

			} elseif ( is_front_page() ) {

				$setting = $options['layout_front'];
			} else {
				
				if ( class_exists( 'WC' ) ) {
					if( is_tax() ) {
						$setting = $options['layout_product_cat'];

						$term = get_queried_object();
						$meta_data = get_term_meta( $term->term_id, 'rt_sidebar', true );

						if ( is_array( $meta_data ) && ! empty( $meta_data['is_overwrite'] ) ) {
							unset( $meta_data['is_overwrite'] );
							$setting = wp_parse_args( $meta_data, $options['layout_product_cat'] ); // Change "archive" to "category" if Category enable.
						}
					} elseif ( is_product() ) {

						$meta_data = get_post_meta( get_the_ID(), 'rt_sidebar', true );

						if ( is_array( $meta_data ) && ! empty( $meta_data['is_overwrite'] ) ) {
							unset( $meta_data['is_overwrite'] );
							$setting = wp_parse_args( $meta_data, $options[ $key ] );
						}
					}
				}
			}

			/**
			 * //
			 *
			 * @var array
			 */
			static::$cache_setting = apply_filters( 'rt_get_sidebar_setting', $setting, $options );

			return isset( static::$cache_setting[ $get ] ) ? static::$cache_setting[ $get ] : static::$cache_setting;
		}

		/**
		 * Allowed pages can register in customizer.
		 *
		 * @return array
		 */
		protected static function allowed_pages() {
			return array(
				'layout_front'    => esc_html__( 'Trang Tĩnh', 'rt-theme' ),
				'layout_home'     => esc_html__( 'Trang Chủ', 'rt-theme' ),
				'layout_category' => esc_html__( 'Trang Chuyên mục', 'rt-theme' ),
				'layout_archive'  => esc_html__( 'Trang Lưu trữ chung', 'rt-theme' ),
				'layout_page'     => esc_html__( 'Trang', 'rt-theme' ),
				'layout_single'   => esc_html__( 'Bài viết', 'rt-theme' ),
				'layout_product_cat'     => esc_html__( 'Danh mục sản phẩm', 'rt-theme' ),
				'layout_product'   => esc_html__( 'Sản phẩm', 'rt-theme' ),
			);
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
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	function __rt_widget_area() {
		return __Rt_Widget_Area::get_instance();
	}

	__rt_widget_area();
}

<?php

add_action('widgets_init', create_function('', "register_widget('image_partner');" ));
class image_partner extends WP_Widget {

	function image_partner() {
		$widget_ops = array( 'classname' => 'img-partner', 'description' => __('Ảnh đối tác', 'rt-theme') );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'imgpartner' );
		$this->WP_Widget( 'imgpartner', __('RT - Ảnh slide đối tác', 'rt-theme'), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);

        $newtab = isset( $instance['newtab'] ) ? '1' : '0';
        $on_slide = isset( $instance ['slide'])? '1' : '0' ;
        $slide_vertical = isset( $instance ['slide_vertical']) ? '1' : '0';

		echo $before_widget;
        if(!empty($instance['title'])) {
            echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        }
            ?>
                <div class="image-partner">
                        <?php for($i = 0; $i < $instance['img_num']; $i++) : ?>
                        <div class="slide">
                            <div class="image-item">                                
                                <a href="<?php echo $instance['img_link_'.$i]; ?>"  <?php if ( $newtab == 1 ) echo 'target="_blank"'; ?> title="<?php echo $instance['img_title_'.$i]; ?>">
                                    <?php if(!empty($instance['img_title_'.$i])) { ?><p class="title"><?php echo $instance['img_title_'.$i]; ?></p> <?php } ?>
                                    <img src="<?php echo $instance['img_src_'.$i]; ?>" alt="<?php echo $instance['img_title_'.$i]; ?>" />
                                </a>
                                <?php if(!empty($instance['img_content_'.$i])) { ?><p class="content-partner"><?php echo $instance['img_content_'.$i]; ?></p><?php } ?>
                            </div>
                        </div>
                        <?php endfor; ?>
                </div>
                <?php if( $on_slide != 0): ?>
                    <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        "use strict";
                        jQuery('.image-partner').slick({
                            speed:1000,
                            autoplay:true,
                            autoplaySpeed: 1500,
                            vertical: <?php if( $slide_vertical != 0) echo "true";else echo "false"; ?>,
                            slidesToShow:<?php echo $instance['slide_numb']; ?>,
                            slidesToScroll:1,
                            arrows:true,
                            prevArrow:
                                        '<div class="slick-prev"></div>',
                            nextArrow:
                                        '<div class="slick-next"></div>',
                            
                            // prevArrow:
                            //             <?php 
                            //             if( $slide_vertical !=0 )
                            //             echo "'<div class='slick-prev'><i class='fa fa-arrow-left' aria-hidden='true'></i></div>'";
                            //             else echo "'<div class="slick-prev"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>'";     
                            //             ?>,
                            // nextArrow:
                            //             <?php  
                            //             if( $slide_vertical ==0 )
                            //             echo "'<div class='slick-next'><i class='fa fa-arrow-right' aria-hidden='true'></i></div>'";
                            //             else echo '<div class="slick-next"><i class="fa fa-arrow-down" aria-hidden="true"></i></div>';
                            //             ?>,
                        });
                    });
                    </script>
                <?php endif; ?>
            <?php

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
        ! empty( $new_instance['newtab'] ) ? 1 : 0;
        ! empty( $on_slide['slide'] ) ? 1: 0;
        ! empty( $slide_vertical['slide_vertical']) ? 1: 0;
        return $new_instance;
	}

	function form($instance) {

		// ensure value exists
		$instance = wp_parse_args( (array)$instance, array(
			'title' => '',
            'link' => '',
            'slide_numb' => 0,
            'img_num' => 0,
		) );
        $newtab = isset( $instance['newtab'] ) ? ( bool ) $instance['newtab'] : false;
        $on_slide = isset( $instance['slide'] ) ? ( bool ) $instance['slide'] : false;
        $slide_vertical = isset( $instance['slide_vertical'] ) ? ( bool ) $instance['slide_vertical'] : false;
?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Tiêu đề', 'rt-theme'); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:99%;" /></p>

        <p><label for="<?php echo $this->get_field_id('slide'); ?>"><?php _e('Bật slide chạy', 'rt-theme'); ?>  </label>
            <input type="checkbox" id="<?php echo $this->get_field_id('slide'); ?>" name="<?php echo $this->get_field_name('slide'); ?>" <?php checked( $on_slide ); ?> />
        </p>

        <p><label for="<?php echo $this->get_field_id('slide_vertical'); ?>"><?php _e('Slide chạy dọc(Mặc định chạy ngang)', 'rt-theme'); ?>  </label>
            <input type="checkbox" id="<?php echo $this->get_field_id('slide_vertical'); ?>" name="<?php echo $this->get_field_name('slide_vertical'); ?>" <?php checked( $slide_vertical ); ?> />
        </p>

        <p><label for="<?php echo $this->get_field_id('slide_numb'); ?>"><?php _e('Số ảnh hiển thị slide', 'rt-theme'); ?></label>
            <input type="number" min="0" max="30" id="<?php echo $this->get_field_id('slide_numb'); ?>" name="<?php echo $this->get_field_name('slide_numb'); ?>" value="<?php echo esc_attr( $instance['slide_numb'] ); ?>" style="width:20%" />
        </p>
        <p><label for="<?php echo $this->get_field_id('newtab'); ?>"><?php _e('Mở trong tab mới ?', 'rt-theme'); ?>  </label>
            <input type="checkbox" id="<?php echo $this->get_field_id('newtab'); ?>" name="<?php echo $this->get_field_name('newtab'); ?>" <?php checked( $newtab ); ?> />
        </p>

        <div style="overflow: hidden;"><label for="<?php echo $this->get_field_id('img_num'); ?>"><?php _e('Số lượng ảnh', 'rt-theme'); ?>:</label>
		<input type="number" min="0" max="30" id="<?php echo $this->get_field_id('img_num'); ?>" name="<?php echo $this->get_field_name('img_num'); ?>" value="<?php echo esc_attr( $instance['img_num'] ); ?>" style="width:20%" />

            <p class="alignright">
        		<img alt="" title="" class="ajax-feedback " src="<?php bloginfo('url'); ?>/wp-admin/images/wpspin_light.gif" style="visibility: hidden;" />
        		<input type="submit" value="Lưu" class="button-primary widget-control-save" id="savewidget" name="savewidget" />
            </p>
        </div>

        <?php for($i = 0; $i < $instance['img_num']; $i++) : ?>
        <div style="background: #F5F5F5; margin-bottom: 10px; padding: 10px;">
            <p><label for="<?php echo $this->get_field_id('img_title_'.$i); ?>"><?php _e('Tên đối tác ', 'rt-theme'); echo $i+1; ?>:</label>
              <input type="text" id="<?php echo $this->get_field_id('img_title_'.$i); ?>" name="<?php echo $this->get_field_name('img_title_'.$i); ?>" value="<?php echo esc_attr( $instance['img_title_'.$i] ); ?>" style="width:90%;" />
            </p>

            <p id="<?php echo $this->get_field_id('img_src_'.$i); ?>"><label for="<?php echo $this->get_field_id('img_src_'.$i); ?>"><?php _e('Nguồn ảnh ', 'rt-theme'); echo $i+1; ?>:</label>
		      <input class="rt-value-upload" type="text" id="<?php echo $this->get_field_id('img_src_'.$i); ?>" name="<?php echo $this->get_field_name('img_src_'.$i); ?>" value="<?php echo esc_attr( $instance['img_src_'.$i] ); ?>" style="width:70%;" />
              <input class="button rt-upload" type="button" value="Upload" style="width:25%;" />
            </p>

            <p><label for="<?php echo $this->get_field_id('img_link_'.$i); ?>"><?php _e('Liên kết đối tác ', 'rt-theme'); echo $i+1; ?>:</label>
        		<input type="text" id="<?php echo $this->get_field_id('img_link_'.$i); ?>" name="<?php echo $this->get_field_name('img_link_'.$i); ?>" value="<?php echo esc_attr( $instance['img_link_'.$i] ); ?>" style="width:90%;" />
            </p>

            <p><label for="<?php echo $this->get_field_id('img_content_'.$i); ?>"><?php _e('Nội dung giới thiệu ', 'rt-theme'); echo $i+1; ?>:</label>
                <input type="text" id="<?php echo $this->get_field_id('img_content_'.$i); ?>" name="<?php echo $this->get_field_name('img_content_'.$i); ?>" value="<?php echo esc_attr( $instance['img_content_'.$i] ); ?>" style="width:90%;" />
            </p>
        </div>
        <?php endfor; ?>

	<?php
	}

}
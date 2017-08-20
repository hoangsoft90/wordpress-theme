<?php

add_action('widgets_init', create_function('', "register_widget('Image_QC');" ));
class Image_QC extends WP_Widget {

	function Image_QC() {
		$widget_ops = array( 'classname' => 'img-qc', 'description' => __('Ảnh - Image', 'rt-theme') );
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'imgqc' );
		$this->WP_Widget( 'imgqc', __('RT - Ảnh quảng cáo', 'rt-theme'), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);

        $nofollow = isset( $instance['nofollow'] ) ? '1' : '0';
        $newtab = isset( $instance['newtab'] ) ? '1' : '0';

		echo $before_widget;

        echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
            ?>

                <div class="image-adv">
                        <?php for($i = 0; $i < $instance['img_num']; $i++) : ?>
                        <div class="image-item">
                            <a href="<?php echo $instance['img_link_'.$i]; ?>" rel="<?php if ( $nofollow == 1 ) echo 'nofollow'; ?>" <?php if ( $newtab == 1 ) echo 'target="_blank"'; ?> title="<?php echo $instance['img_title_'.$i]; ?>">
                                <img src="<?php echo $instance['img_src_'.$i]; ?>" alt="<?php echo $instance['img_title_'.$i]; ?>" />
                            </a>
                        </div>
                        <?php endfor; ?>
                </div>

            <?php

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
        ! empty( $new_instance['nofollow'] ) ? 1 : 0;
        ! empty( $new_instance['newtab'] ) ? 1 : 0;

        return $new_instance;
	}

	function form($instance) {

		// ensure value exists
		$instance = wp_parse_args( (array)$instance, array(
			'title' => '',
            'link' => '',
            'img_num' => 0
		) );

        $nofollow = isset( $instance['nofollow'] ) ? ( bool ) $instance['nofollow'] : false;
        $newtab = isset( $instance['newtab'] ) ? ( bool ) $instance['newtab'] : false;

?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Tiêu đề', 'rt-theme'); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:99%;" /></p>

        <p><label for="<?php echo $this->get_field_id('nofollow'); ?>"><?php _e('Nofollow ?', 'rt-theme'); ?>  </label>
            <input type="checkbox" id="<?php echo $this->get_field_id('nofollow'); ?>" name="<?php echo $this->get_field_name('nofollow'); ?>" <?php checked( $nofollow ); ?> />
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
            <p><label for="<?php echo $this->get_field_id('img_title_'.$i); ?>"><?php _e('Tiêu đề ảnh ', 'rt-theme'); echo $i+1; ?>:</label>
              <input type="text" id="<?php echo $this->get_field_id('img_title_'.$i); ?>" name="<?php echo $this->get_field_name('img_title_'.$i); ?>" value="<?php echo esc_attr( $instance['img_title_'.$i] ); ?>" style="width:90%;" />
            </p>

            <p id="<?php echo $this->get_field_id('img_src_'.$i); ?>"><label for="<?php echo $this->get_field_id('img_src_'.$i); ?>"><?php _e('Nguồn ảnh ', 'rt-theme'); echo $i+1; ?>:</label>
		      <input class="rt-value-upload" type="text" id="<?php echo $this->get_field_id('img_src_'.$i); ?>" name="<?php echo $this->get_field_name('img_src_'.$i); ?>" value="<?php echo esc_attr( $instance['img_src_'.$i] ); ?>" style="width:70%;" />
              <input class="button rt-upload" type="button" value="Upload" style="width:25%;" />
            </p>

            <p><label for="<?php echo $this->get_field_id('img_link_'.$i); ?>"><?php _e('Liên kết ảnh ', 'rt-theme'); echo $i+1; ?>:</label>
        		<input type="text" id="<?php echo $this->get_field_id('img_link_'.$i); ?>" name="<?php echo $this->get_field_name('img_link_'.$i); ?>" value="<?php echo esc_attr( $instance['img_link_'.$i] ); ?>" style="width:90%;" />
            </p>
        </div>
        <?php endfor; ?>

	<?php
	}

}
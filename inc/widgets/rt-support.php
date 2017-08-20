<?php
	/***************************
		Widget Name : Support oline
	*/
if ( ! function_exists('rt_support')) {
		add_action('widgets_init','rt_support');
			function rt_support(){
			register_widget('Gtid_Support_Online');
		}
}
class Gtid_Support_Online extends WP_Widget{
	function Gtid_Support_Online(){
		$widget_ops                = array(
			'classname'            => 'support-online-widget',
			'description'          => __('Add nick yahoo , skype on website','rt-theme')
		);
		$control_ops               = array(
			'width'                => 505,
			'height'               => 250,
			'id_base'              => 'support_online'
		);
		$this ->WP_Widget('support_online',__('RT: Hỗ trợ trực tuyến','rt-theme'),$widget_ops,$control_ops);
	}
	/***Gtid_Support_Online*/

	function widget($args, $instance){
		extract($args);
		$instance = wp_parse_args( (array)$instance, array(
			'title'                => '',
			'number_supporter'     => 1,
			'phone'                => '',
			'mail'                 => '',
			'data_style'           => '',
			'name'                 => '',
			'link_img'			   => '',
			)
		);
		$url = get_stylesheet_directory_uri();
		echo $before_widget;

		if ( !empty($instance['title'] ) ) {
			echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title ;
		}
		if ( !empty($instance['link_img'] ) ) {
			echo "<img class='support-img' src='".$instance['link_img']."'/>";
		}
		?>
		<div id="supporter-info" class="<?php echo $instance['data_style']; ?>">
			<?php
				$giaodien = substr($instance['data_style'], -1 );
				for($j = 1;$j<=$instance['number_supporter'];$j++){
					$name 		= $instance['supporter_'.$j.'_name'];
					$phone      = $instance['supporter_'.$j.'_phone'];
					$mail       = $instance['supporter_'.$j.'_mail'];
					$mail2      = $instance['supporter_'.$j.'_mail2'];
					$skype      = $instance['supporter_'.$j.'_skype'];
					$zalo       = $instance['supporter_'.$j.'_zalo'];
					$viber      = $instance['supporter_'.$j.'_viber'];
					$phone2     = $instance['supporter_'.$j.'_phone2'];
				?>
				<div id="support-<?php echo $j; ?>" class="supporter">
					<?php
						echo '<div class="info">';
							echo '<div class="support-rt">';
								if ( !empty( $name ) )  {
									echo '<span class="name-support">'.$name.'</span>';
								}
								if ( !empty( $phone ) ) {
									echo '<span class="phone-support phone-support_2 phone_support_3"><a href= tel:'.$phone.' ><i class="fa fa-phone-square" aria-hidden="true"></i>'.$phone.'</a></span>';
								}
									if ( in_array( $giaodien, array( 3,5,6 ) ) ) {
										echo"<div class='socical'>";
											 if ( !empty( $skype ) ): ?>
												<a href="<?php echo 'skype:'.$instance['supporter_'.$i.'_skype'].'?chat'; ?>">
													<img src="<?php echo $url.'/lib/css/images/icon-sky.png' ?>" style="border: none; width:auto; height: 24px;" width="100" height="24" alt="My status" />
												</a>
											<?php endif ?>
											<?php
											 if ( !empty( $zalo ) ): ?>
												<a href="<?php echo 'zalo:'.$instance['supporter_'.$i.'_zalo'].'?chat'; ?>">
													<img src="<?php echo $url.'/lib/css/images/icon-zl.png' ?>" style="border: none; width:auto; height: 24px;" width="100" height="24" alt="My status" />
												</a>
											<?php endif ?>
											<?php
											 if ( !empty( $viber ) ): ?>
												<a href="<?php echo 'viber:'.$instance['supporter_'.$i.'_viber'].'?chat'; ?>">
													<img src="<?php echo $url.'/lib/css/images/icon-vb.png' ?>" style="border: none; width:auto; height: 24px;" width="100" height="24" alt="My status" />
												</a>
											<?php endif ?>
											<?php echo "</div>" ; ?>
						<?php
									} // end social sky viber zalo
							echo '</div>'; // support-rt
							if ( !empty( $mail ) ) {
							echo '<span class="mail-support"><i class="fa fa-envelope" aria-hidden="true"></i>'.$mail.'</span>';
							}
							if ( !empty( $mail2 ) && !empty( $phone2 ) ) {
								echo'<div class="support-defaul">';
								echo '<span class="phone"><a href= tel:'.$phone2.' >'.$phone2.'</a></span>';
								echo '<span class="mail"><i class="fa fa-envelope" aria-hidden="true"></i>'.$mail2.'</span>';
								echo "</div>";
							}
						echo "</div>";// end info
				?>
				</div>  <!-- end supporter -->
				<?php
				} // end for
			?>
		</div> <!-- end supporter-info -->
		<?php
		echo $after_widget;
	}/***************widget****************/
	
	/****update*****/
	function update( $new_instance,$old_instance ){
		return $new_instance;
	}//update

	/*********form**********/
	function form( $instance ){
		$instance = wp_parse_args( ( array ) $instance ,array(
			'title'                => '',
			'number_supporter'     => 1,
			'phone'                => '',
			'mail'                 => '',
			'data_style'           => '',
			'link_img'             => '',
		));
		?>
		<p>
			<label for="<?php echo $this->get_field_id('number_supporter');?>" style="width:20%;display: inline-block;"><?php _e( 'Số hỗ trợ viên','genesis' );?></label>
			<input type="number" id="<?php echo $this->get_field_id('number_supporter');?>" name="<?php echo $this->get_field_name('number_supporter') ;?>" value="<?php echo esc_attr( $instance['number_supporter'] );?>" style="width:70%" path="note" />
		
		</p>
		<p>	
			<label for="<?php echo $this->get_field_id('giaodien');?>" style="width:20%;display: inline-block;"><?php _e( 'Giao diện','genesis' );?>:</label>
			<select id="<?php echo $this->get_field_id('data_style');?>" name="<?php echo $this->get_field_name('data_style') ;?>" style="width:70%">
				<?php
					for ($i=1; $i < 7 ; $i++): ?>
							<option value="gd_support_<?php echo $i ;?>" <?php selected( 'gd_support_'.$i, $instance['data_style']);?>>
								Style <?php echo $i;?>
							</option>
						<?php endfor;
				?>
			</select>
		</p>
		<p>
			<input type="submit" name="save-widget" class="button-primary widget-control-save" value="Lưu" />
		</p>
		<?php
		$html.= $this->rt_support_title( $title, $instance['title'] );
		$html.= $this->rt_support_img( $link_img, $instance['link_img'] );
		
		$giaodien = substr($instance['data_style'], -1 );
		 for($j = 1;$j<=$instance['number_supporter'];$j++){ ?>

			<div style="width: 47%; padding: 5px; margin: 5px 0; background: #eee; <?php echo $j % 2 ==0 ? 'float: right;' : 'float: left;'; ?>"  >
				<?php
					switch ($giaodien) {
						case '3':
							$html.= $this->rt_support_name( 'supporter_'.$j.'_name', $instance['supporter_'.$j.'_name']  , $j );
							$html.= $this->rt_support_phone( 'supporter_'.$j.'_phone',$instance['supporter_'.$j.'_phone'], $j );
							$html.= $this->rt_support_mail( 'supporter_'.$j.'_mail', $instance['supporter_'.$j.'_mail'] , $j );
							$html.= $this->rt_support_skype( 'supporter_'.$j.'_skype',$instance['supporter_'.$j.'_skype'], $j );
							$html.= $this->rt_support_zalo( 'supporter_'.$j.'_zalo',$instance['supporter_'.$j.'_zalo'], $j );
							$html.= $this->rt_support_viber( 'supporter_'.$j.'_viber',$instance['supporter_'.$j.'_viber'], $j );
							break;
						case '4':
							$html.= $this->rt_support_name( 'supporter_'.$j.'_name', $instance['supporter_'.$j.'_name']  , $j );
							$html.= $this->rt_support_phone( 'supporter_'.$j.'_phone',$instance['supporter_'.$j.'_phone'], $j );
							$html.= $this->rt_support_mail( 'supporter_'.$j.'_mail', $instance['supporter_'.$j.'_mail'] , $j );
							$html.= $this->rt_support_phone_2( 'supporter_'.$j.'_phone2',$instance['supporter_'.$j.'_phone2'], $j );
							$html.= $this->rt_support_mail2( 'supporter_'.$j.'_mail2', $instance['supporter_'.$j.'_mail2'] , $j );
							break;
						case '5':
							$html.= $this->rt_support_phone( 'supporter_'.$j.'_phone',$instance['supporter_'.$j.'_phone'], $j );
							$html.= $this->rt_support_mail( 'supporter_'.$j.'_mail', $instance['supporter_'.$j.'_mail'] , $j );
							$html.= $this->rt_support_zalo( 'supporter_'.$j.'_zalo',$instance['supporter_'.$j.'_zalo'], $j );
							$html.= $this->rt_support_viber( 'supporter_'.$j.'_viber',$instance['supporter_'.$j.'_viber'], $j );
							break;
						case '6':
							$html.= $this->rt_support_name( 'supporter_'.$j.'_name', $instance['supporter_'.$j.'_name']  , $j );
							$html.= $this->rt_support_phone( 'supporter_'.$j.'_phone',$instance['supporter_'.$j.'_phone'], $j );
							$html.= $this->rt_support_mail( 'supporter_'.$j.'_mail', $instance['supporter_'.$j.'_mail'] , $j );
							$html.= $this->rt_support_skype( 'supporter_'.$j.'_skype',$instance['supporter_'.$j.'_skype'], $j );
							break;
						default:
							$html.= $this->rt_support_name( 'supporter_'.$j.'_name', $instance['supporter_'.$j.'_name']  , $j );
							$html.= $this->rt_support_phone( 'supporter_'.$j.'_phone',$instance['supporter_'.$j.'_phone'], $j );
							$html.= $this->rt_support_mail( 'supporter_'.$j.'_mail', $instance['supporter_'.$j.'_mail'] , $j );
							break;
					}
				?>
			</div>
		<?php }
		 	
	}/***********************form*************
	/*********-----------------------------------------------------*********/
	function rt_support_title( $title, $value ){ ?>
			<p>
				<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="Tiêu đề Widget" default="Hỗ trợ trực tuyến" style="width:100%;"
				/></p>
		<?php 
	}
	function rt_support_img( $link_img, $value ){ 
		?>
            <p id="<?php echo $this->get_field_id('link_img'); ?>"><label for="<?php echo $this->get_field_id('link_img'); ?>">
		      <input class="rt-value-upload" type="text" id="<?php echo $this->get_field_id('link_img'); ?>" name="<?php echo $this->get_field_name('link_img'); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:70%;" />
              <input class="button rt-upload" type="button" value="Upload" style="width:25%;" />
            </p>
		<?php
	}
	function rt_support_name( $name, $value, $i ){ ?>
			<p><label for="<?php echo $this->get_field_id( $name ); ?>"><?php _e( 'Tên-'. $i .'', 'rt-theme' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( $name ); ?>" name="<?php echo $this->get_field_name( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;" /></p>	
		<?php
	}
	function rt_support_mail( $mail, $value, $i ){ ?>
			<p><label for="<?php echo $this->get_field_id( $mail ); ?>"><?php _e( 'Email-'. $i .'', 'rt-theme' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( $mail ); ?>" name="<?php echo $this->get_field_name( $mail ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;" /></p>	
	 	<?php
	}
	function rt_support_mail2( $mail2, $value, $i ){ ?>
		<p><label for="<?php echo $this->get_field_id( $mail2 ); ?>"><?php _e( 'Email 2-'. $i .'', 'rt-theme' ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id( $mail2 ); ?>" name="<?php echo $this->get_field_name( $mail2 ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;" /></p>	
		<?php 
	}
	function rt_support_phone( $phone, $value, $i ){ ?>
		<p><label for="<?php echo $this->get_field_id( $phone ); ?>"><?php _e( 'Số điện thoại-'.$i.'', 'rt-theme' ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id( $phone ); ?>" name="<?php echo $this->get_field_name( $phone ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;" /></p>
		<?php
	 }
	function rt_support_skype( $skype, $value, $i ){ ?>
		<p><label for="<?php echo $this->get_field_id( $skype ); ?>"><?php _e( 'Skype ID ', 'rt-theme' ); ?>:</label>
				<input type="text" id="<?php echo $this->get_field_id( $skype ); ?>" name="<?php echo $this->get_field_name( $skype ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;" /></p>
		<?php
	}
	function rt_support_phone_2( $phone2, $value, $i ){ ?>
		<p><label for="<?php echo $this->get_field_id( $phone2 ); ?>"><?php _e( 'Số điện thoại 2-'.$i.'', 'rt-theme'); ?>:</label>
		<input type="number" id="<?php echo $this->get_field_id( $phone2 ); ?>" name="<?php echo $this->get_field_name( $phone2 ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;" /></p>
		<?php
	}
	function rt_support_zalo( $zalo, $value, $i ){ ?>
		<p><label for="<?php echo $this->get_field_id( $zalo ); ?>"><?php _e( 'Zalo ', 'rt-theme' ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_zalo'); ?>" name="<?php echo $this->get_field_name( $zalo ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;" /></p>
		<?php
	}
	function rt_support_viber( $viber, $value, $i ){ ?>
		<p><label for="<?php echo $this->get_field_id( $viber ); ?>"><?php _e( 'viber ', 'rt-theme' ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_viber'); ?>" name="<?php echo $this->get_field_name( $viber ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;" /></p>
		<?php
	}

}/*********************Classs***********/

?>
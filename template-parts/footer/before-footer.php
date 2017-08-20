<?php
/**
 * Footer template part.
 *
 */


global $rt_option;
$num_bf = $rt_option['before_footer_widget'];
$before_ft = ( $rt_option['before_footer_widget'] ) ? intval($rt_option['before_footer_widget']) : 1;
if ( $num_bf != 0 ) :
	//echo "aa";

?>

<div class="before-footer clear">
	<div class="container">
		<div class="row">
			<?php
				for ($number_column = 1; $number_column <= $before_ft ; $number_column++) { 

					do_action( '__rt_render_widget_area', 'before-footer-'.$number_column );
					
				}
			?>
		</div>
	</div>
</div><!-- .bottom-footer -->
<?php endif; ?>
<?php
/**
 * Footer template part.
 *
 */


global $rt_option;

$column = ( $rt_option['footer_column'] ) ? intval($rt_option['footer_column']) : 1;

?>

<div class="footer-row row clear">
	<?php
		for ($number_column = 1; $number_column <= $column ; $number_column++) { 

			do_action( '__rt_render_widget_area', 'footer-'.$number_column );
			
		}
	?>
</div><!-- .bottom-footer -->
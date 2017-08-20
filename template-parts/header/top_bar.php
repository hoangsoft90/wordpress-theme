<?php
/**
 * Top bar
 */
global $rt_option;

if ( ! $rt_option['top_bar'] ) {
	return;
}
?>
	<div class="top_bar">
		<div class="container">
			<div class="row">
				<?php dynamic_sidebar( 'top-bar' ); ?>
			</div>
		</div>
	</div>
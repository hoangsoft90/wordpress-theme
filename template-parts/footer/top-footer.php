<?php
/**
 * Footer template part.
 *
 */
if (!is_active_sidebar('top-footer')) {
	return;
}
?>

<div class="top-footer row">

	<?php do_action( '__rt_render_widget_area', 'top-footer' ); ?>

</div><!-- .top-footer -->

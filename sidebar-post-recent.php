<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package universal-theme
 */

if ( ! is_active_sidebar( 'main-sidebar-top' ) ) {
	return;
}
?>

<div id="secondary" class="main-sidebar-top">
	<?php dynamic_sidebar( 'main-sidebar-top' ); ?>
</div><!-- #secondary -->

<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package universal-theme
 */

if ( ! is_active_sidebar( 'sidebar-post-recent' ) ) {
	return;
}
?>

<div id="secondary" class="sidebar-post-recent">
	<?php dynamic_sidebar( 'sidebar-post-recent' ); ?>
</div><!-- #secondary -->

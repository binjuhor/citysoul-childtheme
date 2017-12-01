<?php
/**
 * Functions for Citysoul child theme
 * @author Binjuhor - <binjuhor@gmail.com>
 */

function citysoul_child_theme_style() {
	wp_enqueue_style( 'citysoul_child-childtheme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'citysoul_child_theme_style' , 10);

/* Insert custom functions below */
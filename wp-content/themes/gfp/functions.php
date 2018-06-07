<?php

/*
==============================
ADD GLOBAL CSS TO PAGE
==============================
*/
function enqueue_global_css() {
    wp_enqueue_style('global', get_stylesheet_directory_URI() . '/dist/css/global.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_global_css');

/*
==============================
ADD GLOBAL JS TO PAGE
==============================
*/
function enqueue_global_js() {
  wp_enqueue_script('global', get_stylesheet_directory_URI() . '/dist/js/global.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_global_js');

/*
==========================================
CREATING ADMIN NAV MENUS
==========================================
*/
register_nav_menus( array(
  'eyebrow' => __( 'Eyebrow' ),  
  'site-header' => __( 'Site Header' )
) );


/*
==========================================
HIDE ADMIN BAR
==========================================
*/
add_filter('show_admin_bar', '__return_false');
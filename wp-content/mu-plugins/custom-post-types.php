<?php 

/**
 * Plugin Name:  GFP Custom Post Types
 * Description:  Create custom post types to manage sitewide promotions and more
 * Version:      1.0.0
 * Author:       Daniel Bell
 * Author URI:   https://github.com/danieljbell
 *
 * @link         https://github.com/danieljbell
 * @package      WordPress
 * @author       Daniel Bell
 * @version      1.0.0
 */


/*
==============================
REGISTER PROMOTIONS
==============================
*/
add_action( 'init', 'register_promotions_post_type' );
function register_promotions_post_type() {
  $labels = array(
    'name'                => 'Promotions',
    'singular_name'       => 'Promotion',
    'add_new'             => 'Add New Promotion',
    'add_new_item'        => 'Add New Promotion',
    'edit_item'           => 'Edit Promotion',
    'new_item'            => 'New Promotion',
    'all_items'           => 'All Promotions',
    'view_item'           => 'View Page',
    'search_items'        => 'Search Promotions',
    'not_found'           => 'No Promotions found',
    'not_found_in_trash'  => 'No Promotions found in Trash',
    'parent_item_colon'   => '',
    'menu_name'           => 'Promotions'
  );
  $args = array(
    'labels'      => $labels,
    'public'      => false,
    'show_ui'     => true,
    'has_archive' => false,
    'with_front' => false,
    'menu_icon'   => 'dashicons-megaphone',
    'supports'    => array( 'title' ),
    // 'rewrite'            => array( 'slug' => 'resources/library' ),
    // 'capability_type' => 'library',
    'map_meta_cap' => true,
    'show_in_rest'       => true,
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    // 'capabilities' => array(
    // // meta caps (don't assign these to roles)
    // 'edit_post'              => 'edit_library',
    // 'read_post'              => 'read_library',
    // 'delete_post'            => 'delete_library',
    // // primitive/meta caps
    // 'create_posts'           => 'create_librarys',
    // // primitive caps used outside of map_meta_cap()
    // 'edit_posts'             => 'edit_librarys',
    // 'edit_others_posts'      => 'manage_librarys',
    // 'publish_posts'          => 'manage_librarys',
    // 'read_private_posts'     => 'read',
    // // primitive caps used inside of map_meta_cap()
    // 'read'                   => 'read',
    // 'delete_posts'           => 'manage_librarys',
    // 'delete_private_posts'   => 'manage_librarys',
    // 'delete_published_posts' => 'manage_librarys',
    // 'delete_others_posts'    => 'manage_librarys',
    // 'edit_private_posts'     => 'edit_librarys',
    // 'edit_published_posts'   => 'edit_librarys'
    // ),
  );
  register_post_type( 'promotions', $args );
}


/*
==============================
REGISTER ALERTS
==============================
*/
add_action( 'init', 'register_alerts_post_type' );
function register_alerts_post_type() {
  $labels = array(
    'name'                => 'Alerts',
    'singular_name'       => 'Alert',
    'add_new'             => 'Add New Alert',
    'add_new_item'        => 'Add New Alert',
    'edit_item'           => 'Edit Alert',
    'new_item'            => 'New Alert',
    'all_items'           => 'All Alerts',
    'view_item'           => 'View Alert',
    'search_items'        => 'Search Alerts',
    'not_found'           => 'No Alerts found',
    'not_found_in_trash'  => 'No Alerts found in Trash',
    'parent_item_colon'   => '',
    'menu_name'           => 'Alerts'
  );
  $args = array(
    'labels'      => $labels,
    'public'      => false,
    'show_ui'     => true,
    'has_archive' => false,
    'with_front' => false,
    'menu_icon'   => 'dashicons-megaphone',
    'supports'    => array( 'title', 'editor' ),
    // 'rewrite'            => array( 'slug' => 'resources/library' ),
    // 'capability_type' => 'library',
    'map_meta_cap' => true,
    'show_in_rest'       => true,
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    // 'capabilities' => array(
    // // meta caps (don't assign these to roles)
    // 'edit_post'              => 'edit_library',
    // 'read_post'              => 'read_library',
    // 'delete_post'            => 'delete_library',
    // // primitive/meta caps
    // 'create_posts'           => 'create_librarys',
    // // primitive caps used outside of map_meta_cap()
    // 'edit_posts'             => 'edit_librarys',
    // 'edit_others_posts'      => 'manage_librarys',
    // 'publish_posts'          => 'manage_librarys',
    // 'read_private_posts'     => 'read',
    // // primitive caps used inside of map_meta_cap()
    // 'read'                   => 'read',
    // 'delete_posts'           => 'manage_librarys',
    // 'delete_private_posts'   => 'manage_librarys',
    // 'delete_published_posts' => 'manage_librarys',
    // 'delete_others_posts'    => 'manage_librarys',
    // 'edit_private_posts'     => 'edit_librarys',
    // 'edit_published_posts'   => 'edit_librarys'
    // ),
  );
  register_post_type( 'alerts', $args );
}

<?php
/*
   Plugin Name: GFP-Sellerhub
   Version: 1.0.0
   Author: Daniel Bell
   Description: Provides a simplified (and faster) listing of parts at the custom endpoint site.com/wp-json/sellerhub/v1/products.  
   Text Domain: jsforwp-simple-posts-endpoint
   License: GPLv3
*/

defined( 'ABSPATH' ) or die( 'No direct access!' );

// Register the endpoint
function jsforwp_register_equipment() {
  register_rest_route( 'sellerhub/v1', '/products', [
    'methods' => 'GET',
    'callback' => 'jsforwp_simple_posts',
  ] );
}
add_action( 'rest_api_init', 'jsforwp_register_equipment' );

// Get simple posts
function jsforwp_simple_posts( $data ) {

  // Get all posts
  $args = [
    'numberposts'       => 1,
    'suppress_filters'  => true,
    'post_type'         => 'product'
  ];
  $posts = get_posts( $args );

  // If not posts, return null
  if ( empty( $posts ) ) {
    return null;
  }

  // If posts, setup simple posts
  $simple_posts = [];
  foreach( $posts as $post ) {
    
    $simple_post = [
      'id'            => $post->ID,
      'url'           => $post->guid,
      'title'         => $post->post_title,
      'price'         => number_format(get_post_meta($post->ID, '_regular_price')[0], 2, '.', ','),
      'thumb'         => get_the_post_thumbnail_url( $post->ID, 'full' ),
    ];

    if (get_post_meta($post->ID, 'used_equipment_is_sold')[0] !== 'yes') {
      array_push( $simple_posts, $simple_post );
    }

  }

  return $simple_posts;

}



function jsforwp_register_single_equipment() {
  register_rest_route( 'sellerhub/v1', '/products/(?P<sku>[a-zA-Z0-9-]+)', [
    'methods' => 'GET',
    'callback' => 'jsforwp_single_posts',
  ] );
}
add_action( 'rest_api_init', 'jsforwp_register_single_equipment' );

// Get simple posts
function jsforwp_single_posts( $data ) {

    // Get all posts
    $args = [
      'numberposts'       => 1,
      'suppress_filters'  => true,
      'post_type'         => 'product',
      's'                 => $data['sku']
    ];
    $posts = get_posts( $args );

    // If not posts, return null
    if ( empty( $posts ) ) {
      return null;
    }

    $single_post = array(
      'id' => $posts[0]->ID,
      'url' => $posts[0]->guid,
      'title' => $posts[0]->post_title,
      'price' => number_format(get_post_meta($posts[0]->ID, '_regular_price')[0], 2, '.', ','),
      'thumb' => get_the_post_thumbnail_url( $posts[0]->ID, 'full' ),
    );

  return $single_post;

}
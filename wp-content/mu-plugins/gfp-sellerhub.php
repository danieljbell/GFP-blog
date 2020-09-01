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


function get_google_data() {
  register_rest_route( 'sellerhub/v1', '/googledata', [
    'methods'   => 'POST',
    'callback'  => 'get_postdata_google'
  ] );
}
add_action( 'rest_api_init', 'get_google_data' );

function get_postdata_google ( $request ) {

  $offset = json_decode($request->get_body())->offset;

  $product_data = array();

  $posts = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => 100,
    'offset'    => $offset,
    'meta_query' => array(
      array(
        'key' => '_thumbnail_id',
        'compare' => 'EXISTS'
      ),
      array(
        'key' => 'nla_part',
        'value' => 'no'
      )
    )
  ));

  if ($posts->have_posts()) :
    while ($posts->have_posts()) : $posts->the_post();
      $prod = new stdClass();
      $prod->id = get_the_id();
      $terms = get_the_terms($prod->id, 'pa_brand');
      $prod_meta = get_post_meta($prod->id);
      $prod->sku = $prod_meta['_sku'][0];
      $prod->title = get_the_title();
      $prod->description = get_the_excerpt();
      $prod->url = get_the_permalink();
      $prod->price = $prod_meta['_regular_price'][0];
      $prod->img = get_the_post_thumbnail_url($prod->id);
      ($terms ? $prod->brand = $terms[0]->name : 'John Deere');
      array_push($product_data, $prod);
    endwhile;
  endif;

  // global $wpdb;
  // $results = $wpdb->get_results( $wpdb->prepare( 
  //   "
  //     SELECT * FROM wp_posts
  //     LEFT JOIN wp_postmeta ON ID = post_id
  //     WHERE post_type = %s
  //     AND meta_key = '_sku'
  //     LIMIT 1
  //   ", 
  //   'product'
  // ) );

  return array(
    'offset'  => $offset,
    'count'   => $posts->post_count,
    'posts'   => $product_data
  );

}
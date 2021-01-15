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

  global $wpdb;
  $result = $wpdb->get_results(
    $wpdb->prepare(
      "
        SELECT 
          wp.ID AS woo_id,
          pm1.meta_value AS sku,
          wp.post_title AS title,
          wp.post_excerpt AS description,
          REPLACE(wp.guid, 'blog.', '') AS url,
          pm3.meta_value AS price,
          CONCAT('https://greenfarmparts.com/wp-content/uploads/', am1.meta_value) AS img,
          wp_ship.rule_item_cost AS shipping
        FROM wp_posts AS wp
        LEFT JOIN wp_postmeta AS pm1 ON wp.ID = pm1.post_id
        LEFT JOIN wp_postmeta AS pm2 ON wp.ID = pm2.post_id
        LEFT JOIN wp_postmeta AS pm3 ON wp.ID = pm3.post_id
        LEFT JOIN wp_postmeta AS am1 ON am1.post_id = pm2.meta_value AND am1.meta_key = '_wp_attached_file'
        LEFT JOIN wp_woocommerce_per_product_shipping_rules AS wp_ship ON wp.ID = wp_ship.product_id
        WHERE post_type = 'product'
        AND post_status = 'publish'
        AND pm1.meta_key = '_sku'
        AND pm2.meta_key = '_thumbnail_id'
        AND pm2.meta_value IS NOT NULL
        AND pm3.meta_key = '_regular_price'
        LIMIT %d 
        OFFSET %d
      ",
      array(100, intval($offset))
    )
  );

  return array(
    'offset'  => $offset,
    'count'   => $wpdb->num_rows,
    'products'   => $result
  );

}

function get_nla_parts() {
  register_rest_route( 'sellerhub/v1', '/nla_parts', [
    'methods'   => 'POST',
    'callback'  => 'get_postdata_nla_parts'
  ] );
}
add_action( 'rest_api_init', 'get_nla_parts' );

function get_postdata_nla_parts ( $request ) {

  $offset = json_decode($request->get_body())->offset;
  $results = array();

  $posts = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => 100,
    'offset'    => $offset,
    'meta_query' => array(
      array(
        'key' => 'nla_part',
        'value' => 'yes'
      )
    )
  ));

  if ($posts->have_posts()) :
    while ($posts->have_posts()) : $posts->the_post();
      array_push($results, get_the_id());
    endwhile;
  endif;

  return array(
    'offset'  => $offset,
    'count'   => count($results),
    'total'   => $posts->found_posts,
    'results' => $results
  );

}

function get_oversized_shipping ( ) {
  register_rest_route( 'sellerhub/v1', '/oversize', [
    'methods'   => 'POST',
    'callback'  => 'get_oversized_shipping_data'
  ] );
}
add_action( 'rest_api_init', 'get_oversized_shipping' );

function get_oversized_shipping_data( $request ) {
  $offset = json_decode($request->get_body())->offset;
  $results = array();

  global $wpdb;
  $count = $wpdb->get_results( 
      "
          SELECT 
            COUNT(1) AS total
          FROM wp_woocommerce_per_product_shipping_rules
      "
  );
  $result = $wpdb->get_results(
    $wpdb->prepare(
      "
        SELECT * FROM wp_woocommerce_per_product_shipping_rules ORDER BY rule_id ASC LIMIT %d OFFSET %d
      ",
      array(100, intval($offset))
    )
  );

  return array(
    'offset'  => $offset,
    'count'   => $wpdb->num_rows,
    'total'   => $count[0],
    'results' => $result
  );
}
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

  $posts = new WP_Query(
    array(
      'post_type' => 'product',
      'posts_per_page' => 100,
      'offset'    => $offset,
      'meta_query' => array(
        array(
          'key' => '_thumbnail_id',
          'compare' => 'EXISTS'
        )
      )
    )
  );

  if ($posts->have_posts()) :
    while ($posts->have_posts()) : $posts->the_post();
      $prod = new stdClass();
      $prod->woo_id = get_the_id();
      $terms = get_the_terms($prod->woo_id, 'pa_brand');
      $prod_meta = get_post_meta($prod->woo_id);
      $prod->sku = $prod_meta['_sku'][0];
      $prod->title = get_the_title();
      $prod->description = get_the_excerpt();
      $prod->url = get_the_permalink();
      $prod->price = $prod_meta['_regular_price'][0];
      $prod->img = get_the_post_thumbnail_url($prod->woo_id);
      ($terms ? $prod->brand = $terms[0]->name : 'John Deere');
      array_push($product_data, $prod);
    endwhile;
  endif;

  return array(
    'offset'  => $offset,
    'count'   => $posts->post_count,
    'total'   => $posts->found_posts,
    'products'   => $product_data
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

function get_all_products ( ) {
  register_rest_route( 'sellerhub/v1', '/all-products', [
    'methods'   => 'GET',
    'callback'  => 'get_all_products_data'
  ] );
}
add_action( 'rest_api_init', 'get_all_products' );

function get_all_products_data( $request ) {
  $offset = intval($request['offset']);
  $product_data = array();

  $posts = new WP_Query(
    array(
      'post_type' => 'product',
      'posts_per_page' => 100,
      'offset'    => $offset
    )
  );

  if ($posts->have_posts()) :
    while ($posts->have_posts()) : $posts->the_post();
      $prod_meta = get_post_meta(get_the_id());
      $terms = get_the_terms($prod->woo_id, 'pa_brand');
      $image_url = get_the_post_thumbnail_url($prod->woo_id);
      if ($image_url === false) { $image_url = null; }

      $prod = new stdClass();
      $prod->woo_id = get_the_id();
      $prod->sku = $prod_meta['_sku'][0];
      $prod->title = get_the_title();
      $prod->description = get_the_excerpt();
      $prod->url = get_the_permalink();
      $prod->regular_price = floatval($prod_meta['_regular_price'][0]);
      $prod->sale_price = $prod_meta['_sale_price'][0] ? floatval($prod_meta['_sale_price'][0]) : null;
      $prod->img = $image_url;
      ($terms ? $prod->brand = str_replace('&nbsp;', ' ', $terms[0]->name) : 'John Deere');
      $prod->weight = floatval($prod_meta['_weight'][0]);
      $prod->height = floatval($prod_meta['_height'][0]);
      $prod->length = floatval($prod_meta['_length'][0]);
      $prod->width = floatval($prod_meta['_width'][0]);
      $prod->is_nla = $prod_meta['nla_part'][0] && $prod_meta['nla_part'][0] === 'yes' ? true : false;
      $prod->is_vendor = $prod_meta['vendor_part'][0] && $prod_meta['vendor_part'][0] === 'yes' ? true : false;
      $prod->is_vintage = $prod_meta['vintage_part'][0] && $prod_meta['vintage_part'][0] === 'yes' ? true : false;



      // if ($prod->woo_id === 1035217) {
        array_push($product_data, $prod);
      // }
    endwhile;
  endif;

  return array(
    'offset'  => $offset,
    'count'   => $posts->post_count,
    'total'   => $posts->found_posts,
    'products'   => $product_data
  );
}
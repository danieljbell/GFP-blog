<?php

/*
==============================
ADD GLOBAL CSS TO PAGE
==============================
*/
function enqueue_global_css() {
  wp_enqueue_style('global', get_stylesheet_directory_URI() . '/dist/css/global.css', array(), '1.0.17');
}
add_action('wp_enqueue_scripts', 'enqueue_global_css');

/*
==============================
ADD GLOBAL JS TO PAGE
==============================
*/
function enqueue_global_js() {
  wp_enqueue_script('global', get_stylesheet_directory_URI() . '/dist/js/global.js', array(), '1.0.17', true);
}
add_action('wp_enqueue_scripts', 'enqueue_global_js');

/*
==========================================
CREATING ADMIN NAV MENUS
==========================================
*/
register_nav_menus( array(
  'eyebrow' => __( 'Eyebrow' ),
  'shop-by-part' => __( 'Shop By Part' ),
  'shop-by-equipment' => __( 'Shop By Equipment' )
) );


/*
==========================================
HIDE ADMIN BAR
==========================================
*/
add_filter('show_admin_bar', '__return_false');


/*
=========================
ADDING POST FORMATS
=========================
*/
add_theme_support( 'post-formats', array( 'video' ) );

/*
==========================================
ADDS POST THUMBNAILS
==========================================
*/
add_theme_support( 'post-thumbnails' );


/*
=========================
OPTIONS PAGES
=========================
*/
if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page(array(
    'page_title'  => 'Global Blog Settings',
    'menu_title'  => 'Blog Settings',
    'menu_slug'   => 'global-blog-settings',
    'capability'  => 'edit_posts',
    'parent_slug' => 'edit.php',
    'redirect'    => false
  ));
  
}


/*
==========================================
REMOVE WP EMOJICONS
==========================================
*/
function disable_wp_emojicons() {
  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );










add_filter( 'posts_join', 'custom_posts_join', 10, 2 );
/**
 * Callback for WordPress 'posts_join' filter.'
 *
 * @global $wpdb
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 *
 * @param string $join The sql JOIN clause.
 * @param WP_Query $wp_query The current WP_Query instance.
 *
 * @return string $join The sql JOIN clause.
 */
function custom_posts_join( $join, $query ) {

    global $wpdb;

    if ( is_main_query() && is_search() ) {

        $join .= "
        LEFT JOIN
        (
            {$wpdb->term_relationships}
            INNER JOIN
                {$wpdb->term_taxonomy} ON {$wpdb->term_taxonomy}.term_taxonomy_id = {$wpdb->term_relationships}.term_taxonomy_id
            INNER JOIN
                {$wpdb->terms} ON {$wpdb->terms}.term_id = {$wpdb->term_taxonomy}.term_id
        )
        ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id ";

    }

    return $join;

}



add_filter( 'posts_where', 'custom_posts_where', 10, 2 );
/**
 * Callback for WordPress 'posts_where' filter.
 *
 * Modify the where clause to include searches against a WordPress taxonomy.
 *
 * @global $wpdb
 *
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 *
 * @param string $where The where clause.
 * @param WP_Query $query The current WP_Query.
 *
 * @return string The where clause.
 */
function custom_posts_where( $where, $query ) {

    global $wpdb;

    if ( is_main_query() && is_search() ) {

        // get additional where clause for the user
        $user_where = custom_get_user_posts_where();

        $where .= " OR (
                        {$wpdb->term_taxonomy}.taxonomy IN( 'category', 'post_tag' )
                        AND
                        {$wpdb->terms}.name LIKE '%" . esc_sql( get_query_var( 's' ) ) . "%'
                        {$user_where}
                    )";

    }

    return $where;

}

/**
 * Get a where clause dependent on the current user's status.
 *
 * @global $wpdb https://codex.wordpress.org/Class_Reference/wpdb
 *
 * @uses get_current_user_id()
 * @see http://codex.wordpress.org/Function_Reference/get_current_user_id
 *
 * @return string The user where clause.
 */
function custom_get_user_posts_where() {

    global $wpdb;

    $user_id = get_current_user_id();
    $sql     = '';
    $status  = array( "'publish'" );

    if ( $user_id ) {

        $status[] = "'private'";

        $sql .= " AND {$wpdb->posts}.post_author = {$user_id}";

    }

    $sql .= " AND {$wpdb->posts}.post_status IN( " . implode( ',', $status ) . " ) ";

    return $sql;

}


add_filter( 'posts_groupby', 'custom_posts_groupby', 10, 2 );
/**
 * Callback for WordPress 'posts_groupby' filter.
 *
 * Set the GROUP BY clause to post IDs.
 *
 * @global $wpdb https://codex.wordpress.org/Class_Reference/wpdb
 *
 * @param string $groupby The GROUPBY caluse.
 * @param WP_Query $query The current WP_Query object.
 *
 * @return string The GROUPBY clause.
 */
function custom_posts_groupby( $groupby, $query ) {

    global $wpdb;

    if ( is_main_query() && is_search() ) {
        $groupby = "{$wpdb->posts}.ID";
    }

    return $groupby;

}




// add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);

// function my_wp_nav_menu_objects( $items, $args ) {
  
//   // loop
//   foreach( $items as &$item ) {
    
//     // vars
//     $icon = get_field('image', $item);
    
    
//     // append icon
//     if( $icon ) {
      
//       $item->title = '<img src="' . $icon["sizes"]["thumbnail"] . '">' . $item->title;
      
//     }
    
//   }
  
  
//   // return
//   return $items;
  
// }

function new_submenu_class($menu) {    
    $menu = preg_replace('/ class="sub-menu"/','/ class="navigation--level-two" /',$menu);        
    return $menu;      
}

add_filter('wp_nav_menu','new_submenu_class');


/*
==============================
REMOVE WOOCOMMERCE STYLESHEETS
==============================
*/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/*
=====================================
CHANGE PLACEHOLDER IMAGE FOR PRODUCTS
=====================================
*/
add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');

function custom_woocommerce_placeholder_img_src( $src ) {
    // $upload_dir = wp_upload_dir();
    // $uploads = untrailingslashit( $upload_dir['baseurl'] );
    // replace with path to your image
    $src = '//fillmurray.com/300/300';
     
    return $src;
}

/*
================================
CHANGE THE BREADCRUMB SEPARATOR
================================
*/
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
function wcc_change_breadcrumb_delimiter( $defaults ) {
  // Change the breadcrumb delimeter from '/' to '>'
  $defaults['delimiter'] = '<span class="breadcrumb-delimiter">&gt;</span>';
  return $defaults;
}


add_action( 'woocommerce_template_single_title', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_template_single_rating', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_template_single_price', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_template_single_excerpt', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_template_single_meta', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_template_single_sharing', 'woocommerce_template_single_sharing', 50 );
add_action( 'woocommerce_template_single_add_to_cart', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_output_product_data_tabs', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_template_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_template_loop_product_link_close', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_template_loop_product_thumbnail', 'woocommerce_template_loop_product_thumbnail', 5 );
add_action( 'woocommerce_cart_totals', 'woocommerce_cart_totals', 10 );
add_action( 'woocommerce_checkout_login_form', 'woocommerce_checkout_login_form', 10 );
add_action( 'woocommerce_checkout_coupon_form', 'woocommerce_checkout_coupon_form', 10 );

add_action( 'woocommerce_catalog_ordering', 'woocommerce_catalog_ordering', 30 );



/*
==================================================
Removing the content editor for product pages
==================================================
*/
add_action( 'init', function() {
    remove_post_type_support( 'product', 'editor' );
}, 99);

// function remove_metaboxes() {
//      remove_meta_box( 'postcustom' , 'product' , 'normal' );
//      remove_meta_box( 'postexcerpt' , 'product' , 'normal' );
//      remove_meta_box( 'commentsdiv' , 'product' , 'normal' );
//      remove_meta_box( 'tagsdiv-product_tag' , 'product' , 'normal' );
// }
// add_action( 'add_meta_boxes' , 'remove_metaboxes', 50 );

// add_action( 'add_meta_boxes' , 'remove_metaboxes', 11 );
// Move Yoast to bottom
function yoasttobottom() {
  return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');


function get_cart() {
  $cart = WC()->instance()->cart;
  $response = $cart->get_cart();
  echo json_encode($response, true);
}


function remove_item_from_cart() {
  $cart = WC()->instance()->cart;
  $id = $_POST['product_id'];
  $cart_id = $cart->generate_cart_id($id);
  $cart_item_id = $cart->find_product_in_cart($cart_id);
  if ($cart_item_id) {
   $cart->set_quantity($cart_item_id, 0);
   echo 'product removed';
  } 
}

function add_item_to_cart() {
  $cart = WC()->instance()->cart;
  $id = $_POST['product_id'];
  $cart_id = $cart->generate_cart_id($id);
  $cart_item_id = $cart->find_product_in_cart($cart_id);
  $cart->add_to_cart($id, 1);
  $response = $cart->get_cart();
  echo json_encode($response, true);
}

function increment_item_in_cart() {
  $cart = WC()->instance()->cart;
  $id = $_POST['product_id'];
  $qty = $_POST['qty'];
  
  $cart_id = $cart->generate_cart_id($id);
  $cart_item_id = $cart->find_product_in_cart($cart_id);
  $cart->set_quantity($cart_item_id, $qty);

  echo json_encode($cart->get_cart());
}

function get_product_details() {
  $cart = WC()->instance()->cart;
  $cart_line_items = $cart->get_cart();
  $product_id = $_POST['product_id'];
  $product_details = array();
  foreach ($cart_line_items as $line_item) :
    $line_item_details = $line_item[data];
    $permalink = $line_item_details->get_permalink();
    $id = $line_item_details->get_id();
    $sku = strtoupper($line_item_details->get_sku());
    $name = $line_item_details->get_name();
    $name = str_replace('John Deere ', '', $name);
    $name = str_replace('Green Farm Parts ', '', $name);
    $name = str_replace('Frontier ', '', $name);
    $name = str_replace('A&I ', '', $name);
    $name = str_replace($sku, '', $name);
    $price = $line_item_details->get_regular_price();
    $sale_price = $line_item_details->get_sale_price();
    
    $single_product_details = array(
      'id'          => $id,
      'permalink'   => $permalink,
      'name'        => trim($name),
      'sku'         => $sku,
      'price'       => $price,
      'salePrice'   => $sale_price,
      'quantity'    => $line_item[quantity]
    );

    array_push($product_details, $single_product_details);
  endforeach;
  echo json_encode($product_details);
}

function find_product_by_sku() {
  $sku = $_POST['sku'];
  $resp = wc_get_product_id_by_sku($sku);
  echo $resp;
}


add_action('wp_ajax_get_cart', 'get_cart');
add_action('wp_ajax_nopriv_get_cart', 'get_cart');
add_action('wp_ajax_remove_item_from_cart', 'remove_item_from_cart');
add_action('wp_ajax_nopriv_remove_item_from_cart', 'remove_item_from_cart');
add_action('wp_ajax_add_item_to_cart', 'add_item_to_cart');
add_action('wp_ajax_nopriv_add_item_to_cart', 'add_item_to_cart');
add_action('wp_ajax_increment_item_in_cart', 'increment_item_in_cart');
add_action('wp_ajax_nopriv_increment_item_in_cart', 'increment_item_in_cart');
add_action('wp_ajax_get_product_details', 'get_product_details');
add_action('wp_ajax_nopriv_get_product_details', 'get_product_details');
add_action('wp_ajax_find_product_by_sku', 'find_product_by_sku');
add_action('wp_ajax_nopriv_find_product_by_sku', 'find_product_by_sku');



/*
========================================
ALLOW THEME TO INTERACT WITH WOOCOMMERCE
========================================
*/
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );





/*
==============================
CREATE CUSTOM FIELD FOR VENDOR
==============================
*/
function vendor_create_custom_field() {
  $select_field = array(
    'id' => 'vendor_selection',
    'label' => __( 'Select Vendor', 'textdomain' ),
    'desc_tip' => true,
    'description' => __( 'Enter the vendor for the product. Default: John Deere', 'ctwc' ),
    'options' => array(
      'john_deere' => __( 'John Deere', 'textdomain' ),
      'stens' => __( 'Stens', 'textdomain' ),
      'ai' => __( 'A&I', 'textdomain' ),
      'sunbelt' => __( 'Sunbelt', 'textdomain' ),
      'honda' => __( 'Honda', 'textdomain' ),
      'zglide_suspension' => __( 'ZGlide Suspension', 'textdomain' ),
      'green_farm_parts' => __( 'Green Farm Parts', 'textdomain' ),
      'frontier' => __( 'Frontier', 'textdomain' ),
    )
  );
 woocommerce_wp_select( $select_field );
}
add_action( 'woocommerce_product_options_general_product_data', 'vendor_create_custom_field' );


/*
============================
SAVE CUSTOM FIELD FOR VENDOR
============================
*/
function vendor_save_custom_field( $post_id ) {
 $product = wc_get_product( $post_id );
 $title = isset( $_POST['vendor_selection'] ) ? $_POST['vendor_selection'] : '';
 $product->update_meta_data( 'vendor_selection', sanitize_text_field( $title ) );
 $product->save();
}
add_action( 'woocommerce_process_product_meta', 'vendor_save_custom_field' );






/*
===========================================================================
SEARCH JSON FOR WP-API
@Link - https://benrobertson.io/wordpress/wordpress-custom-search-endpoint
===========================================================================
*/

/**
 * Register our custom route.
 */
function gfp_register_search_route() {
    register_rest_route('gfp/v1', '/search', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'gfp_ajax_search',
        'args' => gfp_get_search_args()
    ]);
}
add_action( 'rest_api_init', 'gfp_register_search_route');

/**
 * Define the arguments our endpoint receives.
 */
function gfp_get_search_args() {
    $args = [];
    $args['s'] = [
       'description' => esc_html__( 'The search term.', 'gfp' ),
       'type'        => 'string',
   ];

   return $args;
}

/**
 * Use the request data to find the posts we
 * are looking for and prepare them for use
 * on the front end.
 */
function gfp_ajax_search( $request ) {
    $posts = [];
    $results = [];
    // check for a search term
    if( isset($request['s'])) :

      $post_count = 10;
      
      // get posts
      $posts = get_posts([
        'posts_per_page' => $post_count,
        'post_type' => 'any',
        's' => $request['s'],
      ]);

      $tax_posts = get_posts([
        'posts_per_page' => $post_count,
        'post_type' => 'product',
        'tax_query' => array(
          array(
            'taxonomy' => 'product_tag',
            'field' => 'slug',
            'terms' => $request['s'],
          ),
        )
      ]);
      
      // set up the data I want to return
      foreach($posts as $post):
        $results[] = [
            'title' => $post->post_title,
            'link' => get_permalink( $post->ID ),
            'type' => $post->post_type
        ];
      endforeach;

      foreach($tax_posts as $post):
        $results[] = [
            'title' => $post->post_title,
            'link' => get_permalink( $post->ID ),
            'type' => $post->post_type
        ];
      endforeach;

    endif;

    if( empty($results) ) :
        return new WP_Error( 'front_end_ajax_search', 'No results');
    endif;

    return rest_ensure_response( $results );
}
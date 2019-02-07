<?php

add_action( 'login_enqueue_scripts', 'enqueue_my_script' );

function enqueue_my_script( $page ) {
    wp_enqueue_script( 'my-script', get_stylesheet_directory_URI() . '/dist/js/login.js', null, null, true );
}

/*
==============================
ADD GLOBAL CSS TO PAGE
==============================
*/
function enqueue_global_css() {
  wp_enqueue_style('global', get_stylesheet_directory_URI() . '/dist/css/global.css', array(), '1.0.13');
}
add_action('wp_enqueue_scripts', 'enqueue_global_css');

/*
==============================
ADD GLOBAL JS TO PAGE
==============================
*/
function enqueue_global_js() {
  wp_enqueue_script('global', get_stylesheet_directory_URI() . '/dist/js/global.js', array(), '1.0.13', true);

  // if (is_page_template( 'page-templates/check-order-status.php' ) || is_account_page()) {
    $translation_array = array(
      'ajax_url'   => admin_url( 'admin-ajax.php' ),
      'nonce'  => wp_create_nonce( 'nonce_name' )
    );
    wp_localize_script( 'global', 'ajax_order_tracking', $translation_array );
  // }
  
}
add_action('wp_enqueue_scripts', 'enqueue_global_js');


/*
=========================
CHANGE REDIRECT LOCATION
=========================
*/
function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        //check for subscribers
        if (in_array('administrator', $user->roles) || in_array('shop_manager', $user->roles)) {
            // redirect them to another URL, in this case, the homepage 
            $redirect_to = site_url() . '/wp-admin/admin.php?page=wc-reports';
        }
    }

    return $redirect_to;
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );


/*
==========================================
CREATING ADMIN NAV MENUS
==========================================
*/
register_nav_menus( array(
  'eyebrow' => __( 'Eyebrow' ),
  // 'shop-by-part' => __( 'Shop By Part' ),
  // 'shop-by-equipment' => __( 'Shop By Equipment' ),
  'homepage-promoted-categories' => __( 'Homepage Promoted Categories' )
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
  
  // acf_add_options_page(array(
  //   'page_title'  => 'Global Blog Settings',
  //   'menu_title'  => 'Blog Settings',
  //   'menu_slug'   => 'global-blog-settings',
  //   'capability'  => 'edit_posts',
  //   'parent_slug' => 'edit.php',
  //   'redirect'    => false
  // ));

  acf_add_options_page(array(
    'page_title'  => 'Global Shop Settings',
    'menu_title'  => 'Shop Settings',
    'menu_slug'   => 'global-shop-settings',
    'capability'  => 'edit_posts',
    'parent_slug' => 'edit.php?post_type=shop_order',
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
    $src = get_stylesheet_directory_URI() . '/dist/img/partPicComingSoon.jpg';
     
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
add_action( 'woocommerce_order_review', 'woocommerce_order_review', 10 );
add_action( 'woocommerce_checkout_payment', 'woocommerce_checkout_payment', 20 );



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


function formatCartItems($response) {
  $lineItems = array();

  foreach ($response as $key => $line_item) {
    $line_item_details = $line_item[data];
    $name = $line_item_details->get_name();
    $product_brands = get_terms('pa_brand');
    if ($product_brands) {
      foreach ($product_brands as $key => $brand) {
        $name = str_replace($brand->name . ' ', '', $name);
      }
    }
    if (has_post_thumbnail($line_item_details->get_id())) :
      $thumb = '<img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/' . $line_item_details->get_sku() . '-0.jpg" alt="' . $line_item_details->get_name() . '">';
    else :
      $thumb = '<img src="' . get_stylesheet_directory_URI() . '/dist/img/partPicComingSoon.jpg" alt="No Part Image">';
    endif;
    $singleLineItem = array(
      'productName'         => $name,
      'productID'           => $line_item_details->get_id(),
      'productKey'          => $line_item[key],
      'productSku'          => $line_item_details->get_sku(),
      'productQty'          => $line_item[quantity],
      'productRegularPrice' => number_format($line_item_details->get_regular_price(), 2, '.', ''),
      'productSalePrice'    => number_format($line_item_details->get_sale_price(), 2, '.', ''),
      'productImg'          => $thumb,
      'productPermalink'    => $line_item_details->get_permalink()
    );
    array_push($lineItems, $singleLineItem);

    // number_format((float)$wc_product->get_price(), 2, '.', '');
  }
  return $lineItems;
}

function add_item_to_cart_with_qty() {
  check_ajax_referer( 'nonce_name' );
  $sku = $_POST['sku'];
  $qty = $_POST['qty'];
  $wc_product_id = wc_get_product_id_by_sku($sku);
  $wc_product = wc_get_product($wc_product_id);
  if ($wc_product) {
    $cart = WC()->instance()->cart;
    $cart->add_to_cart($wc_product_id, $qty);
    
    if (has_post_thumbnail($wc_product->get_id())) :
      $thumb = '<img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/' . $wc_product->get_sku() . '-0.jpg" alt="' . $wc_product->get_name() . '">';
    else :
      $thumb = '<img src="' . get_stylesheet_directory_URI() . '/dist/img/partPicComingSoon.jpg" alt="No Part Image">';
    endif;

    wp_send_json(array(
      'id' => $wc_product->get_id(),
      'name' => $wc_product->get_name(),
      'link' => $wc_product->get_permalink(),
      'img' => $thumb,
      'price' => $wc_product->get_price()
    ));
  } else {
    wp_send_json(array(
      'status' => 'failed'
    ));
  }
}

function add_multiple_items() {
  check_ajax_referer( 'nonce_name' );
  $items = $_POST['items'];
  $cart = WC()->instance()->cart;
  foreach ($items as $key => $item) {
    $cart->add_to_cart($item['id'], $item['qty']);
  }
  wp_send_json(array(
    'success' => true
  ));
}


function get_product_info() {
  check_ajax_referer( 'nonce_name' );
  $sku = $_POST['sku'];
  $wc_product_id = wc_get_product_id_by_sku($sku);
  $wc_product = wc_get_product($wc_product_id);
  if ($wc_product) {
    if (has_post_thumbnail($wc_product->get_id())) :
      $thumb = '<img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/' . $wc_product->get_sku() . '-0.jpg" alt="' . $wc_product->get_name() . '">';
    else :
      $thumb = '<img src="' . get_stylesheet_directory_URI() . '/dist/img/partPicComingSoon.jpg" alt="No Part Image">';
    endif;
    $response = array(
      'id'    => $wc_product_id,
      'name' => $wc_product->get_name(),
      'link' => $wc_product->get_permalink(),
      'img' => $thumb,
      'price' => $wc_product->get_price()
    );
  } else {
    $response = array(
      'price' => '&ndash;'
    );
  }
  wp_send_json($response);
}

function get_cart() {
  check_ajax_referer( 'nonce_name' );
  $cart = WC()->instance()->cart;
  $response = $cart->get_cart();
  // wp_send_json($response);
  wp_send_json(array(
    'totals' => $cart->get_totals(),
    'lineItems' => formatCartItems($response)
  ));
}


function remove_item_from_cart() {
  // check_ajax_referer( 'nonce_name' );
  $cart = WC()->instance()->cart;
  $id = $_POST['product_id'];
  $key = $_POST['product_key'];
  $cart_item_id = $cart->find_product_in_cart($key);
  if ($cart_item_id) {
    $cart->set_quantity($cart_item_id, 0);
    // wp_send_json();
    wp_send_json(array(
      'subtotal' => $cart->get_totals()[subtotal],
      'lineItems' => formatCartItems($cart->get_cart())
    ));
  } 
  
}

function add_item_to_cart() {
  // check_ajax_referer( 'nonce_name' );
  $cart = WC()->instance()->cart;
  $id = $_POST['product_id'];
  $cart->add_to_cart($id, 1);
  $response = $cart->get_cart();
  wp_send_json(array(
    'subtotal' => $cart->get_totals()['subtotal'],
    'lineItems' => formatCartItems($cart->get_cart())
  ));
}

function increment_item_in_cart() {
  check_ajax_referer( 'nonce_name' );
  $cart = WC()->instance()->cart;
  $id = $_POST['product_id'];
  $key = $_POST['product_key'];
  $qty = $_POST['qty'];
  $cart_item_id = $cart->find_product_in_cart($key);
  $cart->set_quantity($cart_item_id, $qty);
  wp_send_json(array(
    'subtotal' => $cart->get_totals()[subtotal],
    'lineItems' => formatCartItems($cart->get_cart())
  ));
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
    $name = str_replace('Stens ', '', $name);
    $name = str_replace('Sunbelt ', '', $name);
    $name = str_replace('ZGlide Suspension ', '', $name);
    $name = str_replace('Honda ', '', $name);
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

function get_orders() {
  check_ajax_referer( 'nonce_name' );
  $email_address = $_POST['email_address'];
  $zipcode = $_POST['zipcode'];
  
  if (!$email_address && !$zipcode) {
    echo json_encode(array(
      'status'      => 'error',
      'messages'    => array(
        'email'     => 'Please provide an email address',
        'zipcode'   => 'Please provide a shipping zipcode'
      )
    ));
    die();
  }

  if (!$email_address) {
    echo json_encode(array(
      'status'      => 'error',
      'messages'    => array(
        'email'     => 'Please provide an email address',
      )
    ));
    die();
  }

  if (!$zipcode) {
    echo json_encode(array(
      'status'      => 'error',
      'messages'    => array(
        'zipcode'   => 'Please provide a shipping zipcode',
      )
    ));
    die();
  }

  $supplied_user = get_user_by('email', $email_address);
  if ($supplied_user) {
    $WC_user = new WC_Customer($supplied_user->ID);
    if ($zipcode === $WC_user->get_shipping_postcode()) {
      $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $supplied_user->data->ID,
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_order_statuses() ),
      ) );
      foreach ($customer_orders as $k => $customer_order) {
        $sequential_order = get_post_meta($customer_order->ID, '_order_number_formatted');
        $customer_orders[$k]->fancy = $sequential_order[0];
        // $customer_orders['asdfasdf'] = $customer_orders[$k]->post_status;
      }
      echo json_encode(array(
        'status'        => 'success',
        'email_address' => $email_address,
        'zipcode'       => $zipcode,
        'orders'        => $customer_orders,
        'user'          => array(
          'display_name'    => $WC_user->get_display_name(),
          'phone_number'    => $WC_user->get_billing_phone(),
          'email_address'   => $WC_user->get_email()
        )
      ));
    } else {
      echo json_encode(array(
        'status'      => 'error',
        'messages'    => array(
          'zipcode'   => 'Sorry, the email & shipping zipcode provided don\'t match any orders',
        )
      ));
    }
    die();
  } else {
    echo json_encode(array(
      'status'      => 'error',
      'messages'    => array(
        'zipcode'   => 'Sorry, the email & shipping zipcode provided don\'t match any orders',
      )
    ));
    die();
  }

  
}

function get_order_details() {
  check_ajax_referer( 'nonce_name' );
  $orderID = $_POST['orderID'];
  $order = wc_get_order( $orderID );
  $order_items = $order->get_items();
  $order_details = [];
  
  foreach ( $order_items as $item_id => $item ) {
    $product = $item->get_product();
    $qty = $item->get_quantity();
    $name = $item->get_name();
    $image = $product->get_image(array(100,100));
    $link = $product->get_permalink();
    $subtotal = $item->get_subtotal();
    $total = $item->get_total();
    $unit_price = $subtotal / $qty;
    array_push($order_details,array(
      "qty"         => $qty,
      "name"        => $name,
      "image"       => $image,
      "link"        => $link,
      "subtotal"    => $subtotal,
      "total"       => $total,
      "unit_price"  => $unit_price
    ));
  }

  echo json_encode($order_details);
  die();
}

function get_order_notes() {
  check_ajax_referer( 'nonce_name' );
  $order_id = $_POST['orderID'];
  $order = wc_get_order( $order_id );
  $order_notes = $order->get_customer_order_notes();
  $scrubbed_note = [];

  foreach ($order_notes as $note) {
    array_push($scrubbed_note, array(
      'commentAuthor'     => $note->comment_author,
      'commentAuthorImg'  => get_avatar($note->comment_author_email, 50, null, $note->comment_author),
      'commentDate'       => $note->comment_date_gmt,
      'commentContent'    => $note->comment_content
    ));
  }

  echo json_encode($scrubbed_note);
  die();
}


add_action('wp_ajax_get_product_info', 'get_product_info');
add_action('wp_ajax_nopriv_get_product_info', 'get_product_info');
add_action('wp_ajax_add_multiple_items', 'add_multiple_items');
add_action('wp_ajax_nopriv_add_multiple_items', 'add_multiple_items');
add_action('wp_ajax_add_item_to_cart_with_qty', 'add_item_to_cart_with_qty');
add_action('wp_ajax_nopriv_add_item_to_cart_with_qty', 'add_item_to_cart_with_qty');
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
add_action('wp_ajax_get_orders', 'get_orders');
add_action('wp_ajax_nopriv_get_orders', 'get_orders');
add_action('wp_ajax_get_order_details', 'get_order_details');
add_action('wp_ajax_nopriv_get_order_details', 'get_order_details');
add_action('wp_ajax_get_order_notes', 'get_order_notes');
add_action('wp_ajax_nopriv_get_order_notes', 'get_order_notes');
add_action('wp_ajax_send_order_comment', 'send_order_comment');
add_action('wp_ajax_nopriv_send_order_comment', 'send_order_comment');



/*
========================================
ALLOW THEME TO INTERACT WITH WOOCOMMERCE
========================================
*/
function mytheme_add_woocommerce_support() {
  add_theme_support( 'woocommerce' );
  // add_theme_support( 'wc-product-gallery-zoom' );
  // add_theme_support( 'wc-product-gallery-lightbox' );
  // add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );





if ( function_exists('register_sidebar') ) {
  register_sidebar(array(
      'name' => 'Product Filters',
      'id' => 'product_filters',
    ));

  register_sidebar(
    array(
    'name'  => 'Product Categories',
    'id'    => 'product_categories',
    )
  );

  register_sidebar(
    array(
    'name'  => 'Product Recommendations',
    'id'    => 'product_recommendations',
    )
  );

}







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
    // $results = [array(
    //   'term' => $request['s']
    // )];
    $results = [];
    // check for a search term
    if ( isset($request['s']) ) :

      if (!$_GET['per_page']) {
        $post_count = 10;
      } else {
        $post_count = $_GET['per_page'];
      }
      
      // get posts
      $posts = get_posts([
        'posts_per_page' => $post_count,
        'post_type' => 'post',
        's' => $request['s'],
      ]);

      $products = get_posts([
        'posts_per_page' => $post_count,
        'post_type' => 'product',
        's' => $request['s'],
      ]);

      $categories = get_categories(array(
        'taxonomy'      => 'product_cat',
        'name__like'    => $request['s'],
        'number'        => $post_count,
        'hide_empty'    => false
      ));
      
      
      // set up the data I want to return
      if ($posts) :
        foreach($posts as $post):
          $cat = get_the_category($post->ID);
          $slug = $cat[0]->slug;
          $title = $post->post_title;
          if ($slug === 'maintenance-reminder') {
            $title = $post->post_title;
            $title = str_replace('John Deere ', "", $title);
            $title = str_replace(' Maintenance Guide', "", $title);
          }
          $results[] = [
            'title' => $title,
            'link' => get_permalink( $post->ID ),
            'type' => ($slug === 'maintenance-reminder' ? 'model' : $post->post_type)
          ];
        endforeach;
      endif;

      if ($products) :
        foreach($products as $product):
          $product = new WC_product($product->ID);
          $attachmentIds = $product->get_gallery_attachment_ids();
          $imgURL = wp_get_attachment_url( $attachmentId[0] );
          $results[] = [
            'title' => $product->get_name(),
            'link' => $product->get_permalink(),
            'type' => 'product',
            'image' => $product->get_image('thumbnail')
          ];
        endforeach;
      endif;
      
      if ($categories) :
        foreach($categories as $cat):
          $name = $cat->category_nicename;
          $name = explode('-', $name);
          $name = implode(' ', $name);
          $thumb_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
          $image = wp_get_attachment_url( $thumb_id );
          if (!$image) {
            $image = get_stylesheet_directory_URI() . '/dist/img/partPicComingSoon.jpg';
          }
          $results[] = [
            'title' => ucwords($name),
            'link' => get_tag_link($cat->term_id),
            'type' => 'category',
            'image' => $image
          ];
        endforeach;
      endif;

      wp_send_json($results);

    endif;

    if( empty($results) ) :
        return new WP_Error( 'front_end_ajax_search', 'No results');
    endif;

    echo json_encode($results);
    die();
}


/*
=================================
CREATE CUSTOM FIELD FOR NLA PARTS
=================================
*/
function create_nla_parts() {
  global $woocommerce, $post;
  woocommerce_wp_checkbox(array( 
    'id'            => 'nla_part', 
    'wrapper_class' => 'show_if_simple', 
    'label'         => __('Part Is NLA', 'woocommerce' )
  ));
}
add_action( 'woocommerce_product_options_general_product_data', 'create_nla_parts' );

/*
==================================
SAVE CUSTOM FIELD FOR PRODUCT SUBS
==================================
*/
function save_nla_parts( $post_id ) {
 $woocommerce_checkbox = isset( $_POST['nla_part'] ) ? 'yes' : 'no';
  update_post_meta( $post_id, 'nla_part', $woocommerce_checkbox );
}
add_action( 'woocommerce_process_product_meta', 'save_nla_parts' );

/*
====================================
CREATE CUSTOM FIELD FOR PRODUCT SUBS
function create_replaced_by() {
  global $woocommerce, $post;
?>
<p class="form-field">
    <label for="replaced_by"><?php _e( 'Replaced By', 'woocommerce' ); ?></label>
    <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="replaced_by" name="replaced_by[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval( $post->ID ); ?>">
        <?php
            $product_ids = get_post_meta( $post->ID, 'replaced_by', true );

            foreach ( $product_ids as $product_id ) {
                $product = wc_get_product( $product_id );
                if ( is_object( $product ) ) {
                    echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
                }
            }
        ?>
    </select> <?php echo wc_help_tip( __( 'Select Products Here.', 'woocommerce' ) ); ?>
</p>

<?php
}
add_action( 'woocommerce_product_options_related', 'create_replaced_by' );
====================================
*/


/*
==================================
SAVE CUSTOM FIELD FOR PRODUCT SUBS
function save_replaced_by( $post_id ) {
 $product_field_type =  $_POST['replaced_by'];
    update_post_meta( $post_id, 'replaced_by', $product_field_type );
}
add_action( 'woocommerce_process_product_meta', 'save_replaced_by' );
==================================
*/



/*
========================================
CREATE CUSTOM FIELD FOR PRODUCT REPLACES
function create_replaces() {
  global $woocommerce, $post;
?>
<p class="form-field">
    <label for="replaces"><?php _e( 'Replaces', 'woocommerce' ); ?></label>
    <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="replaces" name="replaces[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval( $post->ID ); ?>">
        <?php
            $product_ids = get_post_meta( $post->ID, 'replaces', true );

            foreach ( $product_ids as $product_id ) {
                $product = wc_get_product( $product_id );
                if ( is_object( $product ) ) {
                    echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
                }
            }
        ?>
    </select> <?php echo wc_help_tip( __( 'Select Products Here.', 'woocommerce' ) ); ?>
</p>

<?php
}
add_action( 'woocommerce_product_options_related', 'create_replaces' );
========================================
*/

/*
======================================
SAVE CUSTOM FIELD FOR PRODUCT REPLACES
function save_replaces( $post_id ) {
 $product_field_type =  $_POST['replaces'];
    update_post_meta( $post_id, 'replaces', $product_field_type );
}
add_action( 'woocommerce_process_product_meta', 'save_replaces' );
======================================
*/




/*
============================================
CREATE CUSTOM FIELD FOR PRODUCT ALTERNATIVES
function create_product_alternatives() {
  global $woocommerce, $post;
?>
<p class="form-field">
    <label for="product_alternatives"><?php _e( 'Product Alternatives', 'woocommerce' ); ?></label>
    <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="product_alternatives" name="product_alternatives[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval( $post->ID ); ?>">
        <?php
            $product_ids = get_post_meta( $post->ID, 'product_alternatives', true );

            foreach ( $product_ids as $product_id ) {
                $product = wc_get_product( $product_id );
                if ( is_object( $product ) ) {
                    echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
                }
            }
        ?>
    </select> <?php echo wc_help_tip( __( 'Select Products Here.', 'woocommerce' ) ); ?>
</p>

<?php
}
add_action( 'woocommerce_product_options_related', 'create_product_alternatives' );
============================================
*/
function create_product_alternative_field() {
 $args = array(
 'id' => 'product_alternatives',
 'label' => __( 'Product Alternatives', 'cfwc' ),
 'desc_tip' => true,
 'description' => __( 'Separate SKUs by | with no spaces Ex: ABC123|DEF456|GHI789', 'ctwc' ),
 );
 woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_related', 'create_product_alternative_field' );

/*
==========================================
SAVE CUSTOM FIELD FOR PRODUCT ALTERNATIVES
function save_product_alternatives( $post_id ) {
 $product_field_type =  $_POST['product_alternatives'];
    update_post_meta( $post_id, 'product_alternatives', $product_field_type );
}
add_action( 'woocommerce_process_product_meta', 'save_product_alternatives' );
==========================================
*/
function save_product_alternatives( $post_id ) {
 $product = wc_get_product( $post_id );
 $title = isset( $_POST['product_alternatives'] ) ? $_POST['product_alternatives'] : '';
 $product->update_meta_data( 'product_alternatives', sanitize_text_field( $title ) );
 $product->save();
}
add_action( 'woocommerce_process_product_meta', 'save_product_alternatives' );



/*
=================================================
CHANGE DEFAULT HEADING TO H3 FOR PRODUCT LISTINGS
=================================================
*/
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
add_action('woocommerce_shop_loop_item_title', 'abChangeProductsTitle', 10 );
function abChangeProductsTitle() {
    echo '<h3 class="woocommerce-loop-product_title">' . get_the_title() . '</h3>';
}


/*
=========================
SEND COMMENT ON ORDER
=========================
*/
function send_order_comment() {
  check_ajax_referer( 'nonce_name' );
  // get all vars from the POST
  $contact_preference = $_POST['contact_preference'];
  $customer_name = $_POST['customer_name'];
  $email_address = $_POST['email_address'];
  $phone_number = $_POST['phone_number'];
  $message = $_POST['message'];
  $order_number = $_POST['order_number'];
  $redirect_location = $_POST['redirect_location'];

  $order_id = wc_seq_order_number_pro()->find_order_by_order_number( $order_number );

  $order = wc_get_order( $order_id );
  $order->add_order_note( $message );

  // FORMAT THE MESSAGE TO PASS TO FLOCK
  if ($contact_preference === 'phone') {
    $message = '<strong>' . $customer_name . ' asked:</strong><br/><em>' . $message . '</em><br/>' . 'Please contact ' . $customer_name . ' via ' . $contact_preference . ' at ' . $phone_number . '.';
  } else {
    $message = '<strong>' . $customer_name . ' asked:</strong><br/><em>' . $message . '</em><br/>' . 'Please contact ' . $customer_name . ' via ' . $contact_preference . ' at <a href=\"mailto:' . $email_address . '\">' . $email_address . '</a>.';
  }

  // PASS CUSTOMER NOTIFICATION TO FLOCK
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.flock.com/hooks/sendMessage/5188ba60-d5c2-40f2-9624-16ca3bdb17d5",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n\t\"attachments\": [{\n        \t\"views\": {\n        \t\"flockml\": \"<flockml>" . $message . "</flockml>\"\n    \t},\n    \t\"buttons\": [{\n    \t\t\"name\": \"Open Order\",\n    \t\t\"icon\": \"https://www.greenfarmparts.com/v/vspfiles/templates/gfp-test/img/GFP-logo.svg\",\n    \t\t\"action\": {\n    \t\t\t\"type\": \"openBrowser\",\n    \t\t\t\"url\": \"" . site_url() . "/wp-admin/post.php?post=" . $order_id . "&action=edit\"\n    \t\t}\n    \t}]\n    }]\n}",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache",
      "Content-Type: application/json",
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl); 

  echo json_encode(array(
    'status'               => 'success',
    'contact_preference'   => $contact_preference,
    'name'                 => $customer_name,
    'email_address'        => $email_address,
    'phone_number'         => $phone_number
  ));
  die();

}



if ( ! function_exists( 'is_woocommerce_activated' ) ) {
  function is_woocommerce_activated() {
    if ( class_exists( 'woocommerce' ) ) {
      function remove_output_structured_data() { 
        remove_action( 'wp_footer', array( WC()->structured_data, 'output_structured_data' ), 10 ); // Frontend pages 
        remove_action( 'woocommerce_email_order_details', array( WC()->structured_data, 'output_email_structured_data' ), 30 ); // Emails 
      } 
      add_action( 'init', 'remove_output_structured_data' );
    }
  }
}  





add_action( 'woocommerce_email_header', 'email_header_before', 1, 2 );
function email_header_before( $email_heading, $email ){
    $GLOBALS['email'] = $email;
}



/*
=========================
ALLOW SVG UPLOADS
@LINK - https://codepen.io/chriscoyier/post/wordpress-4-7-1-svg-upload
=========================
*/
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

  global $wp_version;
  if ( $wp_version !== '4.7.1' ) {
     return $data;
  }

  $filetype = wp_check_filetype( $filename, $mimes );

  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];

}, 10, 4 );

function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );






add_filter( 'woocommerce_get_sections_products' , 'shop_language_tab' );
function shop_language_tab( $settings_tab ){
     $settings_tab['shop_language'] = __( 'Shop Language' );
     return $settings_tab;
}

add_filter( 'woocommerce_get_settings_products' , 'shop_language_get_settings' , 10, 2 );
function shop_language_get_settings( $settings, $current_section ) {
         $custom_settings = array();
         if( 'shop_language' == $current_section ) {
              $custom_settings =  array(
                array(
                  'name' => __( 'Order Complete' ),
                  'type' => 'title',
                  'desc' => __( 'Text displayed to customers when order completed.' ),
                  'id'   => 'order_complete' 
                 ),
                array(
                  'name' => __( 'Order Review' ),
                  'type' => 'textarea',
                  'desc' => __( 'Message to display in the order review box'),
                  'desc_tip' => true,
                  'id'  => 'order_review'
                ),
                array(
                  'name' => __( 'Tracking Information' ),
                  'type' => 'textarea',
                  'desc' => __( 'Message to display in the tracking information box'),
                  'desc_tip' => true,
                  'id'  => 'tracking_information'
                ),
                array(
                  'type' => 'sectionend',
                  'id' => 'order_complete'
                ),
            );
         return $custom_settings;
       } else {
          return $settings;
       }
}

function wcpp_custom_style() {?>
  <style>
    textarea[name="order_review"],
    textarea[name="tracking_information"] {
      width: 100% !important;
      min-height: 100px;
    }
  </style>
<?php
}
add_action('admin_head', 'wcpp_custom_style');




/*
=========================
ADD EXCERPTS FOR PAGES
=========================
*/
add_post_type_support( 'page', 'excerpt' );





// add_action('pre_get_posts','shop_filter_cat');

//  function shop_filter_cat($query) {
//     if (is_post_type_archive( 'product' ) && $query->is_main_query()) {
//       $query->query_vars[‘product_cat’] = $_GET['product_cat']; 
//     }
//  }

/**
 * Unhook and remove WooCommerce default emails.
 */
add_action( 'woocommerce_email', 'unhook_those_pesky_emails' );

function unhook_those_pesky_emails( $email_class ) {

    /**
     * Hooks for sending emails during store events
     **/
    remove_action( 'woocommerce_low_stock_notification', array( $email_class, 'low_stock' ) );
    remove_action( 'woocommerce_no_stock_notification', array( $email_class, 'no_stock' ) );
    remove_action( 'woocommerce_product_on_backorder_notification', array( $email_class, 'backorder' ) );
    
    // New order emails
    remove_action( 'woocommerce_order_status_pending_to_processing_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_pending_to_completed_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_failed_to_processing_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_failed_to_completed_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_failed_to_on-hold_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    
    // Processing order emails
    remove_action( 'woocommerce_order_status_pending_to_processing_notification', array( $email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );
    
    // Completed order emails
    remove_action( 'woocommerce_order_status_completed_notification', array( $email_class->emails['WC_Email_Customer_Completed_Order'], 'trigger' ) );
      
    // Note emails
    remove_action( 'woocommerce_new_customer_note_notification', array( $email_class->emails['WC_Email_Customer_Note'], 'trigger' ) );
}



// add_filter('woocommerce_get_catalog_ordering_args', 'am_woocommerce_catalog_orderby');
// function am_woocommerce_catalog_orderby( $args ) {
//     $args['meta_key'] = '_thumbnail_id';
//     $args['orderby'] = 'meta_value';
//     // $args['order'] = 'asc'; 
//     return $args;
// }
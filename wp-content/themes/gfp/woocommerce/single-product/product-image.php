<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.2
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
  return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
  'woocommerce-product-gallery',
  'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
  'woocommerce-product-gallery--columns-' . absint( $columns ),
  'images',
) );
?>
<div class="asdfsticky--container">
  <div class="asdfsticky--element">
    <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
      <figure class="woocommerce-product-gallery__wrapper">
        <?php
        if ( has_post_thumbnail() ) {
          // $html  = wc_get_gallery_image_html( $post_thumbnail_id, true );
          // print_r();
          // echo '<img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_overlay,l_sample/v1542129610/' . $product->get_sku() . '-' . $i . '.jpg" />';
          // https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:20/fl_tiled,l_overlay,o_15/03h1505-0.jpg
          echo '<a href="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30/fl_tiled,l_overlay,o_10/' . $product->get_sku() . '-0.jpg" data-modal-launch="display-product-image"><img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30/fl_tiled,l_overlay,o_10/' . $product->get_sku() . '-0.jpg" class="wp-post-image" alt="' . $product->get_sku() . '-0" title="' . $product->get_sku() . '-0.jpg"></a>';
        } else {
          $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
          $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
          $html .= '</div>';
        }
    
        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
    
        do_action( 'woocommerce_product_thumbnails' );
        ?>
      </figure>
    </div>
  </div>
  <?php
  // $arrContextOptions=array(
  //   "ssl"=>array(
  //     "verify_peer"=>false,
  //     "verify_peer_name"=>false,
  //   ),
  // );  

  $response = file_get_contents(get_stylesheet_directory_uri() . '/config.php', false, stream_context_create($arrContextOptions));
  $lines = explode(PHP_EOL, $response);
  $rfe_ck = '';
  $rfe_cs = '';
  foreach ($lines as $key => $line) {
    $thing = explode('=', $line);
    if ($thing[0] === 'rfe_consumer_key') {
      $rfe_ck = $thing[1];
    }
    if ($thing[0] === 'rfe_consumer_secret') {
      $rfe_cs = $thing[1];
    }
  }

  $url = "https://www.reynoldsfarmequipment.com/equipment/wp-json/wc/v3/products?consumer_key=$rfe_ck&consumer_secret=$rfe_cs&per_page=5";
        $getJSON = curl_init();
        curl_setopt($getJSON, CURLOPT_URL, $url);
        curl_setopt($getJSON, CURLOPT_HEADER, 0);
        curl_setopt($getJSON, CURLOPT_RETURNTRANSFER, 1);
        
        $usedEquip = curl_exec($getJSON);
        $usedEquip = json_decode($usedEquip);
        
        if ($usedEquip && count($usedEquip) > 0) {
          echo '<div class="rfe-used-equip box--with-header mar-t--more">';
            echo '<h3 class="has-text-center">Interested in Used Equipment?</h3>';
            echo '<p class="has-text-center mar-b"><small>Used Equipment brought to you by:</small><br><a href="https://www.reynoldsfarmequipment.com/equipment/category/used?utm_medium=GFP&utm_source=' . get_the_permalink() . '&utm_campaign=used_on_gfp"><img src="https://www.reynoldsfarmequipment.com/wp-content/themes/rfe/dist/img/reynolds-logo.svg" alt="Reynolds Farm Equipment" style="max-width: 125px; display: inline-block; margin-top: 5px;"></p>';
            echo '<ul class="used-equip--list">';
              foreach ($usedEquip as $key => $equip) {
                echo '<li class="used-equip--item"><a href="' . $equip->permalink . '?utm_medium=GFP&utm_source=' . get_the_permalink() . '&utm_campaign=used_on_gfp">';
                  echo '<div class="used-equip--image">';
                    echo '<img src="' . $equip->images[0]->src . '" alt="' . $equip->name . '">';
                  echo '</div>';
                  echo '<h4>' . $equip->name . '</h4>';
                  if ($equip->price !== $equip->regular_price) {
                    echo '<p>Price: <del>$' . number_format($equip->regular_price, "2", '.', ',') . '</del><ins>$' . number_format($equip->price, '2', '.', ',') . '</ins></p>';
                  } else {
                    echo '<p>Price: $' . number_format($equip->regular_price, "2", '.', ',') . '</p>';
                  }
                  echo '<p class="btn-solid--brand mar-t"><small>See More Details</small></p>';
                echo '</a></li>';
              }
            echo '</ul>';
          echo '</div>';
        }
  ?>
</div>
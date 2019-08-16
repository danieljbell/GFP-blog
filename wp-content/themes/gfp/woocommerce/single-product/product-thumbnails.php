<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see       https://docs.woocommerce.com/document/template-structure/
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     3.3.2
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
  return;
}

global $product;

$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids && has_post_thumbnail() ) {
  $i = 1;
  echo '<ul class="woocommerce-product-gallery__thumbs">';
    echo '<li>' . apply_filters( 'woocommerce_single_product_image_thumbnail_html', '<img src="https://res.cloudinary.com/greenfarmparts/image/fetch/w_75,h_75,c_fill/' . str_replace('gfp.local', 'greenfarmparts.com', wp_get_attachment_image_url($post_thumbnail_id, 'full')) . '" data-full-image="https://res.cloudinary.com/greenfarmparts/fetch/fl_tiled,l_overlay,o_10/' . str_replace('gfp.local', 'greenfarmparts.com', wp_get_attachment_image_url($post_thumbnail_id, 'full')) . '" />', $post_thumbnail_id ) . '</li>';
    foreach ( $attachment_ids as $attachment_id ) {
      echo '<li>' . apply_filters( 'woocommerce_single_product_image_thumbnail_html', '<img src="https://res.cloudinary.com/greenfarmparts/image/fetch/w_75,h_75,c_fill/' . str_replace('gfp.local', 'greenfarmparts.com', wp_get_attachment_image_url($attachment_id)) .'" data-full-image="' . str_replace('gfp.local', 'greenfarmparts.com', wp_get_attachment_image_url($attachment_id, 'full')) . '" />', $attachment_id ) . '</li>';
      $i++;
    }
  echo '</ul>';
}

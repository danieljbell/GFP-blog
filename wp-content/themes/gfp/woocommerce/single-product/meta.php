<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

global $product;
?>
<div class="product_meta">

  <?php do_action( 'woocommerce_product_meta_start' ); ?>
  
  <?php
    if (get_the_terms($product->get_id(), 'product_tag')) {
      $allProductTags = wp_get_post_terms($product->get_id(), 'product_tag');
      $product_tags = [];
      foreach ($allProductTags as $key => $product_tag) {
        array_push($product_tags, $product_tag->slug);
      }
      $terms = get_terms(array(
        'taxonomy'        => 'post_tag',
        'posts_per_page'  => -1,
        'hide_empty'      => false,
        'meta_query' => array(
          array(
            'key'     => 'parts_catalog_number',
            'value'   => $product_tags,
          ),
        ),
      ));

      if (count($terms) > 5) {
        echo '<p>' . count($terms) . ' models use ' . $product->name;
          echo '<input type="text" id="fitment-text-filter" placeholder="Start typing your model to filter the list" style="width: 100%; margin-bottom: 1rem; font-size: 0.8em; border-radius: 4px;">';
      } else {
        if (count($terms) > 1) {
          echo '<p>', count($terms), ' models use ', $product->name;
        } else {
          echo '<p>', count($terms), ' model uses ', $product->name;
        }
      }

      echo '<ul class="single--part-fitment-list">';
      foreach ($terms as $productTag) {
        echo '<li class="single--part-fitment-item part-fitment-item--', $productTag->slug, '"><a href="/tag/', $productTag->slug, '">', $productTag->name ,'</a></li>';
      }
      echo '</ul>';


      // if (count($allProductTags) > 5) {
      //   echo '<p>', count($allProductTags), ' models use ', $product->name;
      //   echo '<input type="text" id="fitment-text-filter" placeholder="Start typing your model to filter the list" style="width: 100%; margin-bottom: 1rem; font-size: 0.8em; border-radius: 4px;">';
      // } else {
      //   if (count($allProductTags) > 1) {
      //     echo '<p>', count($allProductTags), ' models use ', $product->name;
      //   } else {
      //     echo '<p>', count($allProductTags), ' model uses ', $product->name;
      //   }
      // }
      // echo '<ul class="single--part-fitment-list">';
      // foreach ($allProductTags as $productTag) {
      //   echo '<li class="single--part-fitment-item part-fitment-item--', $productTag->slug, '"><a href="/tag/', $productTag->slug, '">', $productTag->name ,'</a></li>';
      // }
      // echo '</ul>';
    }
  ?>

  <?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>

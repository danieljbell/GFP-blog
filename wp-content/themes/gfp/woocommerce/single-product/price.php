<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

global $product;

if ($product->get_type() === 'grouped') {
  $child_products = $product->get_children();
  $product_price = 0;
  foreach ($child_products as $key => $child_product) {
    $child = wc_get_product($child_product);
    $product_price = $product_price + $child->get_price();
  }
  echo '<p class="price">$' . money_format('%i', $product_price) . '</p>';
} else {
  echo '<p class="price">' . $product->get_price_html() . '</p>';
}
?>

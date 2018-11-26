<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Automattic
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

global $post;

$product = wc_get_product($post->ID);

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( !$short_description && ($product->get_type() !== 'grouped')) {
  return;
}

?>
<div class="woocommerce-product-details__short-description">
  <?php echo $short_description; // WPCS: XSS ok. ?>
  <?php if ($product->get_type() === 'grouped') : ?>
    <h3><?php echo $product->get_name(); ?> includes:</h3>
    <?php
      $child_products = get_field('grouped_products', $post->ID);
      foreach ($child_products as $key => $child_product) {
        $child_id = wc_get_product_id_by_sku($child_product['part_number']);
        $child = wc_get_product($child_id);
        echo '<li><a href="' . $child->get_permalink() . '">' . '(' . $child_product['quantity'] . ') - ' . $child->get_name() . '</a></li>';
      }
    ?>
  <?php endif; ?>
</div>

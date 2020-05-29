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

?>

<?php if ($product->get_sale_price()) : ?>
  <p class="price" style="font-size: 1.2em;">
    <del style="display: block;"><span class="woocommerce-Price-amount amount">Brick &amp; Mortar Price: $<?php echo number_format($product->get_regular_price() * 1.12, 2, '.', ','); ?></span></del>
    <del style="display: block;"><span class="woocommerce-Price-amount amount" style="font-weight: bold; color: green;">Green Farm Parts Price: $<?php echo number_format($product->get_regular_price(), 2, '.', ','); ?></span></del>
    <ins><span class="woocommerce-Price-amount amount">Sale Price: See Price in Cart</span></ins>
  </p>
<?php else : ?>
  <p class="price" style="font-size: 1.2em;">
    <del style="display: block;"><span class="woocommerce-Price-amount amount">Brick &amp; Mortar Price: $<?php echo number_format($product->get_regular_price() * 1.12, 2, '.', ','); ?></span></del>
    <ins><span class="woocommerce-Price-amount amount" style="color: green;">Green Farm Parts Price: $<?php echo number_format($product->get_regular_price(), 2, '.', ','); ?></span></ins>
  </p>
<?php endif; ?>


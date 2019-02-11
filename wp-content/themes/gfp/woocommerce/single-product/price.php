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
  <p class="price">
    <del><span class="woocommerce-Price-amount amount"><?php echo $product->get_regular_price(); ?></span></del>
    <ins><span class="woocommerce-Price-amount amount">See Price in Cart</span></ins>
  </p>
<?php else : ?>
  <p class="price"><?php echo $product->get_price_html(); ?></p>
<?php endif; ?>


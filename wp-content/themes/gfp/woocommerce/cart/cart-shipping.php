<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
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
 * @version     3.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
$cart = WC()->instance()->cart;
global $wpdb;
?>
<tr class="shipping">
  

  <th><?php echo wp_kses_post( $package_name ); ?></th>
  <td data-title="<?php echo esc_attr( $package_name ); ?>">
    <?php 
      $cart_line_items = $cart->get_cart();
      $is_oversized = false;
      foreach ($cart_line_items as $key => $line_item) {
        $oversized = $wpdb->query( $wpdb->prepare( 
          "
            SELECT * FROM wp_woocommerce_per_product_shipping_rules
            WHERE product_id = %s
          ", 
          $line_item['product_id']
        ) );
        if ($oversized) {
          $is_oversized = true;
        }
      }
    ?>

    <ul style="list-style-type: none;">
      <?php if ($is_oversized) : ?>
        <?php foreach ( $available_methods as $method ) : ?>
          <?php if ($method->get_method_id() !== 'free_shipping') : ?>
            <li>
              <?php
                $text =  wc_cart_totals_shipping_method_label( $method );
                $text = str_replace('Flat rate', 'Oversized Shipping', $text);
                printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method mar-r" %4$s checked />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
                printf( '<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), $text ); // WPCS: XSS ok.
              ?>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php else : ?>
        <?php foreach ( $available_methods as $method ) : ?>
          <li>
            <?php
              printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method mar-r" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
              printf( '<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.
            ?>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>



  <td>
  
</tr>

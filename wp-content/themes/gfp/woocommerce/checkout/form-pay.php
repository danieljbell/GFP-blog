<?php
/**
 * Pay for order form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-pay.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals();

// global $wp;
// print_r(absint($wp->query_vars['order-pay']));
?>


<form id="order_review" method="post" class="order-pay">
  
  <div class="gfp-checkout--contents">
    <?php if ( count( $order->get_items() ) > 0 ) : ?>
      <ul class="gfp-order-details--list">
        <?php foreach ( $order->get_items() as $item_id => $item ) :  ?>
          <?php
          if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
            continue;
          }
          ?>
          <li class="gfp-order-details--item">

            <div class="gfp-order-details--item-image">
              <?php echo $item->get_product()->get_image('woocommerce_thumbnail'); ?>
            </div>
            <div class="gfp-order-details--item-details">
              <div class="gfp-order-details--item-name">
                <?php echo apply_filters( 'woocommerce_order_item_name', esc_html( $item->get_name() ), $item, false ); ?>
              </div>
              <div class="gfp-order-details--item-price">
                <?php
                  // $regular_price = $product->get_regular_price();
                  // $sale_price = $item->get_subtotal();
                  // $customer_discount_price = $item->get_total();

                if ($item->get_subtotal() !== $item->get_total()) {
                  echo '<del>$<span class="regular_price">' . $item->get_subtotal() . '</span></del>';
                  echo '<span class="sale-price">$' . $item->get_total() . '</span>';
                } else {
                  echo '$<span class="regular_price">' . $item->get_subtotal() . '</span>';
                }

                  // echo '$' . $item->get_subtotal();
                  // echo '$' . $item->get_total();
                  // echo $customer_discount_price . '<br />';
                  
                  // if ($is_sale) {
                  //   echo '<del>$<span class="regular-price" data-price="', $line->get_regular_price(), '">', $line->get_regular_price() * $qty, '</span></del>';
                  //   echo '<span class="sale-price" data-sale-price="', $line->get_sale_price(), '">$', $line->get_sale_price() * $qty, '</span>';
                  //   if ($qty > 1) {
                  //     echo '&nbsp;<span class="each-price"> &ndash;&nbsp; $', $line->get_sale_price(), ' each</span>';
                  //   }
                  // } else {
                  //   echo '$<span class="regular-price" data-price="', $line->get_regular_price(), '">', $line->get_regular_price() * $qty, '</span>';
                  //   if ($qty > 1) {
                  //     echo '&nbsp;<span class="each-price"> &ndash;&nbsp; $', $line->get_regular_price(), ' each</span>';
                  //   }
                  // }

                  // echo $regular_price . '<br />';
                  // echo $item->get_subtotal() . '<br />';
                  // echo $item->get_total() . '<br />';
                ?>
              </div>
              <div class="gfp-order-details--item-quantity">
                Quantity: <?php echo $item->get_quantity(); ?>
              </div>
            </div>              
          </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
  </div>

  <div class="gfp-checkout--totals">
    <div id="payment">
      <?php if ( $order->needs_payment() ) : ?>
        <ul class="wc_payment_methods payment_methods methods">
          <?php
          if ( ! empty( $available_gateways ) ) {
            foreach ( $available_gateways as $gateway ) {
              wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
            }
          } else {
            echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', __( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
          }
          ?>
        </ul>
      <?php endif; ?>
      <!-- <div class="form-row"> -->
        <input type="hidden" name="woocommerce_pay" value="1" />

        <?php wc_get_template( 'checkout/terms.php' ); ?>

        <?php do_action( 'woocommerce_pay_order_before_submit' ); ?>
        <div class="has-text-center">
          <?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="button alt btn-solid--brand" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>
        </div>

        <?php do_action( 'woocommerce_pay_order_after_submit' ); ?>

        <?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
      <!-- </div> -->
    </div>
  </div>

</form>





<?php
/*
=========================
<form id="order_review" method="post">

  <table class="shop_table">
    <thead>
      <tr>
        <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
        <th class="product-quantity"><?php esc_html_e( 'Qty', 'woocommerce' ); ?></th>
        <th class="product-total"><?php esc_html_e( 'Totals', 'woocommerce' ); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if ( count( $order->get_items() ) > 0 ) : ?>
        <?php foreach ( $order->get_items() as $item_id => $item ) : ?>
          <?php
          if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
            continue;
          }
          ?>
          <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
            <td class="product-name">
              <?php
                echo apply_filters( 'woocommerce_order_item_name', esc_html( $item->get_name() ), $item, false ); // @codingStandardsIgnoreLine

                do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

                wc_display_item_meta( $item );

                do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
              ?>
            </td>
            <td class="product-quantity"><?php echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', esc_html( $item->get_quantity() ) ) . '</strong>', $item ); ?></td><?php // @codingStandardsIgnoreLine ?>
            <td class="product-subtotal"><?php echo $order->get_formatted_line_subtotal( $item ); ?></td><?php // @codingStandardsIgnoreLine ?>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <?php if ( $totals ) : ?>
        <?php foreach ( $totals as $total ) : ?>
          <tr>
            <th scope="row" colspan="2"><?php echo $total['label']; ?></th><?php // @codingStandardsIgnoreLine ?>
            <td class="product-total"><?php echo $total['value']; ?></td><?php // @codingStandardsIgnoreLine ?>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tfoot>
  </table>

  <div id="payment">
    <?php if ( $order->needs_payment() ) : ?>
      <ul class="wc_payment_methods payment_methods methods">
        <?php
        if ( ! empty( $available_gateways ) ) {
          foreach ( $available_gateways as $gateway ) {
            wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
          }
        } else {
          echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', __( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
        }
        ?>
      </ul>
    <?php endif; ?>
    <div class="form-row">
      <input type="hidden" name="woocommerce_pay" value="1" />

      <?php wc_get_template( 'checkout/terms.php' ); ?>

      <?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

      <?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="button alt" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

      <?php do_action( 'woocommerce_pay_order_after_submit' ); ?>

      <?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
    </div>
  </div>
</form>

=========================
*/
?>
<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details mar-t--more">

  <?php if ( $show_shipping ) : ?>

  <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
    <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">

  <?php endif; ?>
  
  <div class="box--with-header">
    <header><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></header>
    <address>
      <?php echo wp_kses_post( $order->get_formatted_billing_address( __( 'N/A', 'woocommerce' ) ) ); ?>

      <?php if ( $order->get_billing_phone() ) : ?>
        <p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
      <?php endif; ?>

      <?php if ( $order->get_billing_email() ) : ?>
        <p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
      <?php endif; ?>
    </address>
  </div>

  <?php if ( $show_shipping ) : ?>

    </div><!-- /.col-1 -->

    <div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
      <div class="box--with-header">
        <header><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></header>
        <address>
          <?php echo wp_kses_post( $order->get_formatted_shipping_address( __( 'N/A', 'woocommerce' ) ) ); ?>
        </address>
      </div>
    </div><!-- /.col-2 -->

  </section><!-- /.col2-set -->

  <?php endif; ?>

  <?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

  <?php
    // SHOW ONLY ON ORDER CONFIRMATION PAGE
    $path = $_SERVER['REQUEST_URI'];
    $path_array = explode('/', $path);
    if (($path_array[1] === 'checkout') && ($path_array[2] === 'order-received')) :
  ?>
    <div class="mar-y--most"></div>
    <hr>
    <div class="box--with-header mar-y--most">
      <header>Order Review:</header>
      <p>You may review your order at any time by clicking on the My Account link. The status of anonymous orders may not be tracked under "My Account". We are unable to modify an existing order for security reasons.</p>
    </div>
    <div class="box--with-header">
      <header>Tracking Information:</header>
      <p class="mar-b">As soon as your order ships, we will notify you via email. The shipping notification email may also contain a tracking number from the shipper if applicable. You may check the transit and delivery status of your package through the tracking information provided in the shipment confirmation email. Tracking numbers become active once the package has been picked up from our store by the courier. If you created an account with a valid email and password, you can also track your packages (if shipping method is applicable), review your orders, print invoices, and more, from your My Account page at any time.</p>
      <p><em>Please be advised that invoices through John Deere Financial and credit card statements will list your purchase as <strong style="font-weight: bold;">"Reynolds Farm Equipment Inc"</strong> which is our dealership parent company. Paypal purchases may be listed as <strong>"Paypal ReynoldsFarm"</strong>.</em></p>
    </div>
  <?php endif; ?>

</section>

<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

// do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
  echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
  return;
}

?>

<div class="pad-y--most">

  <div class="gfp-checkout--login-form">
    <?php do_action('woocommerce_checkout_login_form'); ?>
  </div>

  <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

    <?php if ( $checkout->get_checkout_fields() ) : ?>
      
      <div class="gfp-checkout--contents mar-b--most">

        <div class="gfp-checkout--billing">
          <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
          <?php do_action( 'woocommerce_checkout_billing' ); ?>
        </div>
        <div class="gfp-checkout--shipping">
          <?php do_action( 'woocommerce_checkout_shipping' ); ?>
        </div>

        <div>
          <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
          <div class="box--with-header mar-b--most">
            <header>Order Items</header>
            <ul class="gfp-order-details--list">
              <?php 
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : 
                  $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                  $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                  if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                  ?>

                    <li class="gfp-order-details--item">
                      <div class="gfp-order-details--item-image">
                        <?php
                          if ( ! $product_permalink ) {
                            echo wp_kses_post( $thumbnail );
                          } else {
                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
                          }
                        ?>
                      </div>
                      <div class="gfp-order-details--item-details" data-productid="<?php echo $product_id; ?>">
                        <div class="gfp-order-details--item-name">
                          <?php
                            if ( ! $product_permalink ) {
                              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                            } else {
                              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                            }
                            do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
                            // Meta data.
                            echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                            // Backorder notification.
                            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>' ) );
                            }
                          ?>
                        </div>
                        <div class="gfp-order-details--item-price">
                          <?php
                            $line = $cart_item['data'];
                            $qty = $cart_item['quantity'];
                            $is_sale = $line->get_sale_price();
                            if ($is_sale) {
                              echo '<del>$<span class="regular-price" data-price="', $line->get_regular_price(), '">', $line->get_regular_price() * $qty, '</span></del>';
                              echo '<span class="sale-price" data-sale-price="', $line->get_sale_price(), '">$', $line->get_sale_price() * $qty, '</span>';
                              if ($qty > 1) {
                                echo '&nbsp;<span class="each-price"> &ndash;&nbsp; $', $line->get_sale_price(), ' each</span>';
                              }
                            } else {
                              echo '$<span class="regular-price" data-price="', $line->get_regular_price(), '">', $line->get_regular_price() * $qty, '</span>';
                              if ($qty > 1) {
                                echo '&nbsp;<span class="each-price"> &ndash;&nbsp; $', $line->get_regular_price(), ' each</span>';
                              }
                            }
                          ?>
                        </div>
                        <div class="gfp-order-details--item-quantity">
                          <p>Quantity: <?php echo $cart_item['quantity']; ?></p>
                        </div>
                      </div>
                    </li>

              <?php 
                  endif;
              ?>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="woocommerce-additional-fields">
            <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
              <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
                <?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>
                  <h3><?php _e( 'Additional information', 'woocommerce' ); ?></h3>
                <?php endif; ?>
                <div class="woocommerce-additional-fields__field-wrapper">
                  <?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
                    <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
          </div>
        </div>


        
      </div>

    <?php endif; ?>
        
    <div class="gfp-checkout--contents">
      <div class="gfp-checkout--order-totals">
        <div class="box--with-header">
          <header>Order Totals</header>
          <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
            <?php do_action( 'woocommerce_order_review' ); ?>
          <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
        </div>
      </div>
      <div class="gfp-checkout--payment-info">
        <div class="box--with-header">
          <header>Payment Information</header>
          <p class="mar-b" style="background-color: red; color: white; padding: 10px;"><strong>Attention:</strong> <em>Due to the adverse effects of COVID-19, please expect an additional 2-3 business days on shipping times for your order.</em></p>
          <?php 
            do_action( 'woocommerce_checkout_payment' );
            wc_get_template( 'checkout/terms.php' );
            do_action( 'woocommerce_after_checkout_billing_form', $checkout );
          ?>
        </div>
      </div>
    </div>

  </form>
  
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

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

  <?php do_action('woocommerce_checkout_login_form'); ?>

  <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

    <?php if ( $checkout->get_checkout_fields() ) : ?>
      
      <div class="gfp-checkout--contents">

        <div>
          <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
          <?php do_action( 'woocommerce_checkout_billing' ); ?>
          <?php wc_get_template( 'checkout/terms.php' ); ?>
        </div>
        <div>
        
        <?php do_action( 'woocommerce_checkout_shipping' ); ?>
        </div>

        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
        <div class="box--with-header">
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
      </div>

    <?php endif; ?>


    <!-- <div class="gfp-checkout--totals">
      <div class="gfp-checkout--totals-inner">

        <?php //wc_print_notices(); ?>
        
        <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

        <div id="order_review" class="woocommerce-checkout-review-order">
          <?php
            do_action( 'woocommerce_checkout_payment' );
            do_action( 'woocommerce_order_review' );
          ?>
        </div>

        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

      </div>
    </div> -->

  </form>
  
</div>

<?php //print_r($checkout); ?>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

// echo '<pre>';
// print_r(WC()->instance()->cart);
if ($_GET['pc']) {
  $cart = WC()->instance()->cart;
  // $coupon = $_POST['coupon'];
  $cart->apply_coupon($_GET['pc']);
  // wp_send_json($cart);
}
?>

<div class="pad-y--most">
  <form class="woocommerce-cart-form gfp-order" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
  
  <div class="gfp-order-details--contents">
    
    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <ul class="gfp-order-details--list">

      <li>
        <?php get_template_part('partials/display', 'current-promo'); ?>
      </li>
      

    <?php 
      foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : 
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
          $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
          $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
        ?>

          <li class="gfp-order-details--item" data-product-key="<?php echo $cart_item_key; ?>">
            <?php
              // @codingStandardsIgnoreLine
              echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-product-key="%s">&times;</a>',
                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                __( 'Remove this item', 'woocommerce' ),
                esc_attr( $product_id ),
                esc_attr( $_product->get_sku() ),
                esc_attr( $cart_item_key )
              ), $cart_item_key );
            ?>

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
                    echo '<del>$<span class="regular-price" data-price="', number_format($line->get_regular_price(), 2, '.', ','), '">', number_format($line->get_regular_price() * $qty, 2, '.', ','), '</span></del>';
                    echo '<span class="sale-price" data-sale-price="', number_format($line->get_sale_price(), 2, '.', ','), '">$', number_format($line->get_sale_price() * $qty, 2, '.', ','), '</span>';
                    if ($qty > 1) {
                      echo '&nbsp;<span class="each-price"> &ndash;&nbsp; $', number_format($line->get_sale_price(), 2, '.', ','), ' each</span>';
                    }
                  } else {
                    echo '$<span class="regular-price" data-price="', number_format($line->get_regular_price(), 2, '.', ','), '">', number_format($line->get_regular_price() * $qty, 2, '.', ','), '</span>';
                    if ($qty > 1) {
                      echo '&nbsp;<span class="each-price"> &ndash;&nbsp; $', number_format($line->get_regular_price(), 2, '.', ','), ' each</span>';
                    }
                  }
                ?>
              </div>
              <div class="gfp-order-details--item-quantity">
                <?php
                // print_r($cart_item);
                  if ( $_product->is_sold_individually() ) {
                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                  } else {
                    $product_quantity = woocommerce_quantity_input( array(
                      'input_name'   => "cart[{$cart_item_key}][qty]",
                      'input_value'  => $cart_item['quantity'],
                      'max_value'    => $_product->get_max_purchase_quantity(),
                      'min_value'    => '1',
                      'product_name' => $_product->get_name(),
                    ), $_product, false );
                  }
                  // print_r();
                  global $wpdb;
                  $qty_increment = $wpdb->get_row( "SELECT meta_value FROM $wpdb->postmeta WHERE post_id = " . $cart_item['product_id'] . " AND meta_key = 'qty_increment'" );
                  echo '<label>Quantity:</label>';
                  if (!$qty_increment) {
                    echo '<input type="number" value="' . $cart_item['quantity'] . '" class="input-text qty text" pattern="[0-9]*" inputmode="numeric" name="cart[' . $cart_item_key . '][qty]' . '">';
                  } else {
                    echo '<input type="number" step="' . $qty_increment->meta_value . '" value="' . $cart_item['quantity'] . '" class="input-text qty text" pattern="[0-9]*" inputmode="numeric" name="cart[' . $cart_item_key . '][qty]' . '">';
                  }
                  
                  
                  
                  // <input type="number" id="quantity_5c8012795265d" class="input-text qty text" step="2" min="2" max="80" name="cart[dac8ce96201895132d4e554f03990705][qty]" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" aria-labelledby="john deere lg264 quantity">

                  // echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                  ?>
              </div>
            </div>
          </li>

    <?php 
        endif;
    ?>
    <?php endforeach; ?>

    </ul>

    <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
    

    <?php do_action( 'woocommerce_cart_actions' ); ?>

    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
    <?php do_action( 'woocommerce_after_cart_contents' ); ?>
    <?php do_action( 'woocommerce_after_cart_table' ); ?>

  </div>


  <div class="gfp-order-details--totals sticky--container">
    <div class="gfp-order-details--totals-inner sticky--element">
      <?php wc_print_notices(); ?>
      <?php if ( wc_coupons_enabled() ) { ?>
        <div class="coupon">
          <label for="coupon_code" class="visually-hidden"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
          <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
          <button type="submit" class="button btn-solid--brand" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply', 'woocommerce' ); ?></button>
          <?php do_action( 'woocommerce_cart_coupon' ); ?>
        </div>
      <?php } ?>
      <?php
        do_action( 'woocommerce_before_cart_contents' );

        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action( 'woocommerce_cart_collaterals' );
        // do_action( 'woocommerce_cart_totals' );
        // do_action( 'woocommerce_before_cart' );
      ?>
    </div>  
  </div>

</form>

</div>



<?php do_action( 'woocommerce_after_cart' ); ?>
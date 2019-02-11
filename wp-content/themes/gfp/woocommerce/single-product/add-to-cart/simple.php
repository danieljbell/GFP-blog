<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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

global $product;

if ( ! $product->is_purchasable() ) {
  return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>
  
  <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

  <form id="single-product--add-to-cart-form" class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
    <?php // do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <?php
    // do_action( 'woocommerce_before_add_to_cart_quantity' );

    // woocommerce_quantity_input( array(
    //   'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
    //   'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
    //   'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
    // ) );

    // do_action( 'woocommerce_after_add_to_cart_quantity' );
    $nla_part = get_post_meta($product->get_ID(), 'nla_part');
    // print_r($nla_part);
    ?>

    <?php if (!$nla_part[0] || ($nla_part[0] && ($nla_part[0] === 'no'))) : ?>

      <button id="single-product--add-to-cart" data-sku="<?php echo $product->sku; ?>" data-product-title="<?php echo $product->name; ?>" type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button btn-solid--brand-two button alt add-to-cart mar-b--more"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

    <?php endif; ?>

    <?php do_action( 'woocommerce_template_single_excerpt' ); ?>

    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    
    <?php  
      
      $current_promotions_args = array(
        'post_type' => 'promotions',
        'posts_per_page' => -1,
        'meta_key' => 'promotion_end_date',
        'meta_value' => date('Ymd'),
        'meta_compare' => '>='
      );

      $current_promotions_query = new WP_Query($current_promotions_args);

      $product_category = get_the_terms($product->get_ID(), 'product_cat');

      if ($current_promotions_query->have_posts()) : while ($current_promotions_query->have_posts()) : $current_promotions_query->the_post();
        if ($product_category[0]->term_id === get_field('categories_on_sale')[0]->term_id) {
          $promotion_body_copy = get_field('promotion_body_copy');
          $promotion_end_date = get_field('promotion_end_date');
          if ($promotion_type === 'coupon') {
            $coupon_details = get_field('coupon');
            echo '<p>' . $promotion_body_copy . '. Use coupon code <span class="current-promotions--promo-code">' . $coupon_details->post_title . '</span> when checking out to save! <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
          } else {
            echo '<p>' . $promotion_body_copy . '. <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
          }
        }
        // echo '<hr />';
      endwhile; endif; wp_reset_postdata();

    ?>

  </form>

  <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

  

<?php endif; ?>

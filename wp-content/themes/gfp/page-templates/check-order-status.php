<?php
/*
=================================
Template Name: Check Order Status
=================================
*/
?>

<?php get_header(); ?>

<section class="hero">
  <div class="site-width">
    <h1><?php echo get_the_title(); ?></h1>
    <h2>Check your order status</h2>
  </div>
</section>

<section class="pad-y--most woocommerce-view-order">
  <div class="site-width">

    <?php
      if ($_GET['order_number'] || $_GET['zipcode']) :
        if (!($_GET['order_number'] && $_GET['zipcode'])) :

    ?>
          
          <?php if (!$_GET['order_number']) : ?>
            <div class="form-errors">
              <button class="form-errors--close" onclick="this.parentElement.remove();">&times;</button> Please provide an order number
            </div>
          <?php endif; ?>

          <?php if (!$_GET['zipcode']) : ?>
            <div class="form-errors">
              <button class="form-errors--close" onclick="this.parentElement.remove();">&times;</button> Please provide a zipcode
            </div>
          <?php endif; ?>

          <form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
            <label for="order_number">Order Number:</label>
            <input type="text" name="order_number" id="order_number" value="<?php echo $_GET['order_number']; ?>">
            <label for="zipcode">Shipping Zipcode:</label>
            <input type="text" name="zipcode" id="zipcode" value="<?php echo $_GET['zipcode']; ?>">
            <input type="submit" name="submit" value="Submit" class="btn-solid--brand-two">
            <input type="hidden" name="action" value="order_tracking">
          </form>
    <?php
        get_footer();
        exit;
        endif;
      endif;
    ?>

    <?php
      if (wc_get_order( $_GET['order_number']) && ($_GET['zipcode'] === wc_get_order( $_GET['order_number'] )->get_shipping_postcode())) :
        $order = wc_get_order( $_GET['order_number'] );
        $order_status = ucwords($order->get_status());
        $order_notes = $order->get_customer_order_notes();
    ?>

    <div class="order-tracking-container sticky-container">
      <div class="order-tracking-status-details sticky-element">
        <h1>Order #<?php echo $_GET['order_number']; ?></h1>
        <p class="order-date">Order Date: <?php echo wc_format_datetime( $order->get_date_created() ); ?></p>
        <p class="order-status">Order Status: <?php echo wc_get_order_status_name( $order->get_status() ); ?></p>
        <div class="mar-b--more">
          <h3 class="">Have A Question On Your Order?</h3>
          <button class="btn-solid--brand-two launchModal" data-modal-launch="send-order-comment">Ask Us!</button>
        </div>
        <div class="mar-b--more">
          <h3>Need to track another order?</h3>
          <a href="/order-tracking" class="btn-solid--brand-two">Check Now</a>
        </div>
      </div>
      <div class="order-tracking-details">
        <?php if ($order_notes) : ?>
          <div class="box--with-header mar-b--most">
            <header>
              <h3>Order Notes</h3>
            </header>
            <ol class="woocommerce-OrderUpdates commentlist notes">
              <?php foreach ( $order_notes as $note ) : ?>
                <li class="woocommerce-OrderUpdate comment note">
                  <div class="woocommerce-OrderUpdate-inner comment_container">
                    <div class="woocommerce-OrderUpdate-text comment-text">
                      <div class="woocommerce-OrderUpdate-description description">
                        <?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
                      </div>
                      <?php echo get_avatar($note->comment_author_email, 50, null, $note->comment_author); ?>
                      <p class="woocommerce-OrderUpdate-meta meta"><?php echo $note->comment_author; ?><br><?php echo date_i18n( __( 'M. dS h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>
        <?php endif; ?>

        <div class="box--with-header">
          <header>
            <h3>Order Details</h3>
          </header>
          <ul class="gfp-order-details--list">
            <?php
              $order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
              foreach ( $order_items as $item_id => $item ) :
                $product = $item->get_product();
                $qty = $item->get_quantity();
                $name = $item->get_name();
                $image = $product->get_image(array(100,100));
                $link = $product->get_permalink();
                $subtotal = $item->get_subtotal();
                $total = $item->get_total();
                $unit_price = $subtotal / $qty;
                include( locate_template('partials/display-order-detail--item.php', false, false) );
              endforeach;
            ?>
          </ul>
        </div>
      </div>      
    </div>

    <?php else : ?>
      
      <?php if ($_GET['order_number'] || $_GET['zipcode']) : ?>
        <div class="form-errors">
          <button class="form-errors--close" onclick="this.parentElement.remove();">&times;</button> Sorry, but the order number or the zipcode is incorrect. Please check our values and try again.
        </div>
      <?php endif; ?>

      <form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
        <label for="order_number">Order Number:</label>
        <input type="text" name="order_number" id="order_number" value="<?php echo $_GET['order_number']; ?>">
        <label for="zipcode">Shipping Zipcode:</label>
        <input type="text" name="zipcode" id="zipcode" value="<?php echo $_GET['zipcode']; ?>">
        <input type="submit" name="submit" value="Submit" class="btn-solid--brand-two">
        <input type="hidden" name="action" value="order_tracking">
      </form>

    <?php endif; ?>
    
  </div>
</section>

<?php get_template_part('partials/modals/display', 'order-comment'); ?>

<?php get_footer(); ?>
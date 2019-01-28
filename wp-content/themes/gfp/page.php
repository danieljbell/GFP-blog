<?php get_header(); ?>

<?php
  $path = $_SERVER['REQUEST_URI'];
  $path_array = explode('/', $path);
  if (($path_array[1] === 'checkout') && ($path_array[2] === 'order-received')) :
    $order = wc_get_order($path_array[3]);
    $order_number = $order->get_order_number();
?>
  <section class="hero">
    <div class="site-width">
      <h1>Thanks <?php echo $order->get_billing_first_name(); ?> for your business!</h1>
      <h2>Your order #<?php echo $order_number; ?> has been received and you will receive an email order confirmation shortly.</h2>
    </div>
  </section>
<?php endif; ?>

<div class="site-width">
  <div class="pad-y--most">

    <?php
      if (have_posts()) : while(have_posts()) : the_post();
        the_content();
      endwhile; endif;
    ?>

  </div>
</div>

<?php get_footer(); ?>
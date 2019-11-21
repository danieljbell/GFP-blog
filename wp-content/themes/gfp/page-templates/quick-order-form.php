<?php

/*
===============================
TEMPLATE NAME: Quick Order Form
===============================
*/

get_header();

?>

<section class="hero" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url(<?php echo get_stylesheet_directory_URI() . '/dist/img/hero--generic-' . rand(1, 5) . '.jpg'; ?>);">
  <div class="site-width pad-b">
    <h1>Quick Parts Order Form</h1>
    <h2 style="font-size: 1.1rem; font-weight: normal;">Already know the parts you need and need to get more than one? <br>You're in the right place.</h2>
  </div>
</section>

<section>
  <div class="site-width">
    <div class="home--current-special-offers">
      <p class="has-text-center">Fill out the form below to populate your cart with all the parts and quantities you need.</p>
      <form action="POST" class="quick-order-form">
        <div class="form-group">
          <label for="sku">Part Number</label>
          <input type="text" name="sku" id="sku">
        </div>
        <div class="form-group">
          <label for="qty">Quantity</label>
          <input type="number" min="1" max="100" name="qty" id="qty" value="1">
        </div>
        <div class="form-group">
          <button class="btn-solid--brand">Add Part</button>
        </div>
      </form>
      <div class="placeholder has-text-center visually-hidden">
        <img src="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/spinner.svg" alt="spinner" class="spinner">
      </div>
      <ul class="gfp-order-details--list visually-hidden"></ul>
      <div class="checkout has-text-center visually-hidden">
        <button class="btn-solid--brand">Checkout</button>
      </div>
    </div>
  </div>
</section>

<style>
  .gfp-order-details--list {
    max-width: 600px;
    margin: 0 auto;
    padding-top: 2rem;
    padding-bottom: 2rem;
  }

  .gfp-order-details--item.error {
    background-color: rgba(255, 0, 0, 0.1);
    border: 1px solid red;
  }

  .gfp-order-details--item.error .remove {
    background-color: rgba(255, 0, 0, 1);
  }
</style>


<?php get_footer(); ?>
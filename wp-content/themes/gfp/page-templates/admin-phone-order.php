<?php 
/*
================================
Template Name: Admin Phone Order
================================
*/

?>

<?php get_header(); ?>

  <section class="pad-y--most has-text-center">
    <div class="site-width">
      <h1>Phone Orders</h1>
    </div>
  </section>

  <section>
    <div class="site-width">
      <div class="box--with-header">
        <header>Customer Details</header>
        <button class="btn-solid--brand-two tab-trigger" id="customer--new">New Customer</button>
        <button class="btn-solid--brand-two tab-trigger" id="customer--returning">Returning Customer</button>
        <div class="customer mar-t">
          <div class="customer--returning">
            <h3>Returning Customer</h3>
            <input id="returning_email_address" type="email" placeholder="Search by email address" name="returning_email_address" style="min-width: 300px;">
            <ul class="returning-customer-list"></ul>
          </div>
          <div class="customer--new visually-hidden">
            <h3>New Customer</h3>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<?php get_footer(); ?>
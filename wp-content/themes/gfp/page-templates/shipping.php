<?php
/*
===================================
Template Name: Shipping Policy Page
===================================
*/
?>

<?php get_header(); ?>

<section class="pad-y--most">
  <div class="site-width">
    <h1><?php echo get_the_title(); ?></h1>
    <nav>
      <ul class="shipping-navigation--list">
        <?php if (have_rows('shipping_sections')) : while (have_rows('shipping_sections')) : the_row('shipping_sections'); ?>
          <li class="shipping-navigation--item">

            <?php
              // print_r(strtolower(get_sub_field('section_title')));
            ?>
            <a href="#free_shipping_guidelines">
              <img src="//fillmurray.com/100/100" alt="">
              <?php echo get_sub_field('section_title'); ?>
            </a>
          </li>
        <?php endwhile; endif; ?>
        <!-- <li class="shipping-navigation--item">
          <a href="#estimated_delivery_times">
            <img src="//fillmurray.com/100/100" alt="">
            Estimated Delivery Times
          </a>
        </li>
        <li class="shipping-navigation--item">
          <a href="#alternative_shipping">
            <img src="//fillmurray.com/100/100" alt="">
            Alternative Shipping
          </a>
        </li>
        <li class="shipping-navigation--item">
          <a href="#sales_tax">
            <img src="//fillmurray.com/100/100" alt="">
            Sales Tax
          </a>
        </li>
        <li class="shipping-navigation--item">
          <a href="#refused_or_non-deliverable_packages">
            <img src="//fillmurray.com/100/100" alt="">
            Refused or Non-deliverable Packages
          </a>
        </li>
        <li class="shipping-navigation--item">
          <a href="#orders_outside_of_the_usa">
            <img src="//fillmurray.com/100/100" alt="">
            Orders outside of the USA
          </a>
        </li>
        <li class="shipping-navigation--item">
          <a href="#international_orders">
            <img src="//fillmurray.com/100/100" alt="">
            International Orders
          </a>
        </li>
        <li class="shipping-navigation--item">
          <a href="#payment">
            <img src="//fillmurray.com/100/100" alt="">
            Payment
          </a>
        </li> -->
      </ul>
    </nav>
  </div>
</section>

<section class="pad-y--most">
  <div class="site-width">
    <?php if (have_rows('shipping_sections')) : while (have_rows('shipping_sections')) : the_row('shipping_sections'); ?>
      <div class="box--with-header">
        <header><?php echo get_sub_field('section_title'); ?></header>
        <?php echo get_sub_field('section_content'); ?>
      </div>
    <?php endwhile; endif; ?>
    <!-- <div class="box--with-header">
      <header>Free Shipping Guidelines</header>
      <ul>
        <li>thing</li>
        <li>thing</li>
        <li>thing</li>
      </ul>
    </div>
    <div class="box--with-header">
      <header>Estimated Delivery Times</header>
      <ul>
        <li>thing</li>
        <li>thing</li>
        <li>thing</li>
      </ul>
    </div>
    <div class="box--with-header">
      <header>Alternative Shipping</header>
      <ul>
        <li>thing</li>
        <li>thing</li>
        <li>thing</li>
      </ul>
    </div>
    <div class="box--with-header">
      <header>Sales Tax</header>
      <ul>
        <li>thing</li>
        <li>thing</li>
        <li>thing</li>
      </ul>
    </div>
    <div class="box--with-header">
      <header>Refused or Non-deliverable Packages</header>
      <ul>
        <li>thing</li>
        <li>thing</li>
        <li>thing</li>
      </ul>
    </div>
    <div class="box--with-header">
      <header>Orders outside of the USA</header>
      <ul>
        <li>thing</li>
        <li>thing</li>
        <li>thing</li>
      </ul>
    </div>
    <div class="box--with-header">
      <header>International Orders</header>
      <ul>
        <li>thing</li>
        <li>thing</li>
        <li>thing</li>
      </ul>
    </div>
    <div class="box--with-header">
      <header>Payment</header>
      <ul>
        <li>thing</li>
        <li>thing</li>
        <li>thing</li>
      </ul>
    </div> -->
  </div>  
</section>


<?php get_footer(); ?>
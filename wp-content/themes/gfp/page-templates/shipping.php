<?php
/*
===================================
Template Name: Shipping Policy Page
===================================
*/
?>

<?php 
  $page_path = $_SERVER['REQUEST_URI'];
  $page_path_array = explode('/', $page_path);
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
              $string = strtolower(get_sub_field('section_title'));
              $array = explode(' ', $string);
              $new_string = implode('_', $array);
            ?>
            <a href="<?php echo site_url() . '/' . $page_path_array[1] . '/#' . $new_string; ?>">
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
      <?php
        $string = strtolower(get_sub_field('section_title'));
        $array = explode(' ', $string);
        $new_string = implode('_', $array);
      ?>
      <div class="shipping-section" id="<?php echo $new_string; ?>">
        <div>
          <img src="<?php echo get_sub_field('section_image')['url']; ?>" alt="<?php echo get_sub_field('section_image')['name']; ?>">
          <?php print_r(); ?>
        </div>
        <div class="box--with-header">
          <header><?php echo get_sub_field('section_title'); ?></header>
          <?php echo get_sub_field('section_content'); ?>
        </div>
      </div>
    <?php endwhile; endif; ?>
  </div>  
</section>


<?php get_footer(); ?>
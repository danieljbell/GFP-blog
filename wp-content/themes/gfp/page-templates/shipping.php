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
              <img src="<?php echo get_sub_field('section_image')['url']; ?>" alt="<?php echo get_sub_field('section_image')['name']; ?>">
              <?php echo get_sub_field('section_title'); ?>
            </a>
          </li>
        <?php endwhile; endif; ?>
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
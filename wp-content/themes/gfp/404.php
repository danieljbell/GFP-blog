<?php
  $actual_link = $_SERVER[REQUEST_URI];
?>

<?php get_header(); ?>

<section class="hero">
      
  <div class="site-width">
    <h1>We're sorry, but something went wrong.</h1>
    <h2>This page <?php echo $actual_link; ?> has either moved locations or doesn't exist.</h2>
    <?php get_search_form(); ?>
  </div>

</section>

<?php get_footer(); ?>
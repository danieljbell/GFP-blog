<?php get_header(); ?>

<section class="hero">
  <div class="site-width">
    <h1>Let Us Help You Find What You Are Looking For</h1>
    <form role="search" method="get" action="/">
      <div>
        <label class="screen-reader-text visually-hidden" for="s">Search for:</label>
        <input type="text" value="" name="s" id="s" placeholder="Search by Part Number or Model Number" autocomplete="off">
        <input type="submit" id="searchsubmit" value="Search">
      </div>
    </form>
  </div>
</section>

<?php
  $current_promotions_args = array(
    'post_type' => 'promotions',
    'posts_per_page' => -1
  );

  $current_promotions_query = new WP_Query($current_promotions_args);

  if ($current_promotions_query->have_posts()) :
    echo '<section>';
      echo '<div class="site-width">';
        echo '<div class="home--current-special-offers">';
          echo '<h2>Current Special Offers</h2>';
          echo '<ul class="promo-card-list">';
            while ($current_promotions_query->have_posts()) : $current_promotions_query->the_post();
              get_template_part('partials/display', 'card--promo');
            endwhile;
          echo '</ul>';
        echo '</div>';
      echo '</div>';
    echo '</section>';
  endif;
?>

<section class="pad-y--most">
  <div class="site-width">
    <h2 class="has-text-center">Shop Popular Categories</h2>
    <?php
      echo wp_nav_menu( array(
        'menu' => 'homepage-promoted-categories',
      ) );
    ?>

  </div>
</section>

<?php get_footer(); ?>
<?php get_header(); ?>

<section class="hero" style="background-image: linear-gradient(rgba(0,0,0, 0.5), rgba(0,0,0, 0.5)), url('//fillmurray.com/1280/400');">
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
    <ul class="home--promoted-categories-list">
      <?php
        $promoted_categories = wp_get_nav_menu_items( 'homepage-promoted-categories' );
        foreach ($promoted_categories as $promoted_category) {
          // print_r(get_post_meta($promoted_category->id, 'product_cat_thumbnail_id'));
          // print_r(expression)
          echo '<li class="home--promoted-categories-item">';
            echo '<a href="' . $promoted_category->url . '">';
              echo '<div class="home--promoted-categories-image">';
                echo '<img src="//fillmurray.com/100/100" alt="Category Image">';
              echo '</div>';
              echo '<div class="home--promoted-categories-title">';
                echo $promoted_category->title;
              echo '</div>';
            echo '</a>';
          echo '</li>';
        }
      ?>
    </ul>
  </div>
</section>

<?php get_footer(); ?>
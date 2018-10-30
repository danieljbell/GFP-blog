<?php get_header(); ?>

<section class="hero" style="background-image: linear-gradient(rgba(0,0,0, 0.15), rgba(0,0,0, 0.15)), url('<?php echo get_stylesheet_directory_URI(); ?>/dist/img/hero--homepage.jpg');">
  <div class="site-width">
    <h1>Let Us Help You Find What You Are Looking For</h1>
    <form role="search" method="get" action="/">
      <div>
        <label class="screen-reader-text visually-hidden" for="s">Search for:</label>
        <input type="text" value="" name="s" id="s" placeholder="Search by Part Number or Model Number" autocomplete="off">
        <input type="image" alt="Search" src="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/search.svg">
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
          echo '<li class="home--promoted-categories-item">';
            echo '<a href="' . $promoted_category->url . '">';
              echo '<div class="home--promoted-categories-image">';
                $thing = get_post_meta($promoted_category->ID)['_menu_item_object_id'][0];
                $image_id = get_woocommerce_term_meta( $thing, 'thumbnail_id', true );
                echo '<img src="' . wp_get_attachment_url($image_id) . '" />';
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
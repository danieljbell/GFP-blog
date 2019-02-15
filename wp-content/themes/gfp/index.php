<?php get_header(); ?>

<?php
  // print_r();
?>

<section class="hero" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(<?php echo get_stylesheet_directory_URI(); ?>/dist/img/hero--generic-<?php echo mt_rand(1,5);?>.jpg);">
      
  <div class="site-width">
    <?php
      $page_subtitle = ($wp_query->post_count > 1) ? 'posts' : 'post'; 

      if (is_search()) {
        $page_title = 'Search for:&nbsp; ' . htmlspecialchars($_GET["s"]);
        $subtitle = '';
      }
      if (is_category()) {
        $queried_object = get_queried_object();
        $page_title = 'Content Categorized As "' . $queried_object->name . '"';
        $count = get_the_category();
        $count = $count[0]->count;
        $subtitle = '<h2>' . $count . ' ' . $page_subtitle . '</h2>';
      }
      if (is_tag()) {
        $queried_object = get_queried_object();
        $page_title = 'Content Tagged As "' . $queried_object->name . '"';
        $count = get_the_tags();

        // print_r($count);
        // $count = $count[0]->count;
      }
      if (is_author()) {
        $queried_object = get_queried_object();
        $page_title = 'Content Written By ' . $queried_object->display_name . '';
      }
    ?>
    <h1><?php echo $page_title ?></h1>
    <?php echo $subtitle; ?>
    
  </div>

</section>

<section class="post-listing--full-details">
  
  <div class="site-width">
    asdfasdf

    <?php if (have_posts()) : ?>
    
    <div class="post-listing--results">  
      <?php
        while (have_posts()) : the_post();
          get_template_part('partials/display', 'card');
        endwhile; 
      ?>
    </div>

    <div class="post-listing--promo">
      <?php get_template_part('partials/display', 'current-promo') ?>
    </div>

    <?php
      else :
        echo 'nothing';
      endif;
    ?>

  </div>

</section>

<section>
  <div class="site-width">

    <?php
      $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
          array(
            'taxonomy' => 'product_tag',
            'field'    => 'slug',
            'terms'    => get_field('parts_catalog_number', get_queried_object()),
          ),
        ),
      );
      $query = new WP_Query($args);
      if ($query->have_posts()) : 
        echo '<ul class="products--list">';
          while ($query->have_posts()) : $query->the_post();
            $product = wc_get_product(get_the_ID());
            get_template_part('partials/display', 'product-card--slim');
          endwhile;
        echo '</ul>';
    endif; wp_reset_query();
    ?>
  </div>
</section>

<?php get_footer(); ?>
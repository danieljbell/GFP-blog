<?php get_header(); ?>

<?php
  // print_r();
?>

<section class="hero">
      
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

        print_r($count);
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
    
    <div class="post-listing--filters">
      <?php get_search_form(); ?>
    </div>
    
    <div class="post-listing--results">  
      <?php
        if (have_posts()) : while (have_posts()) : the_post();
          get_template_part('partials/display', 'card');
        endwhile; endif;
      ?>
    </div>

    <div class="post-listing--promo">
      <?php get_template_part('partials/display', 'current-promo') ?>
    </div>

  </div>

</section>

<?php get_template_part('partials/display', 'alert--add-to-cart'); ?>

<?php get_footer(); ?>
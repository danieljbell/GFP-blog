<?php get_header(); ?>

<section class="hero">
      
  <div class="site-width">
    <?php
      $page_subtitle = ($wp_query->post_count > 1) ? 'posts' : 'post'; 

      if (is_search()) {
        $page_title = 'Search for:&nbsp; ' . htmlspecialchars($_GET["s"]);
      }
      if (is_category()) {
        $queried_object = get_queried_object();
        $page_title = 'Content Categorized As "' . $queried_object->name . '"';
      }
      if (is_tag()) {
        $queried_object = get_queried_object();
        $page_title = 'Content Tagged As "' . $queried_object->name . '"';
      }
      if (is_author()) {
        $queried_object = get_queried_object();
        $page_title = 'Content Written By ' . $queried_object->display_name . '';
      }
    ?>
    <h1><?php echo $page_title ?></h1>
    <h2><?php echo $wp_query->post_count . ' ' . $page_subtitle; ?></h2>
  </div>

</section>

<section class="post-listing--full-details">
  
  <div class="site-width">
    
    <div class="post-listing--filters">
      <?php get_search_form(); ?>
      filter me bro
    </div>
    
    <div class="post-listing--results">  
      <?php
        if (have_posts()) : while (have_posts()) : the_post();
          get_template_part('partials/display', 'card');
        endwhile; endif;
      ?>
    </div>

    <div class="post-listing--promo">
      <div class="single-current-promo">
        <div class="single-current-promo-image">
          <img src="//fillmurray.com/100/100" alt="">
        </div>
        <div class="single-current-promo-content">
          <h4 class="single-current-promo-headline"><?php the_field('current_promo_headline', 'option'); ?></h4>
          <p class="single-current-promo-copy"><?php the_field('current_promo_copy', 'option'); ?></p>
          <a href="<?php the_field('current_promo_button_link'); ?>"><?php the_field('current_promo_button_text', 'option'); ?></a>
        </div>
      </div>
    </div>

  </div>

</section>

<?php get_footer(); ?>
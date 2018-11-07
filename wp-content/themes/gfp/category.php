<?php get_header(); ?>

<section class="hero">
      
  <div class="site-width">
    <?php
      $page_subtitle = ($wp_query->post_count > 1) ? 'posts' : 'post'; 
      $queried_object = get_queried_object();
      $page_title = 'Content Categorized As "' . $queried_object->name . '"';
      $count = get_the_category();
      $count = $count[0]->count;
      $subtitle = '<h2>' . $count . ' ' . $page_subtitle . '</h2>';
    ?>
    <h1><?php echo $page_title ?></h1>
    <?php echo $subtitle; ?>
    
  </div>

</section>

<section class="post-listing--full-details">
  
  <div class="site-width">

    <div>
      <div class="post-listing--results">  
        <?php
          if (have_posts()) : while (have_posts()) : the_post();
            get_template_part('partials/display', 'card');
          endwhile; endif;
        ?>
      </div>
      <div class="mar-y--more has-text-center">
        <img src="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/spinner.svg" alt="spinner" class="spinner" style="display: none; margin: 1rem auto 1rem;">
        <h5 style="font-size: 1.2em; margin-bottom: 0.5em;">Looking for More?</h5>
        <button id="loadMorePosts" class="btn-solid--brand">Load More Posts</button>
      </div>
    </div>

    <div class="post-listing--promo">
      <?php get_template_part('partials/display', 'current-promo') ?>
    </div>

  </div>

</section>

<script>
  var currentCategory = <?php echo get_query_var('cat'); ?>;
  var categoryName = "<?php echo $queried_object->name; ?>";
</script>

<?php get_footer(); ?>
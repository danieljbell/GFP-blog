<?php get_header(); ?>


<section class="post-listing--full-details">
  
  <div class="site-width">
    
    <div class="post-listing--filters">
      <?php get_search_form(); ?>
    </div>
    
    <div class="post-listing--results">  

      <div class="post-listing--list">
        <?php
          if (have_posts()) : while (have_posts()) : the_post();
            get_template_part('partials/display', 'card');
          endwhile; endif;
        ?>
      </div> 

        <div class="mar-y--more has-text-center">
          <h5 style="font-size: 1.2em; margin-bottom: 0.5em;">Looking for More?</h5>
          <button id="loadMorePosts" class="btn-solid--brand">Load More Posts</button>
        </div>

    </div>

    <div class="post-listing--promo">
      <?php get_template_part('partials/display', 'current-promo') ?>
    </div>

  </div>

</section>

<?php get_template_part('partials/display', 'alert--add-to-cart'); ?>

<?php get_footer(); ?>
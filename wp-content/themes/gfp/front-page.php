<?php get_header(); ?>


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
          <a href="<?php the_field('current_promo_button_link', 'option'); ?>"><?php the_field('current_promo_button_text', 'option'); ?></a>
        </div>
      </div>
    </div>

  </div>

</section>

<?php get_footer(); ?>
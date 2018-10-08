<?php get_header(); ?>

<div class="site-width">
  <div class="pad-y--most">

    <?php
      if (have_posts()) : while(have_posts()) : the_post();
        the_content();
      endwhile; endif;
    ?>

  </div>
</div>

<?php get_template_part('partials/display', 'alert--add-to-cart'); ?>

<?php get_footer(); ?>
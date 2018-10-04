<?php get_header(); ?>

<div class="site-width">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; endif; ?>
</div>

<?php get_template_part('partials/display', 'alert--add-to-cart'); ?>

<?php get_footer(); ?>
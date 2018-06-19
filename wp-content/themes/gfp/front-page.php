<?php get_header(); ?>

<div class="site-width">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <p><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></p>
<?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
<?php 
/*
=========================
Template Name: Page Sections
=========================
*/
?>

<?php get_header(); ?>

<section class="hero">
  <div class="site-width">
    <h1><?php echo get_the_title(); ?></h1>
  </div>
</section>

<?php if (have_rows('page_sections')) : while(have_rows('page_sections')) : the_row('page_sections'); ?>
  <?php if (have_rows('flexible_section')) : while(have_rows('flexible_section')) : the_row(); ?>

    <?php if (get_row_layout() === 'one_up_text_header_with_body_copy') : ?>
      <section class="pad-y--most <?php echo get_row_layout(); ?>" id="<?php the_sub_field('page_section_headline'); ?>">
        <div class="site-width">
          <div class="grid--<?php echo the_sub_field('section_size'); ?>-only">
            <h2><?php the_sub_field('page_section_headline'); ?></h2>
            <?php the_sub_field('section_content'); ?>
          </div>
        </div>
      </section>
    <?php endif; ?>

  <?php endwhile; endif; ?>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
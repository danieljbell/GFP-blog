<?php
  $args = array(
    'post_type' => 'promotions'
  );
  $query = new WP_Query($args);
?>

<?php if ($query->have_posts()) : ?>

  <div class="current-single-promotion">

    <?php while ($query->have_posts()) : $query->the_post(); ?>

      <?php
        $image = get_field('current_promo_image');
        $promo_type = get_field('promo_type');
        if ($promo_type === 'percent') {
          $discount = get_field('percent_amount_off');
        } else {
          $discount = get_field('dollar_amount_off');
        }
        $copy = get_field('current_promo_copy');
        $button_text = get_field('current_promo_button_text');
        $button_link = get_field('current_promo_button_link');
        print_r(get_term_link($button_link[0]));
      ?>


    <?php endwhile; ?>

  </div>

<?php endif; wp_reset_postdata(); ?>
<?php
  $args = array(
    'post_type' => 'promotions'
  );
  $query = new WP_Query($args);
?>

  <ul class="current-promotions--list">

    <?php if ($query->have_posts()) : ?>

    <?php while ($query->have_posts()) : $query->the_post(); ?>

      <?php
        $image = get_field('current_promo_image');
        $image = $image[url];
        
        $promo_type = get_field('promo_type');
        if ($promo_type === 'percent') {
          $discount = get_field('percent_amount_off') . '%';
        } else {
          $discount = '$' . get_field('dollar_amount_off');
        }

        $copy = get_field('current_promo_copy');
        if (!$copy) {
          $copy = get_field('current_promo_button_link');
          $copy = $copy[0]->name;
        }
        
        $button_text = get_field('current_promo_button_text');
        if (!$button_link) {
          $button_text = 'Shop All ' . $copy;
        }

        $button_link = get_field('current_promo_button_link');
        $button_link = get_term_link($button_link[0]);
      ?>

      <li class="current-promotions--item" style="background-image: url(<?php echo $image; ?>);">
        <a href="<?php echo $button_link; ?>">
          <span class="current-promotions--content">
            <span class="current-promotions--offer"><?php echo $discount; ?> Off</span>
            <span class="current-promotions--headline"><?php echo $copy; ?></span>
          </span>
        </a>
      </li>
  

    <?php endwhile; ?>
    <?php else : ?>
      
      <li class="current-promotions--item" style="background-image: url(https://unsplash.it/500/350);">
        <a href="#0">
          <span class="current-promotions--content">
            <span class="current-promotions--offer">Free</span>
            <span class="current-promotions--headline">Shipping Sitewide</span>
          </span>
        </a>
      </li>

    <?php endif; wp_reset_postdata(); ?>

  </ul>
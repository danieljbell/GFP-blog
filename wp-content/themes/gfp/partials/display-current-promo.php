<div class="single-current-promo">
  <!-- <div class="single-current-promo-image"> -->
    <?php
      $promo_image = get_field('current_promo_image', 'option');
      // print_r($promo_image);
      echo '<a href="' . get_field('current_promo_button_link', 'option') . '" title="' . $promo_image["name"] . '">';
        echo '<img src="' . $promo_image["url"] . '" srcset="' . $promo_image["sizes"]["medium"] . ' ' . $promo_image["sizes"]["medium-width"] . 'w, ' . $promo_image["sizes"]["large"] . ' ' . $promo_image["sizes"]["large-width"] . 'w" sizes="(max-width: ' . $promo_image["sizes"]["medium-width"] . 'px) 100vw, ' . $promo_image["sizes"]["medium-width"] . 'px" alt="' . $promo_image["name"] . '">';
      echo '</a>';
    ?>
  <!-- </div>
  <div class="single-current-promo-content">
    <h4 class="single-current-promo-headline"><?php the_field('current_promo_headline', 'option'); ?></h4>
    <p class="single-current-promo-copy"><?php the_field('current_promo_copy', 'option'); ?></p>
    <a href="<?php the_field('current_promo_button_link', 'option'); ?>" class="btn-solid--white"><?php the_field('current_promo_button_text', 'option'); ?></a>
  </div> -->
</div>
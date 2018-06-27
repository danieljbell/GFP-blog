<div class="single-current-promo">
  <?php
    $promo_image = get_field('current_promo_image', 'option');
    echo '<a href="' . get_field('current_promo_button_link', 'option') . '" title="' . $promo_image["name"] . '">';
      echo '<img src="' . $promo_image["url"] . '" srcset="' . $promo_image["sizes"]["medium"] . ' ' . $promo_image["sizes"]["medium-width"] . 'w, ' . $promo_image["sizes"]["large"] . ' ' . $promo_image["sizes"]["large-width"] . 'w" sizes="(max-width: ' . $promo_image["sizes"]["medium-width"] . 'px) 100vw, ' . $promo_image["sizes"]["medium-width"] . 'px" alt="' . $promo_image["name"] . '">';
    echo '</a>';
  ?>
</div>
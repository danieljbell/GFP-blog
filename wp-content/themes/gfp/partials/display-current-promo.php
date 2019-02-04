<?php
  $current_promotions_args = array(
    'post_type' => 'promotions'
  );
  $current_promotions_query = new WP_Query($current_promotions_args);
  $current_page = get_queried_object();
  // print_r($current_page->slug);
?>

<ul class="current-promotions--list">

    <?php if ($current_promotions_query->have_posts()) : ?>

    <?php while ($current_promotions_query->have_posts()) : $current_promotions_query->the_post(); ?>

      <?php
        // $promotion_terms = get_field('categories_on_sale');
        // $promo_not_current_category = false;

        // foreach ($promotion_terms as $term) {
        //   if ($current_page->slug !== $term->slug) {
        //     $promo_not_current_category = true;
        //   }
        // }

        $image = get_field('current_promo_image');
        
        if (!$image) {
          $thumbnail_id = get_woocommerce_term_meta( $promotion_terms[0]->term_id, 'thumbnail_id', true );
          $image = wp_get_attachment_url( $thumbnail_id );
        } else {
          $image = $image[url];
        }

        $promo_selected_type = get_field('promo_type');
        if ($promo_selected_type === 'coupon') {
          $coupon = new WC_coupon(get_field('coupon'));
          $promo_type = $coupon->get_discount_type();
          if ($promo_type === 'percent') {
            $discount = $coupon->get_amount() . '%';
          } else {
            $discount = '$' . $coupon->get_amount();
          }
        } else {
          $promo_type = get_field('sale_type');
          if ($promo_type === 'percentage') {
            $discount = get_field('sale_amount') . '%';
          } else {
            $discount = '$' . get_field('sale_amount');
          }
        }

        $promo_headline = get_field('promo_headline');
        if (!$promo_headline) {
          $i = 0;
          $promotion_terms_length = count($promotion_terms);
          foreach ($promotion_terms as $cool) {
            // last iteration
            if ($i == $promotion_terms_length - 1) {
              $promo_headline = $promo_headline . $cool->name;
            } else {
              $promo_headline = $promo_headline . $cool->name . ' & ';
            }
            $i++;
          }
        }

        $promo_body_copy = get_field('promo_body_copy');
        if (!$promo_body_copy) {
          $coupon_code = $coupon->get_code();
          $promo_body_copy = 'Use promo code <span class="current-promotions--promo-code">' . $coupon_code . '</span> when checking out to save!';
        }

        if ($promotion_terms_length === 1) {
          $button_link = get_term_link($promotion_terms[0]);
        }
        
        if (get_field('sale_end_date')) {
          $expiry = get_field('sale_end_date');
        }        
        if ($promo_selected_type === 'coupon') {
          $expiry = str_replace("-", "", $coupon->get_date_expires()->date_i18n()) . ', 12:00 am';
        }

        // echo date("Ymd") . '<br>';
        // echo substr($expiry, 0, 8);
        
        if ((substr($expiry, 0, 8) > date("Ymd"))) :
      ?>

        <li class="current-promotions--item <?php if ($promo_selected_type === 'coupon') { echo 'current-promotions--item__has-body-copy'; } ?>" style="background-image: url(<?php echo $image; ?>);" <?php if ($expiry) { echo 'data-offer-expiry="' . $expiry . '"'; } ?>>
          <a href="<?php echo $button_link; ?>">
            <span class="current-promotions--content">
              <span class="current-promotions--offer"><?php echo $discount; ?> Off</span>
              <span class="current-promotions--headline"><?php echo $promo_headline; ?></span>
              <?php if ($promo_selected_type === 'coupon') {
                echo '<span class="current-promotions--body-copy">', $promo_body_copy, '</span>';
              } ?>
            </span>
          </a>
        </li>
  
      <?php endif; ?>

    <?php endwhile; ?>
  
    <?php
      /*
      ================================
      ADD ANY STATIC PROMOTIONS HERE
      ================================
      */
    ?>

    <?php else : ?>
      
      <?php
        /*
        =========================
        <li class="current-promotions--item" style="background-image: url(https://unsplash.it/500/350);">
        <a href="#0">
          <span class="current-promotions--content">
            <span class="current-promotions--offer">Free</span>
            <span class="current-promotions--headline">Shipping Sitewide</span>
          </span>
        </a>
      </li>
        =========================
        */
      ?>

    <?php endif; wp_reset_postdata(); ?>

  </ul>
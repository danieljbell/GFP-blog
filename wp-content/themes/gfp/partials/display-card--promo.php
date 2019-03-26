<?php
  $promotion_headline = get_field('promotion_headline');
  $promotion_image = get_field('promotion_image');
  $promotion_body_copy = get_field('promotion_body_copy');
  $promotion_type = get_field('promotion_type');
  $categories_on_sale = get_field('categories_on_sale');
  $promotion_end_date = get_field('promotion_end_date');
  
  if ($promotion_headline === '') {
    $promotion_headline = $categories_on_sale[0]->name;
  }

  if ($categories_on_sale) {
    $button_link = get_term_link($categories_on_sale[0]->term_id);
  }

  if (get_field('custom_link')) {
    $button_link = get_field('custom_link_url');
  }

  $discount = [
    "type" => get_field('discount_type'),
    "amount" => (get_field('discount_type')) === 'dollar' ? "$" . get_field('discount_amount') : get_field('discount_amount') . "%"
  ];

?>


<li class="card--promo-card">
  <a href="<?php echo $button_link; ?>">
    <header style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(<?php echo $promotion_image; ?>);">
      <div class="promo-card--meta">
        <?php 
          // print_r($promotion_type);
          if ($promotion_type !== 'landing-page') :
            if ($promotion_type === 'coupon') :
              echo '<div class="promo-card--tag">Free</div>';
            else : 
              echo '<div class="promo-card--tag">' . $discount['amount'] . ' Off</div>';
            endif;
          else :
            echo '<div class="promo-card--tag">Feature</div>';
          endif;
          echo '<div class="promo-card--title">' . $promotion_headline . '</div>';
        ?>
      </div>
    </header>
    <div class="promo-card--content">
      <?php
        if ($promotion_type === 'landing-page') :
          echo '<div class="btn-solid--brand-two">Learn More</div>';
        elseif ($promotion_type === 'coupon') :
          echo '<div class="btn-solid--brand-two">Get it Now!</div>';
        else :
          echo '<div class="btn-solid--brand-two">Save ' . $discount['amount'] . ' Now</div>';
        endif;
      ?>
      <?php
        if ($promotion_type === 'coupon') {
          $coupon_details = get_field('coupon');
          echo '<p>' . $promotion_body_copy . '. Use coupon code <span class="current-promotions--promo-code">' . $coupon_details->post_title . '</span> when checking out to save! <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
        } elseif ($promotion_type === 'discount')  {
          echo '<p>' . $promotion_body_copy . '. <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
        } else {
          echo '<p>' . $promotion_body_copy . '</p>';
        }
      ?>
    </div>
  </a>
</li>
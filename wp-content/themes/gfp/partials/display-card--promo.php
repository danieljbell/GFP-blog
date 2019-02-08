<?php
  // $promotion_terms = get_field('categories_on_sale');
  // $promo_not_current_category = false;

  // foreach ($promotion_terms as $term) {
  //   if ($current_page->slug !== $term->slug) {
  //     $promo_not_current_category = true;
  //   }
  // }

  $image = get_field('current_promo_image');

  // if (!$image) {
  //   $thumbnail_id = get_woocommerce_term_meta( $promotion_terms[0]->term_id, 'thumbnail_id', true );
  //   $image = wp_get_attachment_url( $thumbnail_id );
  // } else {
    $image = $image['url'];
  // }

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

  if (get_field('sale_end_date')) {
    $expiry = get_field('sale_end_date');
  }        
  if ($promo_selected_type === 'coupon') {
    $expiry = str_replace("-", "", $coupon->get_date_expires()->date_i18n()) . ', 12:00 am';
  }
  
  $promo_body_copy = get_field('promo_body_copy');
  if ($promo_selected_type === 'coupon') {
    $coupon_code = $coupon->get_code();
    $promo_body_copy = 'Use promo code <span class="current-promotions--promo-code">' . $coupon_code . '</span> when checking out to save! Offer ends ' . date("F jS, Y", strtotime($expiry));
  } else {
    $promo_body_copy = 'Save now on all ' . $promo_headline . '. No code needed, savings automatically applied. Offer ends ' . date("F jS, Y", strtotime($expiry));
  }

  if ($promotion_terms_length === 1) {
    $button_link = get_term_link($promotion_terms[0]);
  }

  if ((substr($expiry, 0, 8) > date("Ymd"))) :
?>

<li class="card--promo-card">
  <a href="<?php echo $button_link; ?>">
    <header style="background-image: url(<?php echo $image; ?>);">
      <div class="promo-card--meta">
        <div class="promo-card--tag"><?php echo $discount; ?> Off</div>
        <div class="promo-card--title"><?php echo $promo_headline; ?></div>
      </div>
    </header>
    <div class="promo-card--content">
      <div class="btn-solid--brand-two">Save <?php echo $discount . ' On ' . $promo_headline . ' Now'; ?></div>
      <p><?php echo $promo_body_copy; ?></p>
    </div>
  </a>
</li>

<?php endif; ?>
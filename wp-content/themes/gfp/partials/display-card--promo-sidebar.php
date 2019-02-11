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

  $button_link = '#0';
  if ($categories_on_sale) {
    $button_link = get_term_link($categories_on_sale[0]->term_id);
  }

  $discount = [
    "type" => get_field('discount_type'),
    "amount" => (get_field('discount_type')) === 'dollar' ? "$" . get_field('discount_amount') : get_field('discount_amount') . "%"
  ];
?>

<li class="card--promo-sidebar">
  <a href="<?php echo $button_link; ?>">
    <div class="card-content" style="background-image: linear-gradient(rgba(0,0,0,0) 40%, rgba(0,0,0,1)), url(<?php echo $promotion_image; ?>);">
      <p class="card--promo-sidebar-title"><?php echo $promotion_headline; ?></p>
      <?php
        if ($promotion_type === 'coupon') {
          $coupon_details = get_field('coupon');
          echo '<p class="card--promo-sidebar-details">' . $promotion_body_copy . '. Use coupon code <span class="current-promotions--promo-code">' . $coupon_details->post_title . '</span> when checking out to save! <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
        } else {
          echo '<p class="card--promo-sidebar-details">' . $promotion_body_copy . '. <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
        }
      ?>
    </div>
  </a>
</li>

<?php
/*
=========================
<a href="<?php echo $button_link; ?>">
  <header style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(<?php echo $promotion_image; ?>);">
    <div class="promo-card--meta">
      <div class="promo-card--tag"><?php echo $discount['amount']; ?> Off</div>
      <div class="promo-card--title"><?php echo $promotion_headline; ?></div>
    </div>
  </header>
  <div class="promo-card--content">
    <div class="btn-solid--brand-two">Save <?php echo $discount['amount'] . ' Now'; ?></div>
    <?php
      if ($promotion_type === 'coupon') {
        $coupon_details = get_field('coupon');
        echo '<p>' . $promotion_body_copy . '. Use coupon code <span class="current-promotions--promo-code">' . $coupon_details->post_title . '</span> when checking out to save! <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
      } else {
        echo '<p>' . $promotion_body_copy . '. <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
      }
    ?>
  </div>
</a>
=========================
*/
?>








<?php
/*
=========================
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

  $discount = [
    "type" => get_field('discount_type'),
    "amount" => (get_field('discount_type')) === 'dollar' ? "$" . get_field('discount_amount') : get_field('discount_amount') . "%"
  ];

?>


<li class="card--promo-card">
  <a href="<?php echo $button_link; ?>">
    <header style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(<?php echo $promotion_image; ?>);">
      <div class="promo-card--meta">
        <div class="promo-card--tag"><?php echo $discount['amount']; ?> Off</div>
        <div class="promo-card--title"><?php echo $promotion_headline; ?></div>
      </div>
    </header>
    <div class="promo-card--content">
      <div class="btn-solid--brand-two">Save <?php echo $discount['amount'] . ' Now'; ?></div>
      <?php
        if ($promotion_type === 'coupon') {
          $coupon_details = get_field('coupon');
          echo '<p>' . $promotion_body_copy . '. Use coupon code <span class="current-promotions--promo-code">' . $coupon_details->post_title . '</span> when checking out to save! <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
        } else {
          echo '<p>' . $promotion_body_copy . '. <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime($promotion_end_date)) . '">on ' . date("F j, Y", strtotime($promotion_end_date)) . '</span></span></p>';
        }
      ?>
    </div>
  </a>
</li>
=========================
*/
?>
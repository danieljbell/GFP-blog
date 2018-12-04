<?php
  $product_term = get_the_terms($post->ID, 'product_cat');
  $product_vendor = get_post_meta($post->ID, 'vendor_selection')[0];
  if (get_the_terms($post->ID, 'product_tag')) {
      $allProductTags = wp_get_post_terms($post->ID, 'product_tag');
  }
  $product = wc_get_product($post->ID);
  // print_r($product);
?>

<li class="products--item" data-brand="<?php echo $product_vendor; ?>">
    <div class="products--image">
      <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>



<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/" . $product->get_sku() . "-0.jpg",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Content-Type: application/json",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

if ($response) {
  echo '<img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/' . $product->get_sku() . '-0.jpg" alt="">';
} else {
  echo '<img src="' . get_stylesheet_directory_URI() . '/dist/img/partPicComingSoon.jpg">';
}

curl_close($curl);


?>







        
      </a>
    </div>
    <div class="products--content">
      <?php
        // print_r();
        echo '<p class="card-category"><a href="/product-category/', $product_term[count($product_term) - 1]->slug,'">', $product_term[count($product_term) - 1]->name, '</a></p>';
        do_action( 'woocommerce_before_shop_loop_item' );
        do_action( 'woocommerce_shop_loop_item_title' );
        echo '</a>';
        do_action( 'woocommerce_after_shop_loop_item_title' );
        if ($allProductTags) {
          $model_text = 'models';
          if (count($allProductTags) < 2) {
            $model_text = 'model';
          }
          echo '<p class="cart-fitment-count"><em>Fits ', count($allProductTags), ' ', $model_text, '</em></p>';
        }
      ?>
        <div class="products--actions">
          <button class="add-to-cart btn-solid--brand-two" value="<?php echo $post->ID; ?>">Add to Cart</button>
          <!-- <a href="<?php echo get_the_permalink(); ?>" class="btn-outline--brand">View More</a> -->
        </div>
    </div>
</li>
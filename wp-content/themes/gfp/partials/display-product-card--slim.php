<?php
  $product_term = get_the_terms($post->ID, 'product_cat');
  $product_vendor = get_post_meta($post->ID, '_pa_brand')[0];
  $product = wc_get_product($post->ID);
?>


<li class="products--item product-card--slim" data-brand="<?php echo $product_vendor; ?>">
    <div class="products--image">
      <?php if ( has_post_thumbnail() ) : ?>
        <img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/<?php echo $product->get_sku(); ?>-0.jpg" alt="">
      <?php else : ?>
        <img src="<?php echo wc_placeholder_img_src(); ?>" alt="Part Photo Coming Soon">
      <?php endif; ?>
    </div>
    <div class="products--content">
      <?php
        // print_r();
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
        </div>
    </div>
</li>
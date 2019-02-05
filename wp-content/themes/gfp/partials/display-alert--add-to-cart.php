<?php
  $cart = WC()->instance()->cart;
  $cart_line_items = $cart->get_cart();
  $item_count = 0;
  foreach ($cart_line_items as $key => $line_item) {
    $item_count = $item_count + $line_item['quantity'];
  }
?>

<div class="drawer drawer--add-to-cart" role="alert">
  <button class="close-drawer btn-solid--brand-two"><span>&times;</span> Hide Cart</button>
  <?php if (($item_count > 1) || ($item_count === 0)) : ?>
    <h3 class="drawer--header"><span class="item-count"><?php echo $item_count; ?> Items in your Cart</span><br /><span class="cart-subtotal">Cart Subtotal: <span class="subtotal-amount">$<?php echo $cart->get_totals()['subtotal']; ?></span></span></h3>
  <?php else : ?>
    <h3 class="drawer--header"><span class="item-count"><?php echo $item_count; ?> Item in your Cart</span><br /><span class="cart-subtotal">Cart Subtotal: <span class="subtotal-amount">$<?php echo $cart->get_totals()['subtotal']; ?></span></span></h3>
  <?php endif; ?>
  <div class="countdown-to-free-shipping">
    <h4>Keep Shopping!</h4>
    <p>Add $<span class="countdown">24.85</span> to your order to get free shipping</p>
    <div class="progress">
      <p class="start">$0</p>
      <p class="bar"><span class="status" style="width: 24%;"></span></p>
      <p class="end">$49.99</p>
    </div>
  </div>
  <ul class="drawer--items-list">
    <?php 
      foreach ($cart_line_items as $line_item) :
        $line_item_details = $line_item['data'];
        $permalink = $line_item_details->get_permalink();
        $id = $line_item_details->get_id();
        $sku = strtoupper($line_item_details->get_sku());
        $qty = $line_item['quantity'];
        $name = $line_item_details->get_name();
        $product_brands = get_terms('pa_brand');
        foreach ($product_brands as $key => $brand) {
          $name = str_replace($brand->name . ' ', '', $name);
        }
        $name = str_replace($sku, '', $name);
        $price = $line_item_details->get_regular_price();
        $sale_price = $line_item_details->get_sale_price();
       ?>
      <li class="drawer--item" data-product-id="<?php echo $id; ?>" data-product-key="<?php echo $line_item['key']; ?>">
        <div class="drawer-item-action">
          <button class="drawer-remove-item">&times;</button>
        </div>
        <div class="drawer-item-image">
          <a href="<?php echo $permalink; ?>">
            <?php if (has_post_thumbnail($id)) : ?>
              <img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/<?php echo $sku; ?>-0.jpg" alt="">
            <?php else :  ?>
              <img src="<?php echo get_stylesheet_directory_URI() . '/dist/img/partPicComingSoon.jpg' ?>" alt="No Part Image">
            <?php endif; ?>
          </a>
        </div>
        <div class="drawer-item-content">
          <p class="drawer-item-title"><a href="<?php echo $permalink; ?>"><?php echo $name; ?></a></p>
          <?php if ($sale_price) : ?>
            <p class="drawer-item-price"><span class="drawer-item-sku"><?php echo $sku; ?></span> - <del>$<?php echo $price; ?></del> <span class="drawer-item-sale-price">$5.99</span> each</p>
          <?php else : ?>
            <p class="drawer-item-price"><span class="drawer-item-sku"><?php echo $sku; ?></span> - $<?php echo $price; ?> each</p>
          <?php endif; ?>
          <label for="" class="drawer-item-label">Quantity:</label>
          <input type="number" class="drawer-item-input" min="1" step="1" value="<?php echo $qty; ?>">
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
  <p class="has-text-center mar-y--more"><a href="/cart/" class="btn-solid--brand">Checkout</a></p>
</div>
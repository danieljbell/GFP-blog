<?php
  $cart = WC()->instance()->cart;
  $cart_line_items = $cart->get_cart();
?>

<div class="drawer drawer--add-to-cart" role="alert">
  <button class="close-drawer btn-solid--brand-two"><span>&times;</span> Hide Cart</button>
  <h3 class="drawer--header">## Items in your Cart<br /><span>Cart Total: $29.99</span></h3>
  <ul class="drawer--items-list">
    <?php 
      foreach ($cart_line_items as $line_item) :
        $line_item_details = $line_item[data];
        $permalink = $line_item_details->get_permalink();
        $id = $line_item_details->get_id();
        $sku = strtoupper($line_item_details->get_sku());
        $qty = $line_item[quantity];
        $name = $line_item_details->get_name();
        $name = str_replace('John Deere ', '', $name);
        $name = str_replace('Green Farm Parts ', '', $name);
        $name = str_replace('Frontier ', '', $name);
        $name = str_replace('A&I ', '', $name);
        $name = str_replace($sku, '', $name);
        $price = $line_item_details->get_regular_price();
        $sale_price = $line_item_details->get_sale_price();
       ?>
      <li class="drawer--item">
        <div class="drawer-item-action">
          <button class="drawer-remove-item">&times;</button>
        </div>
        <div class="drawer-item-image">
          <a href="<?php echo $permalink; ?>">
            <img src="//fillmurray.com/100/100" alt="">
          </a>
        </div>
        <div class="drawer-item-content">
          <p class="drawer-item-title"><a href="<?php echo $permalink; ?>"><?php echo $name; ?></a></p>
          <p class="drawer-item-price"><span class="drawer-item-sku"><?php echo $sku; ?></span> - <del>$9.99</del> <span class="drawer-item-sale-price">$5.99</span> each</p>
          <label for="" class="drawer-item-label">Quantity:</label>
          <input type="number" class="drawer-item-input" min="1" step="1" value="<?php echo $qty; ?>">
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
  <p class="has-text-center mar-y--more"><a href="/cart/" class="btn-solid--brand">Checkout</a></p>
</div>
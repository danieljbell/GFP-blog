<?php
  $cart = WC()->instance()->cart;
  $cart_line_items = $cart->get_cart();
  $items_in_cart = count($cart_line_items);
  $items_in_cart_text = ($items_in_cart > 1 ? 'Products' : 'Product');
?>

<div class="alert--add-to-cart" role="alert">
  <div class="alert--header">
    <h4><?php echo '<span class="product-count">', $items_in_cart, '</span> ', $items_in_cart_text; ?> in Cart</h4>
    <button class="alert--close" id="closeAlert">&times;</button>
  </div>
  <div class="alert--content">
    <ul class="alert--cart-list">
      <?php
        $i = 0;
        foreach ($cart_line_items as $line_item) :
          $line_item_details = $line_item[data];
          $permalink = $line_item_details->get_permalink();
          $id = $line_item_details->get_id();
          $sku = strtoupper($line_item_details->get_sku());
          $name = $line_item_details->get_name();
          $name = str_replace('John Deere ', '', $name);
          $name = str_replace($sku, '', $name);
          $price = $line_item_details->get_regular_price();
          $sale_price = $line_item_details->get_sale_price();
      ?>
      <li class="alert--cart-item" data-index="<?php echo $i; ?>" data-productID="<?php echo $id; ?>">
        <span class="alert--cart-part">
          <span class="alert--cart-part-type"><a href="<?php echo $permalink; ?>"><?php echo $name; ?></a></span>
          <?php if ($sale_price) : ?>
            <span class="alert--cart-part-number"><?php echo $sku; ?> - <del>$<?php echo $price; ?></del> <span class="sale-price">$<?php echo $sale_price; ?></span></span>
          <?php else : ?>
            <span class="alert--cart-part-number"><?php echo $sku; ?> - $<?php echo $price; ?></span>
          <?php endif; ?>
        </span>
        <span>
          <label for="product_quantity">Qty: </label>
          <input type="number" name="product_quantity" min="1" max="50" value="1">
          <button class="alert--remove-item" data-index="<?php echo $i; ?>">&times;</button>
        </span>
      </li>
      <?php
        $i++;
        endforeach;
      ?>
    </ul>
    <div class="has-text-center mar-t--more">
      <!-- <button id="saveForLater" class="btn-outline--brand-two">Save for Later</button> -->
      <a id="submitCheckout" href="/cart/" class="btn-solid--brand">Checkout</a>
    </div>
  </div>
</div>
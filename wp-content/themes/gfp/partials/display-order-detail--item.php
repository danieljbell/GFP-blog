<li class="gfp-order-details--item" data-sku="<?php echo $product->get_sku(); ?>" data-price="<?php echo $unit_price; ?>" data-qty="<?php echo $qty; ?>">
  <div class="gfp-order-details--item-image">
    <a href="<?php echo $link; ?>">
      <?php echo $image; ?>
    </a>
  </div>
  <div class="gfp-order-details--item-details">
    <div class="gfp-order-details--item-name">
      <a href="<?php echo $link; ?>">
        <?php echo $name; ?>
      </a>
    </div>
    <div class="gfp-order-details--item-price">
      Price: &nbsp;$<span class="regular-price"><?php echo $subtotal; ?> <span class="each-price">&ndash; $<?php echo $unit_price; ?> each</span></span>
    </div>
    <div class="gfp-order-details--item-quantity">
      Quantity: &nbsp;<?php echo $qty; ?>
    </div> 
  </div>
</li>

<?php
/*
echo '$<span class="regular-price" data-price="', $line->get_regular_price(), '">', $line->get_regular_price() * $qty, '</span>';
                    if ($qty > 1) {
                      echo '&nbsp;<span class="each-price"> &ndash;&nbsp; $', $line->get_regular_price(), ' each</span>';
                    }
*/
?>
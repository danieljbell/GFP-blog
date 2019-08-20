(function($) {

  // console.log();

  if ($('body').hasClass('woocommerce-cart') && getParameterByName('pc')) {
    var origin = window.origin;
    var pathName = window.location.pathname;
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'add_coupon',
        coupon: getParameterByName('pc'),
        _ajax_nonce: window.ajax_order_tracking.nonce,
      },
      success: function(res) {
        window.location = window.origin + pathName;
      }
    });
  }

  if (!document.body.classList.contains('woocommerce-cart')) {
    return;
  }


  var cartList = document.querySelector('.gfp-order-details--list');
  var updateCartButton = document.querySelector('button[name="update_cart"]');
  var cartSubtotal = document.querySelector('.cart-subtotal td');
  var cartTotal = document.querySelector('.order-total td strong');
  var coupons = document.querySelectorAll('.cart-discount');


  // REMOVE UPDATE CART BUTTON IF JS ENABLED
  if (updateCartButton) {
    updateCartButton.remove();
  }

  
  /*
  ==============================
  Handle Disable of "Update Cart" Button
  ==============================
  */ 
  cartList.addEventListener('change', function(e) {
    if (e.target.tagName !== 'INPUT') {
      return;
    }
    updateLineItemPrice(e.target);
    // updateCartTotals();
  });

  function updateLineItemPrice(item) {
    console.log('update line item price');

    // console.log();
    
    var itemDetails = item.parentElement.parentElement.parentElement;
    var regularPrice = itemDetails.querySelector('.regular-price');
    var salePrice = itemDetails.querySelector('.sale-price');
    
    regularPrice.textContent = (regularPrice.dataset.price * item.value).toFixed(2);
    
    if (salePrice) {
      salePrice.textContent = '$' + (salePrice.dataset.salePrice * item.value).toFixed(2);
    }

    cartSubtotal.textContent = 'Updating...';
    cartTotal.textContent = 'Updating...';
    coupons.forEach(function(coupon) {
      var couponType = coupon.dataset.discountType;
      if (couponType === 'coupon-percent') {
        coupon.querySelector('td[data-title]').textContent = 'Updating...';
      }
    });


    atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
      method: 'POST',
      data: {
        action: 'increment_item_in_cart',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        product_key: $(item).parents('.gfp-order-details--item').data('productKey'),
        qty: item.value
      }
    }).then(function() {
      updateCartTotals();
    });

  }

  function updateCartTotals() {
    console.log('update cart totals');
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'get_cart',
        _ajax_nonce: window.ajax_order_tracking.nonce,
      },
      success: function(res) {
        // console.log(res);
        cartSubtotal.textContent = '$' + res.totals.subtotal;
        cartTotal.textContent = '$' + res.totals.total;
      }
    })


    // atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
    //   method: 'POST',
    //   data: {
    //     action: 'get_cart',
    //     _ajax_nonce: window.ajax_order_tracking.nonce,
    //   }
    // }).then(function(response) {
    //   console.log(response);
    //   var cart = Object.values(JSON.parse(response.data.slice(0,-1)));
    //   var cartSubtotalAmount = 0;
    //   var cartTotalAmount = 0;
      
    //   cart.forEach(function(item) {
    //     cartSubtotalAmount = cartSubtotalAmount + item.line_subtotal;
    //     cartTotalAmount = cartTotalAmount + item.line_total;
    //   });

    //   coupons.forEach(function(coupon) {
    //     var couponType = coupon.dataset.discountType;
    //     var couponAmount = coupon.dataset.discountAmount;
    //     // console.log(couponAmount);
    //     if (couponType === 'coupon-percent') {
    //       var discount = cartSubtotalAmount * (couponAmount / 100);
    //       coupon.querySelector('td[data-title]').textContent = '-$' + discount.toFixed(2);
    //     }
    //   });

    //   cartSubtotal.textContent = '$' + cartSubtotalAmount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    //   cartTotal.textContent = '$' + cartTotalAmount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    // });
  }


  /*
  ============================
  REMOVE AN ITEM FROM THE CART
  ============================
  */
  cartList.addEventListener('click', function(e) {
    // http://localhost:3000/cart/?remove_item=e721a54a8cf18c8543d44782d9ef681f&_wpnonce=c1398978cc
    if (e.target.className !== 'remove') {
      return;
    }
    e.preventDefault();
    cartSubtotal.textContent = 'Updating...';
    cartTotal.textContent = 'Updating...';
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'remove_item_from_cart',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        product_key: e.target.dataset.productKey
      },
      success: function(response) {
        console.log(response.data);
        e.target.parentElement.remove();
        updateCartTotals();
      }
    });
    // atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
    //   method: 'POST',
    //   data: {
    //     action: 'remove_item_from_cart',
    //     product_id: e.target.dataset.product_id
    //   }
    // })
    //   .then(function(response) {
    //     console.log(response.data);
    //     e.target.parentElement.remove();
    //     updateCartTotals();
    //   });
  });

})(jQuery);
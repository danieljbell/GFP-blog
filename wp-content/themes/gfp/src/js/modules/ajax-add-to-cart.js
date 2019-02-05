(function($) {

  var cartDrawer = $('.drawer--add-to-cart');
  var cartItemList = document.querySelector('.drawer--items-list');
  var closeDrawerButton = $('.close-drawer');
  var openDrawerButton = $('.open-drawer');
  var addToCartButton = $('.add-to-cart');
  var body = $('body');
  var cartSubtotal = $('.drawer--add-to-cart .subtotal-amount');
  var itemCountText = $('.drawer--add-to-cart .item-count');
  // var cartItemCount = 0;
  // var itemInputs = document.querySelectorAll('.drawer--item .drawer-item-input');

  // body.on('click', function() {
  //   $.ajax({
  //     url: window.location.origin + '/wp-admin/admin-ajax.php',
  //     method: 'POST',
  //     data: {
  //       action: 'get_cart',
  //     },
  //     success: function(results) {
  //       console.log(results);
  //     }
  //   })
  // });


  closeDrawerButton.on('click', closeDrawer);

  body.on('click', '.open-drawer', openDrawer);
  body.on('click', '.add-to-cart', addLineItem);

  // addToCartButton.on('click', addLineItem);

  body.on('change', '.drawer--item .drawer-item-input', function(e) {
    var item = $(this).parents('.drawer--item');
    changeQuantity(item);
  })

  body.on('keyup', function(e) {
    if ((e.keyCode === 27) && body.hasClass('cart-drawer--open')) {
      closeDrawer();
    }
  });

  cartDrawer.on('click', '.drawer-remove-item', function() {
    var elem = $(this);
    removeLineItem(elem);
  });

  function openDrawer() {
    if (body.hasClass('woocommerce-cart')) {
      window.location.reload(false);
      return;
    }
    $('body').addClass('cart-drawer--open').removeClass('cart-drawer--closed');
  }

  function closeDrawer() {
    body.removeClass('cart-drawer--open').addClass('cart-drawer--closed');
  }

  function updateCartCount(items, subtotal) {
    var count = 0;
    for (var i = 0; i < items.length; i++) {
      count += parseInt(items[i].productQty);
    }
    if ((count > 1) || (count === 0)) {
      itemCountText.text(count + ' Items in your Cart');
    } else {
      itemCountText.text(count + ' Item in your Cart');
    }
    $('.cart--count').text(count);
    console.log(subtotal);
    $('.progress .bar .status').animate({
      width: ((subtotal / 49.99) * 100).toFixed(2) + '%'
    });
  }

  function updateCartSubtotal(amount) {
    cartSubtotal.text('$' + amount);
  }

  function addLineItem(e) {
    // console.log(e.target);
    e.preventDefault();
    var productID = $(this).attr('value');
    // console.log(productID);
    $.ajax({
      url: window.location.origin + '/wp-admin/admin-ajax.php',
      method: 'POST',
      data: {
        action: 'add_item_to_cart',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        product_id: productID
      },
      success: function(results) {
        console.log(results);
        cartSubtotal.text('$' + results.subtotal);
        populateCart(results.lineItems);
        updateCartCount(results.lineItems, results.subtotal);
      }
    })
    openDrawer();
  }

  function removeLineItem(elem) {
    var productID = elem.parents('.drawer--item').data('product-id');
    var productKey = elem.parents('.drawer--item').data('product-key');
    elem.parents('.drawer--item').addClass('remove');
    elem.parents('.drawer--item').on('transitionend', function() {
      $(this).remove();
    })
    $.ajax({
      url: window.location.origin + '/wp-admin/admin-ajax.php',
      method: 'POST',
      data: {
        action: 'remove_item_from_cart',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        product_id: productID,
        product_key: productKey
      },
      success: function(results) {
        cartSubtotal.text('$' + results.subtotal);
        updateCartCount(results.lineItems, results.subtotal);
      },
      error: function(error) {
        console.log(error);
      }
    })
  }

  function changeQuantity(item) {
    var productID = item.data('product-id');
    var productKey = item.data('product-key');
    var val = item.find('input.drawer-item-input').val();
    console.log(productID, productKey, val);
    $.ajax({
      url: window.location.origin + '/wp-admin/admin-ajax.php',
      method: 'POST',
      data: {
        action: 'increment_item_in_cart',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        product_id: productID,
        product_key: productKey,
        qty: parseInt(val)
      },
      success: function(results) {
        console.log(results);
        cartSubtotal.text('$' + results.subtotal);
        updateCartCount(results.lineItems, results.subtotal);
      },
      error: function(error) {
        console.log(error);
      }
    });
  }

  function populateCart(lineItems) {
    console.log(lineItems);
    cartItemList.innerHTML = lineItems.map(function(item) {
      if (item.SalePrice !== "") {
        var priceHTML = '<p class="drawer-item-price"><span class="drawer-item-sku">' + item.productSku + '</span> - $' + item.productRegularPrice + ' each</p>';
      } else {
        var priceHTML = '<p class="drawer-item-price">Yes Sale</p>';
      }
      return (
        '<li class="drawer--item" data-product-id="' + item.productID + '" data-product-key="' + item.productKey + '">' + 
          '<div class="drawer-item-action">' +
            '<button class="drawer-remove-item">&times;</button>' +
          '</div>' +
          '<div class="drawer-item-image">' +
            '<a href="' + item.productPermalink + '">' +
              item.productImg +
            '</a>' +
          '</div>' +
          '<div class="drawer-item-content">' +
            '<p class="drawer-item-title"><a href="' + item.productPermalink + '">' + item.productName + '</a></p>' +
              priceHTML +
            '<label for="" class="drawer-item-label">Quantity:</label>' +
            '<input type="number" class="drawer-item-input" min="1" step="1" value="' + item.productQty + '">' +
          '</div>' +
        '</li>'
      );
    }).join('');
  }

})(jQuery);
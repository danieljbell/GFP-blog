(function($) {

  var cartDrawer = $('.drawer--add-to-cart');
  var cartItemList = document.querySelector('.drawer--items-list');
  var closeDrawerButton = $('.close-drawer');
  var openDrawerButton = $('.open-drawer');
  var addToCartButton = $('.add-to-cart');
  var body = $('body');
  var cartSubtotal = $('.drawer--add-to-cart .subtotal-amount');

  var itemInputs = document.querySelectorAll('.drawer--item .drawer-item-input');


  closeDrawerButton.on('click', closeDrawer);

  body.on('click', '.open-drawer', function(e) {
    $('body').toggleClass('cart-drawer--open').toggleClass('cart-drawer--closed');
  })

  addToCartButton.on('click', addLineItem);

  body.on('keyup', function(e) {
    if ((e.keyCode === 27) && body.hasClass('cart-drawer--open')) {
      closeDrawer();
    }
  });

  cartDrawer.on('click', '.drawer-remove-item', function() {
    var elem = $(this);
    removeLineItem(elem);
  });

  function closeDrawer() {
    body.toggleClass('cart-drawer--open').toggleClass('cart-drawer--closed');
  }

  function updateCartCount() {
    $('.drawer--add-to-cart .item-count').text(itemsInCart);
  }

  function updateCartSubtotal(amount) {
    cartSubtotal.text('$' + amount);
  }

  function addLineItem() {
    var productID = $(this).attr('value');
    $.ajax({
      url: window.location.origin + '/wp-admin/admin-ajax.php',
      method: 'POST',
      data: {
        action: 'add_item_to_cart',
        product_id: productID
      },
      success: function(results) {
        cartSubtotal.text('$' + results.subtotal);
        populateCart(results.lineItems);
      }
    })
    $(this).prop('disabled', true).addClass('disabled').text('Added To Cart!');
    $(this).parent().append('<button class="open-drawer btn-solid--brand-two mar-l">View Cart</button>');
  }

  function removeLineItem(elem) {
    var productID = elem.parents('.drawer--item').data('product-id');
    $.ajax({
      url: window.location.origin + '/wp-admin/admin-ajax.php',
      method: 'POST',
      data: {
        action: 'remove_item_from_cart',
        product_id: productID
      },
      success: function(results) {
        console.log(results);
        elem.parents('.drawer--item').addClass('remove');
        elem.parents('.drawer--item').on('transitionend', function() {
          $(this).remove();
        })
      },
      error: function(error) {
        console.log(error);
      }
    })
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
        '<li class="drawer--item" data-product-id="">' + 
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
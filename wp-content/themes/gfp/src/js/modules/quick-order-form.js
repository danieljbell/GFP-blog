(function($) {
  
  var spinner = $('.placeholder');
  var form = $('.quick-order-form');
  var products = form.siblings('.gfp-order-details--list');
  var checkout = form.siblings('.checkout');

  form.on('submit', addPart);
  products.on('click', '.remove', removePart);
  products.on('keyup', 'input[name="part-qty"]', changePartQty);
  checkout.on('click', 'button', buildCart);

  function addPart(e) {
    e.preventDefault();
    var skuInput = $(this).find('#sku');
    var qtyInput = $(this).find('#qty');
    var sku = skuInput.val();
    var qty = qtyInput.val();

    skuInput.val('');
    skuInput.focus();
    qtyInput.val('1');
    
    showSpinner();
    hideErrors();

    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'get_product_info',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        sku: sku,
        qty: qty
      },
      success: function(res) {
        hideSpinner();
        showProducts();
        formatResults(res, qty);
      }
    })
  }

  function showSpinner() {
    spinner.removeClass('visually-hidden');
  }

  function hideSpinner() {
    spinner.addClass('visually-hidden'); 
  }

  function hideErrors() {
    products.find('.error').remove();
  }

  function showProducts() {
    products.removeClass('visually-hidden');
  }

  function formatResults(res, qty) {
    if (res.status === 'failed') {
      products.prepend('<li class="gfp-order-details--item error"><button class="remove">&times;</button>Sorry, that doesn\'t look like a part we carry.<br>Please double check your part number and try again.</li>');
      return;
    }

    products.append('<li class="gfp-order-details--item" data-product-id="' + res.id + '" data-product-price="' + res.price + '"><button class="remove">&times;</button><div class="gfp-order-details--item-image"><a href="' + res.link + '">' + res.img + '</a></div><div class="gfp-order-details--item-details"><div class="gfp-order-details--item-name"><a href="' + res.link + '">' + res.name + '</a></div><div class="gfp-order-details--item-price">$<span class="subtotal">' + (Number(res.price) * qty).toFixed(2) + '</span> <span class="each-price">- $' + Number(res.price).toFixed(2) + ' each</span></div><div class="gfp-order-details--item-quantity">Quantity: <input type="number" min="1" max="100" name="part-qty" value="' + qty + '" /></div></div></li>');

    showCheckoutButton();
  }

  function removePart(e) {
    e.preventDefault();
    $(this).parent().remove();
    var productID = $(this).parents('.gfp-order-details--item').data('productId');
  }

  function showCheckoutButton() {
    checkout.removeClass('visually-hidden');
  }

  function changePartQty() {
    var productID = $(this).parents('.gfp-order-details--item').data('productId');
    var productPrice = $(this).parents('.gfp-order-details--item').data('productPrice');
    var newQty = Number($(this).val());
    var newSubtotal = Number(productPrice) * newQty;
    $(this).parents('.gfp-order-details--item').find('.gfp-order-details--item-price .subtotal').text(newSubtotal.toFixed(2));
  }

  function buildCart(e) {
    e.preventDefault();
    $(this).prop('disabled', true).html('<img src="' + window.location.origin + '/wp-content/themes/gfp/dist/img/spinner--light.svg" alt="spinner" class="spinner" style="vertical-align: middle; max-width: 25px; margin-right: 0.5rem;"> Adding Items to Cart');
    var items = products.find('li');
    var productsToAdd = [];
    $.each(items, function() {
      var id = $(this).data('productId');
      var qty = $(this).find('input[name="part-qty"]').val();
      productsToAdd.push({
        id: id,
        qty: Number(qty)
      })
    });
    
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'add_multiple_items',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        items: productsToAdd
      },
      success: function(res) {
        if (res.success === true) {
          ga('send', 'event', {
            eventCategory: 'Form',
            eventAction: 'Quick Order Form',
            eventLabel: productsToAdd.length,
            hitCallback: function() {
              document.location = '/cart/';
            }
          });
        }
      }
    })

    // console.log(productsToAdd);
  }

})(jQuery);
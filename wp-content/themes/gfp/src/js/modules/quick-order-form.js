(function($) {
  
  var spinner = $('.placeholder');
  var form = $('.quick-order-form');
  var products = form.siblings('.gfp-order-details--list');
  var checkout = form.siblings('.checkout');

  form.on('submit', addPart);
  products.on('click', '.remove', removePart);
  products.on('keyup', 'input[name="part-qty"]', changePartQty);

  function addPart(e) {
    e.preventDefault();
    var sku = $(this).find('#sku').val();
    var qty = $(this).find('#qty').val()
    
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

    products.append('<li class="gfp-order-details--item" data-product-id="' + res.id + '"><button class="remove">&times;</button><div class="gfp-order-details--item-image"><a href="' + res.link + '">' + res.img + '</a></div><div class="gfp-order-details--item-details"><div class="gfp-order-details--item-name"><a href="' + res.link + '">' + res.name + '</a></div><div class="gfp-order-details--item-price">$' + (Number(res.price) * qty).toFixed(2) + ' <span class="each-price">- $' + Number(res.price).toFixed(2) + ' each</span></div><div class="gfp-order-details--item-quantity">Quantity: ' + qty + '</div></div></li>');

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
    var newQty = Number($(this).val());
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'GET',
      data: {
        action: 'increment_item_in_cart',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        sku: sku,
        qty: qty
      },
      success: function(res) {
        console.log(res);
      }
    });
  }

})(jQuery);
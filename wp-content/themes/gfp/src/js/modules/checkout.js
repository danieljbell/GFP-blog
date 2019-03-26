(function($) {
  
  var shipToDifferent = document.querySelector('#ship-to-different-address-checkbox');
  var shipDetails = document.querySelector('.shipping-details--is-hidden');
  
  if (shipToDifferent) {
    shipToDifferent.addEventListener('change', function(e) {
      if (!shipToDifferent.checked) {
        shipDetails.classList.add('shipping-details--is-hidden');
        return;
      }
      shipDetails.classList.remove('shipping-details--is-hidden');
    });
  }

  mailchimpOptIn = document.querySelector('#mailchimp_woocommerce_newsletter');
  if (mailchimpOptIn) {
    mailchimpOptIn.checked = true;
  }

  if (getParameterByName('add-coupon')) {
    var coupon = getParameterByName('add-coupon');
    $.ajax({
      url: window.location.origin + '/wp-admin/admin-ajax.php',
      method: 'POST',
      data: {
        action: 'add_coupon',
        coupon: coupon
      },
      success: function(res) {
        $('.woocommerce-cart-form__totals .cart-subtotal').after('<tr class="cart-discount"><th><span class="coupon-code">' + coupon + '</span></th><td>-<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>' + String(Number(Object.values(res.coupon_discount_totals)[0]).toFixed(2)) + '</span></td></tr>');
        var initialPath = window.location.pathname;
        window.history.replaceState( {} , 'bar', initialPath );
      }
    })
  }

})(jQuery);
(function() {
  var cartList = document.querySelector('.gfp-cart--list');
  var updateCartButton = document.querySelector('button[name="update_cart"]');

  cartList.addEventListener('change', function(e) {
    if (e.target.tagName !== 'INPUT') {
      return;
    }
    updateCartButton.disabled = false;
  });
})();
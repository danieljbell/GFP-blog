(function ($) {
  if (window.location.pathname !== '/parts-diagram/') {
    return;
  }

  document.body.addEventListener('click', sendToCart);

  function sendToCart(e) {
    if (!e.target.classList.contains('ariPartListAddToCart')) {
      return;
    }

    console.log('ARI add to cart');
    var partQty = getQty(e.target);
    console.log(partQty);
  }

  function getQty(target) {
    var qty = $(target).parents('.ariPLCart').siblings('.ariPLQtyInput').find('input').val();
    console.log(qty);
  }

})(jQuery);
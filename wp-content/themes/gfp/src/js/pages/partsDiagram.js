(function ($) {
  if (window.location.pathname !== '/parts-diagram/') {
    return;
  }

  document.body.addEventListener('click', sendToCart);

  function sendToCart(e) {
    if (!e.target.classList.contains('ariPartListAddToCart')) {
      return;
    }

    // console.log('ARI add to cart');
    var partQty = getQty(e.target);
    var partID = getID(e.target);
    // console.log(partID, partQty);
  }

  function getQty(target) {
    var qty = $(target).parents('.ariPLCart').siblings('.ariPLQtyInput').find('input').val();
    return qty;
  }

  function getID(target) {
    var params = getParams('ProductCode', target.name);
    console.log(params);
    return '123456';
  }

  function getParams(name, url) {
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");
    var results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  };

})(jQuery);
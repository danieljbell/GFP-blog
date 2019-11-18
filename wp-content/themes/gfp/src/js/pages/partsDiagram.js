(function () {
  if (window.location.pathname !== '/parts-diagram/') {
    return;
  }

  document.body.addEventListener('click', sendToCart);

  function sendToCart(e) {
    if (e.target.classList.contains('ariPartListAddToCart')) {
      console.log('ARI add to cart');
    }
  }

})();
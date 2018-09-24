(function() {

  if (document.body.classList.contains('woocommerce-cart') || document.body.classList.contains('woocommerce-checkout')) {
    // bail
    return;
  }

  var cartDrawer = document.querySelector('.alert--add-to-cart');
  var cartOpen = false;
  var cartList = document.querySelector('.alert--cart-list');
  var cartHeader = document.querySelector('.alert--header');
  
  cartList.addEventListener('click', function(e) {
    if (e.target.matches('a')) {
      console.log('redirect');
      return;
    }
    if (e.target.matches('button')) {
      e.preventDefault();
      removefromCart(e); 
    }
  });

  cartList.addEventListener('change', function(e) {
    incrementItem(e);
  });

  cartHeader.addEventListener('click', function(e) {
    displayCart();
  });

  if (cartList.querySelectorAll('li').length > 0) {
    displayCart(true);
  }

  var addToCartButtons = document.querySelectorAll('.add-to-cart');
  if (addToCartButtons) {
    addToCartButtons.forEach(function(button) {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        updateCartHeaderCount('up');
        addToCart(e.target);
        displayCart();
      })
    });
  }

  function addToCart(elem) {
    if (!elem.value) {
      // get id some other way
    }
    var productID = elem.value;
    console.log(productID);
    atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
      method: 'POST',
      data: {
        action: 'add_item_to_cart',
        product_id: productID,
        qty: 1
      }
    }).then(function(response) {
      console.log(response);
    })
  }

  function populateCart(lineItems) {
    cartList.innerHTML = lineItems.map(function(item, index) {
      return '<li class="alert--cart-item" data-productID="' + item.id + '" data-index="' + index + '"><span class="alert--cart-part"><span class="alert--cart-part-type">' + item.name + '</span><span class="alert--cart-part-number">' + item.sku + '</span></span><span><label for="product_quantity">Qty: </label><input type="number" name="product_quantity" min="1" max="50" value="1"><button class="alert--remove-item" data-index="' + index + '">&times;</button></span></li>';
    }).join('');
  }

  function removefromCart(e) {
    e.preventDefault();
    
    if (e.target.matches('button')) {
      var index = e.target.dataset.index;
      var parent = cartList.querySelector('[data-index="' + index + '"]');
      parent.remove();
      atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
        method: 'POST',
        data: {
          action: 'remove_item_from_cart',
          product_id: parent.dataset.productid
        }
      }).then(function(response) {
        updateCartHeaderCount('down');
      })
    }

  }

  function updateCartHeaderCount(direction) {
    var currentCount = parseInt(cartHeader.querySelector('.product-count').innerText);
    if (!direction) {
      cartHeader.querySelector('.product-count').innerText = currentCount;
      return;
    }

    if (direction === 'up') {
      ++currentCount;
    } else {
      --currentCount;
    }
    cartHeader.querySelector('.product-count').innerText = currentCount;
  }

  function displayCart(isMinimized) {
    if (!cartDrawer) { 
      console.error('Cart Markup is not on the page');
      return;
    }

    cartOpen = !cartOpen;
    cartDrawer.classList.add('alert--is-active');

    if (cartDrawer.classList.contains('alert--is-minimized')) {
      cartDrawer.classList.remove('alert--is-minimized');
      return;
    }

    if (!cartDrawer.classList.contains('alert--is-minimized')) {
      cartDrawer.classList.add('alert--is-minimized');
      return;
    }

    

    

    // cartDrawer.classList.add('alert--is-active');

    // if (cartDrawer.classList.contains('alert--is-minimized')) {
    //   cartDrawer.classList.remove('alert--is-minimized');
    //   isMinimized = !isMinimized;
    // }

    // if (!cartDrawer.classList.contains('alert--is-minimized')) {
    //   cartDrawer.classList.add('alert--is-minimized');
    //   isMinimized = !isMinimized;
    // }

    // if (isMinimized) {
    //   cartDrawer.classList.add('alert--is-minimized');
    //   isMinimized = !isMinimized;
    // }

    // console.log(isMinimized);
    
  }

  function incrementItem(e) {
    var elementChanged = e.target;
    var productID = elementChanged.parentElement.parentElement.dataset.productid;
    var qty = elementChanged.value;
    atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
      method: 'POST',
      data: {
        action: 'increment_item_in_cart',
        product_id: productID,
        qty: qty
      }
    }).then(function(response) {
      // console.log(response.data);
      var responseObj = JSON.parse(response.data.slice(0,-1));
      console.log(responseObj);
      // updateCartHeaderCount('up');
    })
  }

})();
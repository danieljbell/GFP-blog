(function() {

  if (document.body.classList.contains('woocommerce-cart') || document.body.classList.contains('woocommerce-checkout')) {
    // bail
    return;
  }

  var cartDrawer = document.querySelector('.alert--add-to-cart');
  var cartOpen = false;
  var cartList = document.querySelector('.alert--cart-list');
  var cartHeader = document.querySelector('.alert--header');
  var cartLineItems = [];

  if (!cartList) {
    console.error('Ajax Cart Markup doesn\'t exist on the page. Add it!');
    return;
  }
  
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
    displayCart(e);
  });

  if (cartList.querySelectorAll('li').length > 0) {
    displayMinimizedCart();
  }

  var addToCartButtons = document.querySelectorAll('.add-to-cart');
  if (addToCartButtons) {
    addToCartButtons.forEach(function(button) {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        // updateCartHeaderCount('up');
        addToCart(e.target);
      })
    });
  }

  function addToCart(elem) {
    var productID = elem.value;
    atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
      method: 'POST',
      data: {
        action: 'add_item_to_cart',
        product_id: productID,
        qty: 1
      }
    }).then(function(response) {
      if (response.xhr.status === 200) {
        console.log('successfully added ' + productID + ' to cart');
        populateCart();
      }
      
    })
  }

  function populateCart() {
    var lineItems = getProductDetails();

    lineItems.then(function(itemArray) {
      updateCartHeaderCount(itemArray.length);
      cartList.innerHTML = itemArray.map(function(item, index) {
        if (item.salePrice) {
          return '<li class="alert--cart-item" data-productID="' + item.id + '" data-index="' + index + '"><span class="alert--cart-part"><span class="alert--cart-part-type"><a href="' + item.permalink + '">' + item.name + '</a></span><span class="alert--cart-part-number">' + item.sku + ' - <del>$' + item.price + '</del> <span class="sale-price">$' + item.salePrice + '</span></span></span><span class="alert--cart-actions"><label for="product_quantity">Qty: </label><input type="number" name="product_quantity" min="1" max="50" value="1"><button class="alert--remove-item" data-index="' + index + '">&times;</button></span></li>';
        } else {
          return '<li class="alert--cart-item" data-productID="' + item.id + '" data-index="' + index + '"><span class="alert--cart-part"><span class="alert--cart-part-type"><a href="' + item.permalink + '">' + item.name + '</a></span><span class="alert--cart-part-number">' + item.sku + ' - $' + item.price + '</span></span><span class="alert--cart-actions"><label for="product_quantity">Qty: </label><input type="number" name="product_quantity" min="1" max="50" value="1"><button class="alert--remove-item" data-index="' + index + '">&times;</button></span></li>';
        }
      }).join('');
    });
    setTimeout(function() {
      displayCart();
    }, 200)
  }

  function getProductDetails(id) {
    return atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
      method: 'POST',
      data: {
        action: 'get_product_details',
        product_id: id
      }
    }).then(function(response) {
      return JSON.parse(response.data.slice(0,-1));
      // console.log(response.data);
    })
  }

  function removefromCart(e) {
    e.preventDefault();

    populateCart();
    
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
      })
    }

    if (cartList.children.length < 1) {
      cartList.innerHTML = '<li>Your shopping cart is empty.</li>';
    }

  }

  function updateCartHeaderCount(count) {
    
    // if (currentCount > 1 || currentCount === 0) {
      cartHeader.querySelector('h4').innerHTML = '<span class="product-count">' + count + '</span> Products in Cart';
    // } else {
    //   cartHeader.querySelector('h4').innerHTML = '<span class="product-count">' + currentCount + '</span> Product in Cart';
    // }
  }

  function displayCart(e) {
    if (!cartDrawer) { 
      console.error('Cart Markup is not on the page');
      return;
    }

    if (!e) {
      cartDrawer.classList.add('alert--is-active');
      cartDrawer.classList.remove('alert--is-minimized');
      return;
    }

    // cartOpen = !cartOpen;
    if (e.target.classList.contains('alert--header') || e.target.parentElement.classList.contains('alert--header')) {
      cartDrawer.classList.toggle('alert--is-minimized');
      return;
    }

    if (cartDrawer.classList.contains('alert--is-minimized')) {
      cartDrawer.classList.add('alert--is-active');
      cartDrawer.classList.remove('alert--is-minimized');
      return;
    }


    
  }

  function displayMinimizedCart() {
    if (!cartDrawer) { 
      console.error('Cart Markup is not on the page');
      return;
    }
    cartDrawer.classList.add('alert--is-active');
    cartDrawer.classList.add('alert--is-minimized');
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
      if (response.xhr.status === 200) {
        // var responseObj = JSON.parse(response.data.slice(0,-1));
        console.log('quantity for ' + productID + ' is set to ' + qty);
      }
    })
  }

})();
(function() {

  var addToCart = document.querySelectorAll('.add-to-cart');
  var cartList = document.querySelector('.alert--cart-list');
  var cartDrawer = document.querySelector('.alert--add-to-cart');
  var lineItems = JSON.parse(localStorage.getItem('gfp-line-items')) || [];
  var cartHeader = document.querySelector('.alert--header');

  if (lineItems.length > 0) {
    updateCartHeaderCount();
    displayCart(true);
    populateCart(lineItems);
  }

  if (addToCart) {
    for (var i = 0; i < addToCart.length; i++) {
      addToCart[i].addEventListener('click', function(e) {
        e.preventDefault();
        addToCartState(this);
        updateCartHeaderCount();
        displayCart();
      });
    }

    cartHeader.addEventListener('click', function(e) {
      displayCart();
    });
  }

  function addToCartState(elem) {
    var lineItem = {
      id: elem.value,
      name: elem.dataset.productTitle.replace('John Deere ', '').split(' ').slice(0,-1).join(' '),
      sku: elem.dataset.sku.toUpperCase(),
      qty: 1
    }
    lineItems.push(lineItem);
    localStorage.setItem('gfp-line-items', JSON.stringify(lineItems));
    populateCart(lineItems);
  }

  function incrementItems() {

  }

  function updateCartHeaderCount() {
    var productText = 'Product'
    if (lineItems.length > 1) {
      productText = 'Products';
    }
    cartHeader.querySelector('h4').innerText = lineItems.length + ' ' + productText + ' in Cart';
  }

  function populateCart(lineItems) {
    cartList.innerHTML = lineItems.map(function(item, index) {
      return '<li class="alert--cart-item" data-index="' + index + '"><span class="alert--cart-part"><span class="alert--cart-part-type">' + item.name + '</span><span class="alert--cart-part-number">' + item.sku + '</span></span><span><label for="product_quantity">Qty: </label><input type="number" name="product_quantity" min="1" max="50" value="1"><button class="alert--remove-item">&times;</button></span></li>';
    }).join('');
  }

  function displayCart(isMinimized) {
    if (!cartDrawer) { 
      console.error('Cart Markup is not on the page');
      return;
    }
    
    // Default state is open alert
    isMinimized = (typeof isMinimized !== 'undefined') ? isMinimized : false;

    if (isMinimized) {
      cartDrawer.classList.add('alert--is-minimized');
    } else {
      cartDrawer.classList.toggle('alert--is-minimized');
      cartDrawer.classList.add('alert--is-active');
    }
  }

})();
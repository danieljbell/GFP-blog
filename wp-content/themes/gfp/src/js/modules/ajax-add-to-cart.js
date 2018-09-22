(function() {

  if (document.body.classList.contains('woocommerce-cart') || document.body.classList.contains('woocommerce-checkout')) {
    // bail
    return;
  }

  var cartDrawer = document.querySelector('.alert--add-to-cart');
  var cartList = document.querySelector('.alert--cart-list');
  var cartHeader = document.querySelector('.alert--header');
  
  cartList.addEventListener('click', removefromCart);

  cartHeader.addEventListener('click', function(e) {
    displayCart();
  });

  displayCart(true);

  function removefromCart(e) {
    e.preventDefault();
    if (!e.target.matches('button')) {
      return;
    }
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
      console.log(response);
    })
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



//   // document.body.addEventListener('click', function(e) {
//     // .then(function(response) {
//     //   console.log(JSON.parse(response.data.slice(0,-1)));
//     // })
//   // });

//   if (document.body.classList.contains('woocommerce-cart') || document.body.classList.contains('woocommerce-checkout')) {
    
//     // if (true) {}
    
//     // bail
//     return;

//   }

//   var addToCart = document.querySelectorAll('.add-to-cart');
//   var cartList = document.querySelector('.alert--cart-list');
  // var cartDrawer = document.querySelector('.alert--add-to-cart');
//   var lineItems = JSON.parse(localStorage.getItem('gfp-line-items')) || [];
//   var cartHeader = document.querySelector('.alert--header');

//   if (lineItems.length > 0) {
//     getCart();
//     updateCartHeaderCount();
//     displayCart(true);
//     populateCart(lineItems);
//   }

//   if (addToCart) {
    
//     // loop over all add-to-cart buttons and set up functions
//     for (var i = 0; i < addToCart.length; i++) {
//       addToCart[i].addEventListener('click', function(e) {
//         e.preventDefault();
//         addToCartState(this);
//         updateCartHeaderCount();
//         displayCart();
//       });
//     }

//     // toggle cart alert
    // cartHeader.addEventListener('click', function(e) {
    //   displayCart();
    // });

//     // remove item from cart
//     cartList.addEventListener('click', removeFromCartState);

//   }

//   function getCart() {
//     console.log('get cart');
//     atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
//       method: 'POST',
//       data: {
//         action: 'get_cart'
//       }
//     }).then(function(response) {
//       var responseObj = JSON.parse(response.data.slice(0,-1));
//       for (var i = 0; i < responseObj.length; i++) {
//         var lineItem = {
//           id: responseObj[i].product_id,
//           qty: responseObj[i].id
//         }
//         lineItems.push(lineItem);
//       }
//       localStorage.setItem('gfp-order', JSON.stringify(lineItems));
//     })
//   }

//   function addToCartState(elem) {
//     var lineItem = {
//       id: elem.value,
//       name: elem.dataset.productTitle.replace('John Deere ', '').split(' ').slice(0,-1).join(' '),
//       sku: elem.dataset.sku.toUpperCase(),
//       qty: 1
//     }
//     lineItems.push(lineItem);
//     addToWooCart(lineItem);
//     localStorage.setItem('gfp-line-items', JSON.stringify(lineItems));
//     populateCart(lineItems);
//   }

//   function removeFromCartState(e) {
//     if (!e.target.matches('button')) {
//       return;
//     }
//     var index = e.target.dataset.index;
//     var parent = cartList.querySelector('[data-index="' + index + '"]');
//     lineItems.splice(index, 1);
//     parent.remove();
//     localStorage.setItem('gfp-line-items', JSON.stringify(lineItems));
//     atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
//       method: 'POST',
//       data: {
//         action: 'remove_item_from_cart',
//         product_id: parent.dataset.productid
//       }
//     }).then(function(response) {
//       console.log(response);
//     })
//     updateCartHeaderCount();
//   }

//   function incrementItems() {

//   }

//   function updateCartHeaderCount() {
//     var productText;
//     if (lineItems.length > 1) {
//       productText = 'Products';
//     } else {
//       var productText = 'Product';
//     }
//     cartHeader.querySelector('h4').innerText = lineItems.length + ' ' + productText + ' in Cart';
//   }

//   function populateCart(lineItems) {
//     cartList.innerHTML = lineItems.map(function(item, index) {
//       return '<li class="alert--cart-item" data-productID="' + item.id + '" data-index="' + index + '"><span class="alert--cart-part"><span class="alert--cart-part-type">' + item.name + '</span><span class="alert--cart-part-number">' + item.sku + '</span></span><span><label for="product_quantity">Qty: </label><input type="number" name="product_quantity" min="1" max="50" value="1"><button class="alert--remove-item" data-index="' + index + '">&times;</button></span></li>';
//     }).join('');
//   }



//   function addToWooCart(lineItem) {
//     atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
//       method: 'POST',
//       data: {
//         action: 'add_item_to_cart',
//         product_id: lineItem.id,
//         qty: lineItem.qty
//       }
//     })
//   }

})();
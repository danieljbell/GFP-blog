(function() {
  
  /*
  =========================
  FITMENT TEXT FILTER
  =========================
  */

  // Get Vars
  var fitmentTextFilter = document.querySelector('#fitment-text-filter'),
      productFitmentTags = document.querySelectorAll('.single--part-fitment-list a');

  // Check that page has text filter
  if (fitmentTextFilter) {
    fitmentTextFilter.addEventListener('keyup', function(e) {
      var value = e.target.value.toUpperCase();
      // Loop over all fitment and add/remove hidden class
      for (var i = 0; i < productFitmentTags.length; i++) {
        productFitmentTags[i].parentElement.classList.add('hidden');
        if (productFitmentTags[i].textContent.includes(value)) {
          productFitmentTags[i].parentElement.classList.remove('hidden');
        }
      }
    });
  }

  /*
  =========================
  ADD PRODUCT TO CART
  =========================
  */

  // Get Vars
  // var productForm = document.querySelector('#single-product--add-to-cart-form'),
  //     addProductToCart = document.querySelector('#single-product--add-to-cart');
  
  // if (addProductToCart) {

  //   addProductToCart.addEventListener('click', function(e) {
  //     e.preventDefault();
  //     var addToCartDrawer = document.querySelector('.alert--add-to-cart');
      
  //     atomic(window.location.origin + '?add-to-cart=' + e.target.value)
  //       .then(function(response) {
  //         addToCartDrawer.classList.add('alert--is-active');
          
  //         addProductToCart(e.target.value);

  //         function addProductToCart(productID) {

  //           // Check for cart item template and copy the structure
  //           var alertCartItemTemplate = document.querySelector('.alert--cart-item').innerHTML;

  //           var addItem = document.createElement( 'li' );
  //           addItem.classList.add('alert--cart-item');
  //           addItem.dataset.productID = productID;
  //           addItem.innerHTML = alertCartItemTemplate;

  //           var productName = document.querySelector('.entry-title').innerText;
  //           var productSKU = productName.split(' ').splice(-1, 1);
  //           var consolidatedProductName = productName.replace('John Deere ', '').replace(productSKU, '');

  //           addItem.querySelector('.alert--cart-part-number').innerText = window.location.pathname.split('/')[2].toUpperCase();
  //           addItem.querySelector('.alert--cart-part-type').innerText = consolidatedProductName;

  //           document.querySelector('.alert--cart-list').appendChild(addItem);
  //         }
  //       })

  //   })
  // }


})();
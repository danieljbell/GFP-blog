(function() {

  var alertCartItemTemplate = document.querySelector('.alert--cart-item').innerHTML;
  var addedProducts = [];

  document.querySelector('.alert--cart-list').innerHTML = '';

  
  /*
  =========================================
  CHANGE PAGE WHEN SELECTED MODEL MODIFIER
  =========================================
  */
  var modelModiferSelect = document.querySelector('#modelModifiers');
  var mainContainer = document.querySelector('#main_content');
  modelModiferSelect.addEventListener('change', function(e) {
    
    // mainContainer.style.height = mainContainer.offsetHeight;
    // mainContainer.innerHTML = '<div class="site-width pad-y--most"><img src="https://fillmurray.com/200/200"></div>';

    var loc = e.target.value;
    window.location.href = '/' + loc;
  });


  /*
  =========================
  ADDING PRODUCT TO CART
  =========================
  */
  document.addEventListener('click', function(e) {
    var self = e.target;
    
    if (self.classList.contains('add-to-cart')) {

      var alert = document.querySelector('.alert--add-to-cart');
      var partType = e.target.parentElement.parentElement.querySelector('td:first-child').innerText;
      var partNumber = e.target.parentElement.parentElement.querySelector('td:nth-child(2)').innerText;

      if (addedProducts.includes(partNumber)) {
        return;
      }

      addedProducts.push(partNumber);

      var addItem = document.createElement( 'li' );
      addItem.classList.add('alert--cart-item');
      addItem.dataset.productcode = partNumber;
      addItem.innerHTML = alertCartItemTemplate;

      addItem.querySelector('.alert--cart-part-number').innerText = partNumber;
      addItem.querySelector('.alert--cart-part-type').innerText = partType;

      document.querySelector('.alert--cart-list').appendChild(addItem);
      

      alert.classList.add('alert--is-active');

      if (alert.classList.contains('alert--is-minimized')) {
        alert.classList.remove('alert--is-minimized')
      }
    }
  });

  /*
  =========================
  TOGGLE CART ALERT
  =========================
  */
  document.querySelector('#closeAlert').addEventListener('click', function(e) {
    var self = e.target;
    var container = self.parentElement.parentElement;
    var classes = container.classList.toString();

    if (classes.includes('alert--is-minimized')) {
      container.classList.remove('alert--is-minimized');
    } else {
      container.classList.add('alert--is-minimized');
    }
  });


  /*
  =========================
  REMOVE ITEM FROM CART
  =========================
  */
  document.addEventListener('click', function(e) {
    var self = e.target;
    if (self.classList.contains('alert--remove-item')) {
      var productCode = self.parentElement.parentElement.dataset.productcode;
      var index = addedProducts.indexOf(productCode);
      addedProducts.splice(index, 1);
      self.parentElement.parentElement.remove(); 
    }
  });



  function buildCartString() {
    var initURL = 'https://www.greenfarmparts.com/shoppingcart.asp?';
    var allAddedProducts = [];
    var allAddedItems = document.querySelectorAll('.alert--cart-item');

    for (var i = 0; i < allAddedItems.length; i++) {
      var productCode = allAddedItems[i].dataset.productcode;
      var productQty = allAddedItems[i].querySelector('input[name="product_quantity"]').value;
      allAddedProducts.push({
        productCode: productCode,
        productQty: productQty
      });
    }

    for (var i = 0; i < allAddedProducts.length; i++) {
      if (i < 1) {
        initURL = initURL + 'productcode=' + allAddedProducts[i].productCode + '&QTY.' + allAddedProducts[i].productCode + '=' + allAddedProducts[i].productQty;
      } else {
        initURL = initURL + '&productcode=' + allAddedProducts[i].productCode + '&QTY.' + allAddedProducts[i].productCode + '=' + allAddedProducts[i].productQty;
      }
    }

    return initURL;
  }

  /*
  ====================================
  CHECKOUT - Send products to Volusion
  ====================================
  */
  document.querySelector('#submitCheckout').addEventListener('click', function(e) {
    // cart url template: https://www.greenfarmparts.com/shoppingcart.asp?productcode=jdzg900&QTY.jdzg900=5
    e.preventDefault();
    window.location.href = buildCartString();

  });

  /*
  =====================================================
  SAVE FOR LATER - Send products to Volusion and cookie
  =====================================================
  */
  document.querySelector('#saveForLater').addEventListener('click', function(e) {
    e.preventDefault();


    atomic(buildCartString(), {
      method: 'POST'
    })
    .then(function (response) {
      console.log(response.data); // xhr.responseText
      console.log(response.xhr);  // full response
    })
    .catch(function (error) {
      console.log(error.status); // xhr.status
      console.log(error.statusText); // xhr.statusText
    });

  });

})();


/*
========================================================================================================
POLYFILL FOR str.includes()
@LINK https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/includes
========================================================================================================
*/
if (!String.prototype.includes) {
  String.prototype.includes = function(search, start) {
    'use strict';
    if (typeof start !== 'number') {
      start = 0;
    }
    
    if (start + search.length > this.length) {
      return false;
    } else {
      return this.indexOf(search, start) !== -1;
    }
  };
}


/*
========================================================================
POLYFILL FOR node.remove()
@LINK https://developer.mozilla.org/en-US/docs/Web/API/ChildNode/remove
========================================================================
*/
(function (arr) {
  arr.forEach(function (item) {
    if (item.hasOwnProperty('remove')) {
      return;
    }
    Object.defineProperty(item, 'remove', {
      configurable: true,
      enumerable: true,
      writable: true,
      value: function remove() {
        if (this.parentNode !== null)
          this.parentNode.removeChild(this);
      }
    });
  });
})([Element.prototype, CharacterData.prototype, DocumentType.prototype]);



/*
======================================================================================================
POLYFILL FOR array.includes
@LINK https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/includes
======================================================================================================
*/
if (!Array.prototype.includes) {
  Object.defineProperty(Array.prototype, 'includes', {
    value: function(searchElement, fromIndex) {

      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      // 1. Let O be ? ToObject(this value).
      var o = Object(this);

      // 2. Let len be ? ToLength(? Get(O, "length")).
      var len = o.length >>> 0;

      // 3. If len is 0, return false.
      if (len === 0) {
        return false;
      }

      // 4. Let n be ? ToInteger(fromIndex).
      //    (If fromIndex is undefined, this step produces the value 0.)
      var n = fromIndex | 0;

      // 5. If n ≥ 0, then
      //  a. Let k be n.
      // 6. Else n < 0,
      //  a. Let k be len + n.
      //  b. If k < 0, let k be 0.
      var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

      function sameValueZero(x, y) {
        return x === y || (typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y));
      }

      // 7. Repeat, while k < len
      while (k < len) {
        // a. Let elementK be the result of ? Get(O, ! ToString(k)).
        // b. If SameValueZero(searchElement, elementK) is true, return true.
        if (sameValueZero(o[k], searchElement)) {
          return true;
        }
        // c. Increase k by 1. 
        k++;
      }

      // 8. Return false
      return false;
    }
  });
}
(function($) {

  /*
  =========================================
  CHANGE PAGE WHEN SELECTED MODEL MODIFIER
  =========================================
  */
  var modelModiferSelect = document.querySelector('#modelModifiers');
  var mainContainer = document.querySelector('#main_content');

  if (modelModiferSelect) {
    modelModiferSelect.addEventListener('change', function(e) {
      var loc = e.target.value;
      window.location.href = loc;
    });
  }


  /*
  =========================
  AJAX FOR PRICE
  =========================
  */
  var allSections = $('.category-maintenance-reminder table');
  $.each(allSections, function(i) {
    var elem = $(this);
    var allSectionParts = elem.find('[data-sku]');
    var partsArray = [];
    $.each(allSectionParts, function() {
      partsArray.push($(this).data('sku'));
    })
    // console.log(partsArray);
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'get_product_prices',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        parts: partsArray
      },
      dataType: 'json',
      success: function(response) {
        for (var i = 0; i < response.length; i++) {
          var id = response[i].id;
          if (id !== '') {
            var sku = response[i].sku;
            var price = response[i].regular_price;
            var elem = $('[data-sku="' + sku.toUpperCase() + '"]');
            elem.siblings('[data-header="Price"]').html('$' + Number(price).toFixed(2));
            elem.parent().find('button').removeClass('disabled').addClass('add-to-cart').text('Add to Cart').attr('value', id);
          } else {
            console.log('null product');
          }
        }
      },
      error: function(err) {
        console.log(err);
      }
    });
  });
  // $.ajax({
  //     url: window.ajax_order_tracking.ajax_url,
  //     method: 'POST',
  //     data: {
  //       action: 'get_product_prices',
  //       _ajax_nonce: window.ajax_order_tracking.nonce,
  //       parts: partsArray
  //     },
  //     dataType: 'json',
  //     success: function(response) {
  //       for (var i = 0; i < response.length; i++) {
  //         var sku = response[i].sku;
  //         var price = response[i].regular_price;
  //         $('[data-sku="' + sku.toUpperCase() + '"]').siblings('[data-header="Price"]').html('$' + price);
  //       }
  //       // var price = Number(response.price).toFixed(2);
  //       // var html = elem.html();
  //       // elem.siblings('[data-header="Price"]').html('$' + price);
  //       // if (response.id) {
  //       //   elem.html('<a href="/?p=' + response.id + '">' + html + '</a>');
  //       //   elem.parent().find('button').removeClass('disabled').addClass('add-to-cart').text('Add to Cart').attr('value', response.id);
  //       // }
  //     },
  //     error: function(err) {
  //       console.log(err);
  //     }
  //   });


  /*
  ==============================
  STICKY MAINTENANCE KIT BUY NOW
  ==============================
  */

  var maintenanceKitContainer = document.querySelector('.maintenance-kit-container');
  if (maintenanceKitContainer && window.innerWidth > 1080) {
    window.onload = function() {
      var offsetTop = maintenanceKitContainer.offsetTop;
      var baseFontSize = window.getComputedStyle(document.body, null).fontSize;
      baseFontSize = parseInt(baseFontSize.split('px')[0]);

      window.addEventListener('scroll', function(e) {
        if (window.scrollY > (offsetTop - (baseFontSize * 3))) {
          maintenanceKitContainer.classList.add('maintenance-kit-container--is-fixed');
        }
        if (window.scrollY < (offsetTop - (baseFontSize * 3))) {
          maintenanceKitContainer.classList.remove('maintenance-kit-container--is-fixed');
        }
      });
    }

  }


})(jQuery);


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
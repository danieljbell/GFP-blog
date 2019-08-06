(function($) {

  var reviewLink = document.querySelectorAll('.woocommerce-review-link');
  if (reviewLink) {
    reviewLink.forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
      });
    });
  }
  
  /*
  =========================
  FITMENT TEXT FILTER
  =========================
  */

  // Get Vars
  var fitmentTextFilter = document.querySelector('#fitment-text-filter'),
      productFitmentTags = document.querySelectorAll('.single--part-fitment-list li');

  // Check that page has text filter
  if (fitmentTextFilter) {
    fitmentTextFilter.addEventListener('keyup', function(e) {
      var value = e.target.value.toUpperCase();
      // Loop over all fitment and add/remove hidden class
      for (var i = 0; i < productFitmentTags.length; i++) {
        productFitmentTags[i].classList.add('hidden');
        if (productFitmentTags[i].textContent.toUpperCase().includes(value)) {
          productFitmentTags[i].classList.remove('hidden');
        }
      }
    });
  }


  var productThumbs = document.querySelectorAll('.woocommerce-product-gallery__thumbs li');
  if (productThumbs) {
    productThumbs.forEach(function(thumb) {
      thumb.addEventListener('click', swapFeaturedPhoto);
    });
  }

  function swapFeaturedPhoto(e) {
    e.preventDefault();
    var newImage = e.target.dataset.fullImage;
    var wrapper = document.querySelector('.woocommerce-product-gallery__wrapper > a');
    wrapper.href = newImage;
    wrapper.querySelector('img').src = newImage;
  }


  // $('body').on('init', '#reviews', function() {
  //   var stars = $('.stars a');
  //   stars.html('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 300 284.7" xml:space="preserve"><polygon points="150,0 195.8,100 300,108.3 219.4,183.3 243.1,284.7 147.2,231.9 56.9,284.7 79.2,177.8 0,108.3 108.3,95.8 "/></svg>');
  //   stars.on('mouseenter', function() {
  //     $(this).prevAll().find('polygon').css("fill", "#29652d");
  //   });
  //   stars.on('mouseleave', function() {
  //     $(this).prevAll().find('polygon').css("fill", "");
  //   });
  //   stars.on('click', function(e) {
  //     console.log($(this));
  //     $(this).siblings().removeClass('highlight');
  //     $(this).prevAll().addClass('highlight');
  //     var val = $(this).index();
  //     val = String(val);
  //     $('select#rating').val(val);
  //     // elem.attr('selected');
  //     console.log(typeof val);
  //   });
  //   $('.comment-form-email input').removeAttr('required').removeAttr('aria-required');
  // })


  $('.woocommerce-product-gallery__wrapper a').on('click', function(e) {
    e.preventDefault();
    $('.modal--display-product-image .modal-container').css('max-width', '800px');
    $('.modal--display-product-image .modal-content').html('<img src="' + e.target.src + '">');
    launchModal(e);
  });



  // commentFormRating.addEventListener('load', function() {
  //   console.log('asdf');
  //   console.log(document.querySelectorAll('.stars a'));
  // })
  // if (commentFormRating) {
  //   setTimeout(function() {
  //     var stars = commentFormRating.querySelectorAll('.stars a');
  //     stars.forEach(function(star) {
  //       star.innerHTML = '<img src="//fillmurray.com/10/10">';
  //     });
  //   }, 1000);
  // }

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

  /*
  =========================
  ARI LINKS
  =========================
  */
  // $('body').on('click', '.ariPartListAddToCart', function(e) {
  //   e.preventDefault();
  //   console.log('clicked');
  // })

  if (document.querySelector('.used-equip--list')) {
    var usedSlider = tns({
      container: '.used-equip--list',
      items: 1,
      // slideBy: 'page',
      autoplay: true,
      controls: false,
      center: true,
      edgePadding: 50,
      navPosition: 'bottom',
      autoplayHoverPause: true
      // responsive: {
      //     960: {
      //         items: 3,
      //         nav: true,
      //     } 
      // }
    });
  }

  $('#checkInventory').on('click', function(e) {
    e.preventDefault();
    // console.log($('#single-product--add-to-cart').data('sku'));
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'getInventory',
        partNumber: $('#single-product--add-to-cart').data('sku'),
        _ajax_nonce: window.ajax_order_tracking.nonce
      },
      success: function(res) {
        var fulfillmentLocations = ['FISHERS', 'ATLANTA', 'LEBANON', 'MOORESVILLE', 'MUNCIE'];
        var modal = $('.modal--checkInventory');
        var modalContent = modal.find('.modal-content');
        var data = res.data;
        var totalInv = 0;
        var invByLoc = [
          {
            name: 'FISHERS',
            warehouse: 1,
            inv: 0
          },
          {
            name: 'MUNCIE',
            warehouse: 2,
            inv: 0
          },
          {
            name: 'ATLANTA',
            warehouse: 3,
            inv: 0
          },
          {
            name: 'LEBANON',
            warehouse: 8,
            inv: 0
          },
          {
            name: 'MOORESVILLE',
            warehouse: 9,
            inv: 0
          }
        ];

        for (var i = 0; i < data.length; i++) {
          if (fulfillmentLocations.includes(data[i].WK_LOC)) {
            totalInv += Number(data[i].WK_PMOH);
            for (var j = 0; j < invByLoc.length; j++) {
              if (invByLoc[j].name === data[i].WK_LOC) {
                invByLoc[j].inv += Number(data[i].WK_PMOH);
              }
            }
          }
        }

        var rowString = '';
        $.each(invByLoc, function(index, val) {
          if (val.warehouse === 1) {
            rowString += '<tr><td>Warehouse ' + val.warehouse + ': <em style="font-size: 0.75em; display: block;">Shipping Facility</em></td><td>' + val.inv + ' <span>in stock</span></td></tr>';
          } else {
            rowString += '<tr><td>Warehouse ' + val.warehouse + ':</td><td>' + val.inv + ' <span>in stock</span></td></tr>';
          }
        });

        var centralWarehouse = '';
        if (totalInv === 0) {
          var centralWarehouse = '<p><em>No worries, we can still get your part! Our fullfillment warehouses don\'t have stock, but we can get your parts from our central warehouse in two business days.</em></p>';
        }

        modalContent.html('<table class="inv-table"><tbody>' + rowString + '</tbody><tfoot><tr><td>Total In Stock Inventory:</td><td>' + totalInv + ' <span>in stock</span></td></tr></tfoot></table>' + centralWarehouse + '<small style="display: block; margin-top: 2rem;">Warehouse 1 is our primary shipping and fulfillment center. While other warehouses may have inventory, all shipping is from warehouse 1, so please allow 1-2 business days for parts to be transfered to warehouse 1.</small>');

      },
    })
  })

})(jQuery);
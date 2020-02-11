(function ($) {

  $('#filter--select-fitment').on('change', filterProductResults);

  function filterProductResults(e) {
    e.preventDefault();
    document.location = window.location.origin + '/part-catalog/' + $(this).val();
    // $.ajax({
    //   url: window.location.origin + '/part-catalog/' + $(this).val(),
    //   success: function(res) {
    //     console.log(res);
    //   }
    // })
  }

  var bodyClasses = document.querySelector('body').classList;
  var bodyTermID = '';
  for (var i = 0; i < bodyClasses.length; i++) {
    if (!bodyClasses[i].includes('term')) {
      continue;
    }
    if (!bodyClasses[i].includes('john')) {
      bodyTermID = bodyClasses[i].split('term-')[1];
    }
  }

  $('.filterModelCategory').on('change', filterModelCategory);

  function filterModelCategory(e) {
    e.preventDefault();
    var filterTermID = e.target.value;
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'filter_model_cat',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        primaryID: bodyTermID,
        filterID: filterTermID
      },
      success: function (res) {
        $('.product-list--sorting').hide();
        $('.product-list--sorting-after').hide();
        var htmlString = '';
        $.each(res.results, function (i, v) {
          var returnString = '<li class="products--item product-card--slim" data-sku="' + v.sku + '">';
          returnString += '<div class="products--image">';
          returnString += '<img src="' + v.thumb + '" alt="' + v.title + '">';
          returnString += '</div>';
          returnString += '<div class="products--content">';
          returnString += '<a href="' + v.url + '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><h3 class="woocommerce-loop-product_title">' + v.title + '</h3></a>';
          returnString += '<span class="price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>' + v.price + '</span></span>';
          returnString += '<div class="products--actions">';
          returnString += '<button class="add-to-cart btn-solid--brand-two" value="' + v.id + '">Add to Cart</button>';
          returnString += '</div>';
          returnString += '</div>';
          returnString += '</li>';
          htmlString += returnString;
        });
        $('.product-list-with-filters ul.products').html(htmlString);
      }
    })
  }

})(jQuery);
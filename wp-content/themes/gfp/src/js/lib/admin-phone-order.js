(function($) {

  var userID;

  $('.tab-trigger').on('click', toggle);
  $('#returning_email_address').on('keyup', findUser);
  $('#choose_customer').on('click', chooseCustomer);
  $('#addSkus').on('submit', addSku);
  $('#createOrder').on('click', createOrder);
  $('#createNewCustomer').on('submit', createCustomer);

  function toggle(e) {
    e.preventDefault();
    var val = $(this).prop('id');
    var elem = $('.' + val);
    elem.siblings().addClass('visually-hidden');
    elem.removeClass('visually-hidden');
  }

  function findUser(e) {
    e.preventDefault();
    var val = $(this).val();
    var container = $('.returning-customer');
    container.addClass('visually-hidden');
    if (val && val !== '') {
      console.log('finding user => ', $(this).val());
      $.ajax({
        url: window.location.origin + '/wp-admin/admin-ajax.php',
        method: 'POST',
        data: {
          action: 'find_user_by_email',
          _ajax_nonce: window.ajax_order_tracking.nonce,
          email_address: $(this).val(),
        },
        success: function(results) {
          
          if (results.success === false) {
            // $('.returning-customer').html('<li>' + results.message + '</li>');
          } else {
            // console.log(results);
            userID = results.id;
            container.removeClass('visually-hidden');
            container.find('.display-name').html('<a href="/wp-admin/edit.php?s&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user=' + results.id + '&_shop_order_pip_print_status&filter_action=Filter&paged=1&action2=-1" target="_blank">' + results.name + ' - ' + results.billing.email + '</a>');
            container.find('.customer-billing .street').html(results.billing.address_1 + '<br>' + results.billing.address_2);
            container.find('.customer-billing .city').html(results.billing.city + ', ' + '<span class="state">' + results.billing.state + '</span>');
            container.find('.customer-billing .zip').html(results.billing.postcode);
            container.find('.customer-shipping .street').html(results.billing.address_1 + '<br>' + results.billing.address_2);
            container.find('.customer-shipping .city').html(results.shipping.city + ', ' + '<span class="state">' + results.shipping.state + '</span>');
            container.find('.customer-shipping .zip').html(results.shipping.postcode);
          }
        },
        error: function(error) {
          console.log(error);
        }
      })
    }
  }

  function chooseCustomer(e) {
    e.preventDefault();
    // console.log(;
    $('.customer--returning').append($(this).parent().find('.display-name').html());
    $('.returning-customer').addClass('visually-hidden');
  }

  function addSku(e) {
    e.preventDefault();
    console.log('add sku');
    var sku = $(this).find('#sku').val().toUpperCase();
    var qty = $(this).find('#qty').val()
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'get_product_info',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        sku: sku,
        qty: qty
      },
      success: function(res) {
        console.log(res);
        if (!res.id) {
          alert('invalid part number');
          return;
        }
        $('table.skus').removeClass('visually-hidden');
        $('table.skus tbody').append('<tr><td data-sku-id="' + res.id + '">' + sku + '</td><td>' + res.name + '</td><td>$' + res.price + '</td><td>' + qty + '</td><td><button class="remove-sku">&times</button></td></tr>');
        document.querySelector('#addSkus').reset();
        $('#sku').focus();
      },
    })
  }

  function createCustomer(e) {
    e.preventDefault(); 
    console.log('creating customer');
    var firstName = $(this).find('#new_customer_first_name').val();
    var lastName = $(this).find('#new_customer_last_name').val();
    var emailAddress = $(this).find('#new_customer_email_address').val();
    console.log(firstName, lastName, emailAddress);
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'create_customer',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        first_name: firstName,
        last_name: lastName,
        email_address: emailAddress
      },
      success: function(res) {
        userID = res.customer;
        $('#createNewCustomer').addClass('visually-hidden');
        if (res.returning === true) {
          $('#createNewCustomer').parent().append('<p>Account already exists for ' + res.email + '. It\'s been selected, you can just add lined items now.</p>');
        } else {
          $('#createNewCustomer').parent().append('<p>Account created for: ' + res.first + res.last + ' - ' + res.email + '</p>');
        }
      }
    })
  }

  function createOrder(e) {
    e.preventDefault();
    console.log('creating order for user: ' + userID);
    $(this).html('<img src="/wp-content/themes/gfp/dist/img/spinner--light.svg" class="spinner" style="vertical-align: middle; max-width: 25px; margin-right: 0.5rem;"> Creating Order');
    var lineItems = [];
    var table = $('table.skus tbody tr');
    $.each(table, function(i, elem) {
      lineItems.push({
        id: $(elem).find('[data-sku-id]').data('skuId'),
        qty: $(elem).find('td:nth-child(4)').text()
      });
    });
    console.log(lineItems);
    $.ajax({
      url: window.ajax_order_tracking.ajax_url,
      method: 'POST',
      data: {
        action: 'draft_order',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        customer: userID,
        lineItems: lineItems
      },
      success: function(res) {
        console.log(res);
        $('#createOrder').hide();
        $('#createOrder').parent().append('<a href="' + res.login + '" class="btn-solid--brand mar-r">Collect Payment</a><a href="/wp-admin/post.php?post=' + res.id + '&action=edit" class="btn-solid--brand-two">View Draft Order</a>');
      }
    })
  }

})(jQuery);
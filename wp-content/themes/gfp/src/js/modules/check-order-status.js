(function() {
  
  var form = document.querySelector('#order_tracking_form');

  if (!form) { 
    return;
  }

  var resultsContainer = document.querySelector('.order-results--container');
  var orderDetailsContainer = document.querySelector('.order-results--details');
  var results = document.querySelector('.order-results--list');
  var orders = [];

  function formSubmission(e) {
    e.preventDefault();
    atomic(window.ajax_order_tracking.ajax_url, {
      method: 'POST',
      data: {
        action: 'get_orders',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        email_address: document.querySelector('input[name="email_address"]').value,
        zipcode: document.querySelector('input[name="zipcode"]').value
      }
    }).then(function(response) {
      var responseOrders = response.data.orders;
      responseOrders.forEach(function(order) {
        orders.push(order);
      });
      formatOrders();
    })
  }

  function displayIndividualOrder(e) {
    if (!e.target.dataset.orderId) {
      return;
    }
    var orderID = e.target.dataset.orderId;
    var orderDetails = orders.find(function(order) {
      return order.ID = orderID
    });
    atomic(window.ajax_order_tracking.ajax_url, {
      method: 'POST',
      data: {
        action: 'get_order_details',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        orderID: orderID
      }
    }).then(function(response) {
      console.log(response.data);
    });
    var button = document.createElement('button');
    button.id = 'showAllOrders';
    button.innerHTML = '&larr;Show All Orders';
    resultsContainer.prepend(button);
    results.innerHTML = '';

    var orderMeta = document.createElement('div');
    orderMeta.classList.add('order-results--meta');
    orderMeta.innerHTML = '<h2>Order #: ' + orderID + '</h2>';
    orderDetailsContainer.appendChild(orderMeta);
  }

  function displayAllOrders(e) {
    if (e.target.id !== 'showAllOrders') {
      return;
    }
    formatOrders();
    document.querySelector('#showAllOrders').remove();
    orderDetailsContainer.innerHTML = '';
  }

  function formatOrders() {
    results.innerHTML = orders.map(function(order, index) {
      return '<li class="order-results--item"><p class="order-results--order-number">Order #: ' + order.ID + '</p><time class="order-results--order-time" datetime="' + order.post_date_gmt + '">' + moment(order.post_date_gmt, "YYYY-MM-DD hh:mm:ss a").format('LL') + '</time><button class="btn-solid--brand-two" data-order-id="' + order.ID + '">View Order</button></li>';
    }).join('');
  }

  form.addEventListener('submit', formSubmission);
  document.addEventListener('click', displayIndividualOrder);
  document.addEventListener('click', displayAllOrders)


})();

function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");
  var results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
};
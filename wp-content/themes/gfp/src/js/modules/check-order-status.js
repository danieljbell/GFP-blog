(function() {
  
  var form = document.querySelector('#order_tracking_form');
  var results = document.querySelector('.order-results');

  form.addEventListener('submit', formSubmission);

  function formSubmission(e) {
    e.preventDefault();
    atomic(window.location.origin + '/wp-admin/admin-ajax.php', {
      method: 'POST',
      data: {
        action: 'get_orders',
        email_address: document.querySelector('input[name="email_address"]').value,
        zipcode: document.querySelector('input[name="zipcode"]').value
      }
    }).then(function(response) {
      var orders = response.data.orders;
      orders.forEach(function(order) {
        // console.log(order);
        results.innerHTML += results.innerHTML + '<li>Order: ' + order.ID + '</li>';
      });
    })
  }

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
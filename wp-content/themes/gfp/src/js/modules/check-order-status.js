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
    orders = [];
    results.innerHTML = '';
    orderDetailsContainer.innerHTML = '';
    if (document.querySelector('#showAllOrders')) {
      document.querySelector('#showAllOrders').remove();
    }

    var allCurrentErrors = document.querySelectorAll('.form-errors');
    if (allCurrentErrors) {
      allCurrentErrors.forEach(function(error) {
        error.remove();
      });
    }
    atomic(window.ajax_order_tracking.ajax_url, {
      method: 'POST',
      data: {
        action: 'get_orders',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        email_address: document.querySelector('input[name="email_address"]').value,
        zipcode: document.querySelector('input[name="zipcode"]').value
      }
    }).then(function(response) {
      
      if (response.data.status === 'error') {
        var allErrors = response.data.messages;
        var errorsList = document.createElement('ul');
        errorsList.style.listStyleType = 'none';
        errorsList.innerHTML = Object.values(allErrors).map(function(error) {
          return '<li class="form-errors"><button class="form-errors--close" onclick="this.parentElement.remove();">&times</button>' + error + '</li>'
        }).join('');
        orderDetailsContainer.prepend(errorsList);
        
      } else {
        var responseOrders = response.data.orders;
        responseOrders.forEach(function(order) {
          orders.push(order);
        });
        formatOrders();
      }
    })
  }

  function displayIndividualOrder(e) {
    if (!e.target.dataset.orderId) {
      return;
    }
    var orderID = e.target.dataset.orderId;
    var index = e.target.dataset.index;
    var order = orders[index];
    var orderStatus = order.post_status.split('wc-')[1];
    orderStatus = orderStatus.charAt(0).toUpperCase() + orderStatus.slice(1);

    var button = document.createElement('button');
    button.id = 'showAllOrders';
    button.innerHTML = '&larr; Show All Orders';
    button.classList.add('btn-solid--brand');
    resultsContainer.prepend(button);
    results.innerHTML = '';

    var orderMeta = document.createElement('div');
    orderMeta.classList.add('order-results--meta');
    orderMeta.innerHTML = '<h2>Order: ' + order.ID + '</h2><time class="order-date">Order Date: ' + moment(order.post_date_gmt, "YYYY-MM-DD hh:mm:ss a").format('LL') + '</time><p class="order-status">Order Status: ' + orderStatus + '</p><h3>Have A Question?</h3><button class="btn-solid--brand-two" data-modal-launch="send-order-comment">Ask Us!</button>';
    orderDetailsContainer.appendChild(orderMeta);

    var orderContent = document.createElement('div');
    orderContent.classList.add('order-results--content');
    orderDetailsContainer.appendChild(orderContent);

    var orderDetailsListContainer = document.createElement('div');
    orderDetailsListContainer.classList.add('box--with-header');
    orderDetailsListContainer.innerHTML = '<header><h3>Order Details</h3></header><div class="has-text-center"><img src="/wp-content/themes/gfp/dist/img/spinner.svg" class="spinner"></div>';
    orderContent.appendChild(orderDetailsListContainer);

    var orderNotesListContainer = document.createElement('div');
    orderNotesListContainer.classList.add('box--with-header');
    orderNotesListContainer.innerHTML = '<header><h3>Order Notes</h3></header><div class="has-text-center"><img src="/wp-content/themes/gfp/dist/img/spinner.svg" class="spinner"></div>';
    orderContent.appendChild(orderNotesListContainer);

    atomic(window.ajax_order_tracking.ajax_url, {
      method: 'POST',
      data: {
        action: 'get_order_details',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        orderID: orderID
      }
    }).then(function(response) {
      var orderDetails = response.data;
      
      var orderDetailsList = document.createElement('ul');
      orderDetailsList.classList.add('gfp-order-details--list');
      orderDetailsList.innerHTML = orderDetails.map(function(item) {
        return '<li class="gfp-order-details--item"><div class="gfp-order-details--item-image"><a href="' + item.link + '">' + item.image + '</a></div><div class="gfp-order-details--item-details"><p class="gfp-order-details--item-name"><a href="' + item.link + '">' + item.name + '</a></p><p class="gfp-order-details--item-price">Price: &nbsp;$<span class="regular-price">' + item.subtotal + ' <span class="each-price">&ndash; $' + item.unit_price + ' each</span></span></p><p class="gfp-order-details--item-quantity">Quantity: &nbsp;' + item.qty + '</p> </div></li>';
      }).join('');
      orderDetailsListContainer.appendChild(orderDetailsList);
      orderDetailsContainer.querySelector('.has-text-center').remove();
    });

    atomic(window.ajax_order_tracking.ajax_url, {
      method: 'POST',
      data: {
        action: 'get_order_notes',
        _ajax_nonce: window.ajax_order_tracking.nonce,
        orderID: orderID
      }
    }).then(function(response) {
      var orderNotes = response.data;
      // console.log(orderNotes);

      if (orderNotes.length > 0) {
        var orderNotesList = document.createElement('ol');
        orderNotesList.classList.add('woocommerce-OrderUpdates', 'commentlist', 'notes');
        orderNotesList.innerHTML = orderNotes.map(function(note) {
          return '<li class="woocommerce-OrderUpdate comment note"><div class="woocommerce-OrderUpdate-inner comment_container"><div class="woocommerce-OrderUpdate-text comment-text"><div class="woocommerce-OrderUpdate-description description">' + note.commentContent + '</div>' + note.commentAuthorImg + '<p class="woocommerce-OrderUpdate-meta meta">' + note.commentAuthor + '<br>' + moment(note.commentDate,  "YYYY-MM-DD hh:mm:ss a").format('LL') + '</p></div></div></li>';
        }).join('');
        orderNotesListContainer.appendChild(orderNotesList);
        orderNotesListContainer.querySelector('.has-text-center').remove();
      } else {
        orderNotesListContainer.querySelector('.has-text-center').innerHTML = 'No notes have been added to this order';
      }

      

/*
=========================
<ol class="woocommerce-OrderUpdates commentlist notes">
  <?php foreach ( $notes as $note ) : ?>
  <li class="woocommerce-OrderUpdate comment note">
    <div class="woocommerce-OrderUpdate-inner comment_container">
      <div class="woocommerce-OrderUpdate-text comment-text">
        <div class="woocommerce-OrderUpdate-description description">
          <?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
        </div>
        <?php echo get_avatar($note->comment_author_email, 50, null, $note->comment_author); ?>
        <p class="woocommerce-OrderUpdate-meta meta"><?php echo $note->comment_author; ?><br><?php echo date_i18n( __( 'M. dS h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
      </div>
    </div>
  </li>
  <?php endforeach; ?>
</ol>
=========================
*/


    });

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
      return '<li class="order-results--item"><p class="order-results--order-number">Order: ' + order.ID + '</p><time class="order-results--order-time" datetime="' + order.post_date_gmt + '">' + moment(order.post_date_gmt, "YYYY-MM-DD hh:mm:ss a").format('LL') + '</time><button class="btn-solid--brand-two" data-index="' + index + '" data-order-id="' + order.ID + '">View Order</button></li>';
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
<?php
  if (get_query_var('view-order')) {
    $order_number = get_query_var('view-order');
    $zipcode = wc_get_order($order_number)->get_shipping_postcode();
  } else {
    $order_number = $_GET['order_number'];
    $zipcode = $_GET['zipcode'];
  }
?>

<div class="modal modal--send-order-comment modal--is-hidden">
  <div class="modal-container">
  <button class="modal--close" data-modal-close="send-order-comment">&times;</button>
  
  <div class="modal-content">
    <h2>Have A Question About Your Order?</h2>
    <p>Fill out the form below and we'll be in touch.</p>
    
    <form method="post" action="/wp-admin/admin-post.php">
      <div class="form-group input-radio">
        <p>How would you like for us to contact you?</p>
        <div class="radio-options">
          <div class="form-group">
            <input type="radio" name="contact_preference" value="phone" id="contact_preference_phone" checked>
            <label for="contact_preference_phone">Phone Call</label>
          </div>
          <div class="form-group">
            <input type="radio" name="contact_preference" value="email" id="contact_preference_email">
            <label for="contact_preference_email">Email</label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="customer_name">Name</label>
        <input type="text" name="customer_name" id="customer_name">
      </div>
      <div class="form-group contact-preference contact-preference--email" style="display: none;">
        <label for="email_address">Email Address</label>
        <input type="email" name="email_address" id="email_address">
      </div>
      <div class="form-group contact-preference contact-preference--phone">
        <label for="phone_number">Phone Number</label>
        <input type="tel" name="phone_number" id="phone_number">
      </div>
      <div class="form-group input-textarea">
        <label for="message">Message</label>
        <textarea name="message" id="message"></textarea>
      </div>
      <div class="has-text-center">
        <input type="submit" class="btn-solid--brand-two" value="Send Message">
      </div>
      <input type="hidden" name="action" value="send_order_comment">
      <input type="hidden" name="order_number" value="<?php echo $order_number; ?>">
      <input type="hidden" name="zipcode" value="<?php echo $zipcode; ?>">
      <input type="hidden" name="redirect_location" value="<?php echo str_replace('?' . $_SERVER[QUERY_STRING], '', $_SERVER[REQUEST_URI]); ?>">
    </form>

  </div>

</div>
</div>
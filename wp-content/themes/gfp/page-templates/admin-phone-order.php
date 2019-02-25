<?php 
/*
================================
Template Name: Admin Phone Order
================================
*/

?>

<?php get_header(); ?>

<?php
// $customer = new WC_Customer(11);
// print_r($customer);

// $last_order_query = $wpdb->get_results( 
//     "
//     SELECT ID, post_title, wp_postmeta.meta_value 
//     FROM $wpdb->posts wp_posts
//     INNER JOIN $wpdb->post_meta wp_postmeta
//     ON wp_posts.ID = wp_postmeta.post_id
//     WHERE post_type = 'shop_order' 
//     AND wp_postmeta.meta_key = '_order_number_formatted'
//     ORDER BY ID DESC
//     LIMIT 1
//     "

//   );
// $last_order = $last_order_query[0]->meta_value;
// $last_order = str_replace('GFP-', '', $last_order);
// $last_order++;
// print_r(gettype($last_order));

  // $last_order = $last_order_query[0]->ID + 1;
?>
  
  <section class="pad-y--most has-text-center">
    <div class="site-width">
      <h1>Phone Orders</h1>
    </div>
  </section>

  <section class="mar-b--most">
    <div class="site-width">
      <div class="box--with-header">
        <header>Customer Details</header>
        <button class="btn-solid--brand-two tab-trigger" id="customer--new">New Customer</button>
        <button class="btn-solid--brand-two tab-trigger" id="customer--returning">Returning Customer</button>
        <div class="customer mar-t">
          <div class="customer--returning">
            <h3>Returning Customer</h3>
            <input id="returning_email_address" type="email" placeholder="Search by email address" name="returning_email_address" style="min-width: 300px;">
            <div class="returning-customer visually-hidden">
              <div class="customer-meta mar-y">
                <div class="display-name"></div>
              </div>
              <div class="customer-billing mar-b">
                <h4>Billing</h4>
                <address>
                  <div class="street"></div>
                  <div class="city"></div>
                  <div class="zip"></div>
                </address>
              </div>
              <div class="customer-shipping mar-b">
                <h4>Shipping</h4>
                <address>
                  <div class="street"></div>
                  <div class="city"></div>
                  <div class="zip"></div>
                </address>
              </div>
              <button class="btn-solid--brand" id="choose_customer">Choose Customer</button>
            </div>
          </div>
          <div class="customer--new visually-hidden">
            <h3>New Customer</h3>
            <div class="form-group">
              <form action="" id="createNewCustomer">
                <label for="new_customer_first_name" class="mar-r">First Name</label>
                <input type="text" name="new_customer_first_name" id="new_customer_first_name" class="mar-r--more">
                <label for="new_customer_last_name" class="mar-r">Last Name</label>
                <input type="text" name="new_customer_last_name" id="new_customer_last_name" class="mar-r--more">
                <label for="new_customer_email_address">Email</label>
                <input type="email" name="new_customer_email_address" id="new_customer_email_address">
                <input type="submit" class="visually-hidden">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="site-width">
      <div class="box--with-header">
        <header>Line Items</header>
        <form action="" id="addSkus" class="has-text-center">
          <div class="form-group">
            <label for="sku" class="mar-r">Part Number</label>
            <input type="text" name="sku" id="sku" class="mar-r--more mar-b">
            <label for="qty" class="mar-r">Quantity</label>
            <input type="number" min="1" name="qty" id="qty" value="1">
            <input type="submit" class="visually-hidden">
          </div>
        </form>
        <table class="skus visually-hidden">
          <thead>
            <tr>
              <th>Part Number</th>
              <th>Name</th>
              <th>Price</th>
              <th>Qty</th>
              <th></th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
              <td colspan="2">Total</td>
              <td></td>
              <td colspan="2"></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </section>

  <section class="mar-y--most">
    <div class="site-width">
      <div class="has-text-center">
        <button class="btn-solid--brand" id="createOrder">Create Order</button>
      </div>
      <div class="order-actions"></div>
    </div>
  </section>
  
<?php get_footer(); ?>

<?php 
  function partForm($i) {
    echo '<div class="form-group has-text-center">';
      echo '<label for="sku-' . $i . '" class="mar-r">Part Number</label>';
      echo '<input type="text" name="sku-' . $i . '" id="sku-' . $i . '" class="mar-r--more mar-b">';
      echo '<label for="qty-' . $i . '" class="mar-r">Quantity</label>';
      echo '<input type="number" min="1" max="100" name="qty-' . $i . '" id="qty-' . $i . '" value="1">';
    echo '</div>';
  }
?>
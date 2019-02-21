<?php 
/*
================================
Template Name: Admin Phone Order
================================
*/

?>

<?php get_header(); ?>

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
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="site-width">
      <div class="box--with-header">
        <header>Line Items</header>
        <form action="" id="addSkus">
          <div class="grid--phone-half">
            <div class="form-group has-text-right">
              <label for="sku">Part Number</label>
              <input type="text" name="sku" id="sku">
            </div>
            <div class="form-group">
              <label for="qty">Quantity</label>
              <input type="number" min="1" max="100" name="qty" id="qty" value="1">
              <button class="btn-solid--brand mar-l">Add Part</button>
            </div>
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
        </table>
      </div>
    </div>
  </section>
  
<?php get_footer(); ?>
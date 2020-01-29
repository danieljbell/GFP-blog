<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see   https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
    <title><?php echo get_bloginfo( 'name', 'display' ); ?> - Order Confirmation</title>
    <meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,700" rel="stylesheet">
      <!--[if mso]>
      <style type="text/css">
        html, body, table, tbody, tr, td, div, p, a, h1, h2, h3, h4, h5, h6,  ul, li, font, span, strong {
          font-family: Arial, sans-serif !important;
        }
      </style>
    <![endif]-->
  </head>
  <body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;mso-hide:all;">
      <?php
          // Call the global WC_Email object
          global $email; 

          // Get an instance of the WC_Order object
          $order = $email->object; 

          if ($email->id === 'customer_processing_order') {
            echo 'Thanks ' . $order->get_billing_first_name() . ' for your order! Your order number is ' . $order->get_order_number() . '.';
          } elseif ($email->id === 'new_order') {
            echo '$' . $order->get_total();
          }
      ?>
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td bgcolor="#f0f0f0" align="center" style="padding: 25px 0 50px;">

          <!-- Header -->
          <table border="0" cellpadding="0" cellspacing="0" width="100%" class="email-header">
            <tr>
              <td align="center">
                <table class="content-table" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                  <tr>
                    <td style="padding: 0px 0 25px;" align="center" valign="top">
                      <a href="https://www.greenfarmparts.com">
                        <img style="display: block" src="https://gallery.mailchimp.com/c80372a35929a7b281b76c090/images/84c255e8-00f1-44a3-9962-9213a077f4d8.png" width="280" height="64" border="0" alt="Green Farm Parts">
                      </a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!-- /Header -->

          <table border="0" cellpadding="0" cellspacing="0" width="600">
            <tr>
              <td bgcolor="#ffffff" style="padding: 25px;">
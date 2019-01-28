<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

// Load colors.
$bg              = get_option( 'woocommerce_email_background_color' );
$body            = get_option( 'woocommerce_email_body_background_color' );
$base            = get_option( 'woocommerce_email_base_color' );
$base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text            = get_option( 'woocommerce_email_text_color' );

// Pick a contrasting color for links.
$link = wc_hex_is_light( $base ) ? $base : $base_text;
if ( wc_hex_is_light( $body ) ) {
  $link = wc_hex_is_light( $base ) ? $base_text : $base;
}

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
?>
/* CLIENT-SPECIFIC STYLES */
    #outlook a { padding: 0; }
    .ReadMsgBody { width: 100%; } .ExternalClass { width: 100%; }
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div, .ExternalClass * { line-height: 100%; }
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; } table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { -ms-interpolation-mode:bicubic; }
    /* RESET STYLES */
    body { height:100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
    img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
    table { border-collapse: collapse !important; }
    /* Remove margin on email wrapper in Android 4.4 KitKat */
    /* See more at: https://blog.jmwhite.co.uk/2015/09/19/revealing-why-emails-appear-off-centre-in-android-4-4-kitkat/ */
    div[style*="margin: 16px 0"] {margin:0 !important; font-size:100% !important;}

    * {
      font-family: 'Open Sans', Helvetica, Arial, sans-serif !important;
    }

    hr {
        background: transparent;
        border: 0;
        border-top: 1px solid #cccccc;
    }

    /* Remove ios blue links */
    a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    .hero-table-cell {
      background-color: #377D3D;
      background-image: url("https://greenfarmparts.com/v/vspfiles/images/email/order-confirmation--hero.jpg");
    }

    .order-details-table table td {
      padding-top: 2px;
      padding-bottom: 2px;
    }

    .order-details-table table tr:first-child td {
      border-bottom: 1px solid #cccccc;
      padding-bottom: 0;
      padding-top: 0;
    }

    /* Outline styles */
    @media only screen and (max-width: 599px) {
      .content-table {
        width: 100% !important;
      }

      img[class="img-max"]{
        width: 100% !important;
        height: auto !important;
      }

      table[class="mobile-button-wrap"]{
        margin: 0 auto;
        width: 100% !important;
      }

      a[class="mobile-button"]{
        width: 100% !important;
        padding: 8px !important;
        border: 0 !important;
        box-sizing: border-box;
      }

      .mobile-align-center {
        text-align: center !important;
        margin-right: auto;
        margin-left: auto;
      }

      .email-header .content-table td {
        padding-top: 25px !important;
      }

      .hero-table-cell table td {
        padding: 50px 25px !important;
      }

    }
<?php

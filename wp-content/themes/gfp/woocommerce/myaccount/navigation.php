<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

do_action( 'woocommerce_before_account_navigation' );

$page_path = $_SERVER['REQUEST_URI'];
?>

<nav class="woocommerce-MyAccount-navigation">
  <ul>
    <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
      <?php if ($label != 'Downloads') : ?>
        <?php 
          if (strpos($page_path, 'view-order') && ($label === 'Orders')) {
            echo '<li class="' . wc_get_account_menu_item_classes( $endpoint ) . ' is-active">';
          } else {
            echo '<li class="' . wc_get_account_menu_item_classes( $endpoint ) . '">';
          }
        ?>
          <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( ucwords($label) ); ?></a>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>

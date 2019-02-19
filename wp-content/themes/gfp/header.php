<?php
  $sku = $_GET['sku'];
  if ($sku && ($sku != '')) {
    $product_id = wc_get_product_id_by_sku($sku);
    if ($product_id) {
      $product = wc_get_product($product_id);
      header("HTTP/1.1 302 Found");
      header("Location: " . $product->get_permalink());
    }
  }
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <base href="<?php echo site_url(); ?>">
  <meta charset="<?php bloginfo('charset'); ?>">
  <title><?php wp_title(''); ?></title>
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/fav/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/fav/favicon-16x16.png">
  <link rel="manifest" href="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/fav/site.webmanifest">
  <link rel="mask-icon" href="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/fav/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <meta name="theme-color" content="#ffffff">
  
  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-MS9CBC8');</script>
  <!-- End Google Tag Manager -->

  <?php wp_head(); ?>

</head>
<body <?php body_class('cart-drawer--closed');?>>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MS9CBC8"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

<?php if( current_user_can('edit_pages') || current_user_can('edit_products') ) :
  echo '<ul style="position: fixed; left: 1rem; bottom: 1rem; z-index: 999;" class="no-print"><li style="display: inline-block;"><a href="' . site_url() . '/wp-admin/edit.php?post_type=shop_order" class="btn-solid--brand" style="text-decoration: none; font-weight: bold;">Admin</a></li>';
  if (is_product_category()) {
    $cat = get_queried_object();
    echo '<li style="display: inline-block; margin-left: 1rem;"><a href="' . site_url() . '/wp-admin/edit.php?product_cat=' . $cat->slug . '&post_type=product" class="btn-solid--brand-two" style="text-decoration: none; font-weight: bold;">Edit</a></li>';
  } else {
    echo '<li style="display: inline-block; margin-left: 1rem;"><a href="' . site_url() . '/wp-admin/post.php?post=' . $post->ID . '&action=edit" class="btn-solid--brand-two" style="text-decoration: none; font-weight: bold;">Edit</a></li>';
  }
  echo '</ul>';
  endif; ?>

<?php get_template_part('partials/display', 'eyebrow'); ?>

<?php get_template_part('partials/display', 'site-header'); ?>

<?php get_template_part('partials/display', 'search'); ?>

<?php wc_print_notices(); ?>

<main id="main_content">
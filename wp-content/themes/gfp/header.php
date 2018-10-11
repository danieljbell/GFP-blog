<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <base href="<?php echo site_url(); ?>">
  <meta charset="<?php bloginfo('charset'); ?>">
  <title><?php wp_title(''); ?></title>
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,700" rel="stylesheet">
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
<body <?php body_class();?>>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MS9CBC8"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

<?php if( current_user_can('edit_pages') || current_user_can('edit_products') ) :
  echo '<ul style="position: fixed; left: 1rem; bottom: 1rem; z-index: 999;" class="no-print"><li style="display: inline-block;"><a href="' . site_url() . '/wp-admin" class="btn-solid--brand" style="text-decoration: none; font-weight: bold;">Admin</a></li>';
  echo '<li style="display: inline-block; margin-left: 1rem;"><a href="' . site_url() . '/wp-admin/post.php?post=' . $post->ID . '&action=edit" class="btn-solid--brand-two" style="text-decoration: none; font-weight: bold;">Edit</a></li>';
  echo '</ul>';
  endif; ?>

<?php get_template_part('partials/display', 'eyebrow'); ?>

<?php get_template_part('partials/display', 'site-header'); ?>

<?php get_template_part('partials/display', 'search'); ?>

<?php wc_print_notices(); ?>

<main id="main_content">
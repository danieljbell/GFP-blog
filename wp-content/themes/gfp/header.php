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
  <!-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-P7LZ6FP');</script> -->
  <!-- End Google Tag Manager -->

  <?php wp_head(); ?>

  <!--[if lte IE 9]>
    <link rel='stylesheet' href='http://localhost:1337/wp-content/themes/octiv2017/dist/css/ie.css?ver=1.0.1' type='text/css' media='all' />
  <![endif]-->

</head>
<body <?php body_class();?>>
  <!-- Google Tag Manager (noscript) -->
  <!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P7LZ6FP"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
  <!-- End Google Tag Manager (noscript) -->  

<?php if( current_user_can('edit_pages') ) :
  echo '<ul style="position: fixed; bottom: 0; z-index: 999;" class="no-print"><li style="display: inline-block;"><a href="' . site_url() . '/wp-admin" class="btn-primary" style="text-decoration: none; font-weight: bold;">Admin</a></li>';
  if (!is_tax()) {
    if (!is_post_type_archive('integration')) {
      echo '<li style="display: inline-block; margin-left: 1rem;"><a href="' . site_url() . '/wp-admin/post.php?post=' . $post->ID . '&action=edit" class="btn-primary" style="text-decoration: none; font-weight: bold;">Edit</a></li>';
    } else {
      echo '<li style="display: inline-block; margin-left: 1rem;"><a href="' . site_url() . '/wp-admin/edit.php?post_type=integration&page=integration-settings" class="btn-primary" style="text-decoration: none; font-weight: bold;">Edit</a></li>';
    }
  } else {
    echo '<li style="display: inline-block; margin-left: 1rem;"><a href="' . site_url() . '/wp-admin/term.php?taxonomy=integration_type&tag_ID=' . get_queried_object()->term_id . '" class="btn-primary" style="text-decoration: none; font-weight: bold;">Edit</a></li>';
  }
  echo '</ul>';
  endif; ?>

<?php get_template_part('partials/display', 'eyebrow'); ?>

<?php get_template_part('partials/display', 'site-header'); ?>

<main id="main_content">
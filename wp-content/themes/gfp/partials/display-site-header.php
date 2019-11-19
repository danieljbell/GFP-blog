<!-- SITE-HEADER -->
<header class="site-header">
  <div class="site-width">
    <div class="menu-item--logo-container">
      <a href="<?php echo site_url(); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/dist/img/gfp-logo.svg" alt="Green Farm Parts">
      </a>
    </div>
    <nav>
      <ul class="navigation--level-zero">
        <li class="mega-menu">
          <button class="navigation--button">Shop By Part</button>
          <?php
            wp_nav_menu( array(
              'menu' => 'shop-by-part',
              'menu_class' => 'mega-menu--list mega-menu--shop-by-part',
              'container' => ''
            ) );
          ?>
        </li>
        <li class="mega-menu">
          <button class="navigation--button">Shop By Equipment</button>
          <?php

            wp_nav_menu( array(
              'menu' => 'shop-by-equipment',
              'menu_class' => 'mega-menu--list mega-menu--shop-by-part',
              'container' => '',
            ) );
          ?>
        </li>
        <li class="mega-menu">
          <button class="navigation--button">Shop By Brand</button>
          <ul class="mega-menu--list mega-menu--shop-by-brand">
            <?php foreach (get_terms('pa_brand') as $key => $term) : ?>
              <li>
                <a href="<?php echo site_url(); ?>/shop?filter_brand=<?php echo $term->slug; ?>&query_type_brand=or">
                  <img src="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/<?php echo $term->slug; ?>.png">
                  <?php echo $term->name; ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li>
          <a href="<?php echo site_url(); ?>/parts-diagram/" class="navigation--button">Parts Diagram</a>
        </li>
          <li class="mobile-only">
            <a href="/account">
              <?php if (is_user_logged_in()) : ?>
                My Account
              <?php else : ?>
                Login
              <?php endif; ?>
            </a>
          </li>
        <li class="cart-container">
          <button class="open-drawer">
            <?php
              $cart = WC()->instance()->cart;
              $cart_line_items = $cart->get_cart();
              $item_count = 0;
              foreach ($cart_line_items as $key => $line_item) {
                $item_count = $item_count + $line_item['quantity'];
              }
            ?>
            <span class="mobile-only">Shopping Cart</span>
            <strong class="cart--count"><?php echo $item_count; ?></strong>
            <img src="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/cart-icon.jpg" style="display: inline-block; vertical-align: middle; border-radius: 50%; max-width: 40px;">
          </button>
        </li>
      </ul>
    </nav>
    <div class="menu-item--menu-toggle">
      <button id="hamburger" class="hamburger hamburger--spin menu-toggle" type="button">
      <span class="hamburger-box">
        <span class="hamburger-inner"></span>
      </span>
      </button>
    </div>
  </div>
</header>
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
        <li class="mobile-search-container">
          <form action="https://www.greenfarmparts.com/searchresults.asp" method="get" name="SearchBoxForm" id="mobileSearchBar">
            <input placeholder="Search..." type="search" name="Search" class="mobile-search ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
          </form>
        </li>
        <li>
          <button class="navigation--button">Shop By Part</button>
          <?php
            wp_nav_menu( array(
              'menu' => 'shop-by-part',
              'menu_class' => 'navigation--level-one'
            ) );
          ?>
        </li>
        <li>
          <button class="navigation--button">Shop By Equipment</button>
          <?php
            wp_nav_menu( array(
              'menu' => 'shop-by-equipment',
              'menu_class' => 'navigation--level-one'
            ) );
          ?>
        </li>
        <li class="cart-container">
          <a href="https://www.greenfarmparts.com/shoppingcart.asp">
            <span class="mobile-only">Shopping Cart</span>
            <strong>0</strong>
            <img src="https://www.greenfarmparts.com/v/vspfiles/templates/gfp-test/img/cart-icon.jpg" style="display: inline-block; vertical-align: middle; border-radius: 50%; max-width: 40px;">
          </a>
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
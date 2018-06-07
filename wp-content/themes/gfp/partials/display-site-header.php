<!-- SITE-HEADER -->
<header class="site-header">
  <div class="site-width">
    <div class="menu-item--logo-container">
      <a href="https://greenfarmparts.com">
        <img src="/wp-content/themes/gfp/dist/img/GFP-logo.svg" alt="Green Farm Parts">
      </a>
    </div>
    <?php
      wp_nav_menu( array(
        'menu' => 'site-header'
      ) );
    ?>
    <div class="menu-item--menu-toggle">
      <button id="hamburger" class="hamburger hamburger--spin menu-toggle" type="button">
      <span class="hamburger-box">
        <span class="hamburger-inner"></span>
      </span>
      </button>
    </div>
  </div>
</header>
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

            $taxonomy = 'product_cat';
            $orderby = 'name';

            $args = array(
              'taxonomy'     => $taxonomy,
              'hierarchical' => $hierarchical,
              'orderby'      => $orderby,
              'order'        => 'DESC',
              'title_li'     => $title,
              'hide_empty'   => false,
              'exclude'      => array(715, 820)
            );

            $all_categories = get_categories( $args );

            echo '<ul class="mega-menu--list mega-menu--shop-by-part">';
              
              $i = 0;
              foreach ($all_categories as $cat) {
                
                if ($cat->category_parent == 0) {
                  $category_id = $cat->term_id;       
                  if ($i === 0) {
                    echo '<li class="mega-menu--parent"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';
                  } else {
                    echo '<li class="mega-menu--parent mega-menu--parent--is-hidden"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';
                  }

                    $args2 = array(
                      'taxonomy'     => $taxonomy,
                      'child_of'     => 0,
                      'parent'       => $category_id,
                      'orderby'      => $orderby,
                      'show_count'   => $show_count,
                      'pad_counts'   => $pad_counts,
                      'hierarchical' => $hierarchical,
                      'title_li'     => $title,
                      'hide_empty'   => $empty
                    );
                    
                    $sub_cats = get_categories( $args2 );
                    echo '<ul class="mega-menu--child-list">';
                      if ($sub_cats) {
                        foreach($sub_cats as $sub_category) {
                            $thumbnail_id = get_woocommerce_term_meta( $sub_category->term_id, 'thumbnail_id', true );
                            $image = wp_get_attachment_url( $thumbnail_id );
                          echo  '<li class="mega-menu--child-item"><a href="'. get_term_link($sub_category->slug, 'product_cat') .'">';
                            echo '<img src="' . $image . '" class="mega-menu--item-image">';
                            echo $sub_category->name;
                          echo '</a></li>';
                        }   
                        // echo '<li><a href="' . get_term_link($cat->slug, 'product_cat') . '">Shop All ' . number_format($cat->category_count, null, '', ',') . ' ' . $cat->name . '</a></li>';
                      } else {
                        // echo '<li><a href="' . get_term_link($cat->slug, 'product_cat') . '">Shop All ' . number_format($cat->category_count, null, '', ',') . ' ' . $cat->name . '</a></li>';
                      }
                    echo '</ul>';

                  echo '</li>';
                  $i++;
                }


              }

            echo '</ul>';

          ?>
        </li>
        <li class="mega-menu">
          <button class="navigation--button">Shop By Brand</button>
          <ul class="mega-menu--list mega-menu--shop-by-brand">
            <?php
              foreach (get_terms('pa_brand') as $key => $term) {
                echo '<li><a href="' . site_url() . '/shop?filter_brand=' . $term->slug . '&query_type_brand=or"><img src="' . get_stylesheet_directory_URI() . '/dist/img/' . $term->slug . '.png">' . $term->name . '</a></li>';
              }
            ?>
          </ul>
          <?php //print_r(get_terms('pa_brand')); ?>
        </li>
        <?php
          /*
          =========================
          <li>
          <button class="navigation--button">Shop By Equipment</button>
          <?php
            wp_nav_menu( array(
              'menu' => 'shop-by-equipment',
              'menu_class' => 'navigation--level-one'
            ) );
          ?>
        </li>
          =========================
          */
        ?>
        <li>
          <a href="#0" class="navigation--button">Parts Diagram</a>
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
          <a href=/cart">
            <?php
              $cart = WC()->instance()->cart;
              $cart_line_items = $cart->get_cart();
              $items_in_cart = count($cart_line_items);
            ?>
            <span class="mobile-only">Shopping Cart</span>
            <strong class="cart--count"><?php echo $items_in_cart; ?></strong>
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
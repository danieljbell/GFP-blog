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
          <button class="navigation--button">Shop By Equipment</button>
          <ul class="mega-menu--list mega-menu--shop-by-equipment">
            <?php
              $lawn_tractors = get_terms(array(
                'taxonomy' => 'post_tag',
                'meta_query' => array(
                  array(
                    'key'     => 'equipment_type',
                    'value'   => array( 'lawn_tractor' ),
                    'compare' => 'IN',
                  ),
                ),
              ));
              $compact_tractors = get_terms(array(
                'taxonomy' => 'post_tag',
                'meta_query' => array(
                  array(
                    'key'     => 'equipment_type',
                    'value'   => array( 'compact_tractor' ),
                    'compare' => 'IN',
                  ),
                ),
              ));
              $zero_turn_radiuses = get_terms(array(
                'taxonomy' => 'post_tag',
                'meta_query' => array(
                  array(
                    'key'     => 'equipment_type',
                    'value'   => array( 'zero_turn_mowers' ),
                    'compare' => 'IN',
                  ),
                ),
              ));
              $gators = get_terms(array(
                'taxonomy' => 'post_tag',
                'meta_query' => array(
                  array(
                    'key'     => 'equipment_type',
                    'value'   => array( 'gators' ),
                    'compare' => 'IN',
                  ),
                ),
              ));
              $walk_behind_mowers = get_terms(array(
                'taxonomy' => 'post_tag',
                'meta_query' => array(
                  array(
                    'key'     => 'equipment_type',
                    'value'   => array( 'walk_behind_mowers' ),
                    'compare' => 'IN',
                  ),
                ),
              ));
              $snow_blowers = get_terms(array(
                'taxonomy' => 'post_tag',
                'meta_query' => array(
                  array(
                    'key'     => 'equipment_type',
                    'value'   => array( 'snow_blowers' ),
                    'compare' => 'IN',
                  ),
                ),
              ));
              $sprayers = get_terms(array(
                'taxonomy' => 'post_tag',
                'meta_query' => array(
                  array(
                    'key'     => 'equipment_type',
                    'value'   => array( 'sprayers' ),
                    'compare' => 'IN',
                  ),
                ),
              ));
            ?>
            <li class="mega-menu--parent">
              <a href="#0">Lawn & Garden</a>
              <ul class="mega-menu--child-list">
                <li class="visually-hidden loading">
                  <img src="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/spinner.svg" alt="spinner" class="spinner">
                </li>
                <li class="visually-hidden equipment-results">
                  <h4></h4>
                  <button class="btn-outline--brand equipmentResultsBack">&lt; Back</button>
                  <ul class="equipment-results--list"></ul>
                </li>
                <?php if ($lawn_tractors) : ?>
                  <li class="mega-menu--child-item">
                    <button class="mega-menu--equipment-parent" data-equipment-ids="<?php
                      foreach ($lawn_tractors as $key => $lawn_tractor) { 
                        if ($key !== (count($lawn_tractors) - 1)) {
                          echo $lawn_tractor->term_id . ','; 
                        } else {
                          echo $lawn_tractor->term_id; 
                        }
                      } 
                    ?>">
                      <img src="//via.placeholder.com/65x65" alt="">
                      Lawn Tractors
                    </button>
                  </li>
                <?php endif; ?>
                <?php if ($compact_tractors) : ?>
                  <li class="mega-menu--child-item">
                    <button class="mega-menu--equipment-parent" data-equipment-ids="<?php
                      foreach ($compact_tractors as $key => $compact_tractor) { 
                        if ($key !== (count($compact_tractors) - 1)) {
                          echo $compact_tractor->term_id . ','; 
                        } else {
                          echo $compact_tractor->term_id; 
                        }
                      } 
                    ?>">
                      <img src="//via.placeholder.com/65x65" alt="">
                      Compact Tractors
                    </button>
                  </li>
                <?php endif; ?>
                <?php if ($zero_turn_radiuses) : ?>
                  <li class="mega-menu--child-item">
                    <button class="mega-menu--equipment-parent" data-equipment-ids="<?php
                      foreach ($zero_turn_radiuses as $key => $zero_turn_radius) { 
                        if ($key !== (count($zero_turn_radiuses) - 1)) {
                          echo $zero_turn_radius->term_id . ','; 
                        } else {
                          echo $zero_turn_radius->term_id; 
                        }
                      } 
                    ?>">
                      <img src="//via.placeholder.com/65x65" alt="">
                      Zero Turn Mowers
                    </button>
                  </li>
                <?php endif; ?>
                <?php if ($gators) : ?>
                  <li class="mega-menu--child-item">
                    <button class="mega-menu--equipment-parent" data-equipment-ids="<?php
                      foreach ($gators as $key => $gator) { 
                        if ($key !== (count($gators) - 1)) {
                          echo $gator->term_id . ','; 
                        } else {
                          echo $gator->term_id; 
                        }
                      } 
                    ?>">
                      <img src="//via.placeholder.com/65x65" alt="">
                      Gators
                    </button>
                  </li>
                <?php endif; ?>
                <?php if ($walk_behind_mowers) : ?>
                  <li class="mega-menu--child-item">
                    <button class="mega-menu--equipment-parent" data-equipment-ids="<?php
                      foreach ($walk_behind_mowers as $key => $walk_behind_mower) { 
                        if ($key !== (count($walk_behind_mowers) - 1)) {
                          echo $walk_behind_mower->term_id . ','; 
                        } else {
                          echo $walk_behind_mower->term_id; 
                        }
                      } 
                    ?>">
                      <img src="//via.placeholder.com/65x65" alt="">
                      Walk-Behind Mowers
                    </button>
                  </li>
                <?php endif; ?>
                <?php if ($snow_blowers) : ?>
                  <li class="mega-menu--child-item">
                    <button class="mega-menu--equipment-parent" data-equipment-ids="<?php
                      foreach ($snow_blowers as $key => $snow_blower) { 
                        if ($key !== (count($snow_blowers) - 1)) {
                          echo $snow_blower->term_id . ','; 
                        } else {
                          echo $snow_blower->term_id; 
                        }
                      } 
                    ?>">
                      <img src="//via.placeholder.com/65x65" alt="">
                      Snow Blowers
                    </button>
                  </li>
                <?php endif; ?>
              </ul>
            </li>
            <li class="mega-menu--parent mega-menu--parent--is-hidden">
              <a href="#0">Agriculture</a>
              <ul class="mega-menu--child-list">
                <li class="visually-hidden loading">
                  <img src="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/spinner.svg" alt="spinner" class="spinner">
                </li>
                <li class="visually-hidden equipment-results">
                  <h4></h4>
                  <button class="btn-outline--brand equipmentResultsBack">&lt; Back</button>
                  <ul class="equipment-results--list"></ul>
                </li>
                <?php if ($sprayers) : ?>
                  <li class="mega-menu--child-item">
                    <button class="mega-menu--equipment-parent" data-equipment-ids="<?php
                      foreach ($sprayers as $key => $sprayer) { 
                        if ($key !== (count($sprayers) - 1)) {
                          echo $sprayer->term_id . ','; 
                        } else {
                          echo $sprayer->term_id; 
                        }
                      } 
                    ?>">
                      <img src="//via.placeholder.com/65x65" alt="">
                      Sprayers
                    </button>
                  </li>
                <?php endif; ?>
              </ul>
            </li>
            <li class="mega-menu--parent mega-menu--parent--is-hidden">
              <a href="#0">Landscapers</a>
              <ul class="mega-menu--child-list">
                <li class="mega-menu--child-item">
                  <button class="mega-menu--equipment-parent">asdf</button>
                </li>
              </ul>
            </li>
            <li class="mega-menu--parent mega-menu--parent--is-hidden">
              <a href="#0">Golf</a>
              <ul class="mega-menu--child-list">
                <li class="mega-menu--child-item">
                  <button class="mega-menu--equipment-parent">asdf</button>
                </li>
              </ul>
            </li>
            <li class="mega-menu--parent mega-menu--parent--is-hidden">
              <a href="#0">Construction</a>
              <ul class="mega-menu--child-list">
                <li class="mega-menu--child-item">
                  <button class="mega-menu--equipment-parent">asdf</button>
                </li>
              </ul>
            </li>
          </ul>
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

<?php
// $field = get_field_object('field_5be5aac55de18');
// $choices = $field['choices'];

// print_r($choices);
  

  // print_r($terms);
?>
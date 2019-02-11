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

            // $taxonomy = 'product_cat';
            // $orderby = 'name';

            // $args = array(
            //   'taxonomy'     => $taxonomy,
            //   'hierarchical' => $hierarchical,
            //   'orderby'      => $orderby,
            //   'order'        => 'DESC',
            //   'title_li'     => $title,
            //   'hide_empty'   => false,
            //   'exclude'      => array(715, 820)
            // );

            // $all_categories = get_categories( $args );

            // echo '<ul class="mega-menu--list mega-menu--shop-by-part">';
              
            //   $i = 0;
            //   foreach ($all_categories as $cat) {
                
            //     if ($cat->category_parent == 0) {
            //       $category_id = $cat->term_id;       
            //       if ($i === 0) {
            //         echo '<li class="mega-menu--parent"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';
            //       } else {
            //         echo '<li class="mega-menu--parent mega-menu--parent--is-hidden"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';
            //       }

            //         $args2 = array(
            //           'taxonomy'     => $taxonomy,
            //           'child_of'     => 0,
            //           'parent'       => $category_id,
            //           'orderby'      => $orderby,
            //           'show_count'   => $show_count,
            //           'pad_counts'   => $pad_counts,
            //           'hierarchical' => $hierarchical,
            //           'title_li'     => $title,
            //           'hide_empty'   => $empty
            //         );
                    
            //         $sub_cats = get_categories( $args2 );
            //         echo '<ul class="mega-menu--child-list">';
            //           if ($sub_cats) {
            //             foreach($sub_cats as $sub_category) {
            //                 $thumbnail_id = get_woocommerce_term_meta( $sub_category->term_id, 'thumbnail_id', true );
            //                 $image = wp_get_attachment_url( $thumbnail_id );
            //               echo  '<li class="mega-menu--child-item"><a href="'. get_term_link($sub_category->slug, 'product_cat') .'">';
            //                 echo '<img src="' . $image . '" class="mega-menu--item-image">';
            //                 echo $sub_category->name;
            //               echo '</a></li>';
            //             }   
            //             // echo '<li><a href="' . get_term_link($cat->slug, 'product_cat') . '">Shop All ' . number_format($cat->category_count, null, '', ',') . ' ' . $cat->name . '</a></li>';
            //           } else {
            //             // echo '<li><a href="' . get_term_link($cat->slug, 'product_cat') . '">Shop All ' . number_format($cat->category_count, null, '', ',') . ' ' . $cat->name . '</a></li>';
            //           }
            //         echo '</ul>';

            //       echo '</li>';
            //       $i++;
            //     }


            //   }

            // echo '</ul>';

          ?>
        </li>
        <li class="mega-menu">
          <button class="navigation--button">Shop By Equipment</button>
          <ul class="mega-menu--list mega-menu--shop-by-equipment">
            <li class="mega-menu--parent">
              <a href="#0">Lawn & Garden</a>
              <ul class="mega-menu--child-list">
                <?php
                  format_equipment_menu('lawn-garden', 'Lawn Tractors', 'lawn-tractors', 'lawn_tractors');
                  format_equipment_menu('lawn-garden', 'Zero Turns', 'zero-turns', 'zero_turns');
                  format_equipment_menu('lawn-garden', 'Compact Tractors', 'compact-tractors', 'compact_tractors');
                  format_equipment_menu('lawn-garden', 'Gators', 'gators', 'gators');
                  format_equipment_menu('lawn-garden', 'Walk Behind', 'walk-behind-mowers', 'walk_behind_mowers');
                  // format_equipment_menu('lawn-garden', 'Front Mowers', 'front-mowers', 'front_mowers');
                  format_equipment_menu('lawn-garden', 'Hand Held Equipment', 'hand-held-equipment', 'hand_held_equipment');
                  // format_equipment_menu('lawn-garden', 'Loaders', 'loaders', 'loaders');
                  // format_equipment_menu('lawn-garden', 'Snow Blowers', 'snow-blower', 'snow_blower');
                ?>
              </ul>
            </li>
            <li class="mega-menu--parent mega-menu--parent--is-hidden">
              <a href="">Agriculture</a>
              <ul class="mega-menu--child-list">
                <?php
                  format_equipment_menu('agriculture', 'Sprayers', 'sprayers', 'sprayers');
                  format_equipment_menu('agriculture', 'Tractors', 'tractors', 'tractors');
                  format_equipment_menu('agriculture', 'Combines', 'combines', 'combines');
                  format_equipment_menu('agriculture', 'Balers', 'balers', 'balers');
                  format_equipment_menu('agriculture', 'Loaders', 'loaders', 'loaders');
                  format_equipment_menu('agriculture', 'Windrowers', 'windrowers', 'windrowers');
                  // format_equipment_menu('agriculture', 'Planters', 'planter', 'planter');
                  // format_equipment_menu('agriculture', 'Rotary Cutters', 'rotary-cutter', 'rotary_cutter');
                ?>
              </ul>
            </li>
            <li class="mega-menu--parent mega-menu--parent--is-hidden">
              <a href="">Landscapers</a>
              <ul class="mega-menu--child-list">
                <?php
                  format_equipment_menu('landscapers', 'Zero Turns', 'zero-turn-mowers', 'zero_turn_mowers');
                  format_equipment_menu('landscapers', 'Front Mowers', 'front-mowers', 'front_mowers');
                  format_equipment_menu('landscapers', 'Quik-Traks', 'quik-traks', 'quik_traks');
                  format_equipment_menu('landscapers', 'Walk Behind', 'walk-behind-mowers', 'walk_behind_mowers');
                  format_equipment_menu('landscapers', 'Wide Area', 'wide-area-mowers', 'wide_area_mowers');
                  // format_equipment_menu('landscapers', 'Loaders', 'loaders', 'loaders');
                ?>
              </ul>
            </li>
            <li class="mega-menu--parent mega-menu--parent--is-hidden">
              <a href="">Golf</a>
              <ul class="mega-menu--child-list">
                <?php
                  format_equipment_menu('golf', 'Aerators', 'aeration', 'aeration');
                  format_equipment_menu('golf', 'Greens Mowers', 'greens-mowers', 'greens_mowers');
                  format_equipment_menu('golf', 'Fairway Mowers', 'fairway-mowers', 'fairway_mowers');
                  format_equipment_menu('golf', 'Rough & Trim Mowers', 'rough-trim-mowers', 'rough_trim_mowers');
                  format_equipment_menu('golf', 'Turf Sprayers', 'turf-sprayers', 'turf_sprayers');
                ?>
              </ul>
            </li>
            <?php
            /*
            =========================
            <li class="mega-menu--parent mega-menu--parent--is-hidden">
              <a href="">Construction</a>
              <ul class="mega-menu--child-list">
                <?php
                  format_equipment_menu('construction', 'Undercarraige', 'undercarraige', 'undercarraige');
                ?>
              </ul>
            </li>
            =========================
            */
            ?>
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
        </li>
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
            <img src="https://www.greenfarmparts.com/v/vspfiles/templates/gfp-test/img/cart-icon.jpg" style="display: inline-block; vertical-align: middle; border-radius: 50%; max-width: 40px;">
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

<?php
  function format_equipment_menu($parent, $pretty_name, $slug, $equip_var) {
    $query = new WP_Query(array(
      'post_type' => 'post',
      'category' => 'maintenance-reminder',
      'posts_per_page' => -1,
      'tag_slug__and' => [$parent, $slug]
    ));
    $posts = [];
    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
      $name = get_the_title();
      $name = str_replace("John Deere", "", $name);
      $name = str_replace("Maintenance Guide", "", $name);
      array_push($posts, array(
        'name' => $name,
        'link' => get_the_permalink()
      ));
    endwhile; endif; wp_reset_query();
    echo '<li class="mega-menu--child-item">';
      echo '<button class="mega-menu--equipment-parent">';
        echo '<img src="' . get_stylesheet_directory_URI() . '/dist/img/' . $parent . '-' . $slug . '.jpg" alt="' . $pretty_name . '">' . $pretty_name;
      echo '</button>';
      echo '<ul class="visually-hidden">';
        foreach ($posts as $key => $equip) {
          echo '<li><a href="' . $equip['link'] . '" style="padding: 0; display: inline-block; text-align: left;">' . $equip['name'] . '</a></li>';
        }
      echo '</ul>';
    echo '</li>';
  }
?>


<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );


// $current_promotions_args = array(
//   'post_type' => 'promotions',
//   'posts_per_page' => -1,
//   'meta_key' => 'promotion_end_date',
//   'meta_value' => date('Ymd'),
//   'meta_compare' => '>='
// );

// $current_promotions_query = new WP_Query($current_promotions_args);
?>


<?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
?>

<div class="site-width">

  <div class="pad-y--most">

    <div class="product-list-with-filters">

      <section>

        <?php          
            if (is_tax()) {
              // if ($current_promotions_query->have_posts()) :
              //   while ($current_promotions_query->have_posts()) : $current_promotions_query->the_post();
              //     if (get_field('categories_on_sale')[0]->term_id === get_queried_object()->term_id) {
              //       echo '<section class="hero mar-b--more" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url(' . get_field('promotion_image') . ');">';
              //         echo '<h1>' . get_queried_object()->name . '</h1>';
              //         echo '<h2>Save Now! <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime(get_field('promotion_end_date'))) . '">on ' . date("F j, Y", strtotime(get_field('promotion_end_date'))) . '</span></span><h2>';
              //       echo '</section>';
              //     }
              //   endwhile;  
              // else : 
                $query_obj = get_queried_object();
                if ($query_obj->name !== '' && $query_obj->description !== '') {
                  echo '<h1>' . $query_obj->name . '</h1>';
                  echo '<p>' . number_format($query_obj->count, 0, '.', ',') . ' Parts</p>';
                  echo '<p class="mar-b--more" style="font-weight: normal; font-size: inherit;">' . $query_obj->description . '</p>';
                } else {
                  if (strpos($query_obj->name, 'Deere')) {
                    echo '<h1>' . $query_obj->name . '</h1>';
                    echo '<p>' . number_format($query_obj->count, 0, '.', ',') . ' Parts</p>';
                    echo '<p class="mar-b--more" style="font-weight: normal; font-size: inherit;">Shop our online catalog of ' . $query_obj->name . ' 24 hours a day!  We sell new, genuine John Deere parts and accessories.</p>';
                  } else {
                    echo '<h1>John Deere ' . $query_obj->name . '</h1>';
                    echo '<p>' . number_format($query_obj->count, 0, '.', ',') . ' Parts</p>';
                    echo '<p class="mar-b--more" style="font-weight: normal; font-size: inherit;">Shop our online catalog of John Deere ' . $query_obj->name . ' 24 hours a day!  We sell new, genuine John Deere parts and accessories.</p>';
                  }
                }
                
                $diagramLink = get_term_meta(get_queried_object()->term_id, 'diagramLink', true);
                if ($diagramLink) {
                  echo '<div class="box--with-header mar-b--most" style="display: table; width: 100%;"><div style="display: table-cell; vertical-align: middle; padding: 2rem;"><img src="/wp-content/themes/gfp/dist/img/cogs.svg" alt="" style="max-width: 75px; width: 100%;"></div><div style="display: table-cell; vertical-align: middle; width: 75%; padding-right: 3rem;"><h4>Need A Detailed Parts Diagram for a ' . str_replace(' Parts','',$query_obj->name) . '?</h4><p><a href="' . $diagramLink . '">View the Diagram</a></p></div></div>';
                }
              // endif; wp_reset_postdata();
            }
        ?>

        <?php
          if ( woocommerce_product_loop() ) {
        ?>

        <div class="product-list--sorting">
          <?php do_action( 'woocommerce_catalog_ordering' ); ?>
          <?php do_action( 'woocommerce_after_shop_loop' ); ?>
        </div>

        <?php
            woocommerce_product_loop_start();
            if ( wc_get_loop_prop( 'total' ) ) {
              while ( have_posts() ) {
                the_post();
                do_action( 'woocommerce_shop_loop' );
                get_template_part('partials/display', 'product-card--slim');
              }
            }
            woocommerce_product_loop_end();
            echo '<div class="product-list--sorting-after">', do_action( 'woocommerce_after_shop_loop' ), '</div>';
          } else {
            echo 'Sorry, nothing was found';
          }
        ?>
        
      </section>

      <aside class="product-list--promos">


          <?php
            if (get_term_meta(get_queried_object()->term_id, 'isModel', true)) {
              $things = new WP_Query(array(
                'posts_per_page' => -1,
                'tax_query' => array(
                  array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => get_queried_object()->term_id
                  )
                  ),
                  'fields' => 'ids'
              ));
              // $object_ids = ;
              $other_cats = get_categories(array(
                'taxonomy' => 'product_cat',
                'object_ids' => $things->posts
              ));

              $replaced_name = [];

              foreach ($other_cats as $cat) {
                $name = str_replace('John Deere ', '', $cat->name);
                array_push($replaced_name, array(
                  'id'   => $cat->term_id,
                  'name' => $name
                ));
              }
              
              usort($replaced_name, "my_sort_function");

              function my_sort_function($a, $b) {
                return $a->name < $b->name;
              }
              

              echo '<div class="box--with-header mar-b--most">';
                echo '<header>Filter By Category</header>';
                echo '<select class="filterModelCategory">';
                  foreach ($replaced_name as $cat) {
                    // print_r($cat);
                    if ($cat['id'] !== get_queried_object()->term_id) {
                      echo '<option value="' . $cat['id'] . '">' . $cat['name'] . '</option>';
                    }
                  }
                echo '</select>';
              echo '</div>';
            }
          
          ?>


        <ul class="filters--list">
          <?php 
            if ( function_exists('dynamic_sidebar') ) :
              dynamic_sidebar( 'Product Filters' );
            endif; 
          ?> 
        </ul>
        <?php
          $current_category = get_queried_object();
          $current_term_id = $current_category->term_id;
          $child_cats = get_categories(array(
            'taxonomy' => 'product_cat',
            'parent' => $current_term_id,
            'order' => 'ASC',
            'orderby' => 'none'
          ));
          if ($child_cats) :
        ?>
        <div class="box--with-header">
          <header><?php echo $current_category->name; ?></header>
          <ul style="list-style-type: none;">
            <?php foreach ($child_cats as $child_cat) : ?>
              <li>
                <a href="/product-category/<?php echo $child_cat->slug; ?>" style="font-size: 0.9em;">
                  <?php echo str_replace('John Deere ','<span class="visually-hidden">John Deere </span>',$child_cat->cat_name); ?> (<?php echo number_format($child_cat->count, 0, '.', ','); ?>)
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php
          endif;
        ?>
        <?php //get_template_part('partials/display', 'current-promo'); ?>
      </aside>
    </div>
    
  </div>
  
</div>

<?php get_footer( 'shop' ); ?>
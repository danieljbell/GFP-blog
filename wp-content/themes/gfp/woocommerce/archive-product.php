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


$current_promotions_args = array(
  'post_type' => 'promotions',
  'posts_per_page' => -1,
  'meta_key' => 'promotion_end_date',
  'meta_value' => date('Ymd'),
  'meta_compare' => '>='
);

$current_promotions_query = new WP_Query($current_promotions_args);
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
              if ($current_promotions_query->have_posts()) :
                while ($current_promotions_query->have_posts()) : $current_promotions_query->the_post();
                  if (get_field('categories_on_sale')[0]->term_id === get_queried_object()->term_id) {
                    echo '<section class="hero mar-b--more" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url(' . get_field('promotion_image') . ');">';
                      echo '<h1>' . get_queried_object()->name . '</h1>';
                      echo '<h2>Save Now! <span class="offer-text" style="color: inherit;">Offer expires <span class="promo-countdown" style="color: inherit !important;" data-expires="' . date("Ymd", strtotime(get_field('promotion_end_date'))) . '">on ' . date("F j, Y", strtotime(get_field('promotion_end_date'))) . '</span></span><h2>';
                    echo '</section>';
                  }
                endwhile;  
              else : 
                $query_obj = get_queried_object();
                echo '<h1>' . $query_obj->description . ' Parts</h1>';
                echo '<h2>' . number_format($query_obj->count, 0, '.', ',') . ' Parts</h2>';
              endif; wp_reset_postdata();
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
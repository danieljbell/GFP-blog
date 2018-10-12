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
      
      <aside class="product-list--filters">
        <ul class="product-list-filters-list">
          <li class="product-list-filters-item">
            <input type="radio" name="brand_filter" value="john_deere" id="john_deere">
            <label for="john_deere">John Deere</label>
          </li>
          <li class="product-list-filters-item">
            <input type="radio" name="brand_filter" value="stens" id="stens">
            <label for="stens">Stens</label>
          </li>
          <li class="product-list-filters-item">
            <input type="radio" name="brand_filter" value="ai" id="ai">
            <label for="ai">A&I</label>
          </li>
          <li class="product-list-filters-item">
            <input type="radio" name="brand_filter" value="sunbelt" id="sunbelt">
            <label for="sunbelt">Sunbelt</label>
          </li>
          <li class="product-list-filters-item">
            <input type="radio" name="brand_filter" value="honda" id="honda">
            <label for="honda">Honda</label>
          </li>
          <li class="product-list-filters-item">
            <input type="radio" name="brand_filter" value="zglide_suspension" id="zglide_suspension">
            <label for="zglide_suspension">ZGlide Suspension</label>
          </li>
          <li class="product-list-filters-item">
            <input type="radio" name="brand_filter" value="green_farm_parts" id="green_farm_parts">
            <label for="green_farm_parts">Green Farm Parts</label>
          </li>
          <li class="product-list-filters-item">
            <input type="radio" name="brand_filter" value="frontier" id="frontier">
            <label for="frontier">Frontier</label>
          </li>
        </ul>
      </aside>

      <section>

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
                get_template_part('partials/display', 'product-card');
              }
            }
            woocommerce_product_loop_end();
            echo '<div class="product-list--sorting-after">', do_action( 'woocommerce_after_shop_loop' ), '</div>';
          } else {
            echo 'asfasd';
          }
        ?>
        
      </section>

      <aside class="product-list--promos">
        <?php get_template_part('partials/display', 'current-promo'); ?>
      </aside>
    </div>
    
  </div>
  
</div>

<?php get_footer( 'shop' ); ?>

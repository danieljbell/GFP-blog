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

$current_page = get_queried_object();

$current_promotions_args = array(
  'post_type' => 'promotions'
);

$current_promotions_query = new WP_Query($current_promotions_args);

if ($current_promotions_query->have_posts()) : 
  $promo_categories = array();
  $promotions = array();
  
  while ($current_promotions_query->have_posts()) : 
    $current_promotions_query->the_post();
      $promotion_terms = get_field('categories_on_sale');
      $promo_categories = array();
      
      foreach ($promotion_terms as $term) {
        array_push($promo_categories, $term->slug);
      }

      $promo_selected_type = get_field('promo_type');
      if ($promo_selected_type === 'coupon') {
        $coupon = new WC_coupon(get_field('coupon'));
        $promo_type = $coupon->get_discount_type();
        $discount = $coupon->get_amount();
      } else {
        $discount = get_field('sale_amount');
        $promo_type = get_field('sale_type');
      }

      if (get_field('sale_end_date')) {
        $expiry = get_field('sale_end_date');
      }        
      if ($promo_selected_type === 'coupon') {
        $expiry = str_replace("-", "", $coupon->get_date_expires()->date_i18n()) . ', 12:00 am';
      }

      array_push($promotions, array(
        'name'              => get_the_title(),
        'promo_categories'  => $promo_categories,
        'promo_type'        => get_field('promo_type'),
        'discount_type'     => $promo_type,
        'discount_amount'   => $discount,
        'expires'           => $expiry
      ));

  endwhile;

    

endif;
wp_reset_postdata();

// global $product;
?>

<?php
/*
=========================
// finds a nested array value
function in_array_r($needle, $haystack, $strict = false) {
  foreach ($haystack as $item) {
    if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
      return true;
    }
  }

  return false;
}

?>


<?php if (in_array_r($current_page->slug, $promotions)) : ?>

<?php
// print_r($promotions);
  foreach ($promotions as $promotion) {
    foreach ($promotion['promo_categories'] as $promo) {
      if (in_array_r($current_page->slug, $promotion) && (substr($promotion['expires'], 0, 8) > date('Ymd'))) {
        $promo_price = '$' . $promotion['discount_amount'];
        if ($promotion['discount_type'] === 'percentage') {
          $promo_price = $promotion['discount_amount'] . '%';
        }
        
?>
  <section class="hero hero--is-sale" data-offer-expiry="<?php echo $promotion['expires']; ?>">
    <div class="site-width">
      <h1>Save <?php echo $promo_price; ?> off <?php echo $current_page->name; ?>. Ends in </h1>
      <h2></h2>
    </div>
  </section>
<?php
      }
    }
  }
?>  

<?php else : ?>
  
  <!-- <section class="hero">
    <div class="site-width">
      <h1><?php echo $current_page->name; ?></h1>
      <h2><?php echo $current_page->count; ?></h2>
    </div>
  </section> -->

<?php endif; ?>
=========================
*/
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
          <?php //echo the_widget( 'product_filters' ); ?> 
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
                <a href="/product-category/<?php echo $child_cat->slug; ?>" style="font-size: 0.9em;"><?php echo $child_cat->cat_name; ?> (<?php echo number_format($child_cat->count, 0, '.', ','); ?>)</a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php
          endif;
        ?>
        <?php get_template_part('partials/display', 'current-promo'); ?>
      </aside>
    </div>
    
  </div>
  
</div>

<?php get_footer( 'shop' ); ?>

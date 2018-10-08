<?php
  
// Get products with extra info about the results.
// $args = array(
//     'paginate' => true,
// );
// $results = wc_get_products( $args );
// echo $results->total . ' products found\n';
// echo 'Page 1 of ' . $results->max_num_pages . '\n';
// echo 'First product id is: ' . $results->products[0]->get_id() . '\n';

  $products = wc_get_products( array(
      'orderby' => 'date',
      'order' => 'DESC',
      'limit' => 3,
      // 'paginate' => true,
  ) );

  // print_r($query);
  // $products = $query->get_products();

  foreach ($products as $product) {
    echo '<p>', $product->get_name(), '</p>';
  }

  // $pagination_args = array(
  //   'total' => 2
  // );

  // woo_pagination($pagination_args);

  // print_r(get_query_var( 'paged' ));

  // $per_page = 5;
  // $order = 'DESC' || get_query_var('order');
  // $orderby = 'date' || get_query_var('orderby');

  // // If on a product taxonomy archive (category or tag)
  // if ( get_query_var( 'taxonomy' ) ) :
  //   $args = array(
  //     'post_type' => 'product',
  //     'posts_per_page' => $per_page,
  //     'order' => $order,
  //     'orderby' => $orderby,
  //     'paged' => get_query_var( 'paged' ),
  //     'tax_query' => array(
  //       array(
  //         'taxonomy' => get_query_var( 'taxonomy' ),
  //         'field'    => 'slug',
  //         'terms'    => get_query_var( 'term' ),
  //       ),
  //     ),
  //   );

  // // On main shop page
  // else :

  //   $args = array(
  //     'post_type' => 'product',
  //     'orderby' => $orderby,
  //     'order' => $order,
  //     'posts_per_page' => $per_page,
  //     'paged' => get_query_var( 'paged' ),
  //   );
  
  // endif;
  
  // // Set the query
  // $products = new WP_Query( $args );

?>

<div class="product-list-with-filters">
  
  <aside class="product-list--filters">
    sidebar bro

    <?php 
      // foreach ($variable as $key => $value) {
      //   # code...
      // }
    ?>

    <?php //echo get_search_form(); ?>
    
    <?php
      /*
      =========================
      CHANGE ORDER BY CRITERIA
      =========================
      */
      // <form class="woocommerce-ordering" method="get">
      //   <select name="orderby" class="orderby">
      //     <option value="popularity" selected="selected">Sort by popularity</option>
      //     <option value="rating">Sort by average rating</option>
      //     <option value="date">Sort by newness</option>
      //     <option value="price">Sort by price: low to high</option>
      //     <option value="price-desc">Sort by price: high to low</option>
      //   </select>
      //   <input type="hidden" name="paged" value="1">
      //   <input type="hidden" name="subid" value="">
      // </form>    
    ?>

  </aside>

  <section>
    <?php
      // Standard loop
      // if ( $products->have_posts() ) :
      //   echo '<ul class="products--list">';
      //   while ( $products->have_posts() ) : $products->the_post();
      //     get_template_part('partials/display', 'product-card');
      //   endwhile;
      //   echo '</ul>';
      //   wp_reset_postdata();
      // endif;
    ?>
  </section>

  <aside class="product-list--promos">
    promo stuff
  </aside>

</div>
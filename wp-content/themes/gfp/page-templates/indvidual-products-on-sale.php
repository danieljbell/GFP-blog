<?php
/*
=========================================
Template Name: Indvidual Products On Sale
=========================================
*/
?>

<?php get_header(); ?>

  <section class="hero">
    <div class="site-width">
      <h1><?php echo get_the_title(); ?></h1>
    </div>
  </section>

  <section>
    <div class="site-width">
      <ul>
        <?php while (have_rows('products')) : the_row(); ?>
          <?php
            $product_id = wc_get_product_id_by_sku(get_sub_field('part_sku'));
            if ($product_id) :
              $wc_product = wc_get_product($product_id);
?>
  <li class="products--item product-card--slim">
      <div class="products--image">
        <?php if ( has_post_thumbnail($wc_product->get_id()) ) : ?>
          <img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/<?php echo $product->get_sku(); ?>-0.jpg" alt="">
        <?php else : ?>
          <img src="<?php echo wc_placeholder_img_src(); ?>" alt="Part Photo Coming Soon">
        <?php endif; ?>
      </div>
      <div class="products--content">
        <a href="<?php echo $wc_product->get_permalink(); ?>">
          <h3><?php echo $wc_product->get_name(); ?></h3>
        </a>
        <span class="price"><?php echo $wc_product->get_price_html(); ?></span>
          <div class="products--actions">
            <button class="add-to-cart btn-solid--brand-two" value="<?php echo $wc_product->get_id(); ?>">Add to Cart</button>
          </div>
      </div>
  </li>
<?php
            endif;
          ?>
        <?php endwhile; ?>
      </ul>
    </div>
  </section>

<?php get_footer(); ?>
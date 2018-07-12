<?php
  $deere_permalink = get_field('deere_permalink');
  $url = $deere_permalink . 'index.json';
  $getJSON = curl_init();
  curl_setopt($getJSON, CURLOPT_URL, $url);
  curl_setopt($getJSON, CURLOPT_HEADER, 0);
  curl_setopt($getJSON, CURLOPT_RETURNTRANSFER, 1);
  
  $returnDeereModel = json_decode(curl_exec($getJSON), true);

  $model_number = $returnDeereModel['Page']['analytics']['MetaData']['product-model-number'];
  $model_name = $returnDeereModel['Page']['analytics']['MetaData']['product-model-name'];
  $model_image = 'https://deere.com/' . $returnDeereModel['Page']['analytics']['MetaData']['product-image'];
?>  

<section <?php post_class(); ?>>
  <div class="site-width">

    <aside>
      <img class="model-image" src="<?php echo $model_image; ?>" alt="John Deere <?php echo $model_number . ' ' . $model_name; ?>">

    </aside>
      
    <article>
      <h1><?php echo get_the_title(); ?></h1>

      <?php
        $model_modifiers = get_field('model_modifers'); 
        echo '<select id="modelModifiers">';
          echo '<option selected disabled>Choose Different Model in this Series</option>';
        foreach ($model_modifiers as $post) {
          setup_postdata($post);
          global $post;
          $post_slug = $post->post_name;
          echo '<option value="' . $post_slug . '">' . str_replace('Maintenance Sheet', '', get_the_title()) . '</option>';
        }
        wp_reset_postdata();
        echo '</select>';
      ?>

      <section class="mar-y--most">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni possimus quasi nobis voluptates sint aliquid in quas rerum, optio quisquam recusandae ratione corporis suscipit quis!</p>
      </section>

      <section class="mar-y--most">
        <h2>Common Parts<span>for John Deere <?php echo $model_number . ' ' . $model_name; ?></span></h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut est soluta vitae ipsam facilis exercitationem, nulla ea. Illum possimus nisi suscipit, quae dolore blanditiis! Autem eligendi libero ullam, accusamus eius nihil facilis iure assumenda! Explicabo.</p>
        <?php if (have_rows('common_parts')) : ?>
          <table>
            <tr>
              <th width="35%">Part Type</th>
              <th width="35%">Part Number</th>
              <th>Price</th>
              <th width="22%"></th>
            </tr>
        <?php while (have_rows('common_parts')) : the_row(); ?>
            <?php
              // $url = 'https://www.greenfarmparts.com/-p/' . get_sub_field('common_part_number') . '.htm';
              // $getHTML = curl_init();
              // curl_setopt($getHTML, CURLOPT_URL, $url);
              // curl_setopt($getHTML, CURLOPT_HEADER, 0);
              // curl_setopt($getHTML, CURLOPT_RETURNTRANSFER, 1);
              // $returnProductData = curl_exec($getHTML);
            ?>
            <tr>
              <td data-header="Part Type"><?php echo get_sub_field('common_part_description'); ?></td>
              <td data-header="Part Number"><a href="https://www.greenfarmparts.com/-p/<?php echo get_sub_field('common_part_number'); ?>.htm"><?php echo get_sub_field('common_part_number'); ?></a></td>
              <td data-header="Price">$9.99</td>
              <td><button class="add-to-cart">Add to Cart</button></td>
            </tr>
            <?php if (have_rows('serial_breaks')) : while(have_rows('serial_breaks')) : the_row(); ?>
              <?php
                // Add Serial Break on seperate line
                $serial_break_common_part_description = get_sub_field('serial_break_common_part_description');
                $serial_break_common_part_description = explode('(', $serial_break_common_part_description);
              ?>
              <tr>
                <td data-header="Part Type"><?php echo $serial_break_common_part_description[0]; ?><br><em>(<?php echo $serial_break_common_part_description[1]; ?></em></td>
                <td data-header="Part Number"><a href="https://www.greenfarmparts.com/-p/<?php echo get_sub_field('serial_break_common_part_number'); ?>.htm"><?php echo get_sub_field('serial_break_common_part_number'); ?></a></td>
                <td data-header="Price">$9.99</td>
                <td><button class="add-to-cart">Add to Cart</button></td>
              </tr>
            <?php endwhile; endif; ?>
        <?php endwhile; ?>
          </table>
        <?php endif; ?>
      </section>

      <section>
        <h2>Hourly Parts<span>for John Deere <?php echo $model_number . ' ' . $model_name; ?></span></h2>
      </section>


    </article>

  </div>
</section>


<div class="alert--add-to-cart">
  <div class="alert--header">
    <h4>Products in Cart</h4>
    <button class="alert--close" id="closeAlert">&times;</button>
  </div>
  <div class="alert--content">
    <ul class="alert--cart-list">
      <li class="alert--cart-item">
        <span class="alert--cart-part">
          <span class="alert--cart-part-type">productType</span>
          <span class="alert--cart-part-number">productCode</span>
        </span>
        <span>
          <label for="product_quantity">Qty: </label>
          <input type="number" name="product_quantity" min="1" max="50" value="1">
          <button class="alert--remove-item">&times;</button>
        </span>
      </li>
    </ul>
    <div class="has-text-center mar-t--more">
      <a id="submitCheckout" href="https://www.greenfarmparts.com/shoppingcart.asp?" class="btn-solid--brand">Checkout</a>
    </div>
  </div>
</div>
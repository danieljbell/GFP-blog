<?php
  $posts = get_posts([
    'posts_per_page' => -1,
    'post_type' => 'any',
    's' => $_GET['s'],
  ]);

  $categories = get_categories(array(
    'taxonomy'      => 'product_cat',
    'name__like'    => $_GET['s'],
    'hide_empty'    => false
  ));

  $tags = get_categories(array(
    'taxonomy'      => 'post_tag',
    'name__like'    => $_GET['s'],
    'meta_key'      => 'is_model',
    'meta_value'    => true,
    'hide_empty'    => false
  ));

  $results_count = count($tags) + count($categories) + count($tax_posts) + count($posts);

  $results = [];

  foreach($posts as $post):
    if ($post->post_type === 'product') {
      $product = new WC_product($post->ID);
      $attachmentIds = $product->get_gallery_attachment_ids();
      $imgURL = wp_get_attachment_url( $attachmentId[0] );
      $results[] = [
        'title' => $post->post_title,
        'link' => get_permalink( $post->ID ),
        'type' => $post->post_type,
        'image' => $product->get_image('thumbnail')
      ];
    } else {
      $results[] = [
        'title' => $post->post_title,
        'link' => get_permalink( $post->ID ),
        'type' => $post->post_type,
      ];
    }
  endforeach;

  if ($categories) :
    foreach($categories as $cat):
      $name = $cat->category_nicename;
      $name = explode('-', $name);
      $name = implode(' ', $name);
      $thumb_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
      $image = wp_get_attachment_url( $thumb_id ); 
      $results[] = [
        'title' => ucwords($name),
        'link' => get_tag_link($cat->term_id),
        'type' => 'category',
        'image' => $image
      ];
    endforeach;
  endif;

  if ($tags) :
    foreach($tags as $tag):
      $image = get_field('model_image', $tag);
      $results[] = [
        'title' => $tag->name,
        'link' => get_tag_link($tag->term_id),
        'type' => 'model',
        'image' => $image['sizes']['thumbnail']
      ];
    endforeach;
  endif;

  // print_r($results);

?>

<?php get_header(); ?>

<section class="hero">
  <div class="site-width">
    <h1>Search for: <mark style="text-shadow: none; display: inline-block; padding-left: 0.25em; padding-right: 0.25em;"><?php echo $_GET['s']; ?></mark></h1>
    <h2><?php echo $results_count; ?> results</h2>
  </div>
</section>

<section class="page-search--results">
  <div class="site-width">
  <aside class="search--navigation">
    <nav>
      <ul>
        <li><a href="<?php echo site_url() . '/?s=' . $_GET['s']; ?>#articles">Articles</a></li>
        <li><a href="<?php echo site_url() . '/?s=' . $_GET['s']; ?>#products">Products</a></li>
        <li><a href="<?php echo site_url() . '/?s=' . $_GET['s']; ?>#models">Models</a></li>
        <li><a href="<?php echo site_url() . '/?s=' . $_GET['s']; ?>#categories">Categories</a></li>
      </ul>
    </nav>
  </aside>
  <section class="search--listings">
    <div class="box--with-header mar-b--most">
      <header>
        <h2 id="articles">Articles</h2>
      </header>
      <?php
        if ($posts) {
          $i = 0;
          foreach ($posts as $key => $post) {
            if ($post->post_type === 'post') {
              echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
            } else {
              if ($i < 1) {
                echo '<p>No articles found matching <strong>' . $_GET['s'] . '</strong>.</p>';
              }          
            }
            $i++;
          }
        } else {
          echo 'nahp';
        }
      ?>
    </div>
    <div class="box--with-header mar-b--most">
      <header>
        <h2 id="products">Products</h2>
      </header>
      <?php
        if ($posts) {
          $i = 0;
          echo '<ul class="grid--third grid--phone-half">';
            foreach ($posts as $key => $post) {
              if ($post->post_type === 'product') {
                  get_template_part('partials/display', 'product-card--slim');
              } else {
                if ($i < 1) {
                  echo '<p>No products found matching <strong>' . $_GET['s'] . '</strong>.</p>';
                }
              }
              $i++;
            }
          echo '</ul>';
        } else {
          echo 'nahp';
        }
      ?>
    </div>
    <div class="box--with-header mar-b--most">
      <header>
        <h2 id="models">Models</h2>
      </header>
      <?php
        if ($tags) {
          echo '<ul class="grid--third grid--phone-half">';
          foreach ($tags as $key => $tag) { ?>
<li class="products--item product-card--slim">
  <?php
    $name = $tag->name;
    $term_link = get_term_link($tag->term_id);
    $image = get_field('model_image', $tag);
    $model_image = $image['sizes']['thumbnail'];
    if (!$image) {
      $model_image = '//fillmurray.com/100/100';
    }
  ?>
  <a href="<?php echo $term_link; ?>"><img src="<?php echo $model_image; ?>" alt="<?php echo $name; ?>"><?php echo $name; ?></a>
</li>
      <?php
          }
          echo '</ul>';
        } else {
          echo '<p>No models found matching <strong>' . $_GET['s'] . '</strong>.</p>';
        }
      ?>
    </div>
    <div class="box--with-header mar-b--most">
      <header>
        <h2 id="categories">Categories</h2>
      </header>
      <?php
        if ($categories) {
          echo '<ul class="grid--third grid--phone-half">';
          foreach ($categories as $key => $category) {  //print_r($category); ?>
<li class="products--item product-card--slim">
  <?php
    $name = $category->name;
    $term_link = get_term_link($category->term_id);
    $thumb_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
    $image = wp_get_attachment_url( $thumb_id );
  ?>
  <a href="<?php echo $term_link; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $name; ?>"><?php echo $name; ?></a>
</li>
      <?php
          }
          echo '</ul>';
        } else {
          echo '<p>No categories found matching <strong>' . $_GET['s'] . '</strong>.</p>';
        }
      ?>
    </div>

    <?php
      /*
      =========================
      <?php foreach ($results as $key => $result) : ?>
      <?php if ($result['type'] === 'post') {
        echo '<h2 id="articles">Articles</h2>';
        echo '<p>' . $result['title'] . '</p>';
        echo '<hr>';
      } ?>
    <?php endforeach; ?>
    <?php foreach ($results as $key => $result) : ?>
      <?php if ($result['type'] === 'product') {
        echo '<h2 id="products">Products</h2>';
        echo '<p>' . $result['title'] . '</p>';
        echo '<hr>';
      } ?>
    <?php endforeach; ?>



      <?php if ($result['type'] === 'model') {
        echo '<h2 id="models">Models</h2>';
        echo '<p>' . $result['title'] . '</p>';
        echo '<hr>';
      } ?>
      <?php if ($result['type'] === 'category') {
        echo '<h2 id="categories">Categories</h2>';
        echo '<p>' . $result['title'] . '</p>';
        echo '<hr>';
      } ?>
      =========================
      */
    ?>
    
  </section>

  </div>
</section>

<?php get_footer(); ?>
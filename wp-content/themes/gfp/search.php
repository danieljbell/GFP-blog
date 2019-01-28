<?php
  $posts = new WP_Query([
    'posts_per_page' => -1,
    'post_type' => 'post',
    's' => $_GET['s'],
    'category__not_in' => [17]
  ]);

  $models = new WP_Query([
    'posts_per_page' => -1,
    'post_type' => 'post',
    's' => $_GET['s'],
    'category_name' => 'maintenance-reminder'
  ]);

  $products = new WP_Query([
    'posts_per_page' => -1,
    'post_type' => 'product',
    's' => $_GET['s']
  ]);

  $categories = get_categories(array(
    'taxonomy'      => 'product_cat',
    'name__like'    => $_GET['s'],
    'hide_empty'    => false
  ));

  $results_count = $posts->post_count + $models->post_count + count($categories) + $products->post_count;

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
        <li><a href="<?php echo site_url() . '/?s=' . $_GET['s']; ?>#pages">Pages</a></li>
        <li><a href="<?php echo site_url() . '/?s=' . $_GET['s']; ?>#models">Models</a></li>
        <li><a href="<?php echo site_url() . '/?s=' . $_GET['s']; ?>#categories">Categories</a></li>
        <li><a href="<?php echo site_url() . '/?s=' . $_GET['s']; ?>#products">Products</a></li>
      </ul>
    </nav>
  </aside>
  <section class="search--listings">
    <div class="box--with-header mar-b--most">
      <header>
        <h2 id="pages">Pages</h2>
      </header>
      <?php
        if ($posts->have_posts()) :
          echo '<ul class="pad-x">';
            while ($posts->have_posts()) : $posts->the_post();
              echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
            endwhile;
          echo '</ul>';
        else :
          echo '<p>No pages found matching <mark><strong>' . $_GET['s'] . '</strong></mark>.</p>';
        endif; wp_reset_query();
      ?>
    </div>
    <div class="box--with-header mar-b--most">
      <header>
        <h2 id="models">Models</h2>
      </header>
      <?php
      if ($models->have_posts()) :
        echo '<ul class="pad-x">';
          while ($models->have_posts()) : $models->the_post();
              $title = get_the_title();
              $title = str_replace('John Deere ', "", $title);
              $title = str_replace(' Maintenance Guide', "", $title);
            echo '<li><a href="' . get_the_permalink() . '">' . $title . '</a></li>';
          endwhile;
        echo '</ul>';
      else :
        echo '<p>No models found matching <mark><strong>' . $_GET['s'] . '</strong></mark>.</p>';
      endif;
      ?>
    </div>
    <div class="box--with-header mar-b--most">
      <header>
        <h2 id="categories">Categories</h2>
      </header>
      <?php
        if ($categories) {
          echo '<ul class="pad-x">';
            foreach ($categories as $key => $category) {
              echo '<li><a href="' . get_term_link($category->term_id) . '">' . $category->name . '</a></li>';
            }
          echo '</ul>';
        } else {
          echo '<p>No categories found matching <mark><strong>' . $_GET['s'] . '</strong></mark>.</p>';
        } 
      ?>
    </div>
    <div class="box--with-header mar-b--most">
      <header>
        <h2 id="products">Products</h2>
      </header>
      <?php
        if ($products->have_posts()) :
          echo '<ul class="grid--third grid--phone-half">';
            while ($products->have_posts()) : $products->the_post();
              get_template_part('partials/display', 'product-card--slim');
            endwhile;
          echo '</ul>';
        else :
          echo '<p>No products found matching <mark><strong>' . $_GET['s'] . '</strong></mark>.</p>';
        endif; wp_reset_query();
      ?>
    </div>
    
  </section>

  </div>
</section>

<?php get_footer(); ?>
<?php
  $posts = get_posts([
    'posts_per_page' => -1,
    'post_type' => 'any',
    's' => $_GET['s'],
  ]);

  $tax_posts = get_posts([
    'posts_per_page' => -1,
    'post_type' => 'product',
    'name__like'  => $_GET['s'],
  ]);

  $categories = get_categories(array(
    'taxonomy'      => 'product_cat',
    'name__like'          => $_GET['s'],
    'hide_empty'    => false
  ));

  $tags = get_categories(array(
    'taxonomy'      => 'post_tag',
    'name__like'          => $_GET['s'],
    'hide_empty'    => false
  ));

  $results_count = count($tags) + count($categories) + count($tax_posts) + count($posts);

?>

<?php get_header(); ?>

<section class="hero">
  <div class="site-width">
    <h1>Search for: <mark style="text-shadow: none; display: inline-block; padding-left: 0.25em; padding-right: 0.25em;"><?php echo $_GET['s']; ?></mark></h1>
    <h2><?php echo $results_count; ?> results</h2>
  </div>
</section>

<section>
  <div class="site-width">
    
  <?php
    

    print_r();
  ?>

  </div>
</section>

<?php get_footer(); ?>
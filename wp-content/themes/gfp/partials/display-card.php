<div class="card">

  <div class="card-content">
    
    <?php
      $all_cats = get_the_category();
      print_r($all_cats);
      echo '<p class="card-category"><a href="/category/' . $all_cats[0]->slug . '">' . $all_cats[0]->name . '</a></p>';
    ?>

    <h4 class="card-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title() ?></a></h4>
    
    <p class="card-description"><?php echo get_the_excerpt(); ?></p>
    
    <?php
      // $post_tags = get_the_tags();
      // if ($post_tags) {
      //   echo '<ul class="single-tags--list">';
      //     foreach($post_tags as $tag) {
      //       echo '<li class="single-tags--item"><a href="/tag/' . $tag->slug . '">' . $tag->name . '</a></li>'; 
      //     }
      //   echo '</ul>';
      // }
    ?>

  </div>
  

</div>
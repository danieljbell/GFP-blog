<div class="card">

  
  <div class="card-meta">
    <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('M d Y'); ?></time>
    <p><small>By: <a href="<?php echo get_author_posts_url(get_the_author_meta('id')); ?>"><?php the_author(); ?></a></small></p>
  </div>

  <div class="card-content">
    
    <?php
      $all_cats = get_the_category();
      echo '<p class="card-category"><a href="/category/' . $all_cats[0]->slug . '">' . $all_cats[0]->name . '</a></p>';
    ?>

    <h4 class="card-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title() ?></a></h4>
    
    <p class="card-description"><?php echo get_the_excerpt(); ?></p>
    
    <?php
      $post_tags = get_the_tags();
      if ($post_tags) {
        echo '<ul class="single-tags--list">';
          foreach($post_tags as $tag) {
            echo '<li class="single-tags--item"><a href="/tag/' . $tag->slug . '">' . $tag->name . '</a></li>'; 
          }
        echo '</ul>';
      }
    ?>

  </div>
  

</div>
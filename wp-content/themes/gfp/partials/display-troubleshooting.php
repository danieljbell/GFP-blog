<?php
  if (has_post_thumbnail()) {
    $thumb_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
    $hero_bg = 'background-image: linear-gradient(rgba(0,0,0, 0.5), rgba(0,0,0, 0.5)), url(' . $thumb_array[0] . ')';
  }
  $post_title = str_replace('Troubleshooting Common Problems for a ', '', get_the_title());
?>

<section class="hero" <?php if (has_post_thumbnail()) { echo 'style="' . $hero_bg . '"'; } ?>>
      
  <div class="site-width">
    <h1 style="margin-bottom: 0;"><?php echo ($current_cat[0]->slug === 'talk-with-a-tech') ? 'Talk With A Tech ' : '';  ?><?php echo get_the_title(); ?></h1>
  </div>

</section>

<section <?php post_class(); ?>>
  <div class="site-width">
    <aside>
      <nav id="stickyNav" class="sticky-navigation">
        <ul>
          <li><a href="/<?php echo $post->post_name; ?>/#engine">Engine</a></li>
          <li><a href="/<?php echo $post->post_name; ?>/#electrical">Electrical</a></li>
          <li><a href="/<?php echo $post->post_name; ?>/#machine">Machine</a></li>
          <li><a href="/<?php echo $post->post_name; ?>/#mower">Mower</a></li>
        </ul>
      </nav>
    </aside>
    <article>
      
      <?php
        if (have_rows('engine_problems')) : 
          echo '<h2 id="engine">Common Engine Problems <span>for ' . $post_title . '<span></h2>';
          echo '<ul class="accordian mar-b--most">';
            while(have_rows('engine_problems')) : the_row();
            echo '<li class="accordian--item">';
              echo '<button class="accordian--title">' . get_sub_field('problem') . '</button>';
              echo '<div class="accordian--content">' . get_sub_field('solution') . '</div>';
            echo '</li>';
            endwhile;
          echo '</ul>';
        endif;
      ?>

      
      <?php
        if (have_rows('electrical_problems')) : 
          echo '<h2 id="electrical">Common Electrical Problems <span>for ' . $post_title . '<span></h2>';
          echo '<ul class="accordian mar-b--most">';
            while(have_rows('electrical_problems')) : the_row();
            echo '<li class="accordian--item">';
              echo '<button class="accordian--title">' . get_sub_field('problem') . '</button>';
              echo '<div class="accordian--content">' . get_sub_field('solution') . '</div>';
            echo '</li>';
            endwhile;
          echo '</ul>';
        endif;
      ?>

      <?php
        if (have_rows('machine_problems')) : 
          echo '<h2 id="machine">Common Machine Problems <span>for ' . $post_title . '<span></h2>';
          echo '<ul class="accordian mar-b--most">';
            while(have_rows('machine_problems')) : the_row();
            echo '<li class="accordian--item">';
              echo '<button class="accordian--title">' . get_sub_field('problem') . '</button>';
              echo '<div class="accordian--content">' . get_sub_field('solution') . '</div>';
            echo '</li>';
            endwhile;
          echo '</ul>';
        endif;
      ?>

      <?php
        if (have_rows('mower_problems')) : 
          echo '<h2 id="mower">Common Mower Problems <span>for ' . $post_title . '<span></h2>';
          echo '<ul class="accordian">';
            while(have_rows('mower_problems')) : the_row();
            echo '<li class="accordian--item">';
              echo '<button class="accordian--title">' . get_sub_field('problem') . '</button>';
              echo '<div class="accordian--content">' . get_sub_field('solution') . '</div>';
            echo '</li>';
            endwhile;
          echo '</ul>';
        endif;
      ?>

    </article>

    <aside>
        
        <?php
          // Loop over tags
          foreach (get_the_tags() as $tag) {
            // if tag is set as a model then query for posts
            if (get_field('is_model', $tag)) {
              $args = array(
                'post_type' => 'post',
                'tax_query' => array(
                  'relation' => 'AND',
                  array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => array( 'maintenance-reminder' ),
                  ),
                  array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'term_id',
                    'terms'  => $tag->term_id,
                  ),
                ),
              );
              $query = new WP_Query( $args );
              if ($query->have_posts()) : 
                echo '<div class="related-maintenance-reminder">';
                  echo '<h4>Need a maintenance guide for your ' . $post_title . '?</h4>';
                  echo '<div class="mar-t">';
                    if ($query->post_count > 1) {
                      echo '<button class="tooltip--toggle btn-solid--brand">Get Your Guide</button>';
                      echo '<ul class="tooltip--links">';
                        while ($query->have_posts()) : $query->the_post();
                          $post_title = str_replace('John Deere ', '', get_the_title());
                          $post_title = str_replace(' Maintenance Sheet', '', $post_title);
                          echo '<li class="tooltip--item"><a href="' . get_the_permalink() . '">' . $post_title . '</a></li>';
                        endwhile;
                      echo '</ul>';
                    } else {
                      while ($query->have_posts()) : $query->the_post();
                        echo '<a href="' . get_the_permalink() . '" class="btn-solid--brand">Get Your Guide</a>';
                      endwhile;
                    }
                  echo '</div>';
                echo '</div>';
              endif;
              wp_reset_postdata();
            }
          }
        ?>

      </div>
    </aside>

  </div>
</section>
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
    <!-- <h2><?php echo get_the_excerpt(); ?></h2> -->
    <p>asdf</p>
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
  </div>
</section>
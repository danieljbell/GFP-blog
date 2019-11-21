<?php
  $current_cat = get_the_category();
  $format = get_post_format();
?>

<?php get_header(); ?>
  
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php
      if (has_post_thumbnail()) {
        $thumb_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
        $hero_bg = 'background-image: linear-gradient(rgba(0,0,0, 0.5), rgba(0,0,0, 0.5)), url(' . $thumb_array[0] . ')';
      }
    ?>

    <?php 
      if (get_the_category()[0]->slug === 'maintenance-reminder') {
        get_template_part('partials/display', 'maintenance-reminder');
      } elseif (get_the_category()[0]->slug === 'troubleshooting') {
        get_template_part('partials/display', 'troubleshooting');
      } elseif (get_the_category()[0]->slug === 'service-intervals') {
        get_template_part('partials/display', 'service-intervals');
      } else {
    ?>

    <section class="hero" <?php if (has_post_thumbnail()) { echo 'style="' . $hero_bg . '"'; } else { echo 'style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(' . get_stylesheet_directory_URI() . '/dist/img/hero--generic-' . mt_rand(1,5) . '.jpg);"'; } ?>>
      
      <div class="site-width">
        <h1><?php echo get_the_title(); ?></h1>
        <h2><?php echo get_the_excerpt(); ?></h2>
      </div>

    </section>

    <section <?php post_class(); ?>>

      <div class="site-width">
        
        <aside class="single-author">
          <time class="single-author--date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date(); ?></time>
          <div class="single-author--headshot">
            <?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
          </div>
          <div class="single-author--content">
            <p class="single-author--name"><a href="<?php echo get_author_posts_url(get_the_author_meta('id')); ?>"><?php the_author(); ?></a></p>
            <p class="single-author--description"><?php echo get_the_author_meta('description'); ?></p>
          </div>
        </aside>
        
        <article class="single-content">
          <?php
            if ( have_rows('tech_section') ) : 
              while ( have_rows('tech_section') ) : the_row();
                if( get_row_layout() == 'text_only' ) :
                  echo the_sub_field('content');
                endif;
                if( get_row_layout() == 'section' ) :
                  $headline = get_sub_field('section_headline');
                  $content = get_sub_field('section_content');
                  $image = get_sub_field('section_image');

                  echo '<div class="single-tech-section">';
                    echo '<h3>' . $headline . '</h3>';
                    echo '<img src="' . $image["url"] . '" srcset="' . $image["sizes"]["medium"] . ' ' . $image["sizes"]["medium-width"] . 'w, ' . $image["sizes"]["large"] . ' ' . $image["sizes"]["large-width"] . 'w" sizes="(max-width: ' . $image["sizes"]["medium-width"] . 'px) 100vw, ' . $image["sizes"]["medium-width"] . 'px" alt="' . $headline . '">';
                    echo $content;
                  echo '</div>';
                endif;
              endwhile;
            
            elseif ($format === 'video') :
              echo '<div class="video-outer mar-b">';
                echo '<div class="video-inner">';
                  echo '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/' . get_field('video_embed_url') . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
                echo '</div>';
              echo '</div>';
              echo the_content();

            else :

              echo the_content();
            
            endif;
          ?>


            <?php
              echo '<footer class="single-footer">';
                $posttags = get_the_tags();
                if ($posttags) {
                  echo '<div class="post-tags">';
                    echo '<span>Tags:</span>';
                    echo '<ul class="single-tags--list">';
                      foreach($posttags as $tag) {
                        echo '<li class="single-tags--item"><a href="/tag/' . $tag->slug . '">' . $tag->name . '</a></li>'; 
                      }
                    echo '</ul>';
                  echo '</div>';
                }
                echo '<div class="social-share">';
                  echo '<h4>Share on social</h4>';
                  echo '<ul class="social-share--list">';
                    echo '<li class="facebook-icon">';
                      echo '<a href="http://www.facebook.com/sharer.php?u=' . get_the_permalink() . '" target="_blank" rel="noopener noreferrer">' . file_get_contents(get_stylesheet_directory_URI() . '/dist/img/facebook-icon.svg', false, $context) . '</a>';
                    echo '</li>';
                    echo '<li class="twitter-icon">';
                      echo '<a href="http://twitter.com/intent/tweet?url=' . get_the_permalink() . '&text=' . get_the_title() . '" target="_blank" rel="noopener noreferrer">' . file_get_contents(get_stylesheet_directory_URI() . '/dist/img/twitter-icon.svg', false, $context) . '</a>';
                    echo '</li>';
                    echo '<li class="linkedin-icon">';
                      echo '<a href="http://www.linkedin.com/shareArticle?mini=true&url=' . get_the_permalink() . '&title=' . get_the_title() . '" target="_blank" rel="noopener noreferrer">' . file_get_contents(get_stylesheet_directory_URI() . '/dist/img/linkedin-icon.svg', false, $context) . '</a>';
                    echo '</li>';
                  echo '</ul>';
                echo '</div>';
              echo '</footer>';
            ?>
            <div class="single-comments">
              <?php comments_template(); ?>
            </div>
        </article>

        <?php 
          /*
          =========================
          <aside class="single-categories">
            <ul class="single-categories--list">
              <?php
                $blog_cats = get_categories();
                foreach ($blog_cats as $cat) {
                  $name = $cat->name;
                  $count = $cat->count;
                  $slug = $cat->slug;
                  $class = ($current_cat[0]->slug === $slug) ? 'single-categories--active' : ''; 
                  echo '<li class="single-categories--item"><a href="/category/' . $slug . '" class="single-categories--link ' . $class . '">' . $name . '<span>' . $count . '</span></a></li>';
                }
              ?>
            </ul>
            <?php get_template_part('partials/display', 'current-promo') ?>
          </aside>
          =========================
          */
        ?>

      </div>

    </section>

  <?php } ?>

  <?php endwhile; endif; ?>

<?php get_footer(); ?>
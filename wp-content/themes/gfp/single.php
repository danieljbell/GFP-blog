<?php
  $current_cat = get_the_category();
  $format = get_post_format();
?>

<?php get_header(); ?>
  
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <section class="hero">
      
      <div class="site-width">
        <h1><?php echo ($current_cat[0]->slug === 'talk-with-a-tech') ? 'Talk With A Tech ' : '';  ?><?php echo get_the_title(); ?></h1>
        <h2><?php echo strip_tags(the_excerpt()); ?></h2>
      </div>

    </section>

    <section <?php post_class(); ?>>

      <div class="site-width">
        
        <aside class="single-author">
          <p class="single-author--date"><small><?php echo get_the_date(); ?></small></p>
          <div class="single-author--headshot">
            <?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
          </div>
          <div class="single-author--content">
            <p class="single-author--name"><?php the_author(); ?></p>
            <p class="single-author--description"><?php echo get_the_author_meta('description'); ?></p>
          </div>
        </aside>
        
        <article class="single-content">
          <?php
            if ( have_rows('tech_section') ) : while ( have_rows('tech_section') ) : the_row();
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
          <footer class="single-footer">
            <?php
              $posttags = get_the_tags();
              if ($posttags) {
                echo '<span>Tags:</span>';
                echo '<ul class="single-tags--list">';
                  foreach($posttags as $tag) {
                    echo '<li class="single-tags--item"><a href="/tag/' . $tag->slug . '">' . $tag->name . '</a></li>'; 
                  }
                echo '</ul>';
              }
            ?>
          </footer>
        </article>

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
          <div class="single-current-promo">
            asdfasdfasdf
          </div>
        </aside>

      </div>

    </section>


  <?php endwhile; endif; ?>

<?php get_footer(); ?>
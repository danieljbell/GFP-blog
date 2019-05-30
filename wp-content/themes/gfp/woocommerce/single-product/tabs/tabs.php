<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see   https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
global $post;
global $product;

$tabs = apply_filters( 'woocommerce_product_tabs', array() );



$comments = get_comments(array(
  'post_id' => $post->ID
));

$fitment = get_the_terms($post->ID, 'pa_part-catalog');
if ($fitment) {
  $sorted_fitment = array_sort($fitment, 'description', SORT_ASC);
}


//if ( ! empty( $tabs ) ) : ?>

<div class="woocommerce-tabs wc-tabs-wrapper">
    <ul class="tabs wc-tabs" role="tablist">
      <?php
/*
=========================
<?php if ($fitment) : ?>
  <li class="fitment_tab" id="tab-title-fitment" role="tab" aria-controls="tab-fitment">
    <a href="#tab-fitment">Product Fitment</a>
  </li>
<?php endif; ?>
=========================
*/
      ?>
      <li class="reviews_tab" id="tab-title-reviews" role="tab" aria-controls="tab-reviews">
        <a href="#tab-reviews">Reviews</a>
      </li>
    </ul>
<?php
/*
=========================
<?php if ($fitment) : ?>
  <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--fitment panel entry-content wc-tab" id="tab-fitment" role="tabpanel" aria-labelledby="tab-title-fitment">
    <p><strong><?php echo $product->get_name() . ' fits ' . count($fitment) . ' models'; ?></strong></p>
    <input type="text" id="fitment-text-filter" placeholder="Start typing your model to filter the list" style="width: 100%; margin-bottom: 1rem; font-size: 0.8em; border-radius: 4px;">
    <ul class="single--part-fitment-list">
    <?php foreach ($sorted_fitment as $key => $fit) {
      echo '<li class="single--part-fitment-item part-fitment-item--', $fit->slug, '">', $fit->description ,'</li>';
    } ?>
    </ul>
  </div>
<?php endif; ?>
=========================
*/
?>
    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--reviews panel entry-content wc-tab" id="tab-reviews" role="tabpanel" aria-labelledby="tab-title-reviews">
      <?php
        if ($comments) :
          echo '<ul class="comments-list">';
          foreach ($comments as $key => $comment) : ?>
            <?php
              $reviewed_date = strtotime($comment->comment_date);
              $reviewed_date = date('F d, Y', $reviewed_date);
              $review_rating = get_comment_meta($comment->comment_ID)['rating'][0];
            ?>
            <li class="comment-item">
              <div class="comment_container">
                <div class="comment-body">
                  <div class="comment-rating">
                    <?php
                      for ($i=0; $i < $review_rating; $i++) { 
                        echo '<img src="' . get_stylesheet_directory_URI() . '/dist/img/star--filled.svg" alt="" class="rating-star">';
                      }
                      for ($i=$review_rating; $i < 5; $i++) { 
                        echo '<img src="' . get_stylesheet_directory_URI() . '/dist/img/star--empty.svg" alt="" class="rating-star">';
                      }
                    ?>
                  </div>
                  <p class="comment-name"><?php echo $comment->comment_author; ?> - <?php echo $reviewed_date; ?></p>
                  <p class="comment-text"><?php echo $comment->comment_content; ?></p>
                </div>
              </div>
            </li>
      <?php
          endforeach;
          echo '</ul>';
        endif;
      ?>
      <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

        <div id="review_form_wrapper">
          <div id="review_form">
            <?php
              $commenter = wp_get_current_commenter();

              global $product;

              $comment_form = array(
                'title_reply'          => '<h3 class="mar-b--less">Rate ' . $product->get_name() . '</h3>',
                'title_reply_to'       => __( 'Leave a Reply to %s', 'woocommerce' ),
                'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
                'title_reply_after'    => '</span>',
                'comment_notes_after'  => '',
                'fields'               => array(
                  'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label> ' .
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
                  'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label> ' .
                        '<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></p>',
                ),
                'label_submit'  => __( 'Submit Your Rating', 'woocommerce' ),
                'logged_in_as'  => '',
                'comment_field' => '',
              );

              if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
                $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'woocommerce' ), esc_url( $account_page_url ) ) . '</p>';
              }

              if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
                $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . '</label><select name="rating" id="rating" required>
                  <option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
                  <option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
                  <option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
                  <option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
                  <option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
                  <option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
                </select></div>';
              }

              $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

              comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
            ?>
          </div>
        </div>

      <?php else : ?>

        <p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

      <?php endif; ?>
    </div>
  </div>
  

<?php //endif; ?>

<?php
/*
=========================
SORT ARRAY BY NESTED KEY
@Link - http://php.net/manual/en/function.sort.php
=========================
*/
function array_sort($array, $on, $order=SORT_ASC) {
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
?>
<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;


// $chach = $wpdb->get_row( "SELECT * FROM $wpdb->postmeta WHERE post_id = 817919 AND meta_key = 'qty_increment'" );
// print_r($last_order_query->meta_value);

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$nla_part = get_post_meta($post->ID, 'nla_part');
?>

<?php
global $product;

	// $args = array(
	// 	'post_type' 		=> 'product',
	// 	'meta_key'			=> 'product_alternatives',
	// 	'meta_value' 		=> $product->get_sku(),
	// 	'meta_compare'	=> 'LIKE'
	// );
	// $query = new WP_Query( $args );
	// if ($query->have_posts()) :
	// 	while($query->have_posts()) : $query->the_post();
	// 	$deere_part = $post->ID;
	// 	$deere_alternatives = get_post_meta($post->ID, 'product_alternatives');
	// 	// print_r($deere_alternatives);
	// 	endwhile;
	// endif; wp_reset_postdata();
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>

	<?php
		// print_r($product);
		// $product = wc_get_product( $post->ID );
		if (wp_get_attachment_url( $product->get_image_id() )) {
			$image = wp_get_attachment_url( $product->get_image_id() );
		} else {
			$image = get_stylesheet_directory_URI() . '/dist/img/partPicComingSoon.jpg';
		}

		if ($product->get_attributes()['pa_brand']) {
			$brand = $product->get_attributes()['pa_brand']->get_terms()[0]->name;
		}
		
		if ( $product->get_review_count() && 'yes' === get_option( 'woocommerce_enable_review_rating' ) ) {
			$aggregate_rating = true;
		}
		
		$review_comments = get_comments( array(
			'post_id' => $post->ID
		) );
	?>


	
	<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			// do_action( 'woocommerce_single_product_summary' );
			// echo '<div class="single-product--content">';
				do_action( 'woocommerce_template_single_title' );
				do_action( 'woocommerce_template_single_rating' );
				

				$part_replacements = get_post_meta($post->ID, 'product_subs');
				if (($part_replacements[0] !== '') && ($nla_part[0] !== 'yes') && ($deere_alternatives[0] === '')) {
					echo '<div class="part--replaced_by mar-t">';
						echo '<p class="mar-b">This part is no longer available. It\'s been replaced by:</p>';
						echo '<ul>';
							foreach ($part_replacements as $part) {
								$replacement_part_id = wc_get_product_id_by_sku($part);
								if ($replacement_part_id) {
									$replacement_part = wc_get_product($replacement_part_id);
									echo '<li class="products--item product-card--slim">';
										echo '<div class="products--image">';
											echo '<a href="' . $replacement_part->get_permalink() . '">';
												if ( has_post_thumbnail() ) :
									        echo '<img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/' . $replacement_part->get_sku() . '-0.jpg" alt="" style="max-width: 65px;">';
												else :
									        echo '<img src="' . wc_placeholder_img_src() . '" alt="Part Photo Coming Soon" style="max-width: 65px;">';
									      endif;
								      echo '</a>';
										echo '</div>';
										echo '<div class="products--content">';
											echo '<a href="' . $replacement_part->get_permalink() . '" style="font-size: 0.85rem;">';
												echo $replacement_part->get_name();
											echo '</a>';
										echo '</div>';
									echo '</li>';
								}
							}
						echo '</ul>';
					echo '</div>';
				} else {
					if ($nla_part[0] === 'yes') {
						echo '<p>Sorry, this part is no longer available.</p>';
					} else {
						do_action( 'woocommerce_template_single_price' );
						do_action( 'woocommerce_template_single_add_to_cart' );
						echo '<div class="box--with-header">';
							echo '<p>We ship all of our genuine John Deere parts, including this ' . $product->get_name() . ', five days per week. We ship primarily via UPS, USPS, FedEx and truck freight. Once your order leaves our warehouse, you will receive a tracking number via email. Most orders ship within 1-3 business days. If you have placed an order on the weekend, during a holiday or after 4pm EST during the week, we will begin processing your order during our next business day.</p>';
						echo '</div>';
						echo '<p class="mar-t"><small>California Use Warning:<br><a href="http://www.P65Warnings.ca.gov" target="_blank" rel="noopener noreferrer">Cancer & Reproductive Harm</a></small></p>';
					}
				}
				
				echo '<div class="product-content">', get_the_content(), '</div>';
				
				do_action( 'woocommerce_output_product_data_tabs' );

				get_template_part('partials/display', 'used-equipment');
				
		?>
	</div>

	<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		// do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php //get_template_part('partials/display', 'alert--add-to-cart'); ?>
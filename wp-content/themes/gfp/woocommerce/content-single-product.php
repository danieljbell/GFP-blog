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
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>
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
				$part_replacements = get_post_meta($post->ID, 'replaced_by');
				$replacement_count = count($part_replacements[0]);
				$replacement_text = 'It\'s been replaced by:';
				if ($replacement_count > 1) {
					$replacement_text = 'It\'s been replaced by these ' .$replacement_count .' parts:';
				}
				if (!$part_replacements) {
					do_action( 'woocommerce_template_single_price' );
					do_action( 'woocommerce_template_single_add_to_cart' );
				} else {
					echo '<div class="part--replaced_by">';
						echo '<p>This part is no longer available. ' . $replacement_text . '</p>';
						echo '<ul>';
							foreach ($part_replacements[0] as $part) {
								$replacement_part = wc_get_product($part);
								echo '<li class="product-card--slim">';
									echo '<a href="' . $replacement_part->get_slug() . '">';
										// echo '<img src="' .  . '">';
										echo $replacement_part->get_image(array(75,75));
										print_r($replacement_part->get_name());
									echo '</a>';
								echo '</li>';
							}
						echo '</ul>';
					echo '</div>';
				}
				echo '<div class="product-content">', get_the_content(), '</div>';
				do_action( 'woocommerce_template_single_excerpt' );
				do_action( 'woocommerce_after_single_product_summary' );
				// do_action( 'woocommerce_output_product_data_tabs' );
				// do_action( 'woocommerce_template_single_meta' );
				// do_action( 'woocommerce_template_single_sharing' );
			// echo '</div>';
			// echo '<div class="single-product--actions">';
			// echo '</div>';
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

<?php get_template_part('partials/display', 'alert--add-to-cart'); ?>
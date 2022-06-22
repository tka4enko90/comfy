<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<main class="main first-section-margin-32px">
	<?php
	/**
	 * woocommerce_before_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action( 'woocommerce_before_main_content' );
	?>
<section class="section product-main-content-section">
	<div class="container">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>
	</div>
</section>
<?php
$benefits_section = get_field( 'benefits' );
if ( ! empty( $benefits_section ) ) {
	$benefits_section['section_name'] = 'benefits';
	?>
	<section class="section benefits-section<?php echo ! empty( $benefits_section['image_position'] ) && 'left' === $benefits_section['image_position'] ? ' image-left' : ''; ?>">
		<?php get_template_part( 'template-parts/blocks/benefits/benefits', '', $benefits_section ); ?>
	</section>
	<?php
}
?>

<?php
$additional_products = get_field( 'additional_products' );
if ( ! empty( $additional_products['items'] ) ) {
	?>
	<section class="section additional-products-section">
		<div class="container">
			<?php
			if ( ! empty( $additional_products['title'] ) ) {
				?>
				<h3 class="section-title">
					<?php echo $additional_products['title']; ?>
				</h3>
				<?php
			}
			?>
			<div class="row">
				<?php
				foreach ( $additional_products['items'] as $item ) {
					if ( ! empty( $item['product'] ) ) {
						$image = wp_get_attachment_image( get_post_thumbnail_id( $item['product'] ), 'cmf_product_preview_small' );
						$link  = get_permalink( $item['product'] );
						?>
						<div class="col">
							<a href="<?php echo ! empty( $link ) ? $link : ''; ?>" class="additional-product-link">
								<?php
								if ( ! empty( $image ) ) {
									?>
									<div class="additional-product-thumb">
										<?php echo $image; ?>
									</div>
									<?php
								}
								?>
								<div class="additional-product-desc">
									<h5 class="additional-product-title">
										<?php
										if ( ! empty( $item['custom_product_title'] ) ) {
											echo $item['custom_product_title'];
										} else {
											echo get_the_title( $item['product'] );
										}
										?>
									</h5>
									<?php
									if ( ! empty( $item['description_items'] ) ) {
										foreach ( $item['description_items'] as $description ) {
											if ( ! empty( $description['label'] ) ) {
												?>
												<p class="label">
													<?php echo $description['label']; ?>
												</p>
												<?php
											}
											if ( ! empty( $description['description'] ) ) {
												?>
												<p class="description">
													<?php echo $description['description']; ?>
												</p>
												<?php
											}
										}
									}
									?>
								</div>
							</a>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
	</section>
	<?php
}
?>

<section class="section instagram-links-section">
<?php
	$instagram_section                 = get_field( 'instagram' );
	$instagram_section['section_name'] = 'instagram-links';
	get_template_part( 'template-parts/blocks/instagram-links/instagram-links', '', $instagram_section );
?>
</section>

<?php wp_enqueue_style( 'comments-archive', get_template_directory_uri() . '/dist/css/pages/comments-archive.css', '', '', 'all' ); ?>
<section class="section comments-archive-section">
	<div class="container container-sm">
		<?php comments_template(); ?>
	</div>
</section>
<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
?>
</main>
<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

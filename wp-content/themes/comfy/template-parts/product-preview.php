<?php
if ( isset( $args ) && isset( $args['product'] ) && isset( $args['product']->ID ) ) {
	setup_postdata( $args['product'] );
	global $product;

	if ( ! isset( $args['thumb'] ) ) {
		$args['thumb'] = 'cmf_product_preview';
	}

	$rating        = $product->get_average_rating();
	$reviews_count = $product->get_review_count();
	$color_counter = cmf_get_variation_colors_count();
	$includes      = get_field( 'includes', $product->get_id() );
	?>
	<article class="product">
		<a href="<?php echo $product->get_permalink(); ?>" class="product-link">
			<div class="product-image-wrap">
				<?php
				if ( isset( $args['show_cats'] ) && true === $args['show_cats'] ) {
					?>
					<div class="product-cats">
						<?php
						if ( true === $args['show_only_chosen_cat'] && ! empty( $args['term_id'] ) ) {
							?>
							<span class="product-cat">
								<?php
								$term = get_term_by( 'id', $args['term_id'], 'product_cat' );
								echo $term->name;
								?>
							</span>
							<?php
						} else {
							$terms = get_the_terms( $args['product']->ID, 'product_cat' );
							if ( is_array( $terms ) && 0 < count( $terms ) ) {
								foreach ( $terms as $term ) {
									?>
									<span class="product-cat">
										<?php echo $term->name; ?>
									</span>
									<?php
								}
							}
						}
						?>
					</div>
					<?php
				}
				echo get_the_post_thumbnail( $args['product']->ID, $args['thumb'] );
				?>
			</div>
			<div class="product-info">
				<h5 class="product-title"><?php echo get_the_title( $args['product'] ); ?></h5>
				<div class="product-price">
					<?php echo $product->get_price_html(); ?>
				</div>
				<div class="product-other-info">
					<?php
					if ( ! empty( $includes ) ) {
						?>
						<p class="product-description">
							<?php echo __( 'Includes', 'comfy' ) . ' ' . $includes; ?>
						</p>
						<?php
					}
					if ( ! empty( $color_counter ) ) {
						?>
						<span class="product-colors"><?php echo $color_counter . __( 'colors', 'comfy' ); ?></span>
						<?php
					}
					?>
					<span class="product-rating"><?php cmf_star_rating( array( 'rating' => $rating ) ); ?></span>
					<span class="product-reviews-count"><?php echo $reviews_count . ' ' . __( 'reviews', 'comfy' ); ?></span>
				</div>

			</div>
		</a>
	</article>
	<?php
}
?>

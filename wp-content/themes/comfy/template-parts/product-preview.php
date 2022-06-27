<?php
//wp_enqueue_style( 'product-preview', get_template_directory_uri() . '/dist/css/partials/product-preview.css', '', '', 'all' );

if ( isset( $args ) && isset( $args['product'] ) && isset( $args['product']->ID ) ) {
	setup_postdata( $args['product'] );
	global $product;

	if ( ! isset( $args['thumb'] ) ) {
		$args['thumb'] = 'full';
	}
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
				?>
				<?php echo get_the_post_thumbnail( $args['product']->ID, $args['thumb'] ); ?>
			</div>
			<div class="product-info">
				<h5 class="product-title"><?php echo get_the_title( $args['product'] ); ?></h5>
				<div class="product-price">
					<?php
					$regular_price = $product->get_regular_price();
					if ( 0.00 !== $regular_price ) {
						$sale = $product->get_price() / $regular_price;
						if ( 1 > $sale ) {
							?>
							<span>
								<?php _e( 'From: ', 'comfy' ); ?>
							</span>
							<?php
						}
					}

					echo preg_replace( '/.00/', '', $product->get_price_html() );
					if ( isset( $sale ) && 1 > $sale ) {
						$sale = round( ( 1 - $sale ) * 100 ) . '%';
						?>
						<span class="sale-persent">
							<?php echo __( 'Save ' ) . ' ' . $sale; ?>
						</span>
						<?php
					}
					?>
				</div>
				<div class="product-other-info">
					<p class="product-description">
						Includes 1 Core Sheet Set, 1 Duvet Cover,
						and 2 extra Pillowcases
					</p>
					<span class="product-colors">12 colors</span>
					<?php
						$rating        = $product->get_average_rating();
						$reviews_count = $product->get_review_count();
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

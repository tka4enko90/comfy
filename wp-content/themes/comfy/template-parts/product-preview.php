<?php
if ( isset( $args ) && isset( $args['product'] ) && isset( $args['product']->ID ) ) {
	setup_postdata( $args['product'] );
	global $product;

	if ( ! isset( $args['thumb'] ) ) {
		$args['thumb'] = 'cmf_product_preview';
	}
	if ( ! empty( $product ) ) {
		?>
		<article class="product">
			<a href="<?php echo $product->get_permalink(); ?>" class="product-link">
				<div class="product-image-wrap">
					<?php
					if ( ! empty( $args['label'] ) ) {
						?>
						<div class="product-labels">
							<?php
							switch ( $args['label'] ) {
								case 'tags':
								case 'tag':
									$terms = wp_get_post_terms( $product->get_id(), 'product_tag' );
									if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
										foreach ( $terms as $term ) {
											?>
											<span class="product-label">
											<?php echo $term->name; ?>
											</span>
											<?php
											if ( 'tag' === $args['label'] ) {
												break 2;
											}
										}
									}
									break;
								case 'cat':
									?>
									<span class="product-label">
									<?php
									$term = get_term_by( 'id', $args['term_id'], 'product_cat' );
									echo $term->name;
									?>
									</span>
									<?php
									break;
								case 'cats':
									$terms = get_the_terms( $args['product']->ID, 'product_cat' );
									if ( is_array( $terms ) && 0 < count( $terms ) ) {
										foreach ( $terms as $term ) {
											?>
											<span class="product-label">
											<?php echo $term->name; ?>
											</span>
											<?php
										}
									}
									break;
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
					<div class="product-other-info">
						<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
					</div>
				</div>
			</a>
		</article>
		<?php
	}
}
?>

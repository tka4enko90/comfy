<?php
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
							foreach ( $terms as $term ) {
								?>
								<span class="product-cat">
									<?php echo $term->name; ?>
								</span>
								<?php
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
				<h5 class="product-title"><?php echo $args['product']->post_title; ?></h5>
				<div class="product-price">
					<?php
					$sale = $product->get_price() / $product->get_regular_price();
					echo ( 1 !== $sale ) ? '<span>' . __( 'From: ', 'comfy' ) . '</span>' : '';
					echo preg_replace( '/.00/', '', $product->get_price_html() );
					if ( 1 !== $sale ) {
						$sale = strval( 1 - $sale );
						$sale = $sale[2] . $sale[3] . '%';
						?>
						<span class="sale-persent">
							<?php echo __( 'Save ' ) . ' ' . $sale; ?>
						</span>
						<?php
					}

					?>
				</div>
				<?php $average = $product->get_average_rating(); ?>
				<?php if ( $average ) { ?>
					<?php echo '<div class="star-rating" title="' . sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $average ) . '"><span style="width:' . ( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . __( 'out of 5', 'woocommerce' ) . '</span></div>'; ?>
				<?php } ?>
			</div>
		</a>
	</article>
	<?php
}
?>

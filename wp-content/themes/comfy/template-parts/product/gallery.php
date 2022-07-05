<?php
if ( isset( $args['image_ids'] ) ) {
	?>
	<figure class="woocommerce-product-gallery-nav">
		<?php
		foreach ( $args['image_ids'] as $id ) {
			?>
			<div data-item="<?php echo $id; ?>" class="gallery-nav-item gallery-nav-item-<?php echo $id; ?>">
				<?php echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $id, false ), $id ); ?>
			</div>
			<?php
		}
		?>
	</figure>
	<figure class="woocommerce-product-gallery-items">
		<?php
		foreach ( $args['image_ids'] as $id ) {
			?>
			<div data-item="<?php echo $id; ?>" class="gallery-item gallery-item-<?php echo $id; ?>">
				<?php echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $id, true ), $id ); ?>
			</div>
			<?php
		}
		?>
	</figure>
	<?php
}

<?php
if ( class_exists( 'WC_Additional_Variation_Images_Frontend' ) ) {
	add_action(
		'wc_ajax_wc_additional_variation_images_get_images',
		function () {
			check_ajax_referer( '_wc_additional_variation_images_nonce', 'security' );

			if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
				wp_send_json_error();
			}

			$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
			$variation    = $variation_id ? wc_get_product( $variation_id ) : false;
			setup_postdata( $variation->get_parent_id() );

			if ( ! $variation ) {
				wp_send_json_error();
			}

			$image_ids            = array_filter( explode( ',', get_post_meta( $variation_id, '_wc_additional_variation_images', true ) ) );
			$variation_main_image = $variation->get_image_id();

			if ( ! empty( $variation_main_image ) ) {
				array_unshift( $image_ids, $variation_main_image );
			}

			if ( empty( $image_ids ) ) {
				wp_send_json_error();
			}

			ob_start();
			?>
			<div class="woocommerce-product-gallery woocommerce-product-gallery--wcavi woocommerce-product-gallery--variation-<?php echo absint( $variation_id ); ?> woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-<?php echo esc_attr( apply_filters( 'woocommerce_product_thumbnails_columns', 4 ) ); ?> images" data-columns="<?php echo esc_attr( apply_filters( 'woocommerce_product_thumbnails_columns', 4 ) ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
				<?php
				get_template_part(
					'template-parts/product/gallery',
					'',
					array(
						'image_ids' => $image_ids,
						'tags'      => cmf_get_the_product_tags(),
					)
				);
				?>
			</div>
			<?php
			wp_send_json(
				array(
					'main_images'  => ob_get_clean(),
					'variation_id' => $variation_id,
				)
			);
		},
		0
	);
}


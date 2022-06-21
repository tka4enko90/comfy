<?php
remove_action( 'wc_ajax_wc_additional_variation_images_get_images', array( 'WC_Additional_Variation_Images_Frontend', 'ajax_get_images' ) );
add_action(
	'wc_ajax_wc_additional_variation_images_get_images',
	function () {
		check_ajax_referer( '_wc_additional_variation_images_nonce', 'security' );

		if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
			wp_send_json_error();
		}

		$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
		$variation    = $variation_id ? wc_get_product( $variation_id ) : false;

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

		$gallery_html  = '<div class="woocommerce-product-gallery woocommerce-product-gallery--wcavi woocommerce-product-gallery--variation-' . absint( $variation_id ) . ' woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-' . esc_attr( apply_filters( 'woocommerce_product_thumbnails_columns', 4 ) ) . ' images" data-columns="' . esc_attr( apply_filters( 'woocommerce_product_thumbnails_columns', 4 ) ) . '" style="opacity: 0; transition: opacity .25s ease-in-out;">';
		$gallery_nav   = '<figure class="woocommerce-product-gallery-nav">';
		$gallery_items = '<figure class="woocommerce-product-gallery-items">';

		foreach ( $image_ids as $id ) {
			$gallery_nav .= '<div data-item="' . $id . '" class="gallery-nav-item">';
			$gallery_nav .= apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $id, false ), $id );
			$gallery_nav .= '</div>';

			$gallery_items .= '<div class="gallery-item gallery-item-' . $id . '">';
			$gallery_items .= apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $id, true ), $id );
			$gallery_items .= '</div>';
		}

		$gallery_items .= '</figure>';
		$gallery_nav   .= '</figure>';

		$gallery_html .= $gallery_nav . $gallery_items;
		$gallery_html .= '</div>';

		wp_send_json( array( 'main_images' => $gallery_html ) );
	},
	0
);

<?php

/*

if ( $product->is_type( 'bundle' ) ) {

}*/
add_action(
	'woocommerce_single_product_summary',
	function () {
		global $product;
		if ( $product->is_type( 'bundle' ) ) {
			cmf_product_includes();
			?>
			<button class="button button-primary bundle-step-button"><?php _e( 'Start building', 'comfy' ); ?></button>
			<?php
			cmf_product_in_stock();
		}
	},
	10
);

add_action(
	'woocommerce_bundled_single_variation',
	function() {
		?>
		<div class="bundle-steps-btns">
			<button class="button button-secondary bundle-step-button prev-step-bundle"><?php _e( 'Previous', 'comfy' ); ?></button>
			<button class="button button-primary bundle-step-button"><?php _e( 'Next', 'comfy' ); ?></button>
		</div>
		<?php
	}
);


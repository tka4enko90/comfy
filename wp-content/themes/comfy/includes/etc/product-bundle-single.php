<?php
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

add_action( 'woocommerce_bundled_item_details', 'cmf_bundle_step_text', 12, 2 );
add_action(
	'woocommerce_bundled_item_details',
	function ( $bundled_item, $product ) {

		?>
	<div class="mobile-info">
		<?php cmf_bundle_step_text( $bundled_item, $product ); ?>
		<h1><?php echo $bundled_item->get_title(); ?></h1>
	</div>
		<?php
	},
	2,
	2
);

function cmf_bundle_step_text( $bundled_item, $product ) {
	$bundled_items    = $product->get_bundled_items();
	$bundle_steps_num = count( $bundled_items );
	$step_counter     = $bundled_item->get_id();
	?>
	<p class="bundle-step-description"><?php echo __( 'Step', 'comfy' ) . ' ' . $step_counter . ' ' . __( 'of', 'comfy' ) . ' ' . $bundle_steps_num; ?></p>
	<?php
}

//Remove bundle product single price
remove_action( 'woocommerce_bundled_single_variation', 'wc_pb_template_single_variation', 10 );


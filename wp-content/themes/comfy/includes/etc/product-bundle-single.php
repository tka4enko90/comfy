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
	'woocommerce_bundled_item_details',
	function() {
		?>
		<div class="bundle-steps-btns">
			<button class="button button-secondary bundle-step-button prev-step-bundle"><?php _e( 'Previous', 'comfy' ); ?></button>
			<button class="button button-primary bundle-step-button"><?php _e( 'Next', 'comfy' ); ?></button>
		</div>
		<?php
	},
	25
);

add_action( 'woocommerce_bundled_item_details', 'cmf_bundle_step_text', 12, 2 );
add_action(
	'woocommerce_bundled_item_details',
	function ( $bundled_item, $product ) {

		?>
	<div class="mobile-info">
		<?php cmf_bundle_step_text( $bundled_item, $product ); ?>
		<h1 class="bundle-step-title"><?php echo $bundled_item->get_title(); ?></h1>
	</div>
		<?php
	},
	2,
	2
);

function cmf_bundle_step_text( $bundled_item, $product ) {
	$bundled_items   = $product->get_bundled_items();
	$current_item_id = $bundled_item->get_product_id();
	$step_counter    = 0;
	foreach ( $bundled_items as $item ) {
		++$step_counter;
		if ( $current_item_id === $item->get_product_id() ) {
			break;
		}
	}
	$bundle_steps_num = count( $bundled_items );
	?>
	<p class="bundle-step-description"><?php echo __( 'Step', 'comfy' ) . ' ' . $step_counter . ' ' . __( 'of', 'comfy' ) . ' ' . $bundle_steps_num; ?></p>
	<?php
}

//Remove bundle product single price
remove_action( 'woocommerce_bundled_single_variation', 'wc_pb_template_single_variation', 10 );


//custom_wc_ajax_variation_threshold
add_filter(
	'woocommerce_ajax_variation_threshold',
	function ( $qty ) {
		return 200;
	},
	10,
	1
);

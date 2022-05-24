<?php
foreach ( $args as $product ) {
	$product_args = array(
		'product' => $product, // Important
		'thumb'   => 'cmf_search_result', // optional
	);
	get_template_part( 'template-parts/product-preview', '', $product_args );
}

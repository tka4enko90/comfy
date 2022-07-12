<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$section = array(
	'title'    => get_sub_field( 'title' ),
	'subtitle' => get_sub_field( 'subtitle' ),
	'products' => get_sub_field( 'products' ),
);
?>
<div class="container container-sm">
	<?php
	if ( ! empty( $section['title'] ) ) {
		?>
		<h2 class="section-title">
			<?php echo $section['title']; ?>
		</h2>
		<?php
	}
	if ( ! empty( $section['subtitle'] ) ) {
		?>
		<p class="section-subtitle">
			<?php echo $section['subtitle']; ?>
		</p>
		<?php
	}
	if ( ! empty( $section['products'] ) ) {
		?>
		<div class="row">
			<?php
			$product_args = array(
				'thumb'            => 'cmf_post_preview', // optional
				'show_stars'       => true,
				'show_reviews_num' => true,
			);
			foreach ( $section['products'] as $item ) {
				if ( ! empty( $item['product'] ) && $item['product'] instanceof WP_Post ) {
					$product_args['product'] = $item['product'];
					?>
					<div class="col">
						<?php get_template_part( 'template-parts/product-preview', '', $product_args ); ?>
					</div>
					<?php
				}
			}
			?>
		</div>
		<?php
	}
	?>
</div>

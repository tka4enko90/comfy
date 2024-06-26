<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$section = array(
	'title'        => get_sub_field( 'title' ),
	'call'         => get_sub_field( 'call' ),
	'email'        => get_sub_field( 'email' ),
	'address'      => get_sub_field( 'address' ),

	'maps_api_key' => get_field( 'google_map_key', 'options' ),
	'map_settings' => get_sub_field( 'map' ),
);

if ( ! empty( $section['maps_api_key'] ) ) {
	wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $section['maps_api_key'], '', '', false );
	wp_enqueue_script( 'cmf-map', get_template_directory_uri() . '/template-parts/blocks/contact-map/contact-map.js', array( 'google-maps', 'jquery' ), '', false );
	wp_localize_script( 'cmf-map', 'cmfMap', $section['map_settings'] );
}
if ( ! empty( $section['title'] ) ) {
	?>
	<div class="container container-sm">
		<h1 class="contact-map-section-title">
			<?php echo $section['title']; ?>
		</h1>
	</div>
	<?php
}
?>
<div class="container container-lg">
	<div class="section-wrap">
		<?php
		if ( ! empty( $section['maps_api_key'] ) && ! empty( $section['map_settings']['coordinates']['lat'] ) && ! empty( $section['map_settings']['coordinates']['lng'] ) && isset( $section['map_settings']['zoom'] ) ) {
			?>
			<div id="map"></div>
			<?php
		}
		?>
		<div class="row">
			<?php
			if ( ! empty( $section['call'] ) ) {
				?>
				<div class="col">
					<h4><?php echo __( 'Call', 'comfy' ); ?></h4>
					<?php echo $section['call']; ?>
				</div>
				<?php
			}
			?>
			<?php
			if ( ! empty( $section['email'] ) ) {
				?>
				<div class="col">
					<h4><?php echo __( 'Email', 'comfy' ); ?></h4>
					<?php echo $section['email']; ?>
				</div>
				<?php
			}
			?>
			<?php
			if ( ! empty( $section['address'] ) ) {
				?>
				<div class="col">
					<h4><?php echo __( 'Address', 'comfy' ); ?></h4>
					<?php echo $section['address']; ?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
<?php

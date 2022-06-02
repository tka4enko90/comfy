<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );

}
$section = array(
	'call'         => get_sub_field( 'call' ),
	'email'        => get_sub_field( 'email' ),
	'address'      => get_sub_field( 'address' ),

	'maps_api_key' => get_field( 'google_map_key', 'options' ),
	'map_settings' => get_sub_field( 'map' ),
);

if ( ! empty( $section['maps_api_key'] ) ) {
	wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $section['maps_api_key'], '', '', false );
	wp_enqueue_script( 'cmf-map', get_template_directory_uri() . '/template-parts/blocks/contact-map/contact-map.js', array( 'google-maps', 'jquery' ), '', false );

}
?>
<script type="text/javascript" id="cmf-map-js-extra">
	window.cmfMap = {
		"zoom":<?php echo ! empty( $section['map_settings']['zoom'] ) ? $section['map_settings']['zoom'] : 10; ?>,
		"coordinates":{
			"lat":<?php echo ! empty( $section['map_settings']['coordinates']['lat'] ) ? $section['map_settings']['coordinates']['lat'] : 0; ?>,
			"lng":<?php echo ! empty( $section['map_settings']['coordinates']['lng'] ) ? $section['map_settings']['coordinates']['lng'] : 0; ?>
		}
	};
</script>
<div class="container container-lg">
	<div class="section-wrap">
		<div id="map"></div>
		<div class="row">
			<?php
			if ( ! empty( $section['call'] ) ) {
				?>
				<div class="col">
					<h4><?php echo __( 'Call', 'comfy' ); ?></h4>
					<p>
						<?php echo $section['call']; ?>
					</p>
				</div>
				<?php
			}
			?>
			<?php
			if ( ! empty( $section['email'] ) ) {
				?>
				<div class="col">
					<h4><?php echo __( 'Email', 'comfy' ); ?></h4>
					<p>
						<?php echo $section['email']; ?>
					</p>
				</div>
				<?php
			}
			?>
			<?php
			if ( ! empty( $section['address'] ) ) {
				?>
				<div class="col">
					<h4><?php echo __( 'Address', 'comfy' ); ?></h4>
					<p>
						<?php echo $section['address']; ?>
					</p>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
<?php

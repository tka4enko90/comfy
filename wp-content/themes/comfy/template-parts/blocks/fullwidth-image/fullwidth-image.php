<?php $section = array(
	'image_id' => get_sub_field( 'image' ),
); ?>
<div class="container">
	<div class="row">
		<div class="col">
			<?php echo  wp_get_attachment_image( $section['image_id'], 'cmf_fullwidth' ); ?>
		</div>
	</div>
</div>

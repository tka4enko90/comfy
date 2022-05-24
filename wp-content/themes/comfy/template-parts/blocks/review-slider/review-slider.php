<?php
wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/dist/css/partials/slick.css', '', '', 'all' );

wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/dist/js/partials/slick.js', array( 'jquery' ), '', true );
wp_enqueue_script( 'review-slider', get_template_directory_uri() . '/template-parts/blocks/review-slider/review-slider.js', array( 'jquery', 'slick-js' ), '', true );
$section = array(
	'slides' => get_sub_field( 'slides' ),
);

if ( is_array( $section['slides'] ) && 0 < count( $section['slides'] ) ) {
	?>
	<div class="container container-medium">
		<div class="row">
			<div class="col-100">
				<div class="review-slider">
					<?php foreach ( $section['slides'] as $slide ) { ?>
						<div class="review-slider-slide">
							<div class="review-slider-slide-wrap">
								<div class="review-slider-slide-content-wrap">
									<div class="review-slider-slide-content">
										<?php
										if ( ! empty( $slide['stars'] ) ) {
											cmf_star_rating( array( 'rating' => $slide['stars'] ) );
										}
										if ( ! empty( $slide['text'] ) ) {
											?>
											<h2 class="review-title">
												<?php echo $slide['text']; ?>
											</h2>
											<?php
										}
										if ( ! empty( $slide['name'] ) ) {
											?>
											<p class="review-name">
												<?php echo $slide['name']; ?>
											</p>
											<?php
										}
										?>
									</div>
								</div>
								<div class="review-slider-slide-image">
									<?php
									if ( ! empty( $slide['image_id'] ) ) {
										echo wp_get_attachment_image( $slide['image_id'], 'cmf_review_slider' );
									}
									?>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

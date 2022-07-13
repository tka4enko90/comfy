<?php
function cmf_get_steps_ahead_counter( $items ) {
	$deep_counters = array();

	foreach ( $items as $item ) {
		$c = 0;
		while ( ! empty( $item['items'] ) ) {
			$item = $item['items'][0];
			$c++;
		}
		$deep_counters[] = $c;
	}

	return max( $deep_counters );
}
function get_step_unique_number() {
	static $a = 0;
	return $a++;
}

function cmf_quiz_choice( $args ) {
	?>
	<section class="quiz-choice" <?php echo ! empty( $args['id'] ) ? 'id="' . $args['id'] . '"' : ''; ?>>
		<div class="container">
			<div>
				<a href="<?php the_permalink(); ?>" class="quiz-link-restart">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_2740_1435)">
							<path d="M14 1.19922L17.2 4.39922L14 7.59922" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2.79688 9.19844V7.59844C2.79688 6.74974 3.13402 5.93581 3.73413 5.3357C4.33425 4.73558 5.14818 4.39844 5.99687 4.39844H17.1969" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M5.99687 18.8004L2.79688 15.6004L5.99687 12.4004" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M17.1969 10.8008V12.4008C17.1969 13.2495 16.8597 14.0634 16.2596 14.6635C15.6595 15.2636 14.8456 15.6008 13.9969 15.6008H2.79688" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/>
						</g>
						<defs>
							<clipPath id="clip0_2740_1435">
								<rect width="19.2" height="19.2" fill="white" transform="translate(0.398438 0.400391)"/>
							</clipPath>
						</defs>
					</svg>
					<?php _e( 'Retake quiz', 'comfy' ); ?>
				</a>
			</div>
			<?php
			if ( ! empty( $args['product_id'] ) ) {
				setup_postdata( $args['product_id'] );
				global $product;
				$rating        = $product->get_average_rating();
				$reviews_count = $product->get_review_count();
				$color_counter = cmf_get_variation_colors_count();
				$includes      = get_field( 'includes', $product->get_id() );
				?>
				<div class="quiz-choice-product">
					<div class="row">
						<div class="col">
							<?php echo wp_get_attachment_image( get_post_thumbnail_id( $args['product_id'] ), 'cmf_review_slider' ); ?>
						</div>
						<div class="col">
							<h2 class="quiz-choice-product-title">
								<span><?php _e( 'Your Match is:', 'comfy' ); ?></span>
								<?php echo $product->get_title(); ?>
							</h2>
							<p class="quiz-choice-product-price">
								<?php echo $product->get_price_html(); ?>
							</p>
							<?php
							if ( ! empty( $includes ) ) {
								?>
								<p class="quiz-choice-product-includes">
									<?php echo __( 'Includes ', 'comfy' ) . $includes; ?>
								</p>
								<?php
							}
							?>
							<div class="quiz-choice-product-info">
								<?php
								if ( ! empty( $color_counter ) ) {
									?>
									<span class="quiz-choice-product-colors"><?php echo $color_counter . ' ' . __( 'colors', 'comfy' ); ?></span>
									<?php
								}
								?>
								<span class="quiz-choice-product-rating"><?php cmf_star_rating( array( 'rating' => $rating ) ); ?></span>
								<span class="quiz-choice-product-reviews-count"><?php echo $reviews_count . ' ' . __( 'reviews', 'comfy' ); ?></span>
							</div>

							<div class="quiz-choice-product-description">
								<?php echo str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $product->get_description() ) ); ?>
							</div>
							<a href="<?php echo $product->get_permalink(); ?>" class="button button-secondary quiz-choice-product-button">
								<?php _e( 'shop now ', 'comfy' ); ?>
							</a>
							<?php
							if ( $product->is_in_stock() ) {
								?>
								<p class="quiz-choice-product-in-stock">
									<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M2 6.5L4.66667 9L10 4" stroke="#C17817" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									<?php _e( 'In Stock & Ready to Ship', 'comfy' ); ?>
								</p>
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<?php

			}
			?>
		</div>
		<div class="quiz-choice-collection">
			<?php woocommerce_upsell_display( 3 ); ?>
		</div>
		<?php
		if ( ! empty( $args['collections'] ) ) {
			?>
			<div class="quiz-choice-other-collection">
				<div class="container">
					<h3 class="quiz-choice-other-collection-title">
						<?php _e( 'Check Other Collections', 'comfy' ); ?>
					</h3>
					<div class="row">
						<?php
						foreach ( $args['collections'] as $collection ) {
							?>
							<div class="col">
								<?php
								echo ! empty( $collection['image_id'] ) ? wp_get_attachment_image( $collection['image_id'], 'cmf_content_with_image_1' ) : '';
								print_r( $collection['content'] );
								if ( ! empty( $collection['content']['title'] ) ) {
									?>
									<h5>
										<?php echo $collection['content']['title']; ?>
									</h5>
									<?php
								}
								if ( ! empty( $collection['content']['title'] ) ) {
									?>
									<p>
										<?php echo $collection['content']['title']; ?>
									</p>
									<?php
								}


								if ( ! empty( $collection['content']['link'] ) ) {
									$button = $collection['content']['link'];
									if ( ! empty( $button['url'] ) && ! empty( $button['title'] ) ) {
										?>

											<a class="button button-secondary"
											   href="<?php echo $button['url']; ?>"
												<?php echo ! empty( $button['target'] ) ? 'target="' . $button['target'] . '"' : ''; ?>>
												<?php echo $button['title']; ?>
											</a>

										<?php
									}
								}
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
		?>

	</section>
	<?php
}

function cmf_quiz_step( $args ) {
	$deep        = ! empty( $args['deep'] ) ? $args['deep'] : 0;
	$steps_ahead = cmf_get_steps_ahead_counter( $args['items'] );
	?>
	<section class="quiz-step" <?php echo ! empty( $args['id'] ) ? 'id="' . $args['id'] . '"' : ''; ?> data-step="<?php echo $deep; ?>" data-steps-ahead="<?php echo $steps_ahead; ?>">
		<div class="container container-xs">
			<div class="quiz-header">
				<p class="quiz-progress">
					<?php _e( 'Quiz Progress', 'comfy' ); ?>
				</p>
				<div class="quiz-progress-bar">
					<span class="quiz-progress-bar-fill"></span>
				</div>
				<?php
				if ( ! empty( $args['question'] ) ) {
					?>
					<h2 class="quiz-title">
						<?php echo $args['question']; ?>
					</h2>
					<?php
				}
				if ( ! empty( $args['back_url'] ) ) {
					?>
					<a href="<?php echo $args['back_url']; ?>" class="quiz-link quiz-link-back ">
						<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M18.9906 9.00195H1.89062" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M8.71762 17.002L0.992188 9.00195L8.71762 1.00195" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<?php _e( 'Back', 'comfy' ); ?>
					</a>
					<?php
				}
				?>
			</div>
			<?php
			if ( ! empty( $args['items'] ) ) {
				?>
				<div class="row">
					<?php

					foreach ( $args['items'] as $quiz_item ) {
						$step_id = 'quiz-step-' . $deep . '-' . get_step_unique_number() . '-' . preg_replace( '/[^A-Za-z0-9\-]/', '', str_replace( ' ', '-', strtolower( $quiz_item['title'] ) ) );
						?>
						<div class="col">
							<a href="<?php echo '#' . $step_id; ?>" class="quiz-link quiz-item">
								<?php
								echo ! empty( $quiz_item['image_id'] ) ? wp_get_attachment_image( $quiz_item['image_id'], 'cmf_quiz' ) : '';

								if ( ! empty( $quiz_item['title'] ) ) {
									?>
									<p class="quiz-item-title">
										<?php echo $quiz_item['title']; ?>
									</p>
									<?php
								}

								switch ( $args['answer_type'] ) {
									case 'product':
										if ( ! empty( $quiz_item['product'] ) ) {
											$step_args = array(
												'id' => $step_id,
												'product_id' => $quiz_item['product'],
												'collections' => $quiz_item['collections'],
											);

											add_action(
												'quiz_steps',
												function () use ( $step_args ) {
													cmf_quiz_choice( $step_args );
												},
												$deep
											);
										}
										break;
									default:
										if ( ! empty( $quiz_item['items'] ) ) {
											$step_args = array(
												'question' => ! empty( $quiz_item['question'] ) ? $quiz_item['question'] : '',
												'items'    => $quiz_item['items'],
												'id'       => $step_id,
												'deep'     => 1 + $deep,
												'back_url' => ( ! empty( $args['id'] ) ) ? '#' . $args['id'] : '',
												'answer_type' => ! empty( $quiz_item['answer_type'] ) ? $quiz_item['answer_type'] : 'qoestion',
											);

											add_action(
												'quiz_steps',
												function () use ( $step_args ) {
													cmf_quiz_step( $step_args );
												},
												$deep
											);
										}
								}

								?>
							</a>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
	</section>
	<?php
}

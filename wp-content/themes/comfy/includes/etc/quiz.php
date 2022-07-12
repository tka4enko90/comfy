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

function cmf_quiz_choice( $args ) {
	?>
	<section class="quiz-step quiz-choice" <?php echo ! empty( $args['id'] ) ? 'id="' . $args['id'] . '"' : ''; ?>>
		<div class="container container-xs">
			<?php
			print_r( $args );
			if ( ! empty( $args['product_id'] ) ) {
				$product = wc_get_product( $args['product_id'] );
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
							<?php echo $product->get_price_html(); ?>
						</div>
					</div>
				</div>
				<?php
				print_r( $product );
			}
			?>
		</div>
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
						$step_id = 'quiz-step-' . $deep . '-' . preg_replace( '/[^A-Za-z0-9\-]/', '', str_replace( ' ', '-', strtolower( $quiz_item['title'] ) ) );
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

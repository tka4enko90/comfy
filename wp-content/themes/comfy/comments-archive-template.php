<?php /* Template Name: Comments Archive Page */
wp_enqueue_style( 'comments-archive', get_template_directory_uri() . '/dist/css/pages/comments-archive.css', '', '', 'all' );
get_header();
?>
<main class="main">
	<?php $chosen_comment = get_field( 'chosen_comment' ); ?>
	<section class="section first-comment-section">
		<div class="container">
			<div class="row">
				<?php
				if ( ! empty( $chosen_comment['image_id'] ) ) {
					?>
					<div class="col">
						<?php echo wp_get_attachment_image( $chosen_comment['image_id'], 'cmf_reviews_archive' ); ?>
					</div>
					<?php
				}
				?>
				<div class="col">
					<?php
					if ( ! empty( $chosen_comment['comment_title'] ) ) {
						?>
						<h2 class="section-title"><?php echo '"' . $chosen_comment['comment_title'] . '"'; ?></h2>
						<?php
					}
					if ( ! empty( $chosen_comment['rating'] ) ) {
						cmf_star_rating(
							array(
								'rating'        => $chosen_comment['rating'],
								'rounded_stars' => false,
							)
						);
					}
					if ( ! empty( $chosen_comment['author_name'] ) ) {
						?>
						<p class="author-name">
							<?php echo $chosen_comment['author_name']; ?>
						</p>
						<?php
					}

					?>
				</div>
			</div>
		</div>
	</section>
	<section class="section comments-archive-section">
		<?php echo apply_filters( 'cmf_review_widget', do_shortcode( '[jgm-all-reviews]' ) ); ?>
	</section>
</main>
<?php wp_list_comments(); ?>
<?php
get_footer();


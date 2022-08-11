<?php /* Template Name: Coming Soon */
wp_enqueue_style( 'coming-soon', get_template_directory_uri() . '/dist/css/pages/coming-soon.css', '', '', 'all' );

$page = array(
	'image_id' => get_post_thumbnail_id(),
	'content'  => get_field( 'content' ),
);

get_header();
?>
<main class="main">
	<section class="section coming-soon-section">
		<div class="container container-lg">
			<div class="row">
				<div class="col">
					<?php echo ! empty( $page['image_id'] ) ? wp_get_attachment_image( $page['image_id'], 'cmf_coming_soon' ) : ''; ?>
				</div>
				<div class="col">
					<div class="section-content-wrap">
						<?php echo ! empty( $page['content'] ) ? str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $page['content'] ) ) : ''; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();

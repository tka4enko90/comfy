<?php
/**
 * @package WordPress
 * @subpackage comfy
 */

wp_enqueue_style( 'post-single', get_template_directory_uri() . '/dist/css/pages/post-single.css', '', '', 'all' );

get_header();
$post_fields = array(
	'subtitle' => get_field( 'post_subtitle' ),
);
$author      = array(
	'name' => get_the_author_meta( 'display_name', $post->post_author ),
	'info' => get_the_author_meta( 'description', $post->post_author ),
);
?>

<main class="main first-section-margin-52px">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
	<article class="post">
		<div class="container container-xs">
			<div class="row">
				<div class="col col-100">
					<div class="post-heading">
						<?php get_template_part( 'template-parts/post', 'cats' ); ?>
						<h1 class="post-title"><?php the_title(); ?></h1>
						<?php
						if ( ! empty( $post_fields['subtitle'] ) ) {
							?>
							<p class="post-subtitle">
								<?php echo $post_fields['subtitle']; ?>
							</p>
							<?php
						}
						?>
						<time datetime="<?php echo get_the_date( 'c' ); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
					</div>
				</div>
			</div>
		</div>
		<div class="container container-lg">
			<div class="row">
				<?php the_post_thumbnail( 'cmf_post_single' ); ?>
			</div>
		</div>
		<div class="container container-xs">
			<div class="row">
				<div class="col-100">
					<div class="post-content">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="col-100">
					<figure class="post-author">
						<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
						<figcaption class="post-author-info">
							<?php
							if ( ! empty( $author['name'] ) ) {
								?>
								<h5 class="post-author-name"><?php echo $author['name']; ?></h5>
								<?php
							}
							if ( ! empty( $author['info'] ) ) {
								?>
								<p><?php echo $author['info']; ?></p>
								<?php
							}
							?>
						</figcaption>
					</figure>
				</div>
			</div>
		</div>
	</article>
		<?php
		$orig_post = $post;
		global $post;
		$tags = wp_get_post_tags( $post->ID );

		if ( ! empty( $tags ) ) {
			?>
			<section class="related-posts">
				<div class="container">
					<div class="row">
						<div class="col-100">
							<h3 class="related-posts-title"><?php _e( 'Related posts', 'comfy' ); ?></h3>
						</div>

						<?php
						$tag_ids = array();
						foreach ( $tags as $individual_tag ) {
							$tag_ids[] = $individual_tag->term_id;
						}
						$args = array(
							'tag__in'             => $tag_ids,
							'post__not_in'        => array( $post->ID ),
							'posts_per_page'      => 2, // Number of related posts to display.
							'ignore_sticky_posts' => 1,
						);

						$my_query = new wp_query( $args );

						while ( $my_query->have_posts() ) {
							$my_query->the_post();
							?>
							<div class="col-100 col-sm-50">
								<article class="post">
									<?php the_post_thumbnail( 'cmf_review_slider' ); ?>
									<?php get_template_part( 'template-parts/post', 'cats' ); ?>
									<h4><?php the_title(); ?></h4>
									<a class="button button-secondary" href="<?php the_permalink(); ?>">
										<?php echo __( 'Read more', 'comfy' ); ?>
									</a>
								</article>
							</div>
							<?php
						}
						$post = $orig_post;
						wp_reset_query();
						?>
					</div>
				</div>
			</section>
			<?php
		}
		?>
	<?php endwhile; ?>
</main>
<?php
get_footer();

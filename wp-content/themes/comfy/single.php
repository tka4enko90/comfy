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
		<div class="container container-large">
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
	<?php endwhile; ?>
</main>
<?php
get_footer();

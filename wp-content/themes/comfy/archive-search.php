<?php
/* Template Name: Custom Search */
get_header(); ?>
	<section class="archive-section">
		<div class="container">
			<div class="row justify-content-center">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
					<div class="col-100">
						<article>
							<?php echo get_the_post_thumbnail(); ?>
							<div>
								<h2 class="faq-item-title"><?php the_title(); ?></h2>
								<span class="faq-item-icon"></span>
							</div>
							<div class="story">
								<?php the_content(); ?>
							</div>
						</article>
					</div>
				<?php endwhile; else : ?>
					<div class="col 12">
						<?php get_template_part( 'partials/notfound' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

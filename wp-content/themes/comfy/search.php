<?php
/**
 * @package WordPress
 * @subpackage comfy
 */

get_header();
if ( ! empty( $_GET['s'] ) ) :
	$query = new WP_Query(
		array(
			'posts_per_page' => -1,
			's'              => sanitize_text_field( $_GET['s'] ),
		)
	); ?>

		<section class="section">
			<div class="container">
				<div class="row">
					<?php
					if ( $query->posts ) :
						foreach ( $query->posts as $post ) :
							$item['product'] = $post
							?>

							<div class="col">
								<?php echo  get_template_part( 'template-parts/product-preview', '', $item ); ?>
							</div>
							<?php
						endforeach;
					endif;
					?>
				</div>
			</div>
		</section>

	<?php
	wp_reset_query();
endif;
get_footer();

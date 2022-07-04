<?php /* Template Name: Comments Archive Page */
wp_enqueue_style( 'comments-archive', get_template_directory_uri() . '/dist/css/pages/comments-archive.css', '', '', 'all' );

$template = array(
	'comments_per_page' => get_field( 'comments_per_page' ),
);

$paged          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$offset         = $paged > 1 ? $template['comments_per_page'] * $paged : 0;
$comments_query = array(
	'number' => $template['comments_per_page'] * 5,
	'offset' => $offset,
	'paged'  => $paged,
);

// Select all comment types and filter out spam later for better query performance.
$comments = array();

get_header();
?>
<main class="main">
	<section class="comments-archive-section">
		<div class="container">
			<?php echo apply_filters( 'cmf_review_widget', do_shortcode( '[jgm-all-reviews]' ) ); ?>
		</div>
	</section>
</main>
<?php wp_list_comments(); ?>
<?php
get_footer();


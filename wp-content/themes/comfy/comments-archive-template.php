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
			<?php
			while ( count( $comments ) < $template['comments_per_page'] && $possible = get_comments( $comments_query ) ) {
				if ( ! is_array( $possible ) ) {
					break;
				}
				foreach ( $possible as $comment ) {
					$comments[] = $comment;

					if ( count( $comments ) === $template['comments_per_page'] ) {
						break 2;
					}
				}
			}
			if ( $comments ) {
				foreach ( $comments as $comment ) {
					$comment_id     = $comment->comment_ID;
					$title          = get_comment_meta( $comment_id, 'title', true );
					$text           = get_comment_text( $comment_id );
					$date           = get_comment_date( 'd/m/o', $comment_id );
					$rating         = get_comment_meta( $comment_id, 'rating', true );
					$commented_post = array(
						'title' => get_the_title( $comment->comment_post_ID ),
						'url'   => get_permalink( $comment->comment_post_ID ),
					);
					?>
					<div class="comment">
						<div class="comment-details">
							<?php
							if ( $rating > 0 ) {
								cmf_star_rating(
									array(
										'rating'        => $rating,
										'rounded_stars' => false,
									)
								);
							}
							?>
							<span class="comment-author">
							<?php echo $comment->comment_author; ?>
						</span>
							<time datetime="<?php echo $date; ?>"><?php echo $date; ?></time>
						</div>
						<div class="comment-info">
							<?php
							if ( ! empty( $title ) ) {
								?>
								<h5 class="comment-title">
									<?php echo $title; ?>
								</h5>
								<?php
							}
							if ( ! empty( $text ) ) {
								?>
								<p>
									<?php echo $text; ?>
								</p>
								<?php
							}
							?>
							<a class="comment-url" href="<?php echo $commented_post['url']; ?>"><?php echo __( 'On ', 'comfy' ) . $commented_post['title']; ?></a>
						</div>
					</div>
					<?php
				}
			}

			$pages = ( ( count( $possible ) + $offset ) / $template['comments_per_page'] ) - 1;
			if ( 1 < $pages ) {
				?>
				<div class="pagination">
					<?php
					paginate_comments_links(
						array(
							'base'         => add_query_arg( 'paged', '%#%' ),
							'format'       => '',
							'total'        => $pages,
							'current'      => $paged,
							'echo'         => true,
							'add_fragment' => '',
							'prev_text'    => '<svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.4953 5L1.94531 5" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.35881 9L1.49609 5L5.35881 1" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/></svg>',
							'next_text'    => '<svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.50468 5L10.0547 5" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.64119 0.999999L10.5039 5L6.64119 9" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/></svg>',
						)
					);
					?>
				</div>
				<?php
			}
			?>
		</div>
	</section>
</main>
<?php wp_list_comments(); ?>
<?php
get_footer();


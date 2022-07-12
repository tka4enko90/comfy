<?php /* Template Name: Quiz Page */
wp_enqueue_style( 'quiz', get_template_directory_uri() . '/dist/css/pages/quiz.css', '', '', 'all' );
wp_enqueue_script( 'quiz', get_template_directory_uri() . '/dist/js/pages/quiz.js', array( 'jquery' ), '', true );

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 0;
$quiz  = array(
	'first_question' => get_field( 'start_question' ),
	'items'          => get_field( 'quiz_items' ),
);

get_header();
?>
<main class="main">
	<?php
	if ( ! empty( $quiz['items'] && ! empty( $quiz['first_question'] ) ) ) {
		cmf_quiz_step(
			array(
				'question' => $quiz['first_question'],
				'items'    => $quiz['items'],
				'id'       => 'first-question',
			)
		);
	}
	do_action( 'quiz_steps' );
	?>
</main>
<?php
get_footer();

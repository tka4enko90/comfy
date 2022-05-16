<?php /**
 * Add new colorpicker field to "Add new Category" screen
 * - https://developer.wordpress.org/reference/hooks/taxonomy_add_form_fields/
 *
 * @param String $taxonomy
 *
 * @return void
 */
function cmf_add_new_category_fields( $taxonomy ) {

	?>

	<div class="form-field term-colorpicker-wrap">
		<label for="term-colorpicker"><?php _e( 'Category Color', 'comfy' ); ?></label>
		<input name="cmf_category_color" value="#283455" class="colorpicker" id="term-colorpicker" />
	</div>
	<div class="form-field term-colorpicker-wrap">
		<label for="term-colorpicker"><?php _e( 'Show category label in navigation', 'comfy' ); ?></label>
		<input type="checkbox" name="cmf_category_in_nav" value="yes"/>
	</div>


	<?php

}
add_action( 'category_add_form_fields', 'cmf_add_new_category_fields' );
add_action( 'product_cat_add_form_fields', 'cmf_add_new_category_fields' );


/**
 * Add new colopicker field to "Edit Category" screen
 * - https://developer.wordpress.org/reference/hooks/taxonomy_add_form_fields/
 *
 * @param WP_Term_Object $term
 *
 * @return void
 */
function cmf_edit_category_fields( $term ) {

	// Color Picker
	$color = get_term_meta( $term->term_id, 'cmf_category_color', true );
	$color = ( ! empty( $color ) ) ? "#{$color}" : '#283455';
	//Show in nav
	$show_in_nav = get_term_meta( $term->term_id, 'cmf_category_in_nav', true );
	$show_in_nav = ( ! empty( $show_in_nav ) ) ? 'yes' : null;

	?>
	<tr class="form-field term-colorpicker-wrap">
		<th scope="row"><label for="term-colorpicker"><?php _e( 'Category Color', 'comfy' ); ?></label></th>
		<td>
			<input name="cmf_category_color" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" />
		</td>
	</tr>
	<tr class="form-field term-colorpicker-wrap">
		<th scope="row"><label for="term-colorpicker"><?php _e( 'Show category label in navigation', 'comfy' ); ?></label></th>
		<td>
			<input type="checkbox" name="cmf_category_in_nav" value="yes" <?php echo ( $show_in_nav ) ? checked( $show_in_nav, 'yes' ) : ''; ?>/>
		</td>
	</tr>

	<?php

}
add_action( 'category_edit_form_fields', 'cmf_edit_category_fields' );
add_action( 'product_cat_edit_form_fields', 'cmf_edit_category_fields' );

/**
 * Term Metadata - Save Created and Edited Term Metadata
 * - https://developer.wordpress.org/reference/hooks/created_taxonomy/
 * - https://developer.wordpress.org/reference/hooks/edited_taxonomy/
 *
 * @param Integer $term_id
 *
 * @return void
 */
function cmf_save_term_meta( $term_id ) {

	// Save term color if possible
	if ( isset( $_POST['cmf_category_color'] ) && ! empty( $_POST['cmf_category_color'] ) ) {
		update_term_meta( $term_id, 'cmf_category_color', sanitize_hex_color_no_hash( $_POST['cmf_category_color'] ) );
	} else {
		delete_term_meta( $term_id, 'cmf_category_color' );
	}

	//Save show_in_vav
	if ( isset( $_POST['cmf_category_in_nav'] ) ) {
		update_term_meta( $term_id, 'cmf_category_in_nav', 'yes' );
	} else {
		update_term_meta( $term_id, 'cmf_category_in_nav', '' );
	}

}
add_action( 'created_category', 'cmf_save_term_meta' );
add_action( 'edited_category', 'cmf_save_term_meta' );
add_action( 'created_product_cat', 'cmf_save_term_meta' );
add_action( 'edited_product_cat', 'cmf_save_term_meta' );

/**
 * Enqueue colorpicker styles and scripts.
 * - https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
 *
 * @return void
 */
function category_colorpicker_enqueue( $taxonomy ) {
	$screen = get_current_screen();
	if ( ! empty( $screen ) ) {
		$allowed_screens = array( 'edit-category', 'edit-product_cat' );
		if ( ! in_array( $screen->id, $allowed_screens ) ) {
			return;
		}
	}

	// Colorpicker Scripts
	wp_enqueue_script( 'wp-color-picker' );

	// Colorpicker Styles
	wp_enqueue_style( 'wp-color-picker' );

}
add_action( 'admin_enqueue_scripts', 'category_colorpicker_enqueue' );

/**
 * Print javascript to initialize the colorpicker
 * - https://developer.wordpress.org/reference/hooks/admin_print_scripts/
 *
 * @return void
 */
function colorpicker_init_inline() {
	$screen = get_current_screen();
	if ( ! empty( $screen ) ) {
		$allowed_screens = array( 'edit-category', 'edit-product_cat' );
		if ( ! in_array( $screen->id, $allowed_screens ) ) {
			return;
		}
	}
	?>

	<script>
		jQuery( document ).ready( function( $ ) {
			$( '.colorpicker' ).wpColorPicker();
		} );
	</script>

	<?php

}
add_action( 'admin_print_scripts', 'colorpicker_init_inline', 20 );



<?php
defined( 'ABSPATH' ) || exit;

/**
 * Manual "related notes" selector on Posts.
 * Up to 3 — no recommendation algorithm, per DESIGN.md §10.
 */
add_action( 'add_meta_boxes', 'mpd_add_related_notes_meta_box' );
function mpd_add_related_notes_meta_box() {
	add_meta_box(
		'mpd_related_notes',
		'Notas relacionadas (máximo 3)',
		'mpd_render_related_notes_box',
		'post',
		'side',
		'default'
	);
}

function mpd_render_related_notes_box( $post ) {
	wp_nonce_field( 'mpd_save_related_notes', 'mpd_related_notes_nonce' );

	$selected = get_post_meta( $post->ID, '_mpd_related_notes', true );
	if ( ! is_array( $selected ) ) {
		$selected = array();
	}

	$others = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'exclude'        => array( $post->ID ),
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);

	if ( empty( $others ) ) {
		echo '<p class="description">No hay otras notas publicadas todavía.</p>';
		return;
	}

	echo '<p class="description">Selecciona hasta 3. Si no eliges ninguna, el bloque de relacionadas no se muestra.</p>';
	echo '<select name="mpd_related_notes[]" multiple size="8" style="width:100%;">';
	foreach ( $others as $other ) {
		$is_selected = in_array( $other->ID, $selected, true );
		echo '<option value="' . esc_attr( $other->ID ) . '" ' . selected( $is_selected, true, false ) . '>' . esc_html( $other->post_title ) . '</option>';
	}
	echo '</select>';
}

add_action( 'save_post_post', 'mpd_save_related_notes' );
function mpd_save_related_notes( $post_id ) {
	if ( ! isset( $_POST['mpd_related_notes_nonce'] ) || ! wp_verify_nonce( $_POST['mpd_related_notes_nonce'], 'mpd_save_related_notes' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$ids = isset( $_POST['mpd_related_notes'] ) ? array_map( 'absint', (array) $_POST['mpd_related_notes'] ) : array();
	$ids = array_slice( array_unique( $ids ), 0, 3 );

	update_post_meta( $post_id, '_mpd_related_notes', $ids );
}

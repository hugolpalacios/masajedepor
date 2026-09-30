<?php
defined( 'ABSPATH' ) || exit;

/**
 * Optional sources list on Posts — one per line. Rendered only "when
 * needed" (DESIGN.md §7): the sources block is skipped entirely if empty.
 */
add_action( 'add_meta_boxes', 'mpd_add_sources_meta_box' );
function mpd_add_sources_meta_box() {
	add_meta_box(
		'mpd_sources',
		'Fuentes (opcional, una por línea)',
		'mpd_render_sources_box',
		'post',
		'side',
		'default'
	);
}

function mpd_render_sources_box( $post ) {
	wp_nonce_field( 'mpd_save_sources', 'mpd_sources_nonce' );
	$value = get_post_meta( $post->ID, '_mpd_sources', true );
	echo '<textarea name="mpd_sources" rows="5" style="width:100%;">' . esc_textarea( $value ) . '</textarea>';
}

add_action( 'save_post_post', 'mpd_save_sources' );
function mpd_save_sources( $post_id ) {
	if ( ! isset( $_POST['mpd_sources_nonce'] ) || ! wp_verify_nonce( $_POST['mpd_sources_nonce'], 'mpd_save_sources' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$value = isset( $_POST['mpd_sources'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mpd_sources'] ) ) : '';
	update_post_meta( $post_id, '_mpd_sources', $value );
}

/**
 * Returns the sources as a clean array of non-empty lines.
 */
function mpd_get_sources( $post_id ) {
	$raw = get_post_meta( $post_id, '_mpd_sources', true );
	if ( '' === trim( (string) $raw ) ) {
		return array();
	}
	return array_values( array_filter( array_map( 'trim', explode( "\n", $raw ) ) ) );
}

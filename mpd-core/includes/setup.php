<?php
defined( 'ABSPATH' ) || exit;

/**
 * The activation hook only fires the moment the plugin is activated, which
 * already happened before these files existed. Re-run the same idempotent
 * setup once via `init`, guarded by an option so it's a no-op afterwards.
 */
add_action( 'init', 'mpd_core_maybe_run_setup', 20 );
function mpd_core_maybe_run_setup() {
	if ( get_option( 'mpd_core_setup_done' ) ) {
		return;
	}

	mpd_core_ensure_categories();
	mpd_core_ensure_contenido_page();

	update_option( 'mpd_core_setup_done', 1 );
}

function mpd_core_ensure_categories() {
	$categories = array( 'Masaje', 'Deporte', 'Recuperación' );
	foreach ( $categories as $name ) {
		if ( ! term_exists( $name, 'category' ) ) {
			wp_insert_term( $name, 'category' );
		}
	}
}

/**
 * Creates the /contenido/ page if it doesn't exist yet, and makes sure it
 * uses the theme's archive template.
 */
function mpd_core_ensure_contenido_page() {
	$existing = get_page_by_path( 'contenido' );

	if ( $existing ) {
		if ( 'page-contenido.php' !== get_page_template_slug( $existing->ID ) ) {
			update_post_meta( $existing->ID, '_wp_page_template', 'page-contenido.php' );
		}
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Contenido',
			'post_name'    => 'contenido',
			'post_status'  => 'publish',
			'post_type'    => 'page',
		)
	);

	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_post_meta( $page_id, '_wp_page_template', 'page-contenido.php' );
	}
}

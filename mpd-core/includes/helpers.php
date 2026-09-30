<?php
defined( 'ABSPATH' ) || exit;

/**
 * MVP has exactly one therapist. These helpers decouple the public byline
 * from the technical WordPress username — notes always credit whoever the
 * single published `terapeuta` entry is, by title, not by wp_users data.
 */
function mpd_get_therapist() {
	static $therapist = null;

	if ( null === $therapist ) {
		$found      = get_posts(
			array(
				'post_type'      => 'terapeuta',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'ID',
				'order'          => 'ASC',
			)
		);
		$therapist = $found ? $found[0] : false;
	}

	return $therapist;
}

function mpd_get_therapist_url() {
	$therapist = mpd_get_therapist();
	return $therapist ? get_permalink( $therapist ) : '';
}

function mpd_get_therapist_name() {
	$therapist = mpd_get_therapist();
	return $therapist ? get_the_title( $therapist ) : '';
}

/**
 * Returns the sanitized services array stored on a `terapeuta` post.
 */
function mpd_get_services( $terapeuta_id ) {
	$services = get_post_meta( $terapeuta_id, '_mpd_services', true );
	return is_array( $services ) ? $services : array();
}

/**
 * Up to 3 manually selected related posts. Empty array when none picked —
 * callers should render nothing in that case (DESIGN.md §10).
 */
function mpd_get_related_notes( $post_id ) {
	$ids = get_post_meta( $post_id, '_mpd_related_notes', true );
	if ( empty( $ids ) || ! is_array( $ids ) ) {
		return array();
	}

	return get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'post__in'       => $ids,
			'orderby'        => 'post__in',
			'posts_per_page' => 3,
		)
	);
}

/**
 * Maps a post's primary category to the CSS class used for its color dot
 * (.cat.deporte / .cat.recuperacion / .cat.masaje in mpd-theme's style.css).
 * Falls back to 'masaje' when the category isn't one of the three known ones.
 */
function mpd_get_category_class( $post_id ) {
	$known = array( 'deporte', 'recuperacion', 'masaje' );
	$terms = get_the_terms( $post_id, 'category' );

	if ( is_array( $terms ) ) {
		foreach ( $terms as $term ) {
			if ( in_array( $term->slug, $known, true ) ) {
				return $term->slug;
			}
		}
	}

	return 'masaje';
}

function mpd_get_category_label( $post_id ) {
	$terms = get_the_terms( $post_id, 'category' );
	if ( is_array( $terms ) && ! empty( $terms ) ) {
		return $terms[0]->name;
	}
	return '';
}

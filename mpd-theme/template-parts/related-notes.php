<?php
/**
 * Up to 3 manually selected related notes. Renders nothing when none
 * are selected — DESIGN.md §10: "If there are no relevant related
 * notes yet, show nothing."
 */
defined( 'ABSPATH' ) || exit;

$related = mpd_get_related_notes( get_the_ID() );

if ( empty( $related ) ) {
	return;
}
?>
<section class="related">
	<div class="related-head"><h2>Te puede interesar</h2></div>
	<div class="related-grid">
		<?php
		foreach ( $related as $related_post ) :
			setup_postdata( $related_post );
			get_template_part( 'template-parts/note-card', null, array( 'show_excerpt' => false ) );
		endforeach;
		wp_reset_postdata();
		?>
	</div>
</section>

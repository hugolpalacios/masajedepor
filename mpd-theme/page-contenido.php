<?php
/**
 * Template Name: Contenido
 *
 * Simple visual grid of all notes — no filters, search, or complex
 * pagination in the MVP (DESIGN.md §8).
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="archive-head">
	<h1>Contenido</h1>
	<p>Todas las notas, de la más reciente a la más antigua.</p>
</div>

<?php
$notes = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 30,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);
?>
<?php if ( $notes->have_posts() ) : ?>
	<div class="note-grid">
		<?php
		while ( $notes->have_posts() ) :
			$notes->the_post();
			get_template_part( 'template-parts/note-card' );
		endwhile;
		wp_reset_postdata();
		?>
	</div>
<?php else : ?>
	<p style="padding:20px;">Todavía no hay notas publicadas.</p>
<?php endif; ?>

<?php get_footer(); ?>

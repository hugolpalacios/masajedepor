<?php
/**
 * Note card — used on the home grid, /contenido/, and related notes.
 *
 * @param array $args {
 *     @type bool $show_excerpt  Whether to print the excerpt line. Default true.
 * }
 */
defined( 'ABSPATH' ) || exit;

$show_excerpt = isset( $args['show_excerpt'] ) ? (bool) $args['show_excerpt'] : true;
$cat_class    = mpd_get_category_class( get_the_ID() );
$cat_label    = mpd_get_category_label( get_the_ID() );
?>
<a href="<?php the_permalink(); ?>" class="note-card">
	<div class="thumb">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium_large' ); ?>
		<?php endif; ?>
	</div>
	<?php if ( $cat_label ) : ?>
		<span class="cat <?php echo esc_attr( $cat_class ); ?>"><span class="dot"></span><?php echo esc_html( $cat_label ); ?></span>
	<?php endif; ?>
	<h3><?php the_title(); ?></h3>
	<?php if ( $show_excerpt ) : ?>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
	<?php endif; ?>
</a>

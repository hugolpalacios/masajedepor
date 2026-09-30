<?php
/**
 * Byline: therapist name (linked) + date. Not the raw WP username —
 * MVP has one author, always credited as the published `terapeuta` entry.
 */
defined( 'ABSPATH' ) || exit;

$therapist_url  = mpd_get_therapist_url();
$therapist_name = mpd_get_therapist_name();
$therapist      = mpd_get_therapist();
?>
<div class="byline">
	<span class="avatar" aria-hidden="true">
		<?php if ( $therapist && has_post_thumbnail( $therapist ) ) : ?>
			<?php echo get_the_post_thumbnail( $therapist, array( 60, 60 ) ); ?>
		<?php elseif ( $therapist_name ) : ?>
			<?php echo esc_html( mb_substr( $therapist_name, 0, 1 ) ); ?>
		<?php endif; ?>
	</span>
	<?php if ( $therapist_url ) : ?>
		<a href="<?php echo esc_url( $therapist_url ); ?>"><?php echo esc_html( $therapist_name ); ?></a>
	<?php else : ?>
		<span><?php echo esc_html( $therapist_name ? $therapist_name : get_the_author() ); ?></span>
	<?php endif; ?>
	<span class="sep">·</span>
	<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
</div>

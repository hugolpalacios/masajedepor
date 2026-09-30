<?php
defined( 'ABSPATH' ) || exit;

$sources = mpd_get_sources( get_the_ID() );

if ( empty( $sources ) ) {
	return;
}
?>
<div class="sources">
	<span class="eyebrow">Fuentes</span>
	<ul>
		<?php foreach ( $sources as $source ) : ?>
			<li><?php echo esc_html( $source ); ?></li>
		<?php endforeach; ?>
	</ul>
</div>

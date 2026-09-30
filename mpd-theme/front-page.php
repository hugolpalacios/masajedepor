<?php
defined( 'ABSPATH' ) || exit;
get_header();

$hero_image_id = get_theme_mod( 'mpd_hero_image' );
$hero_image    = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'full' ) : '';
?>

<section class="hero">
	<?php if ( $hero_image ) : ?>
		<img class="hero-media" src="<?php echo esc_url( $hero_image ); ?>" alt="">
	<?php else : ?>
		<div class="hero-media-fallback" aria-hidden="true"></div>
	<?php endif; ?>

	<svg class="hero-badge" viewBox="0 0 120 120" aria-hidden="true">
		<defs><path id="mpdBadgePath" d="M60,60 m-46,0 a46,46 0 1,1 92,0 a46,46 0 1,1 -92,0"/></defs>
		<g style="stroke:currentColor;stroke-width:2;stroke-linecap:round;">
			<line x1="60" y1="50" x2="60" y2="70"/><line x1="50" y1="60" x2="70" y2="60"/>
			<line x1="53" y1="53" x2="67" y2="67"/><line x1="67" y1="53" x2="53" y2="67"/>
		</g>
		<text font-size="9.3" letter-spacing="2" fill="currentColor" style="font-family:'Instrument Sans'; text-transform:uppercase;">
			<textPath href="#mpdBadgePath" startOffset="0" textLength="289" lengthAdjust="spacingAndGlyphs">Masaje · Deporte · Recuperación ·</textPath>
		</text>
	</svg>

	<div class="hero-copy">
		<span class="eyebrow">Editorial MPD</span>
		<h1><span class="tt-a">Masaje, deporte</span><span class="tt-b">y recuperación.</span></h1>
		<p class="deck">Historias, guías y evidencia práctica para quienes entrenan, compiten y necesitan recuperarse bien.</p>
	</div>
</section>

<div class="section-intro">
	<span class="eyebrow">Lectura recomendada</span>
	<h2><span class="tt-a">Cuida tu cuerpo</span> <span class="tt-b">tan bien como entrenas.</span></h2>
</div>

<?php
$featured = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 4,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);
?>
<?php if ( $featured->have_posts() ) : ?>
	<div class="note-grid note-grid--home">
		<?php
		while ( $featured->have_posts() ) :
			$featured->the_post();
			get_template_part( 'template-parts/note-card' );
		endwhile;
		wp_reset_postdata();
		?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>

<?php
defined( 'ABSPATH' ) || exit;
get_header( 'perfil' );

while ( have_posts() ) :
	the_post();

	$role        = get_post_meta( get_the_ID(), '_mpd_role', true );
	$intro       = get_post_meta( get_the_ID(), '_mpd_short_description', true );
	$formation   = get_post_meta( get_the_ID(), '_mpd_formation', true );
	$location    = get_post_meta( get_the_ID(), '_mpd_location', true );
	$modalities  = get_post_meta( get_the_ID(), '_mpd_modalities', true );
	$schedule    = get_post_meta( get_the_ID(), '_mpd_schedule', true );
	$booking_url = get_post_meta( get_the_ID(), '_mpd_booking_url', true );
	$services    = mpd_get_services( get_the_ID() );

	$title       = get_the_title();
	$first_space = strpos( $title, ' ' );
	$first_name  = false !== $first_space ? substr( $title, 0, $first_space ) : $title;
	$last_name   = false !== $first_space ? substr( $title, $first_space + 1 ) : '';
	?>

	<section class="profile-hero">
		<div class="profile-copy">
			<span class="eyebrow">Perfil profesional</span>
			<h1>
				<span class="tt-a"><?php echo esc_html( $first_name ); ?></span>
				<?php if ( $last_name ) : ?><span class="tt-b"><?php echo esc_html( $last_name ); ?>.</span><?php endif; ?>
			</h1>
			<?php if ( $role ) : ?><p class="role"><?php echo esc_html( $role ); ?></p><?php endif; ?>
			<?php if ( $intro ) : ?><p class="intro"><?php echo esc_html( $intro ); ?></p><?php endif; ?>
		</div>
		<div class="profile-portrait">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large' ); ?>
			<?php else : ?>
				<span class="portrait-tag">Imagen de ejemplo</span>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( ! empty( $services ) ) : ?>
		<section class="section">
			<div class="section-head">
				<h2><span class="tt-a">Servicios para</span><span class="tt-b">volver a moverte.</span></h2>
			</div>
			<div class="services">
				<?php
				$i = 1;
				foreach ( $services as $service ) :
					get_template_part( 'template-parts/service-card', null, array( 'service' => $service, 'index' => $i ) );
					$i++;
				endforeach;
				?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $formation || $location || $schedule ) : ?>
		<section class="section dark">
			<div class="dark-cols">
				<div class="section-head">
					<span class="eyebrow">Forma de trabajo</span>
					<h2><span class="tt-a">Cuidado atento,</span><span class="tt-b">sin promesas fáciles.</span></h2>
					<?php if ( $formation ) : ?><p><?php echo esc_html( $formation ); ?></p><?php endif; ?>
				</div>
				<div class="info-rows">
					<?php if ( $location || $modalities ) : ?>
						<div class="row"><span class="k">Zona</span><div class="v"><?php echo esc_html( trim( $location . ( $modalities ? ' · ' . $modalities : '' ) ) ); ?></div></div>
					<?php endif; ?>
					<?php if ( $schedule ) : ?>
						<div class="row"><span class="k">Horario</span><div class="v"><?php echo esc_html( $schedule ); ?></div></div>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $booking_url ) : ?>
		<div class="cta-section">
			<div>
				<span class="eyebrow">Siguiente paso</span>
				<h2><span class="tt-a">¿Agendamos</span><span class="tt-b">tu sesión?</span></h2>
				<p>La reserva se hace fuera del sitio — el botón te lleva directo al WhatsApp o calendario de <?php echo esc_html( $first_name ); ?>.</p>
			</div>
			<a class="cta-button" href="<?php echo esc_url( $booking_url ); ?>" target="_blank" rel="noopener">Reserva externa →</a>
		</div>
	<?php endif; ?>

	<?php
endwhile;

get_footer();

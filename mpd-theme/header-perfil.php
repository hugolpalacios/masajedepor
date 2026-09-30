<?php
defined( 'ABSPATH' ) || exit;
/**
 * Alternate header used only by single-terapeuta.php (via get_header('perfil')).
 * Intentionally different from header.php — logo left + tagline, nav right —
 * matching the profile-v1 reference. See DESIGN.md §9/§11.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header-perfil">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand">
		<div class="brand-name">MasajeParaDeportistas<span class="dim">.com</span></div>
		<div class="tagline">Masaje, deporte y recuperación</div>
	</a>
	<nav class="primary" aria-label="Navegación principal">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a>
		<a href="<?php echo esc_url( home_url( '/contenido/' ) ); ?>">Contenido</a>
	</nav>
</header>

<main class="site-main">

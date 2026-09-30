<?php
defined( 'ABSPATH' ) || exit;
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

<header class="site-header">
	<nav class="primary" aria-label="Navegación principal">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="<?php echo is_front_page() ? 'is-active' : ''; ?>">Inicio</a>
		<a href="<?php echo esc_url( home_url( '/contenido/' ) ); ?>" class="<?php echo is_page( 'contenido' ) ? 'is-active' : ''; ?>">Contenido</a>
	</nav>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">MasajeParaDeportistas.com</a>
	<div class="header-spacer"></div>
</header>

<main class="site-main">

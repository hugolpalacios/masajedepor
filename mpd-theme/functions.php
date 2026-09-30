<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'mpd_theme_setup' );
function mpd_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'automatic-feed-links' );
}

add_action( 'wp_enqueue_scripts', 'mpd_theme_assets' );
function mpd_theme_assets() {
	wp_enqueue_style(
		'mpd-fonts',
		'https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,500;0,6..96,700;0,6..96,800;1,6..96,600&family=Instrument+Sans:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'mpd-theme-style',
		get_stylesheet_uri(),
		array( 'mpd-fonts' ),
		wp_get_theme()->get( 'Version' )
	);
}

/**
 * Hero background image, set from the Customizer (Apariencia → Personalizar).
 * No plugin needed — this is the one piece of home content expected to
 * change without a code edit; the headline/deck text stays static per
 * DESIGN.md's fixed content direction.
 */
add_action( 'customize_register', 'mpd_customize_register' );
function mpd_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'mpd_home_hero',
		array(
			'title'    => 'Home — imagen del hero',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'mpd_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'mpd_hero_image',
			array(
				'label'    => 'Imagen del hero',
				'section'  => 'mpd_home_hero',
				'mime_type' => 'image',
			)
		)
	);
}

/**
 * Short excerpt length for note cards (home / /contenido/ / related notes).
 */
add_filter( 'excerpt_length', 'mpd_excerpt_length' );
function mpd_excerpt_length( $length ) {
	return 20;
}

/**
 * This is a classic PHP theme with no block templates, so WordPress's
 * global-styles inline block (core's default color/gradient/spacing
 * presets, meant for block themes) is dead weight on every page load.
 * Core hooks wp_enqueue_global_styles() twice (head + footer hoisting);
 * remove both so it never runs.
 */
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );

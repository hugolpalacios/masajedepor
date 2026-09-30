<?php
/**
 * Plugin Name: MPD Core
 * Description: Custom post type, fields and helper functions for MasajeParaDeportistas.com.
 * Version: 0.1.0
 * Author: Hugo López
 * Text Domain: mpd-core
 */

defined( 'ABSPATH' ) || exit;

define( 'MPD_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'MPD_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once MPD_CORE_PATH . 'includes/cpt-terapeuta.php';
require_once MPD_CORE_PATH . 'includes/meta-terapeuta.php';
require_once MPD_CORE_PATH . 'includes/meta-related-notes.php';
require_once MPD_CORE_PATH . 'includes/meta-sources.php';
require_once MPD_CORE_PATH . 'includes/helpers.php';
require_once MPD_CORE_PATH . 'includes/setup.php';

register_activation_hook( __FILE__, 'mpd_core_activate' );

/**
 * Runs once on activation. Also mirrored on `init` in setup.php so it
 * still applies if the plugin was already active when these files landed.
 */
function mpd_core_activate() {
	mpd_core_ensure_categories();
	mpd_core_ensure_contenido_page();
	flush_rewrite_rules();
}

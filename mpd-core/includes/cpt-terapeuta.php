<?php
defined( 'ABSPATH' ) || exit;

/**
 * Registers the `terapeuta` custom post type.
 *
 * Public URL: /terapeuta/{slug}/ — the MVP has exactly one entry (Hugo),
 * but the type stays generic in case the project grows later.
 */
function mpd_register_cpt_terapeuta() {
	$labels = array(
		'name'               => 'Terapeutas',
		'singular_name'      => 'Terapeuta',
		'add_new'            => 'Añadir terapeuta',
		'add_new_item'       => 'Añadir terapeuta',
		'edit_item'          => 'Editar terapeuta',
		'new_item'           => 'Nuevo terapeuta',
		'view_item'          => 'Ver terapeuta',
		'search_items'       => 'Buscar terapeutas',
		'not_found'          => 'No se encontraron terapeutas',
		'all_items'          => 'Terapeutas',
		'menu_name'          => 'Terapeutas',
	);

	register_post_type(
		'terapeuta',
		array(
			'labels'        => $labels,
			'public'        => true,
			'has_archive'   => false,
			'show_in_menu'  => true,
			'menu_icon'     => 'dashicons-businessperson',
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
			'rewrite'       => array( 'slug' => 'terapeuta', 'with_front' => false ),
			'show_in_rest'  => false,
		)
	);
}
add_action( 'init', 'mpd_register_cpt_terapeuta' );

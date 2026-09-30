<?php
defined( 'ABSPATH' ) || exit;

/**
 * Meta keys used by the `terapeuta` post type.
 *
 * These match what was already stored in the database from an earlier
 * build, so existing content (Hugo's profile) keeps working as-is.
 */
function mpd_terapeuta_text_fields() {
	return array(
		'_mpd_role'              => 'Rol (ej. Masajista)',
		'_mpd_short_description' => 'Descripción corta',
		'_mpd_booking_url'       => 'URL de reserva externa',
		'_mpd_formation'         => 'Formación / técnicas',
		'_mpd_location'          => 'Zona',
		'_mpd_modalities'        => 'Modalidades',
		'_mpd_schedule'          => 'Horario',
		'_mpd_social_links'      => 'Redes sociales (una por línea, opcional)',
	);
}

add_action( 'add_meta_boxes', 'mpd_add_terapeuta_meta_boxes' );
function mpd_add_terapeuta_meta_boxes() {
	add_meta_box(
		'mpd_terapeuta_perfil',
		'Perfil del terapeuta',
		'mpd_render_terapeuta_perfil_box',
		'terapeuta',
		'normal',
		'high'
	);

	add_meta_box(
		'mpd_terapeuta_servicios',
		'Servicios',
		'mpd_render_terapeuta_servicios_box',
		'terapeuta',
		'normal',
		'high'
	);
}

function mpd_render_terapeuta_perfil_box( $post ) {
	wp_nonce_field( 'mpd_save_terapeuta', 'mpd_terapeuta_nonce' );

	echo '<table class="form-table"><tbody>';
	foreach ( mpd_terapeuta_text_fields() as $key => $label ) {
		$value    = get_post_meta( $post->ID, $key, true );
		$is_area  = in_array( $key, array( '_mpd_short_description', '_mpd_formation', '_mpd_social_links' ), true );
		$field_id = esc_attr( $key );

		echo '<tr><th style="width:220px;"><label for="' . $field_id . '">' . esc_html( $label ) . '</label></th><td>';

		if ( $is_area ) {
			echo '<textarea id="' . $field_id . '" name="' . $field_id . '" rows="3" style="width:100%;max-width:640px;">' . esc_textarea( $value ) . '</textarea>';
		} else {
			$type = ( '_mpd_booking_url' === $key ) ? 'url' : 'text';
			echo '<input type="' . $type . '" id="' . $field_id . '" name="' . $field_id . '" value="' . esc_attr( $value ) . '" style="width:100%;max-width:480px;">';
		}

		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

function mpd_render_terapeuta_servicios_box( $post ) {
	$services = get_post_meta( $post->ID, '_mpd_services', true );
	if ( ! is_array( $services ) ) {
		$services = array();
	}

	wp_enqueue_media();
	wp_enqueue_script(
		'mpd-services-repeater',
		MPD_CORE_URL . 'assets/services-repeater.js',
		array( 'jquery' ),
		MPD_CORE_VERSION,
		true
	);

	echo '<p class="description">Duración y precios son texto libre. Usa "Por definir" mientras no haya montos confirmados.</p>';
	echo '<table class="widefat" id="mpd-services-table"><thead><tr>';
	foreach ( array( 'Imagen', 'Nombre', 'Descripción', 'Duración', 'Precio sala', 'Precio domicilio', 'URL reserva (opcional)', '' ) as $col ) {
		echo '<th>' . esc_html( $col ) . '</th>';
	}
	echo '</tr></thead><tbody id="mpd-services-rows">';

	foreach ( $services as $i => $service ) {
		mpd_render_service_row( $i, $service );
	}

	echo '</tbody></table>';
	echo '<p><button type="button" class="button" id="mpd-add-service">Añadir servicio</button></p>';

	echo '<script type="text/template" id="mpd-service-row-template">';
	mpd_render_service_row( '__INDEX__', array() );
	echo '</script>';
}

function mpd_render_service_row( $i, $service ) {
	$service = wp_parse_args(
		$service,
		array(
			'name'            => '',
			'description'     => '',
			'duration'        => '',
			'treatment_price' => '',
			'home_price'      => '',
			'booking_url'     => '',
			'image'           => '',
		)
	);

	$name = 'mpd_services[' . $i . ']';
	$img  = $service['image'] ? wp_get_attachment_image( $service['image'], array( 60, 60 ) ) : '';
	?>
	<tr class="mpd-service-row">
		<td>
			<div class="mpd-service-image-preview"><?php echo $img; // phpcs:ignore ?></div>
			<input type="hidden" class="mpd-service-image-id" name="<?php echo esc_attr( $name ); ?>[image]" value="<?php echo esc_attr( $service['image'] ); ?>">
			<button type="button" class="button mpd-service-image-select">Elegir</button>
			<button type="button" class="button-link mpd-service-image-remove">Quitar</button>
		</td>
		<td><input type="text" name="<?php echo esc_attr( $name ); ?>[name]" value="<?php echo esc_attr( $service['name'] ); ?>" style="width:140px;"></td>
		<td><textarea name="<?php echo esc_attr( $name ); ?>[description]" rows="2" style="width:220px;"><?php echo esc_textarea( $service['description'] ); ?></textarea></td>
		<td><input type="text" name="<?php echo esc_attr( $name ); ?>[duration]" value="<?php echo esc_attr( $service['duration'] ); ?>" style="width:80px;"></td>
		<td><input type="text" name="<?php echo esc_attr( $name ); ?>[treatment_price]" value="<?php echo esc_attr( $service['treatment_price'] ); ?>" style="width:100px;"></td>
		<td><input type="text" name="<?php echo esc_attr( $name ); ?>[home_price]" value="<?php echo esc_attr( $service['home_price'] ); ?>" style="width:100px;"></td>
		<td><input type="url" name="<?php echo esc_attr( $name ); ?>[booking_url]" value="<?php echo esc_attr( $service['booking_url'] ); ?>" style="width:140px;"></td>
		<td><button type="button" class="button-link mpd-service-remove" aria-label="Eliminar servicio">✕</button></td>
	</tr>
	<?php
}

add_action( 'save_post_terapeuta', 'mpd_save_terapeuta_meta' );
function mpd_save_terapeuta_meta( $post_id ) {
	if ( 'terapeuta' !== get_post_type( $post_id ) || wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}
	if ( ! isset( $_POST['mpd_terapeuta_nonce'] ) || ! wp_verify_nonce( $_POST['mpd_terapeuta_nonce'], 'mpd_save_terapeuta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array_keys( mpd_terapeuta_text_fields() ) as $key ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $key ] );
		if ( '_mpd_booking_url' === $key ) {
			update_post_meta( $post_id, $key, esc_url_raw( $raw ) );
		} elseif ( in_array( $key, array( '_mpd_short_description', '_mpd_formation', '_mpd_social_links' ), true ) ) {
			update_post_meta( $post_id, $key, sanitize_textarea_field( $raw ) );
		} else {
			update_post_meta( $post_id, $key, sanitize_text_field( $raw ) );
		}
	}

	$services = array();
	if ( isset( $_POST['mpd_services'] ) && is_array( $_POST['mpd_services'] ) ) {
		foreach ( $_POST['mpd_services'] as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$row = wp_unslash( $row );
			$name = isset( $row['name'] ) ? sanitize_text_field( $row['name'] ) : '';
			if ( '' === $name ) {
				continue; // Skip empty rows (e.g. an unused template row).
			}
			$services[] = array(
				'name'            => $name,
				'description'     => isset( $row['description'] ) ? sanitize_textarea_field( $row['description'] ) : '',
				'duration'        => isset( $row['duration'] ) ? sanitize_text_field( $row['duration'] ) : '',
				'treatment_price' => isset( $row['treatment_price'] ) ? sanitize_text_field( $row['treatment_price'] ) : '',
				'home_price'      => isset( $row['home_price'] ) ? sanitize_text_field( $row['home_price'] ) : '',
				'booking_url'     => isset( $row['booking_url'] ) ? esc_url_raw( $row['booking_url'] ) : '',
				'image'           => isset( $row['image'] ) ? absint( $row['image'] ) : 0,
			);
		}
	}
	update_post_meta( $post_id, '_mpd_services', $services );
}

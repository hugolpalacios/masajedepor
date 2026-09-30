<?php
/**
 * One flat, numbered service item (no card border/background) —
 * DESIGN.md §9 / SITE-ARCHITECTURE.md §10.
 *
 * @param array $args {
 *     @type array  $service Service row: name, description, duration,
 *                           treatment_price, home_price, booking_url, image.
 *     @type int    $index   1-based position, printed as "01", "02"...
 * }
 */
defined( 'ABSPATH' ) || exit;

$service = isset( $args['service'] ) ? $args['service'] : array();
$index   = isset( $args['index'] ) ? (int) $args['index'] : 1;

$service = wp_parse_args(
	$service,
	array(
		'name'            => '',
		'description'     => '',
		'duration'        => '',
		'treatment_price' => '',
		'home_price'      => '',
		'image'           => 0,
	)
);
?>
<article class="service">
	<div class="service-thumb">
		<?php if ( $service['image'] ) : ?>
			<?php echo wp_get_attachment_image( $service['image'], 'medium', false, array( 'alt' => esc_attr( $service['name'] ) ) ); ?>
		<?php endif; ?>
	</div>
	<span class="service-index"><?php echo esc_html( str_pad( (string) $index, 2, '0', STR_PAD_LEFT ) ); ?></span>
	<div class="service-body">
		<h3><?php echo esc_html( $service['name'] ); ?></h3>
		<?php if ( $service['description'] ) : ?>
			<p><?php echo esc_html( $service['description'] ); ?></p>
		<?php endif; ?>
		<dl class="service-meta">
			<div><dt>Duración</dt><dd><?php echo esc_html( $service['duration'] ? $service['duration'] : 'Por definir' ); ?></dd></div>
			<div><dt>Sala</dt><dd><?php echo esc_html( $service['treatment_price'] ? $service['treatment_price'] : 'Por definir' ); ?></dd></div>
			<div><dt>Domicilio</dt><dd><?php echo esc_html( $service['home_price'] ? $service['home_price'] : 'Por definir' ); ?></dd></div>
		</dl>
	</div>
</article>

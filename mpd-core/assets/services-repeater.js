( function ( $ ) {
	'use strict';

	var $rows = $( '#mpd-services-rows' );
	var template = document.getElementById( 'mpd-service-row-template' );
	var nextIndex = $rows.find( '.mpd-service-row' ).length;

	function bindRow( $row ) {
		$row.find( '.mpd-service-image-select' ).on( 'click', function ( e ) {
			e.preventDefault();
			var $btn = $( this );
			var $cell = $btn.closest( 'td' );
			var frame = wp.media( { title: 'Elegir imagen', multiple: false } );

			frame.on( 'select', function () {
				var attachment = frame.state().get( 'selection' ).first().toJSON();
				$cell.find( '.mpd-service-image-id' ).val( attachment.id );
				var thumb = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
				$cell.find( '.mpd-service-image-preview' ).html( '<img src="' + thumb + '" width="60" height="60" style="object-fit:cover;">' );
			} );

			frame.open();
		} );

		$row.find( '.mpd-service-image-remove' ).on( 'click', function ( e ) {
			e.preventDefault();
			var $cell = $( this ).closest( 'td' );
			$cell.find( '.mpd-service-image-id' ).val( '' );
			$cell.find( '.mpd-service-image-preview' ).empty();
		} );

		$row.find( '.mpd-service-remove' ).on( 'click', function ( e ) {
			e.preventDefault();
			$row.remove();
		} );
	}

	$rows.find( '.mpd-service-row' ).each( function () {
		bindRow( $( this ) );
	} );

	$( '#mpd-add-service' ).on( 'click', function ( e ) {
		e.preventDefault();
		var html = template.innerHTML.replace( /__INDEX__/g, nextIndex );
		nextIndex++;
		var $row = $( html );
		$rows.append( $row );
		bindRow( $row );
	} );
} )( jQuery );

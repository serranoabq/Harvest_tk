/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

jQuery( document ).ready( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.lead' ).text( to );
		} );
	} );
	
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .lead' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .lead' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
	
	//
	for( var i = 1; i < 12; i++ ){
		wp.customize( 'harvest_tk_panel_' + i + '_opacity', function( value ) {
			value.bind( function( opacity ) {
				$( '.harvest_tk-panel' + i + ' .harvest_tk-panel-background' ).css( {
					'opacity': opacity,
				} );
			} );
		} );

		wp.customize( 'harvest_tk_panel_' + i + '_bgcolor', function( value ) {
			value.bind( function( color ) {
				if ( false === color ) {
					$( '.harvest_tk-panel' + i ).css( {
						'background-color': '',
					} );
				} else {
					$( '.harvest_tk-panel' + i ).css( {
						'background-color': color,
					} );
				}
			} );
		} );
		
	}
} );

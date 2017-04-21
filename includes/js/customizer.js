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
	
	// Header background color.
	wp.customize( 'harvest_tk_header_bgcolor', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( '.pre-content-bg, .site-header, .panel-header' ).css( {
					'background-color': to
				} );
			}
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
	
	wp.customize( 'harvest_tk_panel_count', function( value ){
		value.bind( function( to ){
			for( var i = 1; i < 12; i++ ){
				if( i <= to ) {
					// toggle panel on;
				} else {
					// toggle panel off;
				}
			}
		} );
	} );
	
	//
	for( var i = 1; i <= 12; i++ ){
		var dpanel = 'harvest_tk_panel_' + i;
		wp.customize( dpanel + '_opacity', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( opacity ) {
				$( mpanel + ' .harvest_tk_panel-background' ).css( {
					'opacity': opacity
				} );
			} );
		} );

		wp.customize( dpanel + '_bgcolor', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( color ) {
				if ( false === color ) {
					$( mpanel ).css( {
						'background-color': ''
					} );
				} else {
					$( mpanel ).css( {
						'background-color': color
					} );
				}
			} );
		} );
		
	}
} );

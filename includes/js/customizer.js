/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

jQuery( document ).ready( function( $ ) {
	
	wp.customize.preview.bind( 'section-scroll', function( data ){
		if ( 'undefined' == typeof( $( '.' + data.section ).offset() ) ) {
			return;
		}
		if ( true === data.expanded ) {
			$( 'html, body' ).animate({
				scrollTop: $( '.' + data.section ).offset().top
			}, 600 );			
		} else {
			$( 'html, body' ).animate({
				scrollTop: 0
			}, 300 );
		}
	} );
	
	
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
				$( '.pre-content-bg, .site-header, .panel-header, .dropdown-menu' ).css( {
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
	
	// Panels
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
					$( mpanel + ', ' + mpanel + ' .ctc_cal > .month, ' + mpanel + ' .time' ).css( {
						'background-color': ''
					} );
				} else {
					$( mpanel + ', ' + mpanel + ' .ctc_cal >  .month, ' + mpanel + ' .time' ).css( {
						'background-color': color
					} );
				}
			} );
		} );
		
		wp.customize( dpanel + '_title', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( value ) {
				$( mpanel + ' .panel-header h3' ).html( value );
			} );
		} );
		
		wp.customize( dpanel + '_showtitle', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( value ) {
				$( mpanel + ' .panel-header' ).toggleClass( 'hidden-xs-up' );
			} );
		} );
		
		wp.customize( dpanel + '_whitetext', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( value ) {
				$( mpanel + ' .container' ).toggleClass( 'text-white' );
			} );
		} );
		
	}
} );

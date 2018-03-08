/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

jQuery( document ).ready( function( $ ) {
	var api = wp.customize;
	
	api.preview.bind( 'section-scroll', function( data ){
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
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.lead' ).text( to );
		} );
	} );
	
	// Header background color.
	api( 'harvest_tk_header_bgcolor', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( '.pre-content-bg, .site-header, .dropdown-menu' ).css( {
					'background-color': to
				} );
			}
		} );
	} );
	
	// Header text color.
	api( 'header_textcolor', function( value ) {
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
	
	api( 'harvest_tk_panel_count', function( value ){
		value.bind( function( to ){
			for( var i = 1; i < 12; i++ ){
				if( i <= to ) {
					// toggle panel on;
					$( '.harvest_tk_panel_' + i ).removeClass( 'hidden-xs-up' );
				} else {
					// toggle panel off;
					$( '.harvest_tk_panel_' + i ).addClass( 'hidden-xs-up' );
				}
			}
		} );
	} );
	
	// Panels
	for( var i = 1; i <= 12; i++ ){
		var dpanel = 'harvest_tk_panel_' + i;
		
		api( dpanel + '_opacity', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( opacity ) {
				$( mpanel + ' .harvest_tk_panel-background' ).css( {
					'opacity': opacity
				} );
			} );
		} );

		api( dpanel + '_bgcolor', function( value ) {
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
		
		api( dpanel + '_title', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( title ) {
				$( mpanel + ' .panel-header h1' ).html( title );
			} );
		} );
		
		api( dpanel + '_showtitle', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( show_title ) {
				$( mpanel + ' .panel-header' ).toggleClass( 'hidden-xs-up' );
			} );
		} );
		
		api( dpanel + '_whitetext', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( whitetext ) {
				$( mpanel + ' .container' ).toggleClass( 'text-white' );
			} );
		} );
		
		api( dpanel + '_bgimage', function( value ) {
			var mpanel = '.' + dpanel;
			value.bind( function( image_url ) {
				if( $( mpanel ).hasClass( 'front-panel' ) ) 
					return;
				$( mpanel + ' .harvest_tk_panel-background' ).css( {
					'background-image': 'url(' + image_url + ')'
				} );
			} );
		} );
		
		/*
		api( dpanel + '_swap', function( value ) {
			var mpanel = dpanel;
			value.bind( function( to ) {
				fromPanel = mpanel.replace( 'harvest_tk_panel_', '' );
				toPanel = to.replace( 'panel_', '' );
				swapPanels( fromPanel, toPanel );
			} );
		} );
		*/
	}
	
	function getPanelData( panel ){
		controls = ['title', 'showtitle', 'type', 'page', 'bgimage', 'opacity', 'bgcolor', 'whitetext'];
		panelData = new Object();
		controls.forEach( function( ctl ) {
			panelData[ctl] = wp.customize.value( 'harvest_tk_panel_' + panel + '_' + ctl )();
		})
		return panelData;
	}
	
	function setPanelData( panesl, panelData ){
		controls = ['title', 'showtitle', 'type', 'page', 'bgimage', 'opacity', 'bgcolor', 'whitetext'];
		controls.forEach( function( ctl ) {
			wp.customize.value( 'harvest_tk_panel_' + panel + '_' + ctl )( panelData[ ctl] );		
		})
	}
	
	function swapPanels( fromPanel, toPanel ){
		fromPanelData = getPanelData( fromPanel );
		toPanelData = getPanelData( toPanel );
		
		setPanelData( fromPanel, toPanelData );
		setPanelData( toPanel, fromPanelData );
		
	}
} );

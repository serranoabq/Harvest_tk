<?php
/**
 * The front page template file.
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 *
 * @package harvest_tk
 */

get_header(); ?>

	<?php
	// Get each of our panels and show the post data
	$panels = range( 1, get_theme_mod( 'harvest_tk_panel_count' ), 1 );
	foreach ( $panels as $panel ) :	
		set_query_var( 'harvest_tk_panel', $panel );
		
		switch( get_theme_mod( 'harvest_tk_panel_' . $panel . '_type' )):
			case 'sermon':
				get_template_part( 'components/front', 'sermon' );
				break;
			case 'event':
				get_template_part( 'components/front', 'events' );
				break;
			case 'location':
				get_template_part( 'components/front', 'location' );
				break;
			case 'page':
				if( get_theme_mod( 'harvest_tk_panel_' . $panel . '_page' ) ) :
					$post = get_post( get_theme_mod( 'harvest_tk_panel_' . $panel . '_page') );
					setup_postdata( $post );
					get_template_part( 'components/front', 'panel' );
					wp_reset_postdata();
				endif;
				break;
				
		endswitch;
		
	endforeach;
	?>

<?php get_footer(); ?>

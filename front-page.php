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
		if ( get_theme_mod( 'harvest_tk_panel_' . $panel . '_page') ) :
			$post = get_post( get_theme_mod( 'harvest_tk_panel_' . $panel . '_page') );
			setup_postdata( $post );
			set_query_var( 'harvest_tk_panel', $panel );
			// Each panel can be a page's content, but displayed differently
			// Special pages could be created with special templates 
			// (e.g. for recent sermon or upcoming events)
			// 
			// get_template_part( 'components/content', 'page' );
			wp_reset_postdata();
		endif;
	endforeach;
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>

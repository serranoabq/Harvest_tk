<?php
/**
 * Front page - Page panel 
 * @package harvest_tk
 */
	
	$preview_panel_class = isset( $empty ) && is_customize_preview() ? 'hidden-xs-up' : '';
	
	$panel_title = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_title' );
	$show_title = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_showtitle', false );
	$preview_title_class = !$show_title && is_customize_preview() ? 'hidden-xs-up' : '';
	$wht = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_whitetext', false );
	$white_text_class = $wht ? 'text-white' : '';
	$bgcolor = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgcolor', '' );
	
?>


<article id="post-<?php the_ID(); ?>" <?php post_class( "harvest_tk_panel m-0  py-5 px-3 px-md-5 harvest_tk_panel_$harvest_tk_panel front-panel $preview_panel_class" ); ?> style="background-color:<?php echo $bgcolor; ?>">
	
	<?php if ( has_post_thumbnail() ) :
	
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'harvest_tk-hero' ); 
	
	?>
		
		<div class="harvest_tk_panel-background bg-m-scroll" style="background-image:url(<?php echo esc_url( $image[0] ); ?>)"></div>
		
	<?php endif; ?>
	
	<div class="container px-0 py-5 <?php echo $white_text_class; ?>">
	
		<?php if( $show_title || is_customize_preview() ): ?>
		
			<div class="panel-header pb-4 <?php echo $preview_title_class; ?>"><h1><?php the_title(); ?></h1></div>
		
		<?php endif; ?>
		
		<div class="harvest_tk_panel-content row px-3">
		
			<?php the_content(); ?>
		
		</div> <!-- .harvest_tk_panel-content -->
		
	</div> <!-- .container -->
	
	<?php if( is_customize_preview() ): ?>
	
		<div class="harvest_tk_panel-preview_frame"><span><?php echo __('Panel', 'harvest_tk' ) . ' ' . $harvest_tk_panel; ?></span></div>
	
	<?php endif; ?>
	
</article><!-- #post-## -->

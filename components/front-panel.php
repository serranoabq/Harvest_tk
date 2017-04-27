<?php
/**
 * @package harvest_tk
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class( "harvest_tk_panel m-0 p-5 harvest_tk_panel_$harvest_tk_panel" ); ?> style="background-color:<?php echo get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgcolor' ); ?>">
	
	<?php if ( has_post_thumbnail() ) :
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'harvest_tk-hero' ); ?>
		
		<div class="harvest_tk_panel-background " style="background-image:url(<?php echo esc_url( $image[0] ); ?>)"></div>
		
	<?php endif; ?>
	
	<div class="container">
		<div class="harvest_tk_panel-content">
		
			<?php the_content(); ?>
		
		</div>
		
	</div>
	
	<?php if( is_customize_preview() ): ?>
	
		<div class="harvest_tk_panel-preview_frame"><span><?php echo __('Panel', 'harvest_tk' ) . ' ' . $harvest_tk_panel; ?></span></div>
	
	<?php endif; ?>
	
</article><!-- #post-## -->

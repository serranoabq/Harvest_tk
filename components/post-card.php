<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package harvest_tk
 */ 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row post-card' ); ?>>
	<?php 
		if( has_post_thumbnail( get_the_ID() ) ) : 
			// Use featured image if available
			$id = get_post_thumbnail_id( get_the_ID() );
			$img_src = wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image'] );
			?>
		<div class="ctc-media">
			
			<?php echo $img_src; ?>
			
		</div> 
	<?php endif; ?>
	
	<header class="col-12 p-3">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content col-12">
		
		<?php the_excerpt(); ?>
		
	</div><!-- .entry-content -->
	
	<footer class="entry-footer col-12 p-3 mt-0 text-right">

		<?php edit_post_link( esc_html__( 'Edit this post', 'harvest_tk' ), '<span class="edit-link">', '</span>' ); ?>
	
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->

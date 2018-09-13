<?php
/**
 * @package harvest_tk
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>

	<header class="col-12 px-3">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
		<div class="text-muted pb-3"><?php echo sprintf( __( 'Posted on %s by %s', 'harvest_tk' ), get_the_date(), get_the_author() )  ; ?></div>
	</header><!-- .entry-header -->
	
	<div class="entry-content col-12">
		
		<?php the_content(); ?>
		
		<?php harvest_tk_link_pages(); ?>
		
	</div><!-- .entry-content -->

	<footer class="entry-footer col-12 small mt-5">
		
		<div class="text-muted"><i class="fa fa-tag"></i> <?php echo get_the_category_list( __( ', ', 'harvest_tk' ) ); ?></div>
	
		<?php edit_post_link( __( 'Edit this post', 'harvest_tk' ), '<span class="edit-link">', '</span>' ); ?>
		
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->

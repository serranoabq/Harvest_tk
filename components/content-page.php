<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package harvest_tk
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>
	
	<header class="col-12">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content col-12">
		
		<?php the_content(); ?>
		
	</div><!-- .entry-content -->
	
	<footer class="entry-footer">

		<?php edit_post_link( esc_html__( 'Edit this page', 'harvest_tk' ), '<span class="edit-link">', '</span>' ); ?>
	
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->

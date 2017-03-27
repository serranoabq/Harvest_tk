<?php
/**
 * Template part for displaying single event posts
 *
 * @package harvest_tk
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>

	<header class="col-12">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
	</header>
	
	<div class="col-md-8">
	
		<?php the_content(); ?>
		
		<footer class="entry-footer">

			<?php edit_post_link( esc_html__( 'Edit this event', 'harvest_tk' ), '<span class="edit-link">', '</span>' ); ?>
	
		</footer><!-- .entry-footer -->
	
	</div>
	
	<?php get_template_part( 'components/ctc-event', 'details' ); ?>
	
	
</article><!-- #post-## -->

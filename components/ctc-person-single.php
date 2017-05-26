<?php
/**
 * Template part for displaying single location posts
 *
 * @package harvest_tk
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>

	<header class="col-12 p-3">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
	</header>
	
	<?php get_template_part( 'components/ctc-person', 'details' ); ?>
	
	<div class="col-12">
	
		<?php the_content(); ?>
		
		<footer class="entry-footer">

			<?php edit_post_link( esc_html__( 'Edit this person', 'harvest_tk' ), '<span class="edit-link">', '</span>' ); ?>
	
		</footer><!-- .entry-footer -->
	
	</div>
	
</article><!-- #post-## -->

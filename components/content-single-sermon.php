<?php
/**
 * Template part for displaying single sermon posts.
 *
 * @package Cultiv8
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>

	<?php get_template_part( 'components/ctc', 'sermon-chooser' ); ?>
	
	<header class="col-12">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
		<span class="ctc-sermon-date"><?php echo the_date(); ?></span>
	</header>
	
	<div class="col-md-8">
		<?php the_content(); ?>
		
		<footer class="entry-footer">
			<?php edit_post_link( esc_html__( 'Edit this sermon', 'harvest_tk' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-footer -->
	</div>
	
	
	<?php get_template_part( 'components/ctc', 'sermon-details' ); ?>
	
	
</article><!-- #post-## -->

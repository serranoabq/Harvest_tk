<?php
/**
 * Template part for displaying single sermon posts.
 *
 * @package Cultiv8
 */
?>
<style>

</style>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php get_template_part( 'components/ctc', 'sermon-chooser' ); ?>
	
	<header class="col-lg-8 col-lg-offset-1" style="padding-left:0" >
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
		<span class="ctc-sermon-date"><?php echo the_date(); ?></span>
	</header>
	
	<div class="entry-content row">
		<div class="col-sm-8 col-md-9 col-lg-8 col-lg-offset-1">
			<?php the_content(); ?>
			
			<footer class="entry-footer">
				<?php edit_post_link( esc_html__( 'Edit this sermon', 'harvest_tk' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
		</div>
		
		<div class="col-sm-4 col-md-3">
			<?php get_template_part( 'components/ctc', 'sermon-details' ); ?>
		</div>	
		
	</div> <!-- .entry-content -->

</article><!-- #post-## -->

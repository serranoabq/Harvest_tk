<?php
/**
 * @package harvest_tk
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>

	<header class="col-12 p-3">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
		<span class="text-muted"><?php echo the_date(); ?></span>

	</header><!-- .entry-header -->

	<div class="entry-content col-12">
		
		<?php the_content(); ?>
		
		<?php harvest_tk_link_pages(); ?>
		
	</div><!-- .entry-content -->

	<footer class="entry-footer col-12 small">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'harvest_tk' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'harvest_tk' ) );

			if ( ! harvest_tk_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'harvest_tk' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'harvest_tk' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'harvest_tk' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'harvest_tk' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>
		<div class="entry-meta">
			<?php harvest_tk_posted_on(); ?>
		</div><!-- .entry-meta -->		

		<?php edit_post_link( __( 'Edit this post', 'harvest_tk' ), '<span class="edit-link">', '</span>' ); ?>
		
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->

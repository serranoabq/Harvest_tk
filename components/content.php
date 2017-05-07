<?php
/**
 * @package harvest_tk
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>

	<header class="col-12">
		<h1 class="page-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		
		<div class="entry-meta col-12"><?php harvest_tk_posted_on(); ?></div><!-- .entry-meta -->
		
		<?php endif; ?>
	
	</header><!-- .entry-header -->

	<?php if ( is_search() || is_archive() ) : // Only display Excerpts for Search and Archive Pages ?>
	
	<div class="entry-summary col-12"><?php the_excerpt(); ?></div><!-- .entry-summary -->
	
	<?php else : ?>
	
	<div class="entry-content col-12">
	
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'harvest_tk' ) ); ?>
		
		<?php harvest_tk_link_pages(); ?>
		
	</div><!-- .entry-content -->
	
	<?php endif; ?>

	<footer class="entry-footer">
	
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
		
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'harvest_tk' ) );
				if ( $categories_list && harvest_tk_categorized_blog() ) :
			?>
			
			<span class="cat-links">
			
				<?php printf( __( 'Posted in %1$s', 'harvest_tk' ), $categories_list ); ?>
				
			</span>
			
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'harvest_tk' ) );
				if ( $tags_list ) :
			?>
			
			<span class="tags-links">
			
				<?php printf( __( 'Tagged %1$s', 'harvest_tk' ), $tags_list ); ?>
		
			</span>
			
			<?php endif; // End if $tags_list ?>
			
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'harvest_tk' ), __( '1 Comment', 'harvest_tk' ), __( '% Comments', 'harvest_tk' ) ); ?></span>
		
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'harvest_tk' ), '<span class="edit-link">', '</span>' ); ?>
	
	</footer><!-- .entry-meta -->
	
</article><!-- #post-## -->

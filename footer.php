<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package harvest_tk
 */
?>
<?php if( ! is_front_page() ): ?>

				</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
				
			</div><!-- close .row -->
			
<?php endif; ?>			

		</div><!-- close .container -->
		
	</div><!-- close .main-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		
		<div class="container">
		
		<div class="row">

				<div class="site-footer-inner col-sm-12">

					<div class="site-info">
						<?php do_action( 'harvest_tk_credits' ); ?>
						<?php echo sprintf( __( '&copy; Copyright %d %s', 'harvest' ), date('Y'), get_bloginfo( 'name' ) ); ?>
					</div><!-- close .site-info -->

				</div>

			</div>
			
		</div><!-- close .container -->
		
	</footer><!-- close #colophon -->

<?php wp_footer(); ?>

</body>
</html>

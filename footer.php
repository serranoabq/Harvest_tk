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

	<footer id="colophon" class="site-footer pt-5" role="contentinfo">
		
		<div class="container">
		
			<div class="row">
			
				<?php dynamic_sidebar( 'footer' ); ?>
			
			</div>
			
			<div class="row">

				<div class="site-footer-inner col-sm-6 align-baseline">

					<div class="site-info">
						<?php do_action( 'harvest_tk_credits' ); ?>
						<?php echo sprintf( __( '&copy; Copyright %d %s', 'harvest' ), date('Y'), get_bloginfo( 'name' ) ); ?>
					</div><!-- close .site-info -->

				</div>

				<div class="site-footer-social col-sm-6 text-right">
				
					<?php 
					
						$fb = get_theme_mod('harvest_tk_facebook');
						$tw = get_theme_mod('harvest_tk_twitter');
						$ig = get_theme_mod('harvest_tk_instagram');
						$gp = get_theme_mod('harvest_tk_google');
						$yt = get_theme_mod('harvest_tk_youtube');
						$vm = get_theme_mod('harvest_tk_vimeo');
					
						if( $fb ) echo '<a href="'. $fb .'" target="_blank"><i class="fa fa-facebook-square fa-2x mr-2 text-muted"></i></a>';
						if( $tw ) echo '<a href="'. $tw .'" target="_blank"><i class="fa fa-twitter-square fa-2x mr-2 text-muted"></i></a>';
						if( $ig ) echo '<a href="'. $ig .'" target="_blank"><i class="fa fa-instagram fa-2x mr-2 text-muted"></i></a>';
						if( $gp ) echo '<a href="'. $gp .'" target="_blank"><i class="fa fa-google-plus-square fa-2x mr-2 text-muted"></i></a>';
						if( $yt ) echo '<a href="'. $yt .'" target="_blank"><i class="fa fa-youtube-square fa-2x mr-2 text-muted"></i></a>';
						if( $vm ) echo '<a href="'. $vm .'" target="_blank"><i class="fa fa-vimeo-square fa-2x text-muted"></i></a>';
						
					?>
				</div>
				
			</div>
			
		</div><!-- close .container -->
		
	</footer><!-- close #colophon -->

<?php wp_footer(); ?>

</body>
</html>

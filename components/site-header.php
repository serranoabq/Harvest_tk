	<div id="site-header-container" class="container">
		<div class="row">
			<div class="site-header-inner col-sm-12">
				
				<div class="site-branding">

					<?php harvest_tk_the_custom_logo(); ?>
					
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<p class="site-description lead"><?php bloginfo( 'description' ); ?></p>
				</div>
				
			</div>
			
			<?php get_template_part( 'components/site', 'navigation' ); ?>
			
		</div>
	</div><!-- .container -->

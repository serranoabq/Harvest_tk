<?php
/**
 * The branded header with navigation menu.
 *
 * @package harvest_tk
 */
?>
	<div id="site-header-container" class="container">
	
		<nav class="navbar navbar-toggleable-md navbar-light navbar-white">
		
			<button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="top: 3vw">
					<span class="navbar-toggler-icon"></span>
			</button>
			
			<?php harvest_tk_the_custom_logo( 'navbar-brand w-50' ); ?>
			
			<?php wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'depth'           => 2,
						'container'       => 'div',
						'container_id'    => 'navbarNav',
						'container_class' => 'navbar-collapse justify-content-end align-items-center collapse',
						'menu_class'      => 'navbar-nav',
						'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
						'menu_id'         => 'main-menu',
						'walker'          => new wp_bootstrap_navwalker( array( 
																																'item' => 'nav-item', 
																																'link' => 'nav-link' 
																														) ) 
					)
				); ?>
				
		</nav><!-- .navbar -->
	
	</div><!-- #site-header-container -->

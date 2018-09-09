<?php
/**
 * Some display helpers.
 *
 * @package harvest_tk
 */
 
// Allow shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');

// Make previous/next links based on some special meta argument
function harvest_tk_link_pages_by_meta( $args, $meta_args ){
	$post_id = get_the_id();
	$post_type = get_post_type();
	
	// Templates
	$nav_template = '
		<nav class="navigation post-navigation" role="navigation" aria-label="%1$s">
			<ul class="pagination justify-content-center">%2$s</ul>
		</nav>';
	$navlink_template = '<li class="page-item nav-%direction %active">%link</li>';
	$link_template = '<a class="page-link" href="%url" title="%title">%link_text</a>';
	
	// Parse display arguments
	$defaults = array(
		'prev_text'        => '%title',
		'next_text'        => '%title',
		'screen_reader_text' => __( 'Post navigation', 'harvest_tk' ),
		'echo'             => 1
	);
	$r = wp_parse_args( $args, $defaults );
	
	// Parse meta arguments
	$default_meta_args = array(
		'post_type' 	=> $post_type,
		'posts_per_page' => -1,
		'order' 			=> 'DESC',
		'orderby' 		=> 'meta_value', // Use 'meta_value', 'meta_value_num', 'meta_type'
		'meta_key' 		=> '',
		'meta_type'		=> '',
		'meta_query'	=> '',
	);
	$m = wp_parse_args( $meta_args, $default_meta_args );
	
	// Get the next/previous posts
	$pages = array();
	$nav_posts = get_posts( $m );
	foreach($nav_posts as $nav_post) {
		$pages[] += $nav_post->ID;
	}
	$current = array_search($post_id, $pages);
	$prev = $current - 1;
	$next = $current + 1;
	
	// Prepare the navigation
	$prevlink = '';
	$nextlink = '';
	if( $prev >= 0 ) {
		$prevID = $pages[ $prev ];
		$prevlink = str_replace( '%url', get_permalink( $prevID ), $link_template );
		$prevlink = str_replace( '%link_text', $r[ 'prev_text' ], $prevlink );
		$prevlink = str_replace( '%title', get_the_title( $prevID ), $prevlink );
		$prevlink = str_replace( '%direction', 'previous', $prevlink );
		$prevlink = str_replace( '%link', $prevlink, $navlink_template );
		// $prevlink = str_replace( '%active', 'disabled', $prevlink );
	}
	if( $next < count( $pages ) ) {
		$nextID = $pages[ $next ];
		$nextlink = str_replace( '%url', get_permalink( $nextID ), $link_template );
		$nextlink = str_replace( '%link_text', $r[ 'next_text' ], $nextlink );
		$nextlink = str_replace( '%title', get_the_title( $nextID ), $nextlink );
		$nextlink = str_replace( '%link', $nextlink, $navlink_template );
		$nextlink = str_replace( '%direction', 'next', $nextlink );
		// $nextlink = str_replace( '%active', 'disabled', $nextlink );
	}
	$nav_link = sprintf( $nav_template, $r[ 'screen_reader_text' ], $prevlink . $nextlink );

	if( $r[ 'echo' ] ){
		echo $nav_link;
	}
	return $nav_link;
	
}

// Get image attachment id to allow use of wp_get_attachment_image
function harvest_tk_get_attachment_id( $url ) {
	$attachment_id = 0;
	$dir = wp_upload_dir();

	if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
		$file = basename( $url );

		$query_args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'value'   => $file,
					'compare' => 'LIKE',
					'key'     => '_wp_attachment_metadata',
				),
			)
		);

		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post_id ) {
				$meta = wp_get_attachment_metadata( $post_id );
				$original_file       = basename( $meta['file'] );
				$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );

				if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
					$attachment_id = $post_id;
					break;
				}

			}
		}
	}
	return $attachment_id;
}

// Adds custom classes to the array of body classes.
function harvest_tk_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'harvest_tk_body_classes' );

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
function harvest_tk_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'harvest_tk_page_menu_args' );

// Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
function harvest_tk_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'harvest_tk_enhanced_image_navigation', 10, 2 );

// Filters wp_title to print a neat <title> tag based on what is being viewed.
function harvest_tk_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'harvest_tk' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'harvest_tk_wp_title', 10, 2 );

// Function to add an image on the header above the content
function harvest_tk_precontent(){
	if ( is_singular( array( 'ctc_sermon', 'ctc_event', 'ctc_location', 'ctc_person', 'ctcex_group', 'page', 'post' ) ) || is_tax( 'ctc_sermon_series' ) ) {
		get_template_part( 'components/ctc','image' ); 
	}
}

// Replaces the excerpt "Read More" text by a link
function harvest_tk_excerpt_more( $more ) {
	global $post; 
	return '<br/><br/><a class="moretag" href="'. get_permalink($post->ID) . '">' . __( '[Read more...]', 'harvest_tk' ) . '</a>';
}
add_filter( 'excerpt_more', 'harvest_tk_excerpt_more', 10, 2 );

// Custom pagination display
function harvest_tk_pagination(){
	global $paged, $wp_query;
	
	// Check pages
	if( empty( $paged ) ) $paged = 1;
	$pages = $wp_query->max_num_pages;
	if( ! $pages ) $pages = 1;

	// Skip pagination if only one page
	if( 1 == $pages ) 
		return;
	
	// Make translatable text
	$previous = __( 'Previous', 'harvest_tk' );
	$next = __( 'Next', 'harvest_tk' );
	
	// Prep the arrows
	$prev_arrow = '<i class="fa fa-chevron-left" aria-hidden="true"></i><span class="sr-only">' . $previous . '</span>';
	$prev_available = ( 1 == $paged ? 'disabled' : '' );
	$prev_href =  1 < $paged ? ' href="' . get_pagenum_link( $paged-1 ). '"  aria-label="'. $previous .'"' : ''; 
	$prev_link = '';
	$prev_link = '<a class="page-link"' .  $prev_href . '>' . $prev_arrow . '</a>';
	$prev_item = '<li class="page-item '. $prev_available .'">' . $prev_link . '</li>';
	
	$next_arrow = '<i class="fa fa-chevron-right" aria-hidden="true"></i><span class="sr-only">' . $next . '</span>';
	$next_available = ( $pages == $paged ? 'disabled' : '' );
	$next_link = '';
	$next_href = $pages != $paged ? ' href="' . get_pagenum_link( $paged+1 ). '"  aria-label="'. $next .'"' : '';
	$next_link = '<a class="page-link"' . $next_href . '>' . $next_arrow . '</a>';
	$next_item = '<li class="page-item '. $next_available .'">' . $next_link . '</li>';
	
	// Prepare the page links
	$start = $paged - 1;
	$end = $paged + 1;
	if( $end > $pages - 1 ) {
		$start = $start - 1;
		$end = $pages - 1;
	}
	if( $start < 2 ) { 
		$start = 2;
		$end = $end + 1 < $pages ? $end + 1 : $end;
	}
	
	if( 7 >= $pages ){
		// For 7 or fewer pages, show all items
		$page_nums = range( 1, $pages );
		$start = 2;
		$end = $pages - 1;
	} else {
		// Other cases, show first, current - 1, current, current + 1, last
		$page_nums[] = 1;
		for( $i = $start; $i <= $end; $i++ ){
			$page_nums[] = $i;
		}
		$page_nums[] = $pages;
	}
	
	$page_items = '';
	$ellipsis = '<li class="page-item disabled hidden-xs-down"><a class="page-link">...</li>';
	
	foreach( $page_nums as $i => $page ){
		if( $start == $page && 2 < $page ) {
		 $page_items .= $ellipsis;
		}
		
		$active = ( $page == $paged ) ? 'active' : 'hidden-xs-down';
		$page_items .= '<li class="page-item ' . $active .'"><a class="page-link" href="' . get_pagenum_link( $page ) . '">' . $page . '</a></li>';
		
		if( $end == $page && $pages > $page + 1 ) {
			$page_items .= $ellipsis;
		}
	}
	
?>
	<nav aria-label="<?php _e( 'Page navigation', 'harvest_tk' ); ?>">
		<ul class="pagination justify-content-center m-4">
			<?php echo $prev_item; ?>
			<?php echo $page_items; ?>
			<?php echo $next_item; ?>
		</ul>
	</nav>

<?php
}

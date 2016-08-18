<?php
/**
 * Template Name: Porfolio
 *
 * @package	hanapost
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
get_header();
	
	if ( have_posts() && is_page()) {
		the_post();
		$pt_category = get_post_meta($post->ID, '_hana_category', true);
		$column = get_post_meta($post->ID, '_hana_column', true);
		if ( '' == $column )
			$column = 1;
		$postperpage = get_post_meta($post->ID, '_hana_postperpage', true);
		if ( '' != $postperpage && $postperpage < $column)
			$postperpage = $column;
		$intro = get_post_meta($post->ID, '_hana_intro', true);
		if ( '' == $intro )
			$intro = 0;
		$sidebar = get_post_meta($post->ID, '_hana_sidebar', true);
		$entry_meta = get_post_meta($post->ID, '_hana_disp_meta', true);
		$pt_thumbnail = get_post_meta($post->ID, '_hana_thumbnail', true);
		$thumbnail = hana_thumbnail_size( $pt_thumbnail );
	} else {
		$pt_category = '';
		$intro = 0;
		$column = 1;
		$postperpage = 0;
		$entry_meta = 1;
		$sidebar = 1;
		$thumbnail = 'hana-thumb';
	}
	
	$query = array( 
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => esc_attr( $postperpage ),
		'paged'	=> 1,
		'ignore_sticky_posts' => 1,
	);
	if ( $pt_category ) {
		$query['category__in'] = esc_attr( $pt_category );
	}
		
  	$args = array(
    	'nonce' => wp_create_nonce( 'hana-load-more-nonce' ),
		'url'   => esc_url( admin_url( 'admin-ajax.php' ) ),
		'query' => $query,
		'column' => esc_attr( $column ),
		'entry_meta' => esc_attr( $entry_meta ),
		'thumbnail' => esc_attr( $thumbnail ),	
  	);
    wp_localize_script( 'hana-script', 'hanaloadmore', $args );
?>  
<div id="content" class="portfolio <?php $sidebar ? hana_grid()->content_class() : hana_grid()->fullgrid_class(); ?>" role="main">
<?php 
	if ( $intro ){ ?>
		<div class="page-intro">
			<?php the_content(); ?>
		</div>		
<?php
	}
	hanapost_display_portfolio( $query, $thumbnail, $column, $entry_meta );
?>		
</div>
<?php if ($sidebar) get_sidebar(); ?>
<?php get_footer(); ?>
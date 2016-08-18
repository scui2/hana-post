<?php
/**
 * Common Choice Functions
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
// Post Type
if ( ! function_exists( 'hana_post_types' ) ) : 
function hana_post_types() { 
	$types = array_merge(
		get_post_types( array( 'public'  => true, '_builtin' => true ) ),
		get_post_types( array( 'public'  => true, '_builtin' => false ) )
  	);
	return apply_filters( 'hana_post_types', $types );
}
endif;

//Image Size Choice
if ( ! function_exists( 'hana_thumbnail_array' ) ) : 
function hana_thumbnail_array() {
	$sizes = array (
		''			=> esc_html__( 'Thumbnail', 'hana-post' ),
		'medium'	=> esc_html__( 'Medium', 'hana-post' ),
		'large'		=> esc_html__( 'Large', 'hana-post' ),
		'full'		=> esc_html__( 'Full', 'hana-post' ),	
		'none'		=> esc_html__( 'None', 'hana-post' ),	
	);

	global $_wp_additional_image_sizes;
	if ( isset( $_wp_additional_image_sizes ) )
		foreach( $_wp_additional_image_sizes as $key => $item) 
			$sizes[ $key ] = $key;
	return apply_filters( 'hana_thumbnail_array', $sizes );
}
endif;
// Return Thumbnail
if ( ! function_exists( 'hana_thumbnail_size' ) ) : 
function hana_thumbnail_size( $size, $x = 96, $y = 96 ) {

	if ( empty( $size ) )
		return 'thumbnail';
	elseif ( 'custom' == $size ) {
		if ( ($x > 0) && ($y > 0) )
			return array( $x, $y);
		else
			return 'thumbnail';	
	}
	else 
		return $size;
}
endif;

//Categories
if ( ! function_exists( 'hana_category_choices' ) ) : 
function hana_category_choices( $inc = 'all' ) {
	$categories = get_categories();
	
	$choices = array();
	if ( 'all' == $inc )
		$choices[0] =  esc_html__( 'All Categories', 'hana-post' );
	elseif ( 'metaall' == $inc )
		$choices[''] =   esc_html__( 'All Categories', 'hana-post' );
	elseif ( 'blank' == $inc )
		$choices[''] = '';
		
	foreach ( $categories as $category )
		$choices[ $category->term_id ] = $category->name;
	return apply_filters( 'hana_category_choices', $choices );
}
endif;

//Menus
if ( ! function_exists( 'hana_menu_choices' ) ) : 
function hana_menu_choices() {
	$menus = get_terms('nav_menu');
	$choices = array();
    
	foreach ( $menus as $menu )
		$choices[ $menu->term_id ] = $menu->name;
	return apply_filters( 'hana_menu_choices', $choices );
}
endif;

//Columns
if ( ! function_exists( 'hana_column_choices' ) ) : 
function hana_column_choices( $meta = false ) {
	if ( $meta ) {
		$choices =  array( 
					''  => esc_html__( 'Full', 'hana-post'),
					'2' => esc_html__( 'Half', 'hana-post'),
					'3' => esc_html__( 'One Third', 'hana-post'),
					'4'	=> esc_html__( 'One Fourth', 'hana-post'),
					'6'	=> esc_html__( 'One Sixth', 'hana-post'));	
	} else {
		$choices =  array( 
					'1' => esc_html__( 'Full', 'hana-post'),
					'2' => esc_html__( 'Half', 'hana-post'),
					'3' => esc_html__( 'One Third', 'hana-post'),
					'4'	=> esc_html__( 'One Fourth', 'hana-post'),
					'6'	=> esc_html__( 'One Sixth', 'hana-post'));		
	}
	return apply_filters( 'hana_layout_choices', $choices );
}
endif;

// Sidebar Positions
if ( ! function_exists( 'hana_sidebar_postion_choices' ) ) : 
function hana_sidebar_postion_choices() {
    $choices = array(
        'right'    => esc_html__('Right Sidebar', 'hana-post'),
        'left'     => esc_html__('Left Sidebar', 'hana-post'),
        'both'     => esc_html__('Left & Right Sidebar', 'hana-post'),
        'none'   => esc_html__('No Sidebar', 'hana-post')
    );    
 	return apply_filters( 'hana_sidebar_postion_choices', $choices );
}
endif;
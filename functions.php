<?php
/**
 * Hana Post Functions
 * 
 * @package	hana-post
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
if ( ! defined('ABSPATH') ) exit;
// Load HANACore Framework prefix hana_
require_once( trailingslashit( get_template_directory() ) . 'core/hana-core.php' );
new HANA_Core();

add_action( 'after_setup_theme', 'hanapost_setup', 10 );
if ( ! function_exists( 'hanapost_setup' ) ):
function hanapost_setup() {
	// Load Text Domain.
	load_theme_textdomain( 'hana-post' , HANA_THEME_DIR . 'languages' );
	// Custom Logo 
	add_theme_support( 'custom-logo', array(
		'height'      => 160,
		'width'       => 600,
		'flex-height' => true,
	) );
	// Featured Image
	add_theme_support( 'post-thumbnails' );
	// Post Formats	
	add_theme_support( 'post-formats', array( 'aside', 'link', 'quote', 'gallery', 'status', 'quote', 'image', 'video', 'audio', 'chat' ) );
	// Editor Style
	add_editor_style( 'css/editor.css' );
	// Image Sizes
	add_image_size( 'hana-post-thumb', 600, 400, true); 
	// Menus
	register_nav_menus( array(
		'top-bar' => esc_html__( 'Top Menu' , 'hana-post' ),
		'section' => esc_html__( 'Section Menu' , 'hana-post' ),
		'footer'  => esc_html__( 'Footer Menu', 'hana-post' ),
		'social'  => esc_html__( 'Social Menu', 'hana-post' ),
	));
	// Hana Plugin Support
	add_theme_support( 'hana-widgets' );
	add_theme_support( 'hana-block' );
}
endif;

// Global variable for content width
add_action( 'after_setup_theme', 'hanapost_content_width', 0 );
function hanapost_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hanapost_content_width', 840 );
}

add_action( 'wp_enqueue_scripts', 'hanapost_scripts' );
if ( ! function_exists( 'hanapost_scripts' ) ):
function hanapost_scripts() {
	// Load Google Font
	$font_url = hana_font()->url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'hana-post-fonts', $font_url );
	// Load Font Awesome
	wp_enqueue_style( 'font-awesome' );
	// Load Theme Style and Script
	$deps = array( 'hana-foundation' );
	wp_enqueue_style( 'hana-post-style', HANA_THEME_URI . 'css/hana-post.css', $deps, HANA_THEME_VERSION );
	wp_enqueue_script( 'hana-post-script' , HANA_THEME_URI . 'js/hana-post.js', $deps, HANA_THEME_VERSION, true );
	$inline_handle = 'hana-post-style';
	// Load Scheme's style
	$scheme = get_theme_mod( 'color_scheme', 'default' );
    if ( 'default' != $scheme  ) {
		$schemes = hanapost_scheme_options();		
		wp_enqueue_style( 'hana-post-scheme', $schemes[ $scheme ]['css'], $inline_handle, HANA_THEME_VERSION );
		$inline_handle = 'hana-post-scheme';
	} 
	//Load child theme's style.css
    if ( HANA_THEME_URI != HANA_CHILD_URI ) {
		wp_enqueue_style( 'hana-post-child', get_stylesheet_uri(), $inline_handle, HANA_THEME_VERSION );		
		$inline_handle = 'hana-post-child';
	}
	// Add inline style based on customizer settings
    $custom_css = hanapost_custom_css();
	if ( ! empty( $custom_css ) )
	    wp_add_inline_style( $inline_handle, htmlspecialchars_decode( $custom_css ) );
}
endif;

add_action( 'widgets_init', 'hanapost_widgets_init' );
function hanapost_widgets_init() {
	$sidebars = array (
		'sidebar-full' => array(
			'name' => esc_html__( 'Blog Widget Area (Full)', 'hana-post' ),
			'description' => esc_html__( 'Blog Widget Area (Full) will not be displayed for Left & Right Sidebar', 'hana-post' ),
		),
		'sidebar-1' => array(
			'name' => esc_html__( 'Blog Widget Area 1', 'hana-post' ),
			'description' => esc_html__( 'Blog Widget Area 1', 'hana-post' ),
		),
		'sidebar-2' => array(
			'name' => esc_html__( 'Blog Widget Area 2', 'hana-post' ),
			'description' => esc_html__( 'Blog Widget Area 2', 'hana-post' ),
		),
		'footer-1' => array(
			'name' => esc_html__( 'Footer Widget Area 1', 'hana-post' ),
			'description' => esc_html__( 'Footer Widget Area 1', 'hana-post' ),
		),
		'footer-2' => array(
			'name' => esc_html__( 'Footer Widget Area 2', 'hana-post' ),
			'description' => esc_html__( 'Footer Widget Area 2', 'hana-post' ),
		),
		'footer-3' => array(
			'name' => esc_html__( 'Footer Widget Area 3', 'hana-post' ),
			'description' => esc_html__( 'Footer Widget Area 3', 'hana-post' ),
		),
		'footer-4' => array(
			'name' => esc_html__( 'Footer Widget Area 4', 'hana-post' ),
			'description' => esc_html__( 'Footer Widget Area 4', 'hana-post' ),
		),
	);
	
	foreach ( $sidebars as $id => $sidebar ) {
		register_sidebar( array(
			'id'   			=> $id,
			'name' 			=> $sidebar['name'],
			'description'   => $sidebar['description'],
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section><hr class="widget-divider">',
			'before_title'  => '<div class="widget-title-container"><h4 class="widget-title">',
			'after_title'   => '</h4></div>',
		) );
	}	
	// Home Widget
	$num = absint( apply_filters('hana_homewidget_number', 4) );
	for ( $i = 1; $i <= $num; $i++ ) {
		$column = absint( get_theme_mod( 'home_column_' . $i, 3 ) );
		if ( $column > 1 ) {
			$desc = sprintf( esc_html__('The widgets will be displayed horizontally in %1$s-column layout.', 'hana-post'), $column);	
			$col = absint( 12 / $column );
			$class = 'large-' . $col . ' columns ';	
		} else {
			$desc = '';	
			$class = '';	
		}
		// Same height for all widgets
		$width = absint( get_theme_mod( 'home_width_' . $i, 12 ) );
		if ( 12 == $width && $column > 1) {
			$watch = 'data-equalizer-watch';
		} else {
			$watch = '';
		}
		register_sidebar( array(
			'id'   			=> 'home-' . $i,
			'name' 			=> sprintf( esc_html__('Home Widget Area %1$s', 'hana-post'), $i),
			'description'   => $desc,
			'before_widget' => '<div id="%1$s" class="' . $class . 'widget %2$s" ' . $watch .  '>',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
}

function hanapost_scheme_options() {
	$schemes = array(
		'default' 	=> array(
			'label' => esc_html__('Default','hana-post'),
			'css'   => '',
		),
		'dark' 	=> array(
			'label' => esc_html__('Dark','hana-post'),
			'css'   => HANA_THEME_URI . 'css/dark.css',
		),
    );
	return apply_filters( 'hanapost_scheme_options', $schemes );
}

add_filter( 'body_class', 'hanapost_body_classes' );
if ( ! function_exists( 'hanapost_body_classes' ) ):
function hanapost_body_classes( $classes ) {		
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
	if ( ! is_page_template( array('pages/fullwidth.php', 'pages/nosidebar.php') ) && ! is_attachment() )
		$classes[] = 'sidebar-' . esc_attr( get_theme_mod( 'sidebar_pos', 'right' ) );

	return $classes;
}
endif;

if ( ! function_exists( 'hanapost_featured_top' ) ):
function hanapost_featured_top() {
    global $hana_featured_posts;

	if ( hana_has_featured_posts() ) { ?>
		<div class="featured-content clearfix">
            <div class="row collapse">
                <?php hana_layout()->display( 'block-' . esc_attr( count( $hana_featured_posts ) ) , $hana_featured_posts, 'parts/content-featured' ); ?>
            </div>
		</div>
<?php
	}
}
endif;

require_once( trailingslashit( get_template_directory() ) . 'inc/lib-template.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/customize.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/extras.php' );

<?php
/**
 * Customize Functions
 * 
 * @package	hanapost
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
function hanapost_customize_register( $wp_customize ){			
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$featured_section = $wp_customize->get_section( 'featured_content' ); //Jetpack Featured Content
	if ( !empty( $featured_section ) )
		$featured_section->priority = 22;
	$featured_section = $wp_customize->get_section( 'static_front_page' )->priority = 20;
    /*****************
	* Layout Section 
    *****************/
    $wp_customize->add_section(
        'hana_layout',
        array(
            'title'         => esc_html__('Layout', 'hana-post'),
		    'description'  => esc_html__( 'The theme uses 12-column grid system. Grid width is defined in pixels. Content and sidebar width are defined in columns. Make sure the sume of content and sidebar columns equals to 12.', 'hana-post' ),            
            'priority'      => 20,
        )
    );    		
	// Grid Width
	$wp_customize->add_setting( 'grid_width', array(
		'default'           => 1200,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'grid_width', array(
		'label'    => esc_html__( 'Grid Width (Pixel)', 'hana-post' ),
		'section'  => 'hana_layout',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
            'min'   => 960,
            'max'   => 4000,
            'step'  => 10,
        ),
	) );
	// Content Width
	$wp_customize->add_setting( 'content_column', array(
		'default'           => 8,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'content_column', array(
		'label'    => esc_html__( 'Content (Column)', 'hana-post' ),
		'section'  => 'hana_layout',
		'type'     => 'number',
		'priority' => 11,
        'input_attrs' => array(
        	'min'   => 1,
            'max'   => 12,
            'step'  => 1,
        ),
	) );
	$wp_customize->add_setting( 'sidebar1_column', array(
		'default'           => 2,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'sidebar1_column', array(
		'label'    => esc_html__( 'Sidebar 1 (Column)', 'hana-post' ),
		'section'  => 'hana_layout',
		'type'     => 'number',
		'priority' => 12,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 6,
            'step'  => 1,
        ),
	) );

	$wp_customize->add_setting( 'sidebar2_column', array(
		'default'           => 2,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'sidebar2_column', array(
		'label'    => esc_html__( 'Sidebar 2 (Column)', 'hana-post' ),
		'section'  => 'hana_layout',
		'type'     => 'number',
		'priority' => 13,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 6,
            'step'  => 1,
        ),
	) );
		
	// Sidebar Position.
	$wp_customize->add_setting( 'sidebar_pos', array(
		'default'           => 'right',
		'sanitize_callback' => 'hana_sanitize_sidebar',
	) );
	$wp_customize->add_control( 'sidebar_pos', array(
		'label'    => esc_html__( 'Sidebar Position', 'hana-post' ),
		'description'    => esc_html__( 'Blog Widget Area (Full) will not be displayed for Left & Right Sidebar', 'hana-post' ),
		'section'  => 'hana_layout',
		'type'     => 'radio',
		'choices'  => hana_sidebar_postion_choices(),
		'priority' => 40,
	) );	
	
	$wp_customize->add_setting( 'sticky_sidebar', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'sticky_sidebar', array(
		'label'    => esc_html__( 'Sticky Sidebar (Only one sidebar at each side will be sticky)', 'hana-post' ),
		'section'  => 'hana_layout',
		'type'     => 'checkbox',
		'priority' => 50,
	) );

    /*****************
	* Typography 
    *****************/
    $wp_customize->add_section(
        'hana_typo',
        array(
            'title'         => esc_html__('Typography', 'hana-post'),
		    'description'  => esc_html__( 'You can choose the font for many theme elements such as Body and Headings. Other fonts can be used to load additional web fonts and used in the custom css.', 'hana-post' ),            
            'priority'      => 20,
        )
    );
	$font_elements = apply_filters( 'hana_font_elements', array() );;
	foreach ( $font_elements as $key => $element ) {
		$wp_customize->add_setting( $key, array(
				'default'           => 'default',
			'sanitize_callback' => 'hana_sanitize_fonts',
		) );
		$wp_customize->add_control( $key, array(
			'label'    => $element['label'],
			'section'  => 'hana_typo',
			'type'     => 'select',
			'priority' => 10,
			'choices'  => hana_font()->choices(),
		) );	
	}
	
    /*****************
	* Featured Content 
    *****************/
	if ( !empty( $featured_section ) ) { //If Jetpack is active
		$wp_customize->add_setting( 'max_featured', array(
			'default'           => 10,
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'max_featured', array(
			'label'    => esc_html__( 'Maximum Featured Posts', 'hana-post' ),
			'section'  => 'featured_content',
			'type'     => 'number',
			'priority' => 40,
	        'input_attrs' => array(
	        	'min'   => 1,
	            'max'   => 99,
	            'step'  => 1,
	        ),
		) );
	} // end of featured_content	
	
    /*****************
	* Colors 
    *****************/
	$wp_customize->add_setting( 'color_scheme', array(
			'default'           => 'default',
			'sanitize_callback' => 'hanapost_sanitize_schemes',
	) );
	$wp_customize->add_control( 'color_scheme', array(
			'label'    => esc_html__('Scheme', 'hana-post'),
			'section'  => 'colors',
			'type'     => 'select',
			'priority' => 10,
			'choices'  => hanapost_scheme_choices(),
	) );
    /*****************
	* Posts 
    *****************/
    $wp_customize->add_section(
        'hana_posts',
        array(
            'title'         => esc_html__('Posts', 'hana-post'),
		    'description'  => '',            
            'priority'      => 25,
        )
    );
		
	$wp_customize->add_setting( 'hide_author', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'hide_author', array(
		'label'    => esc_html__( 'Hide Author', 'hana-post' ),
		'section'  => 'hana_posts',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
   
	$wp_customize->add_setting( 'hide_date', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'hide_date', array(
		'label'    => esc_html__( 'Hide Date', 'hana-post' ),
		'section'  => 'hana_posts',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'hide_featured', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'hide_featured', array(
		'label'    => esc_html__( 'Hide Featured Imagae in Single Post View', 'hana-post' ),
		'section'  => 'hana_posts',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
    /*****************
	* Footer 
    *****************/
    $wp_customize->add_section(
        'hana_footer',
        array(
            'title'         => esc_html__('Footer', 'hana-post'),
		    'description'  => '',            
            'priority'      => 40,
        )
    );
    
	$wp_customize->add_setting( 'footer1', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer1', array(
		'label'    => esc_html__( 'Footer Widget 1 (Column)', 'hana-post' ),
		'section'  => 'hana_footer',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 12,
            'step'  => 1,
        ),
	) );

	$wp_customize->add_setting( 'footer2', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer2', array(
		'label'    => esc_html__( 'Footer Widget 2 (Column)', 'hana-post' ),
		'section'  => 'hana_footer',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 12,
            'step'  => 1,
        ),
	) );

	$wp_customize->add_setting( 'footer3', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer3', array(
		'label'    => esc_html__( 'Footer Widget 3 (Column)', 'hana-post' ),
		'section'  => 'hana_footer',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 12,
            'step'  => 1,
        ),
	) );
	
	$wp_customize->add_setting( 'footer4', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'footer4', array(
		'label'    => esc_html__( 'Footer Widget 4 (Column)', 'hana-post' ),
		'section'  => 'hana_footer',
		'type'     => 'number',
		'priority' => 10,
        'input_attrs' => array(
        	'min'   => 0,
            'max'   => 12,
            'step'  => 1,
        ),
	) );

	$wp_customize->add_setting( 'copyright_text', array(
		'default'           => '',
		'sanitize_callback' => 'hana_sanitize_text',
	) );
	$wp_customize->add_control( 'copyright_text', array(
		'label'    => esc_html__( 'Copyright Text', 'hana-post' ),
		'section'  => 'hana_footer',
		'type'     => 'text',
		'priority' => 45,
	) );
		
	$wp_customize->add_setting( 'hide_credit', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'hide_credit', array(
		'label'    => esc_html__( 'Hide Design Credit', 'hana-post' ),
		'section'  => 'hana_footer',
		'type'     => 'checkbox',
		'priority' => 50,
	) );
    /*****************
	* Social 
    *****************/  
    $wp_customize->add_section(
        'hana_social',
        array(
            'title'         => esc_html__('Social', 'hana-post'),
		    'description'  => esc_html__( 'Choose the location where Jetpack sharing buttons are displayed.', 'hana-post'),           
            'priority'      => 50,
        )
    );
	$wp_customize->add_setting( 'share_top', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'share_top', array(
		'label'    => esc_html__( 'Display Jetpack Sharing on Top', 'hana-post' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'share_bottom', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'share_bottom', array(
		'label'    => esc_html__( 'Display Jetpack Sharing at Bottom', 'hana-post' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'social_top', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'social_top', array(
		'label'    => esc_html__( 'Display Social Menu with Top Menu', 'hana-post' ),
		'description'  => esc_html__( 'Create a custom Social Menu and choose the location to display. Supported social services will be displayed as an icon. See theme documentation for setup instruction.', 'hana-post'),           
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 20,
	) );	

	$wp_customize->add_setting( 'social_section', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'social_section', array(
		'label'    => esc_html__( 'Display Social Menu with Section Menu', 'hana-post' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 20,
	) );

	$wp_customize->add_setting( 'social_footer', array(
		'default'           => 0,
		'sanitize_callback' => 'hana_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'social_footer', array(
		'label'    => esc_html__( 'Display Social Link in Footer', 'hana-post' ),
		'section'  => 'hana_social',
		'type'     => 'checkbox',
		'priority' => 20,
	) );
    /*****************
	* Home Page 
    *****************/
	$wp_customize->add_section(
        'hana_homepage',
        array(
            'title'         => esc_html__( 'Home Page', 'hana-post'),
		    'description'  => esc_html__(  'Widgets in Home Widget Areas can be displayed horizontally. Simple specify the width and the layout for each widget area.','hana-post'),            
            'priority'      => 50,
        )
    );
    
    $num = absint( apply_filters('hana_homewidget_number', 4) );
	for ( $i = 1; $i <= $num; $i++ ) {
		// Title		
		$wp_customize->add_setting( 'home_title_' . $i, array(
			'default'           => '',
			'sanitize_callback' => 'hana_sanitize_text',
		) );
		$wp_customize->add_control( 'home_title_' . $i, array(
			'label'    => sprintf( esc_html__('Home Widget Area %1$s Title', 'hana-post'), $i),
			'section'  => 'hana_homepage',
			'type'     => 'text',
			'priority' => 10 * $i,
		) );
		// Subtitle Title		
		$wp_customize->add_setting( 'home_subtitle_' . $i, array(
			'default'           => '',
			'sanitize_callback' => 'hana_sanitize_text',
		) );
		$wp_customize->add_control( 'home_subtitle_' . $i, array(
			'label'    => esc_html__('Sub-Title', 'hana-post'),
			'section'  => 'hana_homepage',
			'type'     => 'text',
			'priority' => 10 * $i,
		) );
		// Width
		$wp_customize->add_setting( 'home_width_' . $i, array(
			'default'           => 12,
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'home_width_' . $i, array(
			'label'    => esc_html__( 'Width (Column)', 'hana-post' ),
			'section'  => 'hana_homepage',
			'type'     => 'number',
			'priority' => 10 * $i,
 	   		'input_attrs' => array(
  		    	'min'   => 0,
           	 	'max'   => 12,
           		 'step'  => 1 ),
		) );

		$wp_customize->add_setting( 'home_column_' . $i, array(
			'default'           => '3',
			'sanitize_callback' => 'hana_sanitize_columns',
		) );
		$wp_customize->add_control( 'home_column_' . $i, array(
			'label'    => esc_html__( 'Layout', 'hana-post'),
			'section'  => 'hana_homepage',
			'type'     => 'select',
			'priority' => 10 * $i,
			'choices'  => hana_column_choices(),
		) );	
	} //end for
    
}
add_action('customize_register', 'hanapost_customize_register');


function hanapost_customize_preview_js() {
	wp_enqueue_script( 'hana-customize', HANA_THEME_URI . 'js/customize.js', array( 'customize-preview' ), '20160606', true );
}
add_action( 'customize_preview_init', 'hanapost_customize_preview_js' );

function hanapost_customize_section_js() {
	wp_enqueue_script( 'hana-customize-section', HANA_THEME_URI . 'js/customize-section.js', array( 'customize-controls' ), '20160606', true );
}
add_action( 'customize_controls_enqueue_scripts', 'hanapost_customize_section_js' );

function hanapost_custom_css( ) {	
	$css = '';
	$width = get_theme_mod( 'grid_width', 1200 );
	if ( 1200 != $width ) {
		$css .= '.row {max-width: ' . esc_attr( $width ) . 'px; }' . "\n";
	}
	// Site Title text color
	if ( get_theme_mod('header_textcolor') )
		$css .= '.site-title a {color: #' . esc_attr( get_theme_mod('header_textcolor') ) . '; }' . "\n";
	// Header image as background	
	$header_image = get_header_image();
	if ( ! empty ($header_image) ) {
		$css .= '.site-header {background-image:url(' . esc_url( $header_image ) . '); }' . "\n";		
	}
	// Slider Height
	if ( get_theme_mod( 'slider_height' ) ) {
		$css .= '.hana-slide {max-height: ' . esc_attr( get_theme_mod( 'slider_height' ) ) . 'px;}' . "\n";
	}
	//Font
	$elements = apply_filters( 'hana_font_elements', NULL );
	foreach ( $elements as $key => $element ) {
		$option = get_theme_mod( $key );
		if ( $option &&  'default' != $option && !empty( $element['selector'] ) )
			$css .= $element['selector'] . ' {font-family:"' . esc_attr( hana_font()->fonts[ $option ]['name'] ) . '",' . esc_attr( hana_font()->fonts[ $option ]['type'] ) . ';}' . "\n";		
	}
	return apply_filters( 'hanapost_custom_css', $css );
}

/***********************
* Sanitize Functions 
***********************/
function hanapost_sanitize_schemes( $input ) {
    $valid = hanapost_scheme_choices();
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
/***********************
* Choices Functions 
***********************/
function hanapost_scheme_choices() {
	$schemes = hanapost_scheme_options();
	$choices = array();
	foreach ( $schemes as $key => $scheme ) {
		$choices[$key] = $scheme['label'];
	}
	return $choices;
}
/***************************************
* Custome Header and Background Support
***************************************/
add_action( 'after_setup_theme', 'hanapost_custom_header_background' );
if ( ! function_exists( 'hanapost_custom_header_background' ) ):
function hanapost_custom_header_background() {
	add_theme_support( 'custom-background', array(
		'default-color' => '', //Default background color
	) );
	$arg = array(
		'default-text-color'     => '303030',
		'width'                  => 1980,
		'height'                 => 300,
        'header-text'            => false,
		'flex-height'            => true,
	);
	add_theme_support( 'custom-header', $arg );	
}
endif;

function hanapost_font_elements( $elements ) {
	$elements = array(
		'bodyfont'      => array( 'label' => esc_html__( 'Body Font', 'hana-post'),
							 	'selector' => 'body'  ),
		'headingfont'   => array( 'label' => esc_html__( 'Heading Font', 'hana-post'),
								'selector' => 'h1, h2, h3, h4, h5, h6'  ),
		'posttitlefont' => array( 'label' => esc_html__( 'Post Title Font', 'hana-post'),
								'selector' => '.entry-title'  ),
		'sitetitlefont' => array( 'label' => esc_html__( 'Site Title Font', 'hana-post'),
								'selector' => '.site-title a'  ),
		'otherfont1' => array( 'label' => esc_html__( 'Other Font 1', 'hana-post'),
								'selector' => ''  ),
		'otherfont2' => array( 'label' => esc_html__( 'Other Font 2', 'hana-post'),
								'selector' => ''  ),
		'otherfont3' => array( 'label' => esc_html__( 'Other Font 3', 'hana-post'),
								'selector' => ''  ),
	);
	return $elements;
}
add_filter( 'hana_font_elements', 'hanapost_font_elements');

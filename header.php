<?php
/**
 * Header
 * 
 * @package	hanapost
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php } ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="off-canvas-wrapper" class="off-canvas-wrapper">
<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
	<?php get_template_part( 'parts/left', 'menu' ); ?>
<div id="wrapper" class="site off-canvas-content" data-off-canvas-content>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'hana-post' ); ?></a>
	<?php do_action('hanapost_header_top'); //Action Hook ?>
 	<header id="masthead" class="site-header">
    <?php   get_template_part( 'parts/top', 'menu' );
            get_template_part( 'parts/branding' );
            do_action('hanapost_header_banner'); //Action Hook ?>
	</header>
 <?php
    hanapost_featured_top();
    hana_archive_title(); 
	do_action('hanapost_header_before_main'); //Action Hook ?>
<div id="main" class="<?php hana_grid()->main_class(); ?>">

<?php
/**
 * Template Name: Home Page
 *
 * @package	hanapost
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
get_header(); ?>
<div id="content" class="site-content homepage" role="main">
	<div id="home-section-0" class="page-content home-section home-section-odd">
		<div class="row">
			<div class="<?php hana_grid()->fullgrid_class(); ?>">
<?php			while ( have_posts() ) {
					the_post();
					the_content();
				} ?>
			</div>
		</div>
	</div>
	<?php get_sidebar('home'); ?>
</div>
<?php get_footer(); ?>

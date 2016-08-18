<?php
/**
 * Footer
 * 
 * @package	hanapost
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
 ?>
</div><!-- main -->
<?php
 	get_sidebar( 'footer' ); ?>
<div id="footer" class="site-footer">
	<div class="<?php hana_grid()->header_row_class(); ?>">
		<div id="site-info" class="copyright medium-4 columns">
<?php 		if ( empty( get_theme_mod( 'copyright_text' ) ) ) {
				printf( '%1$s %2$s <a href="%3$s" titlte="%4$s" rel="home">%4$s</a>',
									esc_html__( 'Copyright &copy;', 'hana-post'),
									sprintf( esc_attr( date('Y') ) ),
									esc_url( home_url( '/' ) ),
									esc_attr( get_bloginfo( 'name', 'display' ) ) );	
			} else {
				echo hana_kses()->text( get_theme_mod('copyright_text') );  //Only allow a, br and em and strong tag in copyright text
			} ?>
		</div>
<?php	$menu_class ='medium-8';
		if ( get_theme_mod( 'social_footer') & has_nav_menu('social') ) { 
			$menu_class ='medium-4'; ?>
			<div class="medium-4 columns">
				<?php hana_social_menu( 'social social-footer' ); ?>
			</div>
<?php	} ?>
		<div class="<?php echo $menu_class;?> columns footer-menu">
<?php		if ( has_nav_menu('footer') ) {
				wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => '' ) ); 	
			} ?>
		</div>
	</div>
<?php
	if ( ! get_theme_mod( 'hide_credit' ) ) { ?>
		<div class="design-credit text-center <?php hana_grid()->header_row_class(); ?>">
			<a href="<?php echo esc_url( __('http://rewindcreation.com/', 'hana-post' ) ) ?>" rel="designer"><?php esc_html_e('Hana Theme by RewindCreation', 'hana-post') ?></a>
		</div>
<?php
	} ?>
	<div class="back-to-top"><a href="#"><span class="fa fa-chevron-up"></span></a></div>
</div><!-- #footer -->
</div><!-- wrapper -->
</div></div><!-- Offcanvas -->
<?php wp_footer(); ?>
</body>
</html>

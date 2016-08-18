<?php
/**
 * The template for displaying search form
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
?>
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	  	<div class="input-group">		
			<input type="text" class="search-query input-group-field" name="s" placeholder="<?php esc_attr_e( 'Search', 'hana-post' ); ?>" 
			value="<?php echo esc_attr( get_search_query() ); ?>" />
  			<div class="input-group-button">
		  		<button type="submit" class="search-submit button" name="submit" value="<?php esc_attr_e( 'Search', 'hana-post' ); ?>">
		  		<span class="fa fa-search"></span></button>
			</div>	
		</div>
	</form>

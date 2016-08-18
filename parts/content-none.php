<?php
/**
 * The template part for displaying Nothing Found message
 *
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
?>
<article id="post-0" class="post hentry no-results not-found">
	<header class="entry-header">
		<h2 class="entry-title"><?php esc_html_e( 'Nothing Found', 'hana-post' ); ?></h2>
	</header>

	<div class="entry-content">
<?php	if ( is_home() ) { ?>
			<p><?php printf( esc_html__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'hana-post' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
<?php 	} else {
			if ( is_search() ) { ?> 
				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hana-post' ); ?></p>
<?php 		} else { ?>
				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hana-post' ); ?></p>
<?php 		}
			get_search_form();
		} ?>
	</div>
</article>

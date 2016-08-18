<?php
/**
 * The template to display content in Portfolio Page
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://www.rewindcreation.com/
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-equalizer-watch>
<?php
	global $hana_thumbnail, $hana_entry_meta;
	
	if ( $has_media = hana_media()->has_media() )
		hana_media()->the_media( $hana_thumbnail, 'scale-item' );
    if ( ! has_post_format( array( 'quote', 'aside') ) ) { ?>
        <header class="entry-header">
            <?php hana_post_title(); ?>
        </header>
<?php
    }
	if ( ! $has_media ) { ?>
		<div class="entry-summary clearfix">
			<?php the_excerpt(); ?>
		</div>
<?php
	}
	hana_postmeta()->edit_link();
	if ( $hana_entry_meta && ! has_post_format( array( 'quote', 'aside') ) ) { ?>
		<footer class="entry-footer clearfix">
<?php	 	hana_postmeta()->display( array( 'comment' ), 'meta-comment' );
			hana_postmeta()->display( array( 'tag' ) );?>
		</footer>
<?php
	} ?>
</article>

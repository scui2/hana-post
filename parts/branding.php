<?php
/**
 * The template part for branding
 * 
 * @package	hana-post
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
?>

<div class="site-brand <?php hana_grid()->row_class( 'row' ); ?>">
    <?php   hana_branding(); ?>
    <div class="brand-date">
        <?php echo esc_html( date( get_option('date_format') ) ); ?>
    </div>
</div>   

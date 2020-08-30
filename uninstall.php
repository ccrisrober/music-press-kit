<?php

/* Prevent direct access outside of WordPress */
function_exists( 'add_action' ) OR exit;

/**
 * 
 * This file runs when the plugin in uninstalled (deleted).
 * This will not run when the plugin is deactivated.
 * Ideally you will add all your clean-up scripts here
 * that will clean-up unused meta, options, etc. in the database.
 *
 */

// If plugin is not being uninstalled, exit (do nothing)
if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) {

	bpk_cleanup();

} else {

	exit;

}


 /**
 * Cleanup database when plugin is uninstalled
 * @return none
 */ 

function bpk_cleanup() { 

if ( is_admin() ) { 

	delete_option ( 'music-press-kit' );

	}

}
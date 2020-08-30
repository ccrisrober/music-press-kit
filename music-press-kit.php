<?php
/*
 * Plugin Name: Music Press Kit
 * Version: 1.0.0
 * Plugin URI: www.github.com/ccrisrober/music-press-kit
 * Description: Enables music bands to easily produce a professional-quality press kit
 * Author: Cristian Rodriguez
 * Author URI: www.github.com/ccrisrober
 * Requires at least: 4.3
 * Tested up to: 4.6
 *
 * Text Domain: music-press-kit
 *
 * @package WordPress
 * @author Cristian Rodriguez
 * @since 1.0.0
 */
 
 
 /* Prevent direct access outside of WordPress */
function_exists( 'add_action' ) OR exit;

 
/**
 * Define constants
 * @return none
 */
Define( 'MPK_ROOT_856', plugin_dir_path( __FILE__ ) );
Define( 'MPK_URL_856', plugin_dir_url( __FILE__ ) );
Define( 'MPK_SETTINGS_856', admin_url( "tools.php?page=music-press-kit" ) ); 
Define( 'MPK_VERSION_856', '1.0.0' );
Define( 'MPK_LOADED_856', 'Loaded' ); 

 

/**
 * Load Plugin Files
 *@return none
 */
require_once  __DIR__ . '/inc/mpk-class.php' ;


// Only load the CMB2 library if it is not already installed elsewhere
If ( ! defined ( 'CMB2_LOADED'  ) ) {
		require_once  __DIR__ . '/lib/cmb2/init.php'; 	   
}




/**
* Add Settings Link to Plugin List
* @return array
*/
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'bpk_add_settings_link' );

function bpk_add_settings_link( $links ) {
    $settings_link = '<a href="'.admin_url( "tools.php?page=music-press-kit" ).'">' . __( 'Settings', 'plan-my-novel' ) . '</a>';
    array_unshift( $links, $settings_link );
  	return $links;
}


 

/**
* Load Plugin Text Domain
* @return none
*/
add_action( 'init', 'bpk_load_textdomain' );
  
function bpk_load_textdomain() {
  load_plugin_textdomain( 'music-press-kit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}



 /**
  * Set default settings values 
  * @return none
  */
$bpk_options = get_option( 'music-press-kit' );

if ( !$bpk_options ) {
	
	$bpk_defaults = array();
		
	$bpk_defaults['bpk_fld_display_bio'] 				= 'on';	
	$bpk_defaults['bpk_fld_display_photos'] 		= 'on';		
	$bpk_defaults['bpk_fld_display_formats'] 		= 'on';
	$bpk_defaults['bpk_fld_display_questions'] 	= 'on';	
	$bpk_defaults['bpk_fld_display_rep'] 				= 'on';	
	
	update_option( 'witer-press-kit', $bpk_defaults );

}
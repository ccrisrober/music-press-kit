<?php

/* Prevent direct access outside of WordPress */
function_exists( 'add_action' ) OR exit;



/**
 * Music Press Kit UI and Settings
 * @since 1.0.0
 */
class MusicPressKit_Admin {
	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'music-press-kit';
	/**
	 * Options page metabox id
	 * @var string
	 */
	private $metabox_id = 'mpk-metabox';
	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';
	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = 'music-press-kit';
	/**
	 * Holds an instance of the object
	 **/
	private static $instance = null;
	/**
	 * Constructor
	 * @since 1.0.0
	 */
	private function __construct() {
		// Set our title
		$this->title = __( 'Music Press Kit', 'music-press-kit' );
	}
	/**
	 * Returns the running object
	 * @return MusicPressKit_Admin
	 **/
	public static function get_instance() {
		if( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->hooks();
		}
		return self::$instance;
	}
	
	
	
	
	/**
	 * Initiate our hooks
	 * @since 1.0.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
		add_action( 'cmb2_admin_init', array( $this, 'bpk_admin_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'bpk_frontend_assets' ), 15 );	
		add_shortcode( 'music_press_kit', array( $this, 'bpk_press_page' ) );
	}
	
	
	/**
	 * Register settings with WP Settings API
	 * @since 1.0.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}
	
	
	/**
	 * Create page and menu entry
	 * @since 1.0.0
	 */
	public function add_options_page() {
		
		$this->submenu_page = add_submenu_page(
																				'tools.php',
																				$this->title, 
																				__( 'Music Press Kit', 'music-press-kit' ), 
																				'manage_options', 
																				$this->key,
																				array( $this, 'admin_page_display' )  
																				
		);
		
		
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css'  ) );
		add_action( "admin_print_styles-{$this->submenu_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
		
	}
	
	
	
	/**
	 * Load backend assets
	 * @since 1.0.0
	 */
	public function bpk_admin_assets() {
		
		if ( is_admin() && isset( $_GET['page'] ) &&  'music-press-kit'==$_GET['page'] ) {
								
			wp_enqueue_style( 'mpk-plugin', MPK_URL_856 . 'css/mpk-admin.css', array( 'cmb2-styles' ), MPK_VERSION_856 );			
			wp_enqueue_script( 'mpk-scripts', MPK_URL_856 . 'js/mpk-admin.js', array( 'jquery' ), null, true ); 				
			
		}
		
	}	
	
	
	/**
	 * Load frontend assets
	 * @since 1.0.0
	 */
	public function bpk_frontend_assets() {
		
		if ( is_single() || is_page() ) {
			//wp_enqueue_style( 'mpk-plugin', MPK_URL_856 . 'css/mpk-frontend.css', null, MPK_VERSION_856 );			
			
			global $post;
			
			// Only load on posts/pages with the plugin's shortcode			
			if ( has_shortcode( $post->post_content, 'music_press_kit' ) ) { 

					if ( ! bpk_get_option ( 'bpk_fld_disable_plugin_styles') ) {
						wp_enqueue_style( 'mpk-plugin', MPK_URL_856 . 'css/mpk-frontend.css', null, MPK_VERSION_856 );			
					}
					
					if ( ! bpk_get_option ( 'bpk_fld_disable_readmore') ) {
						wp_enqueue_script( 'mpk-more', MPK_URL_856 . 'js/readmore.js', array( 'jquery' ), null, true ); 		
						wp_enqueue_script( 'mpk-scripts', MPK_URL_856 . 'js/mpk-frontend.js', array( 'jquery' ), null, true ); 							
					}
			
				}
		
			}
		
	}	
	
	
	public function bpk_template( $path ) {

		// Look for our template in the following locations:
		// 1) Child theme directory
		// 2) Parent theme directory
		// 3) wp-content directory
		// 4) Default template directory
	
		if ( file_exists( get_stylesheet_directory() . '/music-press-kit-templates/' . $path . '.php' ) ) {
			$load = get_stylesheet_directory() . '/music-press-kit-templates/' . $path . '.php';
		} elseif ( file_exists( get_template_directory() . '/music-press-kit-templates/' . $path . '.php' ) ) {
			$load = get_template_directory() . '/music-press-kit-templates/' . $path . '.php';
		} elseif ( file_exists( WP_CONTENT_DIR . '/music-press-kit-templates/' . $path . '.php' ) ) {
			$load = WP_CONTENT_DIR . '/music-press-kit-templates/' . $path . '.php';
		} else {
			$load = WP_PLUGIN_DIR . '/music-press-kit/templates/'  . $path . '.php';
		}
		return $load;
	}


	/**
	 * Define Shortcode Output
	 * @since 1.0.0
	 */
	public function bpk_press_page( $atts ) {
		if ( !is_admin() ) {
			include $this->bpk_template( 'press-kit' );
			return;
		}
	}	
	
	
	
	
	/**
	 * Display the UI
	 * @since 1.0.0
	 */
	public function admin_page_display() {
		?>
			<div class="wrap mpk-ui cmb2-options-page <?php echo $this->key; ?>">
			<h2></span> <?php echo esc_html( get_admin_page_title() ); ?></h2>
		
		
		<div class="wrap">

						<div id="poststuff">

							<div id="post-body" class="metabox-holder columns-2">

								<!-- main content -->
								<div id="post-body-content">

									<div class="meta-box-sortables ui-sortable">

										<div class="postbox">

											<div class="handlediv" title="Click to toggle"><br></div>
											<!-- Toggle -->

											<h2 class="hndle"><span><?php esc_attr_e( 'Content for Press Kit', 'music-press-kit' ); ?></span></h2>

											
											<div class="inside">
												<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>				
												<!--</div> <!-- #mpk-settings -->												
											</div>
											
											
										</div>
										<!-- .postbox -->

									</div>
									<!-- .meta-box-sortables .ui-sortable -->

								</div>
								<!-- post-body-content -->

								<!-- sidebar -->
								<div id="postbox-container-1" class="postbox-container">

									<div class="meta-box-sortables">

										<div class="postbox">

											<div class="handlediv" title="Click to toggle"><br></div>
											<!-- Toggle -->

											<h2 class="hndle"><span><?php esc_attr_e(
														'Plugin Info', 'music-press-kit'
													); ?></span></h2>

											<div class="inside">
													<div id="mpk-plugin-info">														
														<p><span><?php esc_attr_e( 'Version' , 'music-press-kit' ); ?>: </span> <?php echo MPK_VERSION_856; ?> </p>														
														<p><span><?php esc_attr_e( 'Docs' , 'music-press-kit' ); ?>: </span> <a href="www.github.com/ccrisrober/music-press-kit">github.com/ccrisrober/music-press-kit</a> </p>	
														<p><span><?php esc_attr_e( 'Rate' , 'music-press-kit' ); ?>: </span> <a href="https://wordpress.org/plugins/music-press-kit"> <?php esc_attr_e( 'Rate the plugin' , 'music-press-kit' ); ?></a> </p>																														
												   </div>
											</div>
											<!-- .inside -->

										</div>
										<!-- .postbox -->
									

									</div>
									<!-- .meta-box-sortables -->

								</div>
								<!-- #postbox-container-1 .postbox-container -->

							</div>
							<!-- #post-body .metabox-holder .columns-2 -->

							<br class="clear">
						</div>
						<!-- #poststuff -->

			</div> <!-- .wrap -->
		
		</div> <!-- .mpk-ui -->
		

		<?php
	}
	
	
		

		
		
	
	/**
	 * Add the options metabox to the array of metaboxes
	 * @since 1.0.0
	 */
	public function add_options_page_metabox() {
		

		
		
		// hook in our save notices
		add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );
		$mpk = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => true,
			'cmb_styles' => true,

			'show_on'    => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

	
		$mpk->add_field( array(
			'name' => __( 'Biography', 'music-press-kit' ),
			'id' => 'bpk_bio',
			'type' => 'wysiwyg',
			'options' => array( 'textarea_rows' => 8, 'media_buttons' => false, 'tinymce' => true),
			'before_row' =>  '<div id="mpk-settings"><p class="mpk-group-title accordion-toggle">'.__( 'Band Profile', 'music-press-kit' ).'<span class="dashicons dashicons-arrow-down"></span><span class="dashicons dashicons-arrow-up"></p><div class="accordion-content">' ,		 	
		) );
	
		$mpk->add_field( array(
			'name' => __( 'Signature image', 'music-press-kit' ),
			'id' => 'bpk_signature',
			'type' => 'file',
		) );
	
		$mpk->add_field( array(
			'name' => __( 'Contact Us', 'music-press-kit' ),
			'id' => 'bpk_contact_url',
			'type' => 'text_email',
		) );

		$mpk->add_field( array(
		'id'   => 'bpk_close_bios',
		'type' => 'title',
		'after_row' => '</div>',		// Last row, close accordion		
		) );
	
		$mpk->add_field( array(
			'name' => __( 'Latest Video', 'music-press-kit' ),
			'id' => 'bpk_latest_video',
			'type' => 'oembed',
			'before_row' =>  '<div id="mpk-settings"><p class="mpk-group-title accordion-toggle">'.__( 'Band Media', 'music-press-kit' ).'<span class="dashicons dashicons-arrow-down"></span><span class="dashicons dashicons-arrow-up"></p><div class="accordion-content">' ,		 	
		) );
	
		$mpk->add_field( array(
			'name' => __( 'Image Gallery', 'music-press-kit' ),
			'id' => 'bpk_photo_gallery',
			'type' => 'file_list',
		) );
	
		$mpk->add_field( array(
			'name' => __( 'Last Disc Cover', 'music-press-kit' ),
			'id' => 'bpk_latest_track_image',
			'type' => 'file',
		) );
	
		$mpk->add_field( array(
			'name' => __( 'Spotify Link Last Album', 'music-press-kit' ),
			'id' => 'bpk_spotify_url',
			'type' => 'oembed',
		) );
	
		$mpk->add_field( array(
			'name' => __( 'Press Kit File', 'music-press-kit' ),
			'id' => 'bpk_press_kit',
			'type' => 'file',
		) );

		$mpk->add_field( array(
		'id'   => 'bpk_close_media',
		'type' => 'title',
		'after_row' => '</div>',		// Last row, close accordion		
		) );
		
		
		/* PLUGIN OPTIONS
		------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/		
		$mpk->add_field( array(
		'desc' => __( 'Disable the plugin\'s CSS and rely on CSS from my theme', 'music-press-kit' ),
		'id'   => 'bpk_fld_disable_plugin_styles',
		'type' => 'checkbox',	
		'before_row' => '<p>&nbsp;</p>',
		) );
		
		
	}
	
	
	/**
	 * Register settings notices for display
	 *
	 * @since 1.0.0
	 * @param  int   $object_id Option key
	 * @param  array $updated   Array of updated fields
	 * @return void
	 */
	public function settings_notices( $object_id, $updated ) {
		if ( $object_id !== $this->key || empty( $updated ) ) {
			return;
		}
		add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'myprefix' ), 'updated' );
		settings_errors( $this->key . '-notices' );
	}
	/**
	 * Public getter method for retrieving protected/private variables
	 * @since 1.0.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		throw new Exception( 'Invalid property: ' . $field );
	}
}
/**
 * Helper function to get/return the MusicPressKit_Admin object
 * @since 1.0.0
 * @return Musicprefix_Admin object
 */
function bpk_admin() {
	return MusicPressKit_Admin::get_instance();
}
/**
 * Wrapper function around cmb2_get_option
 * @since 1.0.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function bpk_get_option( $key = '' ) {
	return cmb2_get_option( bpk_admin()->key, $key );
}
// Start this instance
bpk_admin();
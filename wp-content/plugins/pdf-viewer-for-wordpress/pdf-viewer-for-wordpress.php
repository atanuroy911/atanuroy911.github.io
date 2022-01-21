<?php
/*
 * Plugin Name: PDF viewer for WordPress
 * Plugin URI: https://themencode.com/pdf-viewer-for-wordpress/
 * Description: The best PDF Reader Plugin for WordPress since 2014, Powers up your WordPress website with a smart and modern PDF Reader & FlipBook.
 * Version: 10.4
 * Author: ThemeNcode
 * Author URI: https://themencode.com
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

update_option( 'tnc_pvfw_sitekey', '**********' );
update_option( 'tnc_pvfw_purchase_code', '**********' );

// Define constants.
define( 'PVFW_PLUGIN_NAME', 'PDF viewer for WordPress' );
define( 'PVFW_PLUGIN_DIR', 'pdf-viewer-for-wordpress' );
define( 'PVFW_PLUGIN_VERSION', '10.4' );
define( 'TNC_PVFW_WEB_DIR', 'pdf-viewer-for-wordpress/web' );
define( 'TNC_PVFW_BUILD_DIR', 'pdf-viewer-for-wordpress/build' );
define( 'TNC_PVFW_RESOURCES_DIR', 'pdf-viewer-for-wordpress/tnc-resources' );

add_action( 'init', 'tnc_pvfw_autoupdate_checker' );

function tnc_pvfw_autoupdate_checker() {
	require_once plugin_dir_path( __FILE__ ) . '/admin/autoupdate.php';
	$tnc_pvfw_plugin_current_version = PVFW_PLUGIN_VERSION;
	$tnc_pvfw_plugin_remote_path     = 'https://updates.themencode.com/pvfw/update.php';
	$tnc_pvfw_plugin_slug            = plugin_basename( __FILE__ );
	$site_url_parse                  = parse_url( site_url() );
	$tnc_pvfw_domain                 = $site_url_parse['host'];
	$tnc_pvfw_license_key            = get_option( 'tnc_pvfw_sitekey' );

	new TncAutoUpdatePVFW( $tnc_pvfw_plugin_current_version, $tnc_pvfw_plugin_remote_path, $tnc_pvfw_plugin_slug, $tnc_pvfw_domain, $tnc_pvfw_license_key );
}

// Include files.
require_once plugin_dir_path( __FILE__ ) . 'admin/tnc-pdf-viewer-options.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/helper-functions.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/cpt.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/csf/codestar-framework.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/pvfw-csf-options.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/pvfw-csf-custom-field.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/pvfw-csf-sc.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/automatic-features.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/tnc_shortcodes.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/pvfw-new-shortcodes.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/scripts.php';



class TncRegisterPT {
		/**
		 * A reference to an instance of this class.
		 */
	private static $instance;
		/**
		 * The array of templates that this plugin tracks.
		 */
		protected $templates;
		/**
		 * Returns an instance of this class.
		 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new TncRegisterPT();
		}
		return self::$instance;
	}
		/**
		 * Initializes the plugin by setting filters and administration functions.
		 */
	private function __construct() {
		$this->templates = array();
		// Add a filter to the attributes metabox to inject template into the cache.
		add_filter(
			'page_attributes_dropdown_pages_args',
			array( $this, 'register_tnc_pdf_templates' )
		);
			// Add a filter to the save post to inject out template into the page cache.
		add_filter(
			'wp_insert_post_data',
			array( $this, 'register_tnc_pdf_templates' )
		);
		// Add a filter to the template include to determine if the page has our.
		// template assigned and return it's path.
		add_filter(
			'template_include',
			array( $this, 'view_tnc_pdf_template' )
		);
		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
			// 4.6 and older
			add_filter( 'page_attributes_dropdown_pages_args', array( $this, 'register_tnc_pdf_templates' ) );
		} else {
			// Add a filter to the wp 4.7 version attributes metabox.
			add_filter( 'theme_page_templates', array( $this, 'add_new_tnc_pdf_template' ) );
		}
		// Add your templates to this array.
		$this->templates = array(
			'tnc-pdf-viewer.php'           => 'PDF Viewer Template',
			'tnc-pdf-viewer-shortcode.php' => 'PDF Viewer Shortcode Template',
		);
	}
		/**
		 * Adds our template to the pages cache in order to trick WordPress
		 * into thinking the template file exists where it doens't really exist.
		 */
	public function register_tnc_pdf_templates( $atts ) {
		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		}
		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key, 'themes' );
		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );
		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );
		return $atts;
	}

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_tnc_pdf_template( $template ) {
		global $post;
		if ( ! isset(
			$this->templates[ get_post_meta(
				$post->ID,
				'_wp_page_template',
				true
			) ]
		) ) {
			return $template;
		}

		$file = plugin_dir_path( __FILE__ ) . get_post_meta(
			$post->ID,
			'_wp_page_template',
			true
		);
		// Just to be safe, we check if the file exist first.
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file; }
			return $template;
	}

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 * @param [type] $posts_templates post templates.
	 * @return array
	 */
	public function add_new_tnc_pdf_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}
}
add_action( 'plugins_loaded', array( 'TncRegisterPT', 'get_instance' ) );
register_activation_hook( __FILE__, 'pvfw_activation' );
register_deactivation_hook( __FILE__, 'pvfw_deactivation' );

/**
 * Activation function
 */
function pvfw_activation() {
	$pdf_viewer_page = pvfw_get_page_by_name( 'themencode-pdf-viewer' );

	if ( ! empty( $pdf_viewer_page ) ) {
		// do nothing
	} else {
		$themencode_pdf_viewer_page                           = array(
			'post_name'     => 'themencode-pdf-viewer',
			'post_title'    => 'ThemeNcode PDF Viewer [Do not Delete]',
			'post_content'  => 'This page is used for Viewing PDF.',
			'post_status'   => 'publish',
			'post_type'     => 'page',
			'page_template' => 'tnc-pdf-viewer.php',
		);
		$themencode_pdf_viewer_page_post_id                   = wp_insert_post( $themencode_pdf_viewer_page );
		$get_pvfw_global_settings                             = get_option( 'pvfw_csf_options' );
		$get_pvfw_global_settings['advanced-pdf-viewer-page'] = $themencode_pdf_viewer_page_post_id;
		update_option( 'pvfw_csf_options', $get_pvfw_global_settings, true );
		update_post_meta( $themencode_pdf_viewer_page_post_id, '_wp_page_template', 'tnc-pdf-viewer.php' );
	}
	$pdf_viewer_sc_page = pvfw_get_page_by_name( 'themencode-pdf-viewer-sc' );
	if ( ! empty( $pdf_viewer_sc_page ) ) {
		// page exists and is in $page.
	} else {
		$themencode_pdf_viewer_sc_page                            = array(
			'post_name'    => 'themencode-pdf-viewer-sc',
			'post_title'   => 'ThemeNcode PDF Viewer SC [Do not Delete]',
			'post_content' => 'This page is used for Viewing PDF.',
			'post_status'  => 'publish',
			'post_type'    => 'page',
		);
		$themencode_pdf_viewer_sc_page_post_id                    = wp_insert_post( $themencode_pdf_viewer_sc_page );
		$get_pvfws_global_settings                                = get_option( 'pvfw_csf_options' );
		$get_pvfws_global_settings['advanced-pdf-viewer-sc-page'] = $themencode_pdf_viewer_sc_page_post_id;
		update_option( 'pvfw_csf_options', $get_pvfws_global_settings, true );
		update_post_meta( $themencode_pdf_viewer_sc_page_post_id, '_wp_page_template', 'tnc-pdf-viewer-shortcode.php' );
	}
}

/**
 * Deactivation Function
 *
 * @return void
 */
function pvfw_deactivation() {
	// Do Nothing Right Now.
}

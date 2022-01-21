<?php
/**
 * Register Custom Post type
 *
 * @package pdf-viewer-for-wordpress
 */

if ( ! function_exists( 'tnc_pvfw_pdf_post_type' ) ) {

	/**
	 * Post Type Data
	 *
	 * @return void
	 */
	function tnc_pvfw_pdf_post_type() {

		$labels = array(
			'name'                  => _x( 'PDF Viewer', 'Post Type General Name', 'pdf-viewer-for-wordpress' ),
			'singular_name'         => _x( 'PDF Viewer', 'Post Type Singular Name', 'pdf-viewer-for-wordpress' ),
			'menu_name'             => __( 'PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'name_admin_bar'        => __( 'PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'archives'              => __( 'PDF Viewer Archives', 'pdf-viewer-for-wordpress' ),
			'attributes'            => __( 'PDF Viewer Attributes', 'pdf-viewer-for-wordpress' ),
			'parent_item_colon'     => __( 'Parent PDF Viewer:', 'pdf-viewer-for-wordpress' ),
			'all_items'             => __( 'All PDF Viewers', 'pdf-viewer-for-wordpress' ),
			'add_new_item'          => __( 'Add New PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'add_new'               => __( 'Add New', 'pdf-viewer-for-wordpress' ),
			'new_item'              => __( 'New PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'edit_item'             => __( 'Edit PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'update_item'           => __( 'Update PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'view_item'             => __( 'View PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'view_items'            => __( 'View PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'search_items'          => __( 'Search PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'not_found'             => __( 'Not found', 'pdf-viewer-for-wordpress' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'pdf-viewer-for-wordpress' ),
			'featured_image'        => __( 'Featured Image', 'pdf-viewer-for-wordpress' ),
			'set_featured_image'    => __( 'Set featured image', 'pdf-viewer-for-wordpress' ),
			'remove_featured_image' => __( 'Remove featured image', 'pdf-viewer-for-wordpress' ),
			'use_featured_image'    => __( 'Use as featured image', 'pdf-viewer-for-wordpress' ),
			'insert_into_item'      => __( 'Insert into PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'uploaded_to_this_item' => __( 'Uploaded to this PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'items_list'            => __( 'PDF Viewers list', 'pdf-viewer-for-wordpress' ),
			'items_list_navigation' => __( 'PDF Viewers list navigation', 'pdf-viewer-for-wordpress' ),
			'filter_items_list'     => __( 'Filter PDF Viewers list', 'pdf-viewer-for-wordpress' ),
		);
		$args   = array(
			'label'               => __( 'PDF Viewer', 'pdf-viewer-for-wordpress' ),
			'description'         => __( 'PDF Viewer items', 'pdf-viewer-for-wordpress' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 10,
			'menu_icon'           => plugins_url() . '/' . PVFW_PLUGIN_DIR . '/images/pdf-viewer-icon-white.svg',
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'pdfviewer', $args );

		if ( get_option( 'tnc_pvfw_permalink_flushed' ) != '1' ) {
			flush_rewrite_rules();
			update_option( 'tnc_pvfw_permalink_flushed', '1', true );
		}
	}
	add_action( 'init', 'tnc_pvfw_pdf_post_type', 0 );

}

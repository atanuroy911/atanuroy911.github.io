<?php

/**
 * @Author: Abdul Awal
 * @Date:   2021-05-11 00:04:08
 * @Last Modified by:   Abdul Awal
 * @Last Modified time: 2021-05-13 14:48:57
 */

if ( ! function_exists( 'pvfw_get_page_by_name' ) ) {
	/**
	 * Get Page by name
	 *
	 * @param  [type] $pagename [description].
	 * @return [type]           [description]
	 */
	function pvfw_get_page_by_name( $pagename ) {
		$list_all_pages = get_pages();
		foreach ( $list_all_pages as $page ) {
			if ( $page->post_name == $pagename ) {
				return $page;
			}
		}
		return false;
	}
}

if ( ! function_exists( 'tnc_mail_to_friend' ) ) {
	add_action( 'wp_ajax_tnc_mail_to_friend', 'tnc_mail_to_friend' );
	add_action( 'wp_ajax_nopriv_tnc_mail_to_friend', 'tnc_mail_to_friend' );

	function tnc_mail_to_friend() {

		if ( ! wp_verify_nonce( $_POST['nonce'], 'tnc_mail_to_friend_nonce' ) ) {
			exit( 'Invalid Request' );
		}

		$uname    = sanitize_text_field( $_POST['yourname'] );
		$fname    = sanitize_text_field( $_POST['friendsname'] );
		$sname    = $_SERVER['SERVER_NAME'];
		$uemail   = sanitize_email( $_POST['youremailaddress'] );
		$femail   = sanitize_email( $_POST['friendsemailaddress'] );
		$message  = nl2br( sanitize_textarea_field( $_POST['message'] ) );
		$link     = $share_url;
		$to       = $femail;
		$subject  = sanitize_text_field( $_POST['email_subject'] );
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
		$headers .= 'From: ' . $uname . ' <webmaster@' . $sname . '>' . "\r\n";
		$headers .= 'Reply-To:' . $uemail . "\r\n";
		$sendmail = mail( $to, $subject, $message, $headers );

		if ( $sendmail ) {
			$result['type'] = 'success';
		} else {
			$result['type'] = 'error';
		}

		if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
			$result = json_encode( $result );
			echo $result;
		}

		die();
	}
}


// Display register link if site is not registered to get updates. Added in version 8.0.
function tnc_pvfw_update_message( $plugin_data, $response ) {
	$get_site_key = get_option( 'tnc_pvfw_sitekey' );
	if ( empty( $get_site_key ) ) {
		echo " Please <a href='" . admin_url( 'admin.php?page=themencode-pdf-viewer-updates' ) . "'>register your copy</a> to get automatic updates.";
	} else {
		if ( empty( $response->package ) ) {
			echo " <a href='" . admin_url( 'update-core.php?force-check=1' ) . "'>click here</a> to refresh license";
		}
	}
}
add_action( 'in_plugin_update_message-pdf-viewer-for-wordpress/pdf-viewer-for-wordpress.php', 'tnc_pvfw_update_message', $priority = 10, $accepted_args = 2 );

// Site registration message.
function tnc_pvfw_site_registered_message() {
	$get_site_key = get_option( 'tnc_pvfw_sitekey' );
	if ( empty( $get_site_key ) ) {
		return '<div style="border: 2px solid red; color: red; padding: 10px 20px;margin: 10px 0;">You are using a non-registered version of PDF Viewer for WordPress. Please register your copy of <a href="https://codecanyon.net/item/pdf-viewer-for-wordpress/8182815/" target="_blank">PDF Viewer for WordPress</a> to receive updates & keep using without issues.<a href="' . admin_url( '/admin.php?page=themencode-pdf-viewer-updates', $scheme = 'admin' ) . '">Click Here</a> to go to registration page.<br /></div>';
	} else {
		return '';
	}
}

// Site registration message.
function tnc_pvfw_site_registered_status( $recheck ) {

	if( $recheck ){
		delete_transient( 'themencode-pdf-viewer-for-wordpress-registration' );
	}
	
	$get_site_key    = get_option( 'tnc_pvfw_sitekey' );
	$site_url_parse  = parse_url( site_url() );
	$tnc_pvfw_domain = $site_url_parse['host'];
	if ( empty( $get_site_key ) ) {
		return false;
	} else {
		$get_reg_status = get_transient( 'themencode-pdf-viewer-for-wordpress-registration' );
		if ( empty( $get_reg_status ) ) {
			$get_registration_response = wp_remote_get( 'https://updates.themencode.com/pvfw/verify.php?sitekey=' . $get_site_key . '&site_domain=' . $tnc_pvfw_domain );
			set_transient( 'themencode-pdf-viewer-for-wordpress-registration', $get_registration_response['body'], 86400 );
			$get_reg_status = $get_registration_response['body'];
			if ( $get_reg_status == 'active' ) {
				return true;
			} else {
				return false;
			}
		} else {
			if ( $get_reg_status == 'active' ) {
				return true;
			} else {
				return false;
			}
		}
	}
}

if ( ! function_exists( 'themencode_news_updates' ) ) {
	// ThemeNcode news updates on admin pages.
	// added on 31 october 2019.
	function themencode_news_updates() {
		$news = get_transient( 'themencode-news-updates' );
		if ( empty( $news ) ) {
			$get_news = wp_remote_get( 'https://updates.themencode.com/' );
			set_transient( 'themencode-news-updates', $get_news['body'], 86400 );
			$news = $get_news['body'];
		}

		return $news;
	}
}

if ( ! function_exists( 'themencode_news_updates_callback' ) ) {
	/**
	 * themencode_news_updates_callback for CSF
	 *
	 * @return [type] [description]
	 */
	function themencode_news_updates_callback() {
		$news = get_transient( 'themencode-news-updates' );
		if ( empty( $news ) ) {
			$get_news = wp_remote_get( 'https://updates.themencode.com/' );
			set_transient( 'themencode-news-updates', $get_news['body'], 86400 );
			$news = $get_news['body'];
		}

		echo $news;
	}
}

if ( ! function_exists( 'tnc_pvfw_create_viewer_url_callback' ) ) {
	/**
	 * [tnc_pvfw_create_viewer_url_callback description]
	 *
	 * @return [type] [description]
	 */
	function tnc_pvfw_create_viewer_url_callback() {
		echo sprintf( esc_html__( 'Please create PDF Viewers using %s (PDF Viewer > Add New) before creating a shortcode.', 'pdf-viewer-for-wordpress' ), '<a href="' . admin_url( '/post-new.php?post_type=pdfviewer', $scheme = 'admin' ) . '">this link</a>' );
	}
}

if ( ! function_exists( 'tnc_num_to_text' ) ) {
	// convert 0 or 1 to Show or Hide
	function tnc_num_to_text( $value ) {
		if ( $value == '1' || $value == 'true' ) {
			return 'Show';
		} else {
			return 'Hide';
		}
	}
}

if ( ! function_exists( 'tnc_pvfw_generate_file_array' ) ) {
	/**
	 * Take requested file url and return array with all the required fields to verify if the user has access.
	 *
	 * @param  $get_requested_file the requested file
	 * @return array
	 */
	function tnc_pvfw_generate_file_array( $get_requested_file ) {

		global $wpdb;

		$posts_table = $wpdb->prefix . 'posts';

		$uploadDir      = wp_upload_dir();
		$full_url       = $uploadDir['baseurl'] . $get_requested_file;
		$full_path      = $uploadDir['basedir'] . $get_requested_file;
		$fileInfo       = pathinfo( $full_path );
		$isResizedImage = false;

		$file_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$posts_table} WHERE guid = %s ", $full_url ) );

		if ( empty( $file_id ) ) {

			// Convert resized thumb url's to main file url
			$query_url = preg_replace( '/(-\d+x\d+)/', '', $full_url );

			$file_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$posts_table} WHERE guid = %s ", $query_url ) );

			if ( $file_id ) {
				$isResizedImage = true;
			}
		}

		$file_array = array(
			'id'               => $file_id,
			'file_url'         => $full_url,
			'file_path'        => $full_path,
			'is_resized_image' => $isResizedImage,
		);

		return $file_array;
	}
}

// Registration notice
function tnc_pvfw_register_pvfw_notice() {
	$get_site_key = get_option( 'tnc_pvfw_sitekey' );
	if ( empty( $get_site_key ) ) { ?>
	
	<div class="notice notice-warning is-dismissible">
		<p>
		<?php

		if ( current_user_can( 'manage_options' ) ) {
			_e( sprintf( 'Please <a href="%s">register</a> your copy of PDF Viewer for WordPress to have it working properly & get updates.', admin_url( '/edit.php?post_type=pdfviewer&page=themencode-pdf-viewer-updates' ) ), 'pdf-viewer-for-wordpress' );
		}
		?>
		</p>
	</div>
	
		<?php
	} }
add_action( 'admin_notices', 'tnc_pvfw_register_pvfw_notice' );

if ( ! function_exists( 'tnc_pvfw_single_pdf_viewer_template' ) ) {
	/* Filter the single_template with our custom function*/
	add_filter( 'single_template', 'tnc_pvfw_single_pdf_viewer_template' );

	function tnc_pvfw_single_pdf_viewer_template( $single ) {

		global $post;

		if ( $post->post_type == 'pdfviewer' ) {
			$viewer_template_file = dirname( __FILE__ ) . '/../tnc-pdf-viewer-single.php';
			if ( file_exists( $viewer_template_file ) ) {
				return $viewer_template_file;
			}
		}

		return $single;

	}
}

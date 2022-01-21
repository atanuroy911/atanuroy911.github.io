<?php
/**
 * Enqueue scripts for PDF Viewer by ThemeNcode
 *
 * Enqueue both frontend and backend scripts.
 *
 * @since 1.0
 *
 * @package pdf-viewer-by-themencode
 */

if ( ! function_exists( 'tnc_pvfw_enqueue_script' ) ) {
	/**
	 * Enqueue jquery as some themes may have jquery disabled.
	 */
	function tnc_pvfw_enqueue_script() {
		if ( is_singular( 'pdfviewer' ) || is_page_template( 'tnc-pdf-viewer-shortcode.php' ) || is_page_template( 'tnc-pdf-viewer.php' ) ) {
			global $post;
			$get_pvfw_global_settings_for_js = get_option( 'pvfw_csf_options' );
			$tnc_pvfw_custom_js              = $get_pvfw_global_settings_for_js['custom-js'];

			wp_enqueue_script( 'jquery', false, array(), false, false );
			wp_enqueue_script( 'themencode-pdf-viewer-compatibility-js', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/compatibility.js', array(), PVFW_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-pdf-js', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/build/pdf.js', array(), PVFW_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-debugger-js', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/debugger.js', array(), PVFW_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-pinch-zoom-js', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/tnc-resources/pinch-zoom.js', array(), PVFW_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-modal-js', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/tnc-resources/jquery.modal.min.js', array(), PVFW_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-viewer-js', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/viewer.js', array(), PVFW_PLUGIN_VERSION, false );

			if ( is_page_template( 'tnc-pdf-viewer-shortcode.php' ) ) {
				if ( isset( $_GET['file'] ) && ! empty( $_GET['file'] ) ) {
					$file     = esc_html( $_GET['file'] );
					$settings = esc_html( $_GET['settings'] );
				} elseif ( isset( $_GET['view'] ) && ! empty( $_GET['view'] ) ) {
					$get_data    = esc_html( $_GET['view'] );
					$decode_data = esc_html( base64_decode( $get_data ) );

					list($file_full, $settings_full, $lang_full) = explode( '&', $decode_data );
					list($file_par, $file)                       = explode( '=', $file_full );
					list($settings_par, $settings)               = explode( '=', $settings_full );
					list($lang_par, $viewer_language)            = explode( '=', $lang_full );

					$encode_file = base64_encode( $file );
				} elseif ( isset( $_GET['tnc_pvfw'] ) && ! empty( $_GET['tnc_pvfw'] ) ) {
					$get_data    = esc_html( $_GET['tnc_pvfw'] );
					$decode_data = esc_html( base64_decode( $get_data ) );

					list( $file_full, $settings_full, $lang_full ) = explode( '&', $decode_data );
					list( $file_par, $file )                       = explode( '=', $file_full );
					list( $settings_par, $settings )               = explode( '=', $settings_full );
					list( $lang_par, $viewer_language )            = explode( '=', $lang_full );

					$encode_file = base64_encode( $file );
				}

				$settings_arr = str_split( $settings );
				$get_language = $viewer_language;
				$fto          = esc_html( $encode_file );
				$download     = $settings_arr[0];
				$print        = $settings_arr[1];

				if ( isset( $settings_arr[17] ) ) {
					$scroll_default = $settings_arr[17];
				} else {
					$scroll_default = '0';
				}

				if ( isset( $settings_arr[18] ) ) {
					$spread_default = $settings_arr[18];
				} else {
					$spread_default = '0';
				}

				wp_add_inline_script(
					'themencode-pdf-viewer-pdf-js',
					'var tnc_locale = "' . esc_html( $get_language ) . '";
					var tnc_imageResourcesPath = "' . plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/images/";
					var tnc_workerSrc = "' . plugins_url() . '/' . PVFW_PLUGIN_DIR . '/build/pdf.worker.js";
					var tnc_cMapUrl = "' . plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/cmaps/";
					var tnc_cMapPacked = true;

					var fto = "' . $fto . '";
					var tnc_print = "' . $print . '";
					var tnc_dl = "' . $download . '";
					var tnc_scroll_default = ' . ( empty( $scroll_default ) ? 0 : $scroll_default ) . ';
					var tnc_spread_default = ' . ( empty( $spread_default ) ? 0 : $spread_default ) . ';',
					$position = 'after'
				);
			}

			if ( is_page_template( 'tnc-pdf-viewer.php' ) ) {
				$get_pvfw_global_settings_for_js = get_option( 'pvfw_csf_options' );
				$get_language                    = $get_pvfw_global_settings_for_js['toolbar-viewer-language'];
				$fto                             = base64_encode( esc_url( $_REQUEST['file'] ) );
				$print                           = $get_pvfw_global_settings_for_js['toolbar-print'];
				$download                        = $get_pvfw_global_settings_for_js['toolbar-download'];
				$scroll_default                  = $get_pvfw_global_settings_for_js['toolbar-default-scroll'];
				$spread_default                  = $get_pvfw_global_settings_for_js['toolbar-default-spread'];

				wp_add_inline_script(
					'themencode-pdf-viewer-pdf-js',
					'var tnc_locale = "' . $get_language . '";
					var tnc_imageResourcesPath = "' . plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/images/";
					var tnc_workerSrc = "' . plugins_url() . '/' . PVFW_PLUGIN_DIR . '/build/pdf.worker.js";
					var tnc_cMapUrl = "' . plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/cmaps/";
					var tnc_cMapPacked = true;

					var fto = "' . $fto . '";
					var tnc_print = "' . $print . '";
					var tnc_dl = "' . $download . '";
					var tnc_scroll_default = ' . ( empty( $scroll_default ) ? 0 : $scroll_default ) . ';
					var tnc_spread_default = ' . ( empty( $spread_default ) ? 0 : $spread_default ) . ';',
					$position = 'after'
				);
			}

			if ( is_singular( 'pdfviewer' ) ) {
				$get_pvfw_single_settings_for_js = get_post_meta( $post->ID, 'tnc_pvfw_pdf_viewer_fields', true );
				$get_language                    = $get_pvfw_single_settings_for_js['language'];
				$fto                             = base64_encode( $get_pvfw_single_settings_for_js['file'] );
				$print                           = $get_pvfw_single_settings_for_js['print'];
				$download                        = $get_pvfw_single_settings_for_js['download'];
				$scroll_default                  = $get_pvfw_single_settings_for_js['default_scroll'];
				$spread_default                  = $get_pvfw_single_settings_for_js['default_spread'];

				wp_add_inline_script(
					'themencode-pdf-viewer-pdf-js',
					'var tnc_locale = "' . $get_language . '";
					var tnc_imageResourcesPath = "' . plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/images/";
					var tnc_workerSrc = "' . plugins_url() . '/' . PVFW_PLUGIN_DIR . '/build/pdf.worker.js";
					var tnc_cMapUrl = "' . plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/cmaps/";
					var tnc_cMapPacked = true;

					var fto = "' . $fto . '";
					var tnc_print = "' . $print . '";
					var tnc_dl = "' . $download . '";
					var tnc_scroll_default = ' . ( empty( $scroll_default ) ? 0 : $scroll_default ) . ';
					var tnc_spread_default = ' . ( empty( $spread_default ) ? 0 : $spread_default ) . ';',
					$position = 'after'
				);
			}
			wp_enqueue_script( 'themencode-pdf-viewer-send-to-friend-js', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/tnc-resources/send-to-friend.js', array(), PVFW_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-turn-js', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/tnc-resources/turn.min.js', array(), PVFW_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-pdf-turn-js', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/pdf-turn/pdf-turn.js', array(), PVFW_PLUGIN_VERSION, false );
			wp_add_inline_script(
				'themencode-pdf-viewer-pdf-turn-js',
				$tnc_pvfw_custom_js,
				$position = 'after'
			);
		}
	}
	add_action( 'wp_enqueue_scripts', 'tnc_pvfw_enqueue_script' );
}


if ( ! function_exists( 'tnc_pvfw_enqueue_admin_css' ) ) {
	add_action( 'admin_enqueue_scripts', 'tnc_pvfw_enqueue_admin_css' );

	/**
	 * Enqueue Scripts in the admin
	 *
	 * @param  [type] $hook_suffix [description].
	 */
	function tnc_pvfw_enqueue_admin_css( $hook_suffix ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'pvfw-admin-css', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/tnc-resources/admin-css.css', array(), PVFW_PLUGIN_VERSION, $media = 'all' );
	}
}

if ( ! function_exists( 'tnc_pvfw_remove_all_scripts' ) ) {
	/**
	 * Remove all other scripts except required ones from viewer pages
	 *
	 * @return void
	 */
	function tnc_pvfw_remove_all_scripts() {
		if ( is_singular( 'pdfviewer' ) || is_page_template( 'tnc-pdf-viewer-shortcode.php' ) || is_page_template( 'tnc-pdf-viewer.php' ) ) {
			global $wp_scripts;
			$tnc_pvfw_script_handles = array( 'jquery', 'themencode-pdf-viewer-compatibility-js', 'themencode-pdf-viewer-pdf-js', 'themencode-pdf-viewer-debugger-js', 'themencode-pdf-viewer-pinch-zoom-js', 'themencode-pdf-viewer-modal-js', 'themencode-pdf-viewer-viewer-js', 'themencode-pdf-viewer-send-to-friend-js', 'themencode-pdf-viewer-turn-js', 'themencode-pdf-viewer-pdf-turn-js' );
			foreach ( $wp_scripts->registered as $single_key => $single_script ) {
				if ( ! in_array( $single_script->handle, $tnc_pvfw_script_handles ) ) {
					wp_dequeue_script( $single_script->handle );
				}
			}
		}
	}
	add_action( 'wp_print_scripts', 'tnc_pvfw_remove_all_scripts' );
}

if ( ! function_exists( 'tnc_pvfw_remove_all_styles' ) ) {
	function tnc_pvfw_remove_all_styles() {
		if ( is_singular( 'pdfviewer' ) || is_page_template( 'tnc-pdf-viewer-shortcode.php' ) || is_page_template( 'tnc-pdf-viewer.php' ) ) {
			global $wp_styles;
			$tnc_pvfw_style_handles = array( 'themencode-pdf-viewer-css', 'themencode-pdf-viewer-theme-midnight-calm', 'themencode-pdf-viewer-theme-material-blue', 'themencode-pdf-viewer-theme-aqua-white', 'themencode-pdf-viewer-modal-css', 'themencode-pdf-viewer-pdf-turn-css', 'themencode-pdf-viewer-custom-color' );
			foreach ( $wp_styles->registered as $single_key => $single_style ) {
				if ( ! in_array( $single_style->handle, $tnc_pvfw_style_handles ) ) {
					wp_dequeue_style( $single_style->handle );
				}
			}
		}
	}
	add_action( 'wp_print_styles', 'tnc_pvfw_remove_all_styles' );
}

if ( ! function_exists( 'tnc_pvfw_add_viewer_styles' ) ) {
	add_action( 'wp_enqueue_scripts', 'tnc_pvfw_add_viewer_styles' );

	function tnc_pvfw_add_viewer_styles() {
		if ( is_singular( 'pdfviewer' ) || is_page_template( 'tnc-pdf-viewer-shortcode.php' ) || is_page_template( 'tnc-pdf-viewer.php' ) ) {
			wp_enqueue_style( 'themencode-pdf-viewer-css', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/viewer.css', array(), PVFW_PLUGIN_VERSION, 'all' );
			// Load selected theme only.
			global $post;
			if ( is_singular( 'pdfviewer' ) ) {
				$get_pvfw_single_settings = get_post_meta( $post->ID, 'tnc_pvfw_pdf_viewer_fields', true );
				$get_pvfw_global_settings = get_option( 'pvfw_csf_options' );

				$get_pvfw_single_type = $get_pvfw_single_settings['appearance-select-type'];
				$get_pvfw_global_type = $get_pvfw_global_settings['appearance-select-type'];

				if ( $get_pvfw_single_settings['appearance-use-global-settings'] == '0' ) {
					if ( $get_pvfw_single_type == 'select-theme' ) {
						$get_pvfw_single_theme = $get_pvfw_single_settings['appearance-select-theme'];
						wp_enqueue_style( 'themencode-pdf-viewer-theme-' . $get_pvfw_single_theme, plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/schemes/' . $get_pvfw_single_theme . '.css', array(), PVFW_PLUGIN_VERSION, 'all' );
					} elseif ( $get_pvfw_single_type = 'custom-color' ) {

						$get_pvfw_single_primary_color   = str_replace( '#', '', $get_pvfw_single_settings['appearance-select-colors']['primary-color'] );
						$get_pvfw_single_secondary_color = str_replace( '#', '', $get_pvfw_single_settings['appearance-select-colors']['secondary-color'] );
						$get_pvfw_single_text_color      = str_replace( '#', '', $get_pvfw_single_settings['appearance-select-colors']['text-color'] );
						$get_pvfw_single_icon_color      = $get_pvfw_single_settings['appearance-select-icon'];

						wp_enqueue_style( 'themencode-pdf-viewer-custom-color', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/schemes/custom.php?primary=' . $get_pvfw_single_primary_color . '&secondary=' . $get_pvfw_single_secondary_color . '&text=' . $get_pvfw_single_text_color . '&icon=' . $get_pvfw_single_icon_color, array(), PVFW_PLUGIN_VERSION, 'all' );
					}
				} else {
					if ( $get_pvfw_global_type == 'select-theme' ) {
						$get_pvfw_global_theme = $get_pvfw_global_settings['appearance-select-theme'];
						wp_enqueue_style( 'themencode-pdf-viewer-theme-' . $get_pvfw_global_theme, plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/schemes/' . $get_pvfw_global_theme . '.css', array(), PVFW_PLUGIN_VERSION, 'all' );
					} elseif ( $get_pvfw_global_type = 'custom-color' ) {

						$get_pvfw_global_primary_color   = str_replace( '#', '', $get_pvfw_global_settings['appearance-select-colors']['primary-color'] );
						$get_pvfw_global_secondary_color = str_replace( '#', '', $get_pvfw_global_settings['appearance-select-colors']['secondary-color'] );
						$get_pvfw_global_text_color      = str_replace( '#', '', $get_pvfw_global_settings['appearance-select-colors']['text-color'] );
						$get_pvfw_global_icon_color      = $get_pvfw_global_settings['appearance-select-icon'];

						wp_enqueue_style( 'themencode-pdf-viewer-custom-color', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/schemes/custom.php?primary=' . $get_pvfw_global_primary_color . '&secondary=' . $get_pvfw_global_secondary_color . '&text=' . $get_pvfw_global_text_color . '&icon=' . $get_pvfw_global_icon_color, array(), PVFW_PLUGIN_VERSION, 'all' );
					}
				}
			} else {
				$get_pvfw_global_settings = get_option( 'pvfw_csf_options' );
				$get_pvfw_global_type     = $get_pvfw_global_settings['appearance-select-type'];

				if ( $get_pvfw_global_type == 'select-theme' ) {
					$get_pvfw_global_theme = $get_pvfw_global_settings['appearance-select-theme'];
					wp_enqueue_style( 'themencode-pdf-viewer-theme-' . $get_pvfw_global_theme, plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/schemes/' . $get_pvfw_global_theme . '.css', array(), PVFW_PLUGIN_VERSION, 'all' );
				} elseif ( $get_pvfw_global_type = 'custom-color' ) {

					$get_pvfw_global_primary_color   = str_replace( '#', '', $get_pvfw_global_settings['appearance-select-colors']['primary-color'] );
					$get_pvfw_global_secondary_color = str_replace( '#', '', $get_pvfw_global_settings['appearance-select-colors']['secondary-color'] );
					$get_pvfw_global_text_color      = str_replace( '#', '', $get_pvfw_global_settings['appearance-select-colors']['text-color'] );
					$get_pvfw_global_icon_color      = $get_pvfw_global_settings['appearance-select-icon'];

					wp_enqueue_style( 'themencode-pdf-viewer-custom-color', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/schemes/custom.php?primary=' . $get_pvfw_global_primary_color . '&secondary=' . $get_pvfw_global_secondary_color . '&text=' . $get_pvfw_global_text_color . '&icon=' . $get_pvfw_global_icon_color, array(), PVFW_PLUGIN_VERSION, 'all' );
				}
			}
			wp_enqueue_style( 'themencode-pdf-viewer-modal-css', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/tnc-resources/jquery.modal.min.css', array(), PVFW_PLUGIN_VERSION, 'all' );
			wp_enqueue_style( 'themencode-pdf-viewer-pdf-turn-css', plugins_url() . '/' . PVFW_PLUGIN_DIR . '/web/pdf-turn/pdf-turn.css', array(), PVFW_PLUGIN_VERSION, 'all' );
			$get_pvfw_global_settings = get_option( 'pvfw_csf_options' );
			$get_pvfw_custom_css      = $get_pvfw_global_settings['custom-css'];
			wp_add_inline_style(
				'themencode-pdf-viewer-pdf-turn-css',
				$get_pvfw_custom_css
			);
		}
	}
}

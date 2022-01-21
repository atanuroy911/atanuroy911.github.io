<?php
/**
 * Plugin Name: Embed Any Document Plus
 * Plugin URI: http://awsm.in/ead-plus-documentation/
 * Description: Embed Any Document WordPress plugin lets you upload and embed your documents easily in your WordPress website without any additional browser plugins like Flash or Acrobat reader. The plugin lets you choose between Google Docs Viewer and Microsoft Office Online to display your documents.
 * Version: 2.6.0
 * Author: Awsm Innovations
 * Author URI: http://awsm.in
 * License: GPL V3
 * Text Domain: embed-any-document-plus
 * Domain Path: /language
 *
 * @package embed-any-document-plus
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EAD_PLUS', true );
define( 'EAD_PLUS_VERSION', '2.6.0' );

/**
 * Embed Any Document Plus Main Class.
 */
class Ead_Plus {
	/**
	 * The instance of the class.
	 *
	 * @var Ead_Plus
	 */
	private static $instance = null;

	/**
	 * Plugin path.
	 *
	 * @var string
	 */
	private $plugin_path = '';

	/**
	 * Plugin url.
	 *
	 * @var string
	 */
	private $plugin_url = '';

	/**
	 * Plugin directory name.
	 *
	 * @var string
	 */
	private $plugin_base = '';

	/**
	 * Current file path.
	 *
	 * @var string
	 */
	private $plugin_file = __FILE__;

	/**
	 * Plugin Version.
	 *
	 * @var string
	 */
	private $plugin_version = EAD_PLUS_VERSION;

	/**
	 * Settings page slug.
	 *
	 * @var string
	 */
	private $settings_slug = 'ead-plus-settings';

	/**
	 * The URL of the plugin's metadata file.
	 *
	 * @var string
	 */
	private $meta_url = 'https://kernl.us/api/v1/updates/59043132ecdf270f2afe5d76/';

	/**
	 * Plugin slug.
	 *
	 * @var string
	 */
	private $plugin_slug = 'embed-any-document-plus';

	/**
	 * Creates or returns an instance of this class.
	 */
	public static function get_instance() {
		 // If an instance hasn't been created and set to $instance create an instance and set it to $instance.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Pro Exists Check.
	 */
	public static function pro_exists() {
		return self::$instance;
	}

	/**
	 * Initializes the plugin by setting localization, hooks, filters, and administrative functions.
	 */
	public function __construct() {
		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->plugin_url  = plugin_dir_url( __FILE__ );
		$this->plugin_base = dirname( plugin_basename( __FILE__ ) );

		// Language Support.
		$this->load_plugin_textdomain();

		// Plugin init.
		add_action( 'init', array( $this, 'wp_plugin_update' ) );

		// embeddoc shortcode support.
		add_shortcode( 'embeddoc', array( $this, 'embed_shortcode' ) );

		// default options.
		register_activation_hook( $this->plugin_file, array( $this, 'defaults' ) );

		// Initialize block.
		include_once $this->plugin_path . 'blocks/class-ead-plus-guten-blocks.php';

		add_action( 'wp_loaded', array( $this, 'register_scripts' ) );
		add_filter( 'script_loader_tag', array( $this, 'script_loader_tag' ), 10, 3 );

		$this->adminfunctions();
	}

	/**
	 * Load Localization files.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'embed-any-document-plus', false, basename( dirname( __FILE__ ) ) . '/language/' );
	}

	/**
	 * Register admin Settings style.
	 */
	public function setting_styles() {
		wp_register_style( 'embed-settings', plugins_url( 'css/settings.min.css', $this->plugin_file ), false, $this->plugin_version, 'all' );
		wp_enqueue_style( 'embed-settings' );
	}

	/**
	 * Embed any Docs Button.
	 *
	 * @param string $editor_id Unique editor identifier.
	 */
	public function embedbutton( $editor_id ) {
		$btn_text = __( 'Add Document', 'embed-any-document-plus' );
		$btn_icon = sprintf( '<img src="%1$s" alt="%2$s" role="presentation" /> ', esc_url( plugins_url( 'images/ead-small.png', __FILE__ ) ), esc_attr( $btn_text ) );

		printf( '<a href="javascript:void(0);" class="awsm-embed button" title="%2$s" data-target="%3$s">%1$s</a>', $btn_icon . esc_html( $btn_text ), esc_attr( $btn_text ), esc_attr( $editor_id ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Admin Easy access settings link.
	 *
	 * @param array $action_links Plugin action links.
	 * @return array Plugin action links with ead settings link included.
	 */
	public function settingslink( $action_links ) {
		$settings_link = '<a href="options-general.php?page=' . esc_attr( $this->settings_slug ) . '">' . esc_html__( 'Settings', 'embed-any-document-plus' ) . '</a>';
		array_unshift( $action_links, $settings_link );
		return $action_links;
	}

	/**
	 * Embed Form popup.
	 */
	public function embedpopup() {
		if ( wp_script_is( 'ead_media_button' ) ) {
			add_thickbox();
			include $this->plugin_path . 'inc/popup.php';
		}
	}

	/**
	 * Register admin scripts.
	 */
	public function embed_helper() {
		$script_deps = array( 'jquery' );
		if ( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			if ( method_exists( $screen, 'is_block_editor' ) && $screen->is_block_editor() ) {
				$script_deps[] = 'wp-blocks';
			}
		}
		$app_key = get_option( 'ead_dropbox' );
		if ( ! empty( $app_key ) ) {
			$script_deps[] = 'awsm-ead-dropboxjs';
		}
		wp_enqueue_script( 'ead_media_button', plugins_url( 'js/ead.min.js', $this->plugin_file ), $script_deps, $this->plugin_version, true );
		wp_enqueue_style( 'ead_media_button', plugins_url( 'css/embed.min.css', $this->plugin_file ), false, $this->plugin_version, 'all' );
		wp_localize_script( 'ead_media_button', 'emebeder', $this->embedjsdata() );
	}

	/**
	 * Localize array.
	 *
	 * @return array l10n data.
	 */
	public function embedjsdata() {
		$jsdata = array(
			'viewers'       => array_keys( self::get_viewers() ),
			'height'        => get_option( 'ead_height', '500px' ),
			'width'         => get_option( 'ead_width', '100%' ),
			'download'      => get_option( 'ead_download', 'none' ),
			'viewer'        => get_option( 'ead_provider', 'google' ),
			'text'          => get_option( 'ead_text', __( 'Download', 'embed-any-document-plus' ) ),
			'gpicker_view'  => get_option( 'ead_gpicker_view', 'file' ),
			'cache'         => 0,
			'insert_text'   => __( 'Select', 'embed-any-document-plus' ),
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'site_url'      => site_url( '/' ),
			'validtypes'    => $this->validembedtypes(),
			'msextension'   => $this->validextensions( 'ms' ),
			'drextension'   => $this->validextensions( 'all' ),
			'nocontent'     => __( 'Nothing to insert', 'embed-any-document-plus' ),
			'nopublic'      => __( 'The document you have chosen is a not public.', 'embed-any-document-plus' ) . __( ' Only the owner and explicitly shared collaborators will be able to view it.', 'embed-any-document-plus' ),
			'invalidurl'    => __( 'Invalid URL', 'embed-any-document-plus' ),
			'from_url'      => __( 'From URL', 'embed-any-document-plus' ),
			'pluginname'    => __( 'Embed Any Document Plus', 'embed-any-document-plus' ),
			'no_api'        => __( 'No API key', 'embed-any-document-plus' ),
			'driveapiKey'   => false,
			'driveclientId' => false,
			'boxapikey'     => false,
			'DropboxApi'    => false,
		);
		if ( get_option( 'ead_drivekey' ) && get_option( 'ead_driveClient' ) ) {
			$jsdata['driveapiKey']   = get_option( 'ead_drivekey' );
			$jsdata['driveclientId'] = get_option( 'ead_driveClient' );
		}
		if ( get_option( 'ead_dropbox' ) ) {
			$jsdata['DropboxApi'] = get_option( 'ead_dropbox' );
		}
		if ( get_option( 'ead_box' ) ) {
			$jsdata['boxapikey'] = get_option( 'ead_box' );
		}
		return $jsdata;
	}

	/**
	 * Check whether the file is viewable by browser or not by checking the file URL.
	 *
	 * @param string $url The file URL.
	 * @return boolean
	 */
	public static function is_browser_viewable_type( $url ) {
		$is_viewable = false;
		$types       = array( 'pdf', 'txt' );
		$splitted    = explode( '.', $url );
		$extension   = end( $splitted );
		if ( ! empty( $extension ) ) {
			if ( in_array( strtolower( trim( $extension ) ), $types, true ) ) {
				$is_viewable = true;
			}
		}
		return $is_viewable;
	}

	/**
	 * Get the iframe preloader content.
	 *
	 * @param array $shortcode_atts The shortcode attributes.
	 */
	public static function get_iframe_preloader( $shortcode_atts ) {
		if ( ! isset( $shortcode_atts['viewer'] ) || ! isset( $shortcode_atts['url'] ) ) {
			return;
		}

		$document_url = '#';
		if ( $shortcode_atts['viewer'] === 'google' ) {
			if ( self::is_browser_viewable_type( $shortcode_atts['url'] ) ) {
				$document_url = $shortcode_atts['url'];
			} else {
				$src          = 'https://docs.google.com/viewer?url=%1$s&hl=%2$s';
				$document_url = sprintf( $src, rawurlencode( $shortcode_atts['url'] ), esc_attr( $shortcode_atts['language'] ) );
			}
		}

		ob_start();
		?>
			<div class="ead-document-loading" style="width:100%;height:100%;position:absolute;left:0;top:0;z-index:10;">
				<div class="ead-loading-wrap">
					<div class="ead-loading-main">
						<div class="ead-loading">
							<img src="<?php echo esc_url( plugins_url( 'images/loading.svg', __FILE__ ) ); ?>" width="55" height="55" alt="<?php esc_html_e( 'Loader', 'embed-any-document-plus' ); ?>">
							<span><?php esc_html_e( 'Loading...', 'embed-any-document-plus' ); ?></span>
						</div>
					</div>
					<div class="ead-loading-foot">
						<div class="ead-loading-foot-title">
							<img src="<?php echo esc_url( plugins_url( 'images/EAD-logo.svg', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'EAD Logo', 'embed-any-document-plus' ); ?>" width="36" height="23"/>
							<span><?php esc_html_e( 'Taking too long?', 'embed-any-document-plus' ); ?></span>
						</div>
						<p>
							<div class="ead-document-btn ead-reload-btn" role="button">
								<img src="<?php echo esc_url( plugins_url( 'images/reload.svg', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Reload', 'embed-any-document-plus' ); ?>" width="12" height="12"/> <?php esc_html_e( 'Reload document', 'embed-any-document-plus' ); ?>
							</div>
							<span>|</span>
							<a href="<?php echo esc_url( $document_url ); ?>" class="ead-document-btn" target="_blank">
								<img src="<?php echo esc_url( plugins_url( 'images/open.svg', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Open', 'embed-any-document-plus' ); ?>" width="12" height="12"/> <?php esc_html_e( 'Open in new tab', 'embed-any-document-plus' ); ?>
							</a>
					</div>
				</div>
			</div>
		<?php
		$preloader = ob_get_clean();

		/**
		 * Customize the document preloader.
		 *
		 * @since 2.4.0
		 *
		 * @param string $preloader The preloader content.
		 * @param array $shortcode_atts The shortcode attributes.
		 */
		return apply_filters( 'awsm_ead_preloader', $preloader, $shortcode_atts );
	}

	/**
	 * Get public script data.
	 *
	 * @return array
	 */
	public function get_public_script_data() {
		/**
		 * Customize the public script data.
		 *
		 * @since 2.4.0
		 *
		 * @param array $script_data The script data.
		 */
		$script_data = apply_filters(
			'awsm_ead_public_script_data',
			array(
				'pdfjs' => '',
			)
		);
		return $script_data;
	}

	/**
	 * Register scripts for both back-end and front-end use.
	 */
	public function register_scripts() {
		wp_register_style( 'awsm-ead-plus-public', plugins_url( 'css/embed-public.min.css', $this->plugin_file ), array(), $this->plugin_version, 'all' );

		wp_register_script( 'awsm-ead-dropboxjs', '//www.dropbox.com/static/api/2/dropins.js', array(), '2', false );
		wp_register_script( 'awsm-ead-pdf-object', plugins_url( 'js/pdfobject.min.js', $this->plugin_file ), array(), $this->plugin_version, true );
		wp_register_script( 'awsm-ead-plus-public', plugins_url( 'js/embed-public.min.js', $this->plugin_file ), array( 'jquery', 'awsm-ead-pdf-object' ), $this->plugin_version, true );

		wp_localize_script( 'awsm-ead-plus-public', 'eadPublic', $this->get_public_script_data() );
	}

	/**
	 * Customize the script tag of an enqueued script.
	 *
	 * @param string $tag The script tag for the enqueued script.
	 * @param string $handle The script's registered handle.
	 * @param string $src The script's source URL.
	 * @return string
	 */
	public function script_loader_tag( $tag, $handle, $src ) {
		if ( $handle === 'awsm-ead-dropboxjs' ) {
			$app_key = get_option( 'ead_dropbox' );
			if ( ! empty( $app_key ) ) {
				// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
				$tag = sprintf( '<script type="text/javascript" src="%1$s" id="dropboxjs" data-app-key="%2$s"></script>', esc_url( $src ), esc_attr( $app_key ) );
			}
		}
		return $tag;
	}

	/**
	 * Get the supported viewers.
	 *
	 * @return array
	 */
	public static function get_viewers() {
		$viewers = array(
			'dropbox'   => __( 'Dropbox', 'embed-any-document-plus' ),
			'google'    => __( 'Google Docs Viewer', 'embed-any-document-plus' ),
			'browser'   => __( 'Browser Based', 'embed-any-document-plus' ),
			'microsoft' => __( 'Microsoft Office Online', 'embed-any-document-plus' ),
		);
		/**
		 * Customize the supported viewers.
		 *
		 * @since 2.4.0
		 *
		 * @param array $viewers Viewers array.
		 */
		return apply_filters( 'awsm_ead_viewers', $viewers );
	}

	/**
	 * Get all providers.
	 *
	 * @return array
	 */
	public static function get_all_providers() {
		$providers = array( 'google', 'microsoft', 'browser', 'dropbox', 'drive', 'box' );
		/**
		 * Customize the providers.
		 *
		 * @since 2.4.0
		 *
		 * @param array $providers Providers array.
		 */
		return apply_filters( 'awsm_ead_providers', $providers );
	}

	/**
	 * Generate style attribute from attributes array.
	 *
	 * @param array $attrs Attributes array.
	 * @return string
	 */
	public static function build_style_attr( $attrs ) {
		$style = 'style="';
		foreach ( $attrs as $property => $value ) {
			$style .= sprintf( '%1$s: %2$s;', esc_attr( $property ), esc_attr( $value ) );
		}
		$style .= '"';
		return $style;
	}

	/**
	 * Main Shortcode.
	 *
	 * @param array $atts The shortcode attributes.
	 * @return string Shortcode output content.
	 */
	public function embed_shortcode( $atts ) {
		$embed            = '';
		$durl             = '';
		$default_width    = $this->sanitize_dims( get_option( 'ead_width', '100%' ) );
		$default_height   = $this->sanitize_dims( get_option( 'ead_height', '500px' ) );
		$default_provider = get_option( 'ead_provider', 'google' );
		$default_download = get_option( 'ead_download', 'none' );
		$default_filesize = get_option( 'ead_filesize', 'yes' );
		$default_text     = get_option( 'ead_text', __( 'Download', 'embed-any-document-plus' ) );
		$show             = false;
		$shortcode_atts   = shortcode_atts(
			array(
				'url'      => '',
				'drive'    => '',
				'id'       => false,
				'width'    => $default_width,
				'height'   => $default_height,
				'language' => 'en',
				'text'     => $default_text,
				'viewer'   => $default_provider,
				'download' => $default_download,
				'cache'    => 'on',
				'boxtheme' => 'dark',
			),
			$atts
		);

		wp_enqueue_style( 'awsm-ead-plus-public' );
		if ( $shortcode_atts['viewer'] === 'dropbox' ) {
			wp_enqueue_script( 'awsm-ead-dropboxjs' );
		}
		wp_enqueue_script( 'awsm-ead-plus-public' );

		if ( isset( $shortcode_atts['url'] ) || isset( $shortcode_atts['id'] ) ) :
			// AMP.
			$is_amp = function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();

			$url       = esc_url(
				$shortcode_atts['url'],
				array(
					'http',
					'https',
				)
			);
			$durl      = '';
			$viewer    = $shortcode_atts['viewer'];
			$providers = self::get_all_providers();

			if ( ! in_array( $viewer, $providers, true ) ) {
				$viewer                   = 'google';
				$shortcode_atts['viewer'] = 'google';
			}

			$is_browser_viewer = false;
			if ( $shortcode_atts['viewer'] === 'browser' ) {
				// fallback for Browser viewer.
				$is_browser_viewer = true;
				$viewer            = 'google';
				// AMP handling.
				if ( $is_amp ) {
					$is_browser_viewer = false;
				}
			}
			$is_builtin_viewer = $shortcode_atts['viewer'] === 'built-in' ? true : false;

			if ( $this->allowdownload( $viewer ) ) {
				if ( $shortcode_atts['download'] === 'alluser' || $shortcode_atts['download'] === 'all' ) {
					$show = true;
				} elseif ( $shortcode_atts['download'] === 'logged' && is_user_logged_in() ) {
					$show = true;
				}
			}

			if ( $show ) {
				$filesize   = 0;
				$size_label = '';
				if ( $default_filesize === 'yes' ) {
					$filedata = wp_remote_head( $shortcode_atts['url'] );
					if ( ! is_wp_error( $filedata ) && isset( $filedata['headers']['content-length'] ) ) {
						$filesize   = $this->human_filesize( $filedata['headers']['content-length'] );
						$size_label = " [{$filesize}]";
					}
				}
				$durl = '<p class="embed_download"><a href="' . esc_url( $shortcode_atts['url'] ) . '" download>' . esc_attr( $shortcode_atts['text'] ) . esc_html( $size_label ) . '</a></p>';
			}

			if ( $shortcode_atts['cache'] === 'off' && $viewer === 'google' ) {
				if ( $this->url_get_param( $url ) ) {
					$url .= '?' . time();
				} else {
					$url .= '&' . time();
				}
			}

			$iframe_src = '';
			switch ( $viewer ) {
				case 'google':
					$src_format = '//docs.google.com/viewer?url=%1$s&embedded=true&hl=%2$s';
					$iframe_src = sprintf( $src_format, rawurlencode( $url ), esc_attr( $shortcode_atts['language'] ) );
					break;

				case 'microsoft':
					$src_format = '//view.officeapps.live.com/op/embed.aspx?src=%1$s';
					$iframe_src = sprintf( $src_format, rawurlencode( $url ) );
					break;

				case 'drive':
					if ( $shortcode_atts['id'] ) {
						$src_format = '//drive.google.com/file/d/%s/preview';
						$iframe_src = sprintf( $src_format, $shortcode_atts['id'] );
					} else {
						$iframe_src = $url;
					}
					break;

				case 'box':
					$iframe_src = $this->boxembed( $url, rawurlencode( $shortcode_atts['boxtheme'] ) );
					break;
			}

			$iframe_style_attrs = array();
			$doc_style_attrs    = array(
				'position' => 'relative',
			);
			if ( $this->check_responsive( $shortcode_atts['height'] ) && $this->check_responsive( $shortcode_atts['width'] ) && ! $is_browser_viewer && ! $is_builtin_viewer && $viewer !== 'dropbox' ) {
				$iframe_style_attrs             = array(
					'width'    => '100%',
					'height'   => '100%',
					'border'   => 'none',
					'position' => 'absolute',
					'left'     => '0',
					'top'      => '0',
				);
				$doc_style_attrs['padding-top'] = '90%';
			} else {
				$iframe_style_attrs = array(
					'width'  => $shortcode_atts['width'],
					'height' => $shortcode_atts['height'],
					'border' => 'none',
				);
				if ( $this->in_percentage( $shortcode_atts['height'] ) ) {
					$iframe_style_attrs['min-height'] = '500px';
					if ( $viewer === 'dropbox' ) {
						$iframe_style_attrs['height'] = '500px';
					}
				}
			}

			$enable_preloader = ! $is_amp && ( $viewer === 'google' || $is_builtin_viewer || $viewer === 'dropbox' );

			if ( $enable_preloader ) {
				$iframe_style_attrs['visibility'] = 'hidden';
			}

			$data_attr = '';
			if ( $is_browser_viewer || $is_builtin_viewer ) {
				$data_attr = sprintf( ' data-pdf-src="%1$s" data-viewer="%2$s"', esc_url( $shortcode_atts['url'] ), esc_attr( $shortcode_atts['viewer'] ) );

				$doc_style_attrs = array_merge( $doc_style_attrs, $iframe_style_attrs );
				unset( $doc_style_attrs['visibility'] );

				if ( $is_builtin_viewer ) {
					$script_data = $this->get_public_script_data();
					if ( isset( $script_data['pdfjs'] ) && ! empty( $script_data['pdfjs'] ) ) {
						$iframe_src = $script_data['pdfjs'] . '?file=' . rawurlencode( $url );
					}
				}
			} elseif ( $viewer === 'dropbox' ) {
				$data_attr       = sprintf( ' data-viewer="%s"', esc_attr( $shortcode_atts['viewer'] ) );
				$doc_style_attrs = array_merge( $doc_style_attrs, $iframe_style_attrs );
				unset( $doc_style_attrs['visibility'] );
			}

			$iframe = '';
			if ( $viewer === 'dropbox' ) {
				$url    = str_replace( 'dl=1', 'dl=0', $url );
				$iframe = sprintf( '<a href="%s" class="dropbox-embed" data-height="%s" data-width="%s"></a>', $url, esc_attr( $iframe_style_attrs['height'] ), esc_attr( $iframe_style_attrs['width'] ) );
			} else {
				$iframe_style = self::build_style_attr( $iframe_style_attrs );
				$iframe       = sprintf( '<iframe src="%s" title="%s" class="ead-iframe" %s></iframe>', esc_url( $iframe_src ), esc_html__( 'Embedded Document', 'embed-any-document-plus' ), $iframe_style );
			}

			if ( $enable_preloader ) {
				$iframe = '<div class="ead-iframe-wrapper">' . $iframe . '</div>' . self::get_iframe_preloader( $shortcode_atts );
			}

			$doc_style = self::build_style_attr( $doc_style_attrs );
			$embed     = sprintf( '<div class="ead-preview"><div class="ead-document" %3$s>%1$s</div>%2$s</div>', $iframe, $durl, $doc_style . $data_attr );
		else :
			$embed = esc_html__( 'No Url Found', 'embed-any-document-plus' );
		endif;

		/**
		 * Customize the shortcode content.
		 *
		 * @since 2.4.0
		 *
		 * @param string $embed The embedded content.
		 * @param array $shortcode_atts The shortcode attributes.
		 */
		$embed = apply_filters( 'awsm_ead_content', $embed, $shortcode_atts );

		return $embed;
	}

	/**
	 * Check value in percentage.
	 *
	 * @since 1.2
	 * @param string $dim Value to be checked.
	 * @return bool
	 */
	public function in_percentage( $dim ) {
		if ( strstr( $dim, '%' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Enable Responsive.
	 *
	 * @since 1.2
	 * @param string $dim Value to be checked.
	 * @return bool
	 */
	public function check_responsive( $dim ) {
		if ( strstr( $dim, '%' ) ) {
			$dim = preg_replace( '/[^0-9]*/', '', $dim );
			if ( (int) $dim === 100 ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Private File Style.
	 */
	public function private_style() {
		echo '<style type="text/css">
        .ead-document{ position:relative;}
        .ead-private{ position:absolute; width: 100%; height: 100%; left:0; top:0; background:rgba(248,237,235,0.8); text-align: center;}
        .ead-lock{ display: inline-block; vertical-align: middle;max-width: 98%;}
        .ead-dummy{ display: inline-block; vertical-align: middle; height:100%; width: 1px;}
    </style>';
	}

	/**
	 * Admin menu setup.
	 */
	public function admin_menu() {
		$eadsettings = add_options_page( 'Embed Any Document Plus', 'Embed Any Document Plus', 'manage_options', $this->settings_slug, array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $eadsettings, array( $this, 'setting_styles' ) );
	}

	/**
	 * Admin settings page.
	 */
	public function settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'default' ) );
		}

		include $this->plugin_path . 'inc/settings.php';
	}

	/**
	 * Register Settings.
	 */
	public function register_eadsettings() {
		register_setting( 'ead-settings-group', 'ead_width', array( $this, 'sanitize_dims' ) );
		register_setting( 'ead-settings-group', 'ead_height', array( $this, 'sanitize_dims' ) );
		register_setting( 'ead-settings-group', 'ead_download' );
		register_setting( 'ead-settings-group', 'ead_filesize' );
		register_setting( 'ead-settings-group', 'ead_provider' );
		register_setting( 'ead-settings-group', 'ead_text' );
		register_setting( 'ead-settings-group', 'ead_gpicker_view' );
		register_setting( 'ead-settings-envato', 'ead_envato_key', array( $this, 'envato_verify' ) );
		register_setting( 'ead-cloud-group', 'ead_drivekey' );
		register_setting( 'ead-cloud-group', 'ead_driveClient' );
		register_setting( 'ead-cloud-group', 'ead_dropbox' );
		register_setting( 'ead-cloud-group', 'ead_box' );
	}

	/**
	 * Admin Functions init.
	 */
	public function adminfunctions() {
		if ( is_admin() ) {
			add_action( 'wp_enqueue_media', array( $this, 'embed_helper' ) );
			add_action( 'admin_footer', array( $this, 'embedpopup' ) );
			add_action( 'wp_head', array( $this, 'private_style' ) );
			add_action( 'media_buttons', array( $this, 'embedbutton' ), 1000 );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_init', array( $this, 'register_eadsettings' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'settingslink' ) );
			add_action( 'after_plugin_row_' . plugin_basename( __FILE__ ), array( $this, 'plugin_row' ), 11, 3 );
			add_filter( 'upload_mimes', array( $this, 'additional_mimes' ) );
			add_action( 'admin_notices', array( $this, 'purchase_key_notice' ) );
			add_filter( 'puc_manual_check_link-embed-any-document-plus', array( $this, 'check_for_update' ) );
		}
	}

	/**
	 * Adds additional mime type for media uploader.
	 *
	 * @param array $mimes Mime types.
	 * @return array An array with additional mime types added.
	 */
	public function additional_mimes( $mimes ) {
		return array_merge(
			$mimes,
			array(
				'svg' => 'image/svg+xml',
				'ai'  => 'application/postscript',
			)
		);
	}

	/**
	 * To get Overlay link.
	 *
	 * @param string|array $keys Option name.
	 * @param string       $id 'id' attribute value for anchor tag.
	 * @param string       $provider Service provider.
	 */
	public function providerlink( $keys, $id, $provider ) {
		if ( $this->isprovider_api( $keys ) ) {
			$link      = 'options-general.php?page=' . $this->settings_slug . '&tab=cloud';
			$id        = '';
			$configure = sprintf( '<span class="overlay"><strong>%s</strong><i></i></span>', esc_html__( 'Configure', 'embed-any-document-plus' ) );
			$target    = 'target="_blank"';
		} else {
			$configure = '';
			$link      = '#';
			$target    = '';
		}

		$imageurl = $this->plugin_url . 'images/icon-' . strtolower( $provider ) . '.png';
		/* translators: %1$s: Service provider */
		$linktext = sprintf( __( 'Add from %1$s', 'embed-any-document-plus' ), $provider );

		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		printf(
			wp_kses(
				'<a href="%1$s" id="%2$s" %3$s><span><img src="%4$s" alt="%2$s" />%5$s %6$s</span></a>',
				array(
					'a'    => array(
						'href'   => array(),
						'id'     => array(),
						'target' => array(),
					),
					'span' => array(),
					'img'  => array(
						'src' => array(),
						'alt' => array(),
					),
				)
			),
			esc_url( $link ),
			esc_attr( $id ),
			$target,
			esc_url( $imageurl ),
			esc_html( $linktext ),
			$configure
		);
		// phpcs:enable
	}

	/**
	 * To initialize default options.
	 */
	public function defaults() {
		$defaults = array(
			'ead_width'       => '100%',
			'ead_height'      => '500px',
			'ead_download'    => 'none',
			'ead_provider'    => 'google',
			'ead_mediainsert' => '1',
			'ead_filesize'    => 'yes',
		);
		foreach ( $defaults as $name => $value ) {
			if ( ! get_option( $name ) ) {
				update_option( $name, $value );
			}
		}
	}

	/**
	 * Dropdown Builder.
	 *
	 * @param string $name 'name' attribute value.
	 * @param array  $options Array of choices.
	 * @param mixed  $selected Optional. One of the values to compare. Default empty.
	 * @param string $class Optional. 'class' attribute value. Default empty.
	 * @param string $attr Optional. Other attributes. Default empty.
	 */
	public function selectbuilder( $name, $options, $selected = '', $class = '', $attr = '' ) {
		if ( is_array( $options ) ) :
			$select_html = '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" class="' . esc_attr( $class ) . '" ' . $attr . '>';
			foreach ( $options as $key => $option ) {
				$selected_html = '';
				if ( $key === $selected ) {
					$selected_html = ' selected="selected"';
				}
				$select_html .= '<option value="' . esc_attr( $key ) . '" ' . $selected_html . '>' . esc_html( $option ) . '</option>';
			}
			echo $select_html .= '</select>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		endif;
	}

	/**
	 * Human Readable filesize.
	 *
	 * @param int|string $bytes Number of bytes.
	 * @param int        $decimals Optional. Precision of number of decimal places. Default 2.
	 * @return string Human readable file size.
	 */
	public function human_filesize( $bytes, $decimals = 2 ) {
		$size   = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
		$factor = floor( ( strlen( $bytes ) - 1 ) / 3 );
		$size   = isset( $size[ $factor ] ) ? $size[ $factor ] : '';
		return sprintf( "%.{$decimals}f ", $bytes / pow( 1024, $factor ) ) . $size;
	}

	/**
	 * Sanitize dimensions (width, height).
	 *
	 * @param string $dim Value to be sanitized.
	 * @return string|bool Sanitized dimensions or false if value is invalid.
	 */
	public function sanitize_dims( $dim ) {
		// remove any spacing junk.
		$dim = trim( str_replace( ' ', '', $dim ) );

		if ( ! strstr( $dim, '%' ) ) {
			$type = 'px';
			$dim  = preg_replace( '/[^0-9]*/', '', $dim );
		} else {
			$type = '%';
			$dim  = preg_replace( '/[^0-9]*/', '', $dim );
			if ( (int) $dim > 100 ) {
				$dim = '100';
			}
		}

		if ( $dim ) {
			return $dim . $type;
		} else {
			return false;
		}
	}

	/**
	 * Get box.com embed url.
	 *
	 * @param string $url document url.
	 * @param string $theme box theme.
	 * @return string box.com embed url.
	 */
	public function boxembed( $url, $theme ) {
		$src     = '';
		$boxdata = parse_url( $url );
		if ( isset( $boxdata['host'] ) && isset( $boxdata['path'] ) ) {
			$src = sprintf( '//%s/embed/%s?theme=%s', untrailingslashit( $boxdata['host'] ), ltrim( $boxdata['path'], '/' ), $theme );
		}
		return esc_url( $src );
	}

	/**
	 * Get valid mime types list.
	 *
	 * @return array valid mime types.
	 */
	public function validmimetypes() {
		$mimetypes = array(
			// Text formats.
			'txt|asc|c|cc|h'  => 'text/plain',
			'rtx'             => 'text/richtext',
			'css'             => 'text/css',
			// Misc application formats.
			'js'              => 'application/javascript',
			'pdf'             => 'application/pdf',
			'ai'              => 'application/postscript',
			'tif'             => 'image/tiff',
			'tiff'            => 'image/tiff',
			// MS Office formats.
			'doc'             => 'application/msword',
			'pot|pps|ppt'     => 'application/vnd.ms-powerpoint',
			'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
			'docx'            => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'dotx'            => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
			'dotm'            => 'application/vnd.ms-word.template.macroEnabled.12',
			'xlsx'            => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'xlsm'            => 'application/vnd.ms-excel.sheet.macroEnabled.12',
			'pptx'            => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'ppsx'            => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
			// iWork formats.
			'pages'           => 'application/vnd.apple.pages',
			// Additional Mime Types.
			'svg'             => 'image/svg+xml',
		);
		return $mimetypes;
	}

	/**
	 * Checks Url Validity.
	 *
	 * @param string $url Document Url.
	 * @return bool
	 */
	public function validtype( $url ) {
		$doctypes = $this->validmimetypes();
		if ( is_array( $doctypes ) ) {
			$allowed_ext = implode( '|', array_keys( $doctypes ) );
			if ( preg_match( "/\.($allowed_ext)$/i", $url ) ) {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * Get allowed Mime Types.
	 *
	 * @return string Mimetypes
	 */
	public function validembedtypes() {
		$doctypes    = $this->validmimetypes();
		$allowedtype = implode( ',', $doctypes );
		return $allowedtype;
	}

	/**
	 * Get allowed Extensions.
	 *
	 * @param string $list Optional. 'all' extensions or 'ms' only extensions. Default 'all'.
	 * @return string Comma-separated extenstions list.
	 */
	public function validextensions( $list = 'all' ) {
		 $extensions['all'] = array( '.css', '.js', '.pdf', '.ai', '.tif', '.tiff', '.doc', '.txt', '.asc', '.c', '.cc', '.h', '.pot', '.pps', '.ppt', '.xla', '.xls', '.xlt', '.xlw', '.docx', '.dotx', '.dotm', '.xlsx', '.xlsm', '.pptx', '.pages', '.svg', '.ppsx' );
		$extensions['ms']   = array( '.doc', '.pot', '.pps', '.ppt', '.xla', '.xls', '.xlt', '.xlw', '.docx', '.dotx', '.dotm', '.xlsx', '.xlsm', '.pptx', '.ppsx' );
		$allowedtype        = implode( ',', $extensions[ $list ] );
		return $allowedtype;
	}

	/**
	 * Get allowed Mime Types for Microsoft.
	 *
	 * @return array Mimetypes.
	 */
	public function microsoft_mimes() {
		$micro_mime = array(
			'doc'             => 'application/msword',
			'pot|pps|ppt'     => 'application/vnd.ms-powerpoint',
			'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
			'docx'            => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'dotx'            => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
			'dotm'            => 'application/vnd.ms-word.template.macroEnabled.12',
			'xlsx'            => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'xlsm'            => 'application/vnd.ms-excel.sheet.macroEnabled.12',
			'pptx'            => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
		);
		return $micro_mime;
	}

	/**
	 * Check Allow Download.
	 *
	 * @param string $provider Service provider.
	 * @return bool
	 */
	public function allowdownload( $provider ) {
		$blacklist = array(
			'drive',
			'box',
		);
		if ( in_array( $provider, $blacklist, true ) ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Check Provider API.
	 *
	 * @param string|array $keys Option name.
	 * @return bool
	 */
	public function isprovider_api( $keys ) {
		$itemflag = false;
		if ( is_array( $keys ) ) {
			foreach ( $keys as $key ) {
				if ( ! get_option( $key ) ) {
					$itemflag = true;
					break;
				}
			}
		} else {
			if ( ! get_option( $keys ) ) {
				$itemflag = true;
			}
		}
		return $itemflag;
	}

	/**
	 * Get Active Menu Class.
	 *
	 * @param string $tab One of the values to compare.
	 * @param string $needle The other value to compare.
	 * @return string Menu class name.
	 */
	public function getactive_menu( $tab, $needle ) {
		$class_name = '';
		if ( $tab === $needle ) {
			$class_name = ' nav-tab-active';
		}
		return $class_name;
	}

	/**
	 * Checks for url query parameter.
	 *
	 * @since 1.1
	 * @param string $url Document url.
	 * @return bool
	 */
	public function url_get_param( $url ) {
		$urldata = parse_url( $url );
		if ( isset( $urldata['query'] ) ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Wp Plugin updater integration for automatic plugin update.
	 *
	 * @since 2.1
	 */
	public function wp_plugin_update() {
		$license_key = get_option( 'ead_envato_key' );
		if ( $license_key ) {
			require_once $this->plugin_path . 'lib/plugin_update_check.php';
			$ead_updates          = new PluginUpdateChecker_2_0( $this->meta_url, __FILE__, $this->plugin_slug, 1 );
			$ead_updates->license = $license_key;
		}
	}

	/**
	 * Envato Purchase code verification.
	 *
	 * @since 2.1.0
	 * @param string $purchase_key Envato purchase key.
	 * @return string|bool Valid purchase key or false if key is invalid.
	 */
	public function envato_verify( $purchase_key ) {
		$options      = array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json',
			),
		);
		$args['code'] = rawurlencode( $purchase_key );
		$url          = add_query_arg( $args, $this->meta_url );
		$result       = wp_remote_get( $url, $options );
		if ( ! is_wp_error( $result ) && isset( $result['response']['code'] ) && ( intval( $result['response']['code'] ) === 200 ) && ! empty( $result['body'] ) ) {
			return $purchase_key;
		} else {
			add_settings_error( 'ead_envato_key', 'api_error', __( 'Invalid Envato purchase key', 'embed-any-document-plus' ), 'error' );
			return false;
		}
	}

	/**
	 * To show message to enter purchase code.
	 *
	 * @since 2.1.0
	 */
	public function plugin_row() {
		$license_key = get_option( 'ead_envato_key' );
		if ( ! $license_key ) {
			$url = 'options-general.php?page=' . $this->settings_slug . '&tab=updates';
			/* translators: %s: link to settings page to add the license key */
			$notice = sprintf( wp_kses( __( 'Please <a href="%s">activate your copy</a> of Embed Any Document Plus to receive automatic updates.', 'embed-any-document-plus' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( $url ) );
			?>
			<tr class="notice inline notice-warning notice-alt">
				<td colspan="3" class="plugin-update">
					<div class="update-message"><span class="bd-licence-activate-notice"><?php echo $notice; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
				</td>
			</tr>
			<?php
		}
	}

	/**
	 * To show admin notice to enter purchase for automatic updates.
	 *
	 * @since 2.1.0
	 */
	public function purchase_key_notice() {
		if ( current_user_can( 'install_plugins' ) && ! get_option( 'ead_envato_key' ) ) {
			$class = 'notice notice-error';
			$url   = 'options-general.php?page=' . $this->settings_slug . '&tab=updates';
			/* translators: %s: link to settings page to add the license key */
			$notice = sprintf( wp_kses( __( 'Please <a href="%s">activate your copy</a> of Embed Any Document Plus to receive automatic updates.', 'embed-any-document-plus' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( $url ) );
			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $notice ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * To hide update check link.
	 *
	 * @since 2.1.0
	 * @return bool
	 */
	public function check_for_update() {
		return false;
	}
}

Ead_Plus::get_instance();

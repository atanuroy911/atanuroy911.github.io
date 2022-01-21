<?php
/**
 * CSF custom fields for pdfviewer post type
 *
 * @package  pdf-viewer-for-wordpress
 */

// Control core classes for avoid errors.
if ( class_exists( 'CSF' ) ) {

	$prefix = 'tnc_pvfw_pdf_viewer_fields';

	// Create a metabox.
	CSF::createMetabox(
		$prefix,
		array(
			'title'     => esc_html__( 'PDF Viewer Settings', 'pdf-viewer-for-wordpress' ),
			'post_type' => 'pdfviewer',
		)
	);

	CSF::createSection(
		$prefix,
		array(
			'title'  => esc_html__( 'Basic Settings', 'pdf-viewer-for-wordpress' ),
			'fields' => array(
				array(
					'type'  => 'subheading',
					'title' => esc_html__( 'Basic Settings', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'id'         => 'file',
					'type'       => 'upload',
					'title'      => 'PDF File',
					'subtitle'   => esc_html__( 'Select or Upload a PDF File', 'pdf-viewer-for-wordpress' ),
					'attributes' => array(
						'required' => 'required',
					),
				),

				array(
					'id'      => 'default_scroll',
					'type'    => 'select',
					'title'   => 'Default Scrolling Mode',
					'options' => array(
						'0' => 'Vertical',
						'1' => 'Horizontal',
						'2' => 'Wrapped',
						'3' => 'Flip',
					),
					'default' => '3',
				),

				array(
					'id'      => 'default_spread',
					'type'    => 'select',
					'title'   => 'Default Spread',
					'options' => array(
						'0' => 'None',
						'1' => 'ODD',
						'2' => 'EVEN',
					),
					'default' => '0',
				),

				array(
					'id'          => 'language',
					'type'        => 'select',
					'title'       => 'Viewer Language',
					'placeholder' => 'Select Language',
					'options'     => array(
						'en-US' => 'en-US',
						'ach'   => 'ach',
						'af'    => 'af',
						'ak'    => 'ak',
						'an'    => 'an',
						'ar'    => 'ar',
						'as'    => 'as',
						'ast'   => 'ast',
						'az'    => 'az',
						'be'    => 'be',
						'bg'    => 'bg',
						'bn-BD' => 'bn-BD',
						'bn-IN' => 'bn-IN',
						'br'    => 'br',
						'bs'    => 'bs',
						'ca'    => 'ca',
						'cs'    => 'cs',
						'csb'   => 'csb',
						'cy'    => 'cy',
						'da'    => 'da',
						'de'    => 'de',
						'el'    => 'el',
						'en-GB' => 'en-GB',
						'en-ZA' => 'en-ZA',
						'eo'    => 'eo',
						'es-AR' => 'es-AR',
						'es-CL' => 'es-CL',
						'es-ES' => 'es-ES',
						'es-MX' => 'es-MX',
						'et'    => 'et',
						'eu'    => 'eu',
						'fa'    => 'fa',
						'ff'    => 'ff',
						'fi'    => 'fi',
						'fr'    => 'fr',
						'fy-NL' => 'fy-NL',
						'ga-IE' => 'ga-IE',
						'gd'    => 'gd',
						'gl'    => 'gl',
						'gu-IN' => 'gu-IN',
						'he'    => 'he',
						'hi-IN' => 'hi-IN',
						'hr'    => 'hr',
						'hu'    => 'hu',
						'hy-AM' => 'hy-AM',
						'id'    => 'id',
						'is'    => 'is',
						'it'    => 'it',
						'ja'    => 'ja',
						'ka'    => 'ka',
						'kk'    => 'kk',
						'km'    => 'km',
						'kn'    => 'kn',
						'ko'    => 'ko',
						'ku'    => 'ku',
						'lg'    => 'lg',
						'lij'   => 'lij',
						'lt'    => 'lt',
						'lv'    => 'lv',
						'mai'   => 'mai',
						'mk'    => 'mk',
						'ml'    => 'ml',
						'mn'    => 'mn',
						'mr'    => 'mr',
						'ms'    => 'ms',
						'my'    => 'my',
						'nb-NO' => 'nb-NO',
						'nl'    => 'nl',
						'nn-NO' => 'nn-NO',
						'nso'   => 'nso',
						'oc'    => 'oc',
						'or'    => 'or',
						'pa-IN' => 'pa-IN',
						'pl'    => 'pl',
						'pt-BR' => 'pt-BR',
						'pt-PT' => 'pt-PT',
						'rm'    => 'rm',
						'ro'    => 'ro',
						'ru'    => 'ru',
						'rw'    => 'rw',
						'sah'   => 'sah',
						'si'    => 'si',
						'sk'    => 'sk',
						'sl'    => 'sl',
						'son'   => 'son',
						'sq'    => 'sq',
						'sr'    => 'sr',
						'sv-SE' => 'sv-SE',
						'sw'    => 'sw',
						'ta'    => 'ta',
						'ta-LK' => 'ta-LK',
						'te'    => 'te',
						'th'    => 'th',
						'tl'    => 'tl',
						'tn'    => 'tn',
						'tr'    => 'tr',
						'uk'    => 'uk',
						'ur'    => 'ur',
						'vi'    => 'vi',
						'wo'    => 'wo',
						'xh'    => 'xh',
						'zh-CN' => 'zh-CN',
						'zh-TW' => 'zh-TW',
						'zu'    => 'zu',
					),
					'default'     => 'en-US',
				),

				array(
					'id'       => 'return-link',
					'type'     => 'text',
					'title'    => esc_html__( 'Return to Site Link', 'pdf-viewer-for-wordpress' ),
					'subtitle' => esc_html__( 'Enter the url where the Return to site button on bottom right should link to. Keeping blank will use the previous page link.', 'pdf-viewer-for-wordpress' ),
				),
			),
		)
	);

	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Toolbar Elements',
			'fields' => array(
				array(
					'type'    => 'subheading',
					'content' => 'Want to use Global Settings?',
				),

				array(
					'id'      => 'toolbar-elements-use-global-settings',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Use Global Settings', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'Toolbar Elements Visibility', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'id'         => 'download',
					'type'       => 'switcher',
					'title'      => 'Download',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'print',
					'type'       => 'switcher',
					'title'      => 'Print',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'fullscreen',
					'type'       => 'switcher',
					'title'      => 'Fullscreen',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'zoom',
					'type'       => 'switcher',
					'title'      => 'Zoom',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'open',
					'type'       => 'switcher',
					'title'      => 'Open',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'pagenav',
					'type'       => 'switcher',
					'title'      => 'Pagenav',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'find',
					'type'       => 'switcher',
					'title'      => 'Find',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'current_view',
					'type'       => 'switcher',
					'title'      => 'Current View',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'share',
					'type'       => 'switcher',
					'title'      => 'Share',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'toggle_left',
					'type'       => 'switcher',
					'title'      => 'Toggle Left Menu',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'toggle_menu',
					'type'       => 'switcher',
					'title'      => 'Toggle Right Menu',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'rotate',
					'type'       => 'switcher',
					'title'      => 'Rotate',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'logo',
					'type'       => 'switcher',
					'title'      => 'Logo',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'handtool',
					'type'       => 'switcher',
					'title'      => 'Handtool',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'scroll',
					'type'       => 'switcher',
					'title'      => 'Scroll',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'doc_prop',
					'type'       => 'switcher',
					'title'      => 'Document Properties',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
				array(
					'id'         => 'spread',
					'type'       => 'switcher',
					'title'      => 'Spread',
					'default'    => true,
					'dependency' => array( 'toolbar-elements-use-global-settings', '==', false ),
				),
			),
		)
	);

	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Appearance',
			'fields' => array(

				array(
					'type'    => 'subheading',
					'content' => 'Want to use Global Settings?',
				),

				array(
					'id'      => 'appearance-use-global-settings',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Use Global Settings', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),


				array(
					'type'    => 'subheading',
					'content' => 'Customize the look of your PDF Viewer Here',
				),

				array(
					'id'          => 'appearance-select-type',
					'type'        => 'select',
					'title'       => esc_html__( 'Do you want to use a Theme or use custom colors?', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select an option',
					'options'     => array(
						'select-theme' => 'Theme',
						'custom-color' => 'Custom Color (Defined Below)',
					),
					'default'     => 'select-theme',
					'dependency'  => array( 'appearance-use-global-settings', '==', false ),
				),

				array(
					'id'          => 'appearance-select-theme',
					'type'        => 'select',
					'title'       => esc_html__( 'Select Theme', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select an option',
					'options'     => array(
						'aqua-white'    => 'Aqua White',
						'material-blue' => 'Material Blue',
						'midnight-calm' => 'Midnight Calm',
					),
					'default'     => 'midnight-calm',
					'dependency'  => array( 'appearance-select-type|appearance-use-global-settings', '==|==', 'select-theme|false' ),
				),

				array(
					'id'         => 'appearance-select-colors',
					'type'       => 'color_group',
					'title'      => 'Select Colors',
					'options'    => array(
						'primary-color'   => 'Primary Color',
						'secondary-color' => 'Secondary Color',
						'text-color'      => 'Text Color',
					),
					'dependency' => array( 'appearance-select-type|appearance-use-global-settings', '==|==', 'custom-color|false' ),
				),

				array(
					'id'          => 'appearance-select-icon',
					'type'        => 'select',
					'title'       => esc_html__( 'Icon Style', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select an option',
					'options'     => array(
						'dark-icons'  => 'Dark',
						'light-icons' => 'Light',
					),
					'dependency'  => array( 'appearance-select-type|appearance-use-global-settings', '==|==', 'custom-color|false' ),
				),
			),
		)
	);

	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Privacy/Security',
			'fields' => array(
				array(
					'type'    => 'subheading',
					'content' => 'Need to protect PDF file access to specific pdf files?',
				),

				array(
					'type'    => 'content',
					'content' => '<a href="https://codecanyon.net/item/wp-file-access-manager/26430349" target="_blank">WP File Access Manager</a> can help you to protect each and every pdf files on your website. You can set permissions for each pdf files (as well as any other file type) by user, user role, user login status. Its also compatible with WooCommerce and Paid Memberships Pro plugins.',
				),

				array(
					'type'    => 'content',
					'content' => 'Note: If you\'re using nginx web server, you need to be able to add a rule to your nginx config, otherwise WP File Access Manager won\'t be able to work.',
				),

				array(
					'type'    => 'content',
					'content' => '<a class="button button-primary" href="https://codecanyon.net/item/wp-file-access-manager/26430349" target="_blank">Get WP File Access Manager now!</a>',
				),

				array(
					'type'    => 'subheading',
					'content' => 'Customize Messages Displayed',
				),

				array(
					'type'    => 'content',
					'content' => 'Following settings are only valid when you have WP File Access Manager installed and activated.',
				),

				array(
					'id'         => 'wfam-error-heading',
					'type'       => 'text',
					'title'      => esc_html__( 'Error Heading', 'pdf-viewer-for-wordpress' ),
					'attributes' => array(
						'placeholder' => esc_html__( 'SORRY', 'pdf-viewer-for-wordpress' ),
					),
				),

				array(
					'id'         => 'wfam-error-content',
					'type'       => 'textarea',
					'title'      => esc_html__( 'Error Content', 'pdf-viewer-for-wordpress' ),
					'attributes' => array(
						'placeholder' => esc_html__( 'You do not have permission to view this file, please contact us if you think this was by a mistake.', 'pdf-viewer-for-wordpress' ),
					),
				),

				array(
					'id'         => 'wfam-error-btn-text',
					'type'       => 'text',
					'title'      => esc_html__( 'Error Button Text', 'pdf-viewer-for-wordpress' ),
					'attributes' => array(
						'placeholder' => esc_html__( 'Go To Homepage', 'pdf-viewer-for-wordpress' ),
					),
				),

				array(
					'id'         => 'wfam-error-btn-url',
					'type'       => 'text',
					'title'      => esc_html__( 'Error Button URL', 'pdf-viewer-for-wordpress' ),
					'attributes' => array(
						'placeholder' => home_url(),
					),
				),
			),
		)
	);
}

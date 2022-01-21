<?php
/**
 * PDF Viewer Global Settings Page
 *
 * All the settings are here, Powered by CSF.
 *
 * @since 10.0
 *
 * @package pdf-viewer-for-wordpress
 */

// Control core classes for avoid errors.
if ( class_exists( 'CSF' ) ) {
	$prefix = 'pvfw_csf_options';

	// Create options.
	CSF::createOptions(
		$prefix,
		array(
			'framework_title' => 'PDF Viewer for WordPress <small>by <a href="https://themencode.com" target="_blank" style="color: #fff;">ThemeNcode</a></small>',
			'framework_class' => '',

			'menu_title'      => 'Global Settings',
			'menu_slug'       => 'pdf-viewer-options',
			'menu_type'       => 'submenu',
			'menu_parent'     => 'edit.php?post_type=pdfviewer',
			'show_bar_menu'   => false,
			'footer_text'     => 'Love PDF Viewer for WordPress? Please <a href="https://codecanyon.net/item/pdf-viewer-for-wordpress/8182815" target="_blank">click here</a> to support us with your valuable review on codecanyon.',
			'footer_after'    => '',
			'footer_credit'   => 'Thank you for using PDF Viewer for WordPress',
		)
	);

	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Welcome',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Welcome to PDF Viewer for WordPress', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'content',
					'content' => esc_html__( 'Thank you for purchasing PDF Viewer for WordPress. On this page we\'ll give you some quick details you may need.', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'Getting Started', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'content',
					'content' => __( 'PDF Viewer for WordPress comes with 2 ways of using it. You can start by creating PDF Viewers using <strong>PDF Viewer > Add New</strong> Menu, then share the link anywhere for users to access. <br><br />The other way is using Automatic Link/Embed option. This setup will Automatically convert all of the .pdf links on your website to open with PDF Viewer for WordPress. Go to <strong>PDF Viewer > Global Settings > Automatic Display</strong> Menu to setup this feature.<br><br />Here are some videos from our documentation that will help you to figure out specific parts more easily.', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'content',
					'content' => '<iframe width="100%" height="450" src="https://www.youtube-nocookie.com/embed/videoseries?list=PL0BHfncpP5oSkv9_LfgeXoElT_xhhEla1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'Useful Links', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'content',
					'content' => '
        <ul>
          <li><a target="_blank" href="https://codecanyon.net/item/pdf-viewer-for-wordpress/8182815>Codecanyon Plugin Page</a></li>
          <li><a target="_blank" href="https://themencode.com/live-preview/pdf-viewer-for-wordpress/">Plugin Live Demo</a></li>
          <li><a target="_blank" href="https://themencode.com/docs/pdf-viewer-for-wordpress/">Plugin Documentation</a></li>
          <li><a target="_blank" href="http://youtube.com/channel/UC0mkhMK6fTx1BCovV6M_E4w">Video Documentations</a></li>
          <li><a target="_blank" href="https://themencode.support-hub.io">Support Portal</a></li>
        </ul>
        ',
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'Latest updates from ThemeNcode', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'     => 'callback',
					'function' => 'themencode_news_updates_callback',
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'Sign up for ThemeNcode NewsLetter', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'content',
					'content' => 'It\'s a real honor for us to get you signed up for our newsletter. We only send periodic notifications about important changes and new products we release. We do not share your email with anyone else & we never spam.',
				),
				array(
					'type'    => 'content',
					'content' => '
        <iframe src="http://eepurl.com/hx1A6H" width="100%" height="700"></iframe>
        ',
				),

			),
		)
	);

	// Create a section.
	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Automatic Display',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Automatic Display', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'content',
					'content' => esc_html__( 'You can set options here to have all of your current .pdf links to either open or embed with a PDF Viewer.', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'id'          => 'select-automatic-display',
					'type'        => 'select',
					'title'       => 'Automatic Display',
					'subtitle'    => esc_html__( 'If you want to convert all current .pdf links to open with PDF Viewer, select any of the options.', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select an option',
					'options'     => array(
						'auto-iframe' => 'Automatic iFrame/Embed',
						'auto-link'   => 'Automatic Link',
					),
				),

				array(
					'type'       => 'subheading',
					'content'    => esc_html__( 'All links ending in .pdf will be replaced with Embedded PDF Viewer automatically', 'pdf-viewer-for-wordpress' ),
					'dependency' => array(
						'select-automatic-display',
						'==',
						'auto-iframe',
					),
				),

				array(
					'type'       => 'subheading',
					'content'    => esc_html__( 'All links ending in .pdf will open with PDF Viewer automatically', 'pdf-viewer-for-wordpress' ),
					'dependency' => array(
						'select-automatic-display',
						'==',
						'auto-link',
					),
				),

				array(
					'id'          => 'select-automatic-link-target',
					'type'        => 'select',
					'title'       => esc_html__( 'Link Target', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select an option',
					'options'     => array(
						'_parent' => 'Same Tab',
						'_blank'  => 'New Tab',
					),
					'dependency'  => array(
						'select-automatic-display',
						'==',
						'auto-link',
					),
				),

				array(
					'id'         => 'select-automatic-iframe-width',
					'type'       => 'text',
					'title'      => esc_html__( 'Automatic iFrame Width', 'pdf-viewer-for-wordpress' ),
					'default'    => '100%',
					'dependency' => array(
						'select-automatic-display',
						'==',
						'auto-iframe',
					),
				),

				array(
					'id'         => 'select-automatic-iframe-height',
					'type'       => 'text',
					'title'      => esc_html__( 'Automatic iFrame Height', 'pdf-viewer-for-wordpress' ),
					'default'    => '800',
					'dependency' => array(
						'select-automatic-display',
						'==',
						'auto-iframe',
					),
				),

			),
		)
	);

	// Create a section.
	CSF::createSection(
		$prefix,
		array(
			'title'  => 'General Settings',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'General Settings', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'content',
					'content' => esc_html__( 'There are some common settings related to the viewer, set all the options accordingly.', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'id'           => 'general-logo',
					'type'         => 'media',
					'title'        => esc_html__( 'Logo', 'pdf-viewer-for-wordpress' ),
					'subtitle'     => esc_html__( 'Logo that appears on top right corner of viewer page', 'pdf-viewer-for-wordpress' ),
					'library'      => 'image',
					'placeholder'  => 'https://',
					'button_title' => 'Upload Logo',
					'remove_title' => 'Remove Logo',
				),

				array(
					'id'           => 'general-favicon',
					'type'         => 'media',
					'title'        => esc_html__( 'Favicon', 'pdf-viewer-for-wordpress' ),
					'subtitle'     => esc_html__( 'Favicon for viewer pages.', 'pdf-viewer-for-wordpress' ),
					'library'      => 'image',
					'placeholder'  => 'https://',
					'button_title' => 'Upload Favicon',
					'remove_title' => 'Remove Favicon',
				),

				array(
					'id'       => 'general-fullscreen-text',
					'type'     => 'text',
					'title'    => esc_html__( 'FullScreen Link Text', 'pdf-viewer-for-wordpress' ),
					'subtitle' => esc_html__( 'Only applicable for iframe shortcode, the link that appears just above iframe', 'pdf-viewer-for-wordpress' ),
					'default'  => 'Fullscreen Mode',
				),

				array(
					'id'       => 'general-return-text',
					'type'     => 'text',
					'title'    => esc_html__( 'Return to Site Link Text', 'pdf-viewer-for-wordpress' ),
					'subtitle' => esc_html__( 'Return to site link that appears on bottom right corner of fullscreen viewer', 'pdf-viewer-for-wordpress' ),
					'default'  => 'Return to Site',
				),

				array(
					'id'       => 'general-analytics-id',
					'type'     => 'text',
					'title'    => esc_html__( 'Google Analytics ID', 'pdf-viewer-for-wordpress' ),
					'subtitle' => esc_html__( 'Example: UA-XXXXXXXX-X', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'id'    => 'general-iframe-responsive-fix',
					'type'  => 'switcher',
					'title' => esc_html__( 'iFrame Responsive Fix', 'pdf-viewer-for-wordpress' ),
				),

			),
		)
	);

	// Create a section.
	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Appearance',
			'fields' => array(

				array(
					'type'    => 'heading',
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
					'dependency'  => array(
						'appearance-select-type',
						'==',
						'select-theme',
					),
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
					'dependency' => array(
						'appearance-select-type',
						'==',
						'custom-color',
					),
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
					'dependency'  => array(
						'appearance-select-type',
						'==',
						'custom-color',
					),
				),

			),
		)
	);

	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Toolbar',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Toolbar Global Defaults', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'Specify Global Default setting here. Options in this section only applies to Automatic Link and iFrame options', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'id'          => 'toolbar-default-scroll',
					'type'        => 'select',
					'title'       => esc_html__( 'Default Scroll', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select an option',
					'options'     => array(
						'0' => 'Vertical Scrolling',
						'1' => 'Horizontal Scrolling',
						'2' => 'Wrapped Scrolling',
						'3' => 'Flip',
					),
				),

				array(
					'id'          => 'toolbar-default-spread',
					'type'        => 'select',
					'title'       => esc_html__( 'Default Spread', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select an option',
					'options'     => array(
						'0' => 'No Spreads',
						'1' => 'Odd Spreads',
						'2' => 'Even Spreads',
					),
				),

				array(
					'id'          => 'toolbar-default-zoom',
					'type'        => 'select',
					'title'       => 'Default Zoom',
					'placeholder' => 'Select Default Zoom',
					'options'     => array(
						'auto'        => 'Auto',
						'page-fit'    => 'Page Fit',
						'page-width'  => 'Page Width',
						'page-height' => 'Page Height',
						'75'          => '75%',
						'100'         => '100%',
						'150'         => '150%',
						'200'         => '200%',
					),
					'default'     => 'auto',
				),

				array(
					'id'          => 'toolbar-viewer-language',
					'type'        => 'select',
					'title'       => esc_html__( 'Viewer Language', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select an option',
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
				),

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Toolbar Elements Visibility', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'Specify Global Default setting here', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'id'      => 'toolbar-share',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Share', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-print',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Print', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-download',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Download', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-open',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Open', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-zoom',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Zoom', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-fullscreen',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Fullscreen', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-logo',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Logo', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-find',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Find', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-pagenav',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Page Navigation', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-current-view',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Current View', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-rotate',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Rotate', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-handtool',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Handtool', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-doc-prop',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Document Properties', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-left-toggle',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Left Toggle Menu', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-right-toggle',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Right Toggle Menu', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-scroll',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Scroll Options', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),

				array(
					'id'      => 'toolbar-spread',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Spread Options', 'pdf-viewer-for-wordpress' ),
					'default' => true,
				),
			),
		)
	);

	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Advanced',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Advanced Settings', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'Only change the first 2 settings if you know what you\'re doing or is suggested by ThemeNcode support', 'pdf-viewer-for-wordpress' ),
				),

				// Select with pages.
				array(
					'id'          => 'advanced-pdf-viewer-page',
					'type'        => 'select',
					'title'       => esc_html__( 'ThemeNcode PDF Viewer Page', 'pdf-viewer-for-wordpress' ),
					'subtitle'    => esc_html__( 'This should be set to the auto created page "ThemeNcode PDF Viewer [Do Not Delete]", only change if you see wrong page selected here. ', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select a page',
					'options'     => 'pages',
					'query_args'  => array(
						'posts_per_page' => - 1, // for get all pages (also it's same for posts).

					),
				),

				array(
					'id'          => 'advanced-pdf-viewer-sc-page',
					'type'        => 'select',
					'title'       => esc_html__( 'ThemeNcode PDF Viewer SC Page', 'pdf-viewer-for-wordpress' ),
					'subtitle'    => esc_html__( 'This should be set to the auto created page "ThemeNcode PDF Viewer SC [Do Not Delete]", only change if you see wrong page selected here. ', 'pdf-viewer-for-wordpress' ),
					'placeholder' => 'Select a page',
					'options'     => 'pages',
					'query_args'  => array(
						'posts_per_page' => - 1, // for get all pages (also it's same for posts).

					),
				),

				array(
					'id'         => 'advanced-context-menu',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Context Menu/Right Click on Viewer Pages', 'pdf-viewer-for-wordpress' ),
					'text_on'    => 'Enabled',
					'text_off'   => 'Disabled',
					'text_width' => 100,
					'default'    => true,
				),

				array(
					'id'         => 'advanced-text-copying',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Text Copying (ctrl+c) keyboard shortcut', 'pdf-viewer-for-wordpress' ),
					'text_on'    => 'Enabled',
					'text_off'   => 'Disabled',
					'text_width' => 100,
					'default'    => true,
				),

			),

		)
	);

	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Custom CSS/JS',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Custom CSS and JS', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'The custom css and javascript code you put below will be executed on viewer pages only.', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'id'       => 'custom-css',
					'type'     => 'code_editor',
					'title'    => 'Custom CSS (Only inside Viewer)',
					'settings' => array(
						'theme' => 'mbo',
						'mode'  => 'css',
					),
				),

				array(
					'id'       => 'custom-js',
					'type'     => 'code_editor',
					'title'    => 'Custom JS (Only inside Viewer)',
					'settings' => array(
						'theme' => 'monokai',
						'mode'  => 'javascript',
					),
					'sanitize' => false,
				),

			),
		)
	);

	// Create a section.
	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Addons & Integrations',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Addons & Integrations', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'subheading',
					'content' => esc_html__( 'Here are the available addons and integrations with PDF Viewer for WordPress.', 'pdf-viewer-for-wordpress' ),
				),

				array(
					'type'    => 'heading',
					'content' => 'Elementor Addon',
				),
				array(
					'type'    => 'subheading',
					'content' => 'This addon let\'s you create PDF Viewer shortcodes using Elementor builder interface',
				),

				array(
					'type'    => 'content',
					'content' => 'If you\'re using elementor page builder on your website, you can get this addon to generate PDF Viewer shortcodes using Elementor Page Builder interface.<br><br /> <a class="button button-primary" href="https://codecanyon.net/item/elementor-pdf-viewer-for-wordpress-addon/27575246" target="_blank">Buy/Download Elementor Addon Now</a>',
				),

				array(
					'type'    => 'heading',
					'content' => 'WPBakery Page Builder Addon',
				),
				array(
					'type'    => 'subheading',
					'content' => 'This addon let\'s you create PDF Viewer shortcodes using WPBakery Page builder interface',
				),

				array(
					'type'    => 'content',
					'content' => 'If you\'re using WPBakery page builder on your website, you can get this addon to generate PDF Viewer shortcodes using WPBakery Page Builder interface.<br><br /> <a class="button button-default" href="https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431" target="_blank">Buy/Download WPBakery Addon Now</a>',
				),

				array(
					'type'    => 'heading',
					'content' => 'Navigative Addon',
				),
				array(
					'type'    => 'subheading',
					'content' => 'If you want to have Multiple pdf files load on a single page, this addon is for you.',
				),

				array(
					'type'    => 'content',
					'content' => 'This addon is useful if you want to have one viewer on a page but open multiple pdf\'s according to users click. You can have a list of PDF links on the sidebar using a widget. When user clicks on any link, the particular pdf will be loaded on the content area.<br><br /> <a class="button csf-warning-primary" href="https://codecanyon.net/item/navigative-pdf-viewer-for-wordpress-adoon/19393796" target="_blank">Buy/Download Navigative Addon Now</a>',
				),

				array(
					'type'    => 'heading',
					'content' => 'WP File Access Manager',
				),
				array(
					'type'    => 'subheading',
					'content' => 'Allows you to restrict access to specific audience.',
				),

				array(
					'type'    => 'content',
					'content' => 'If you want to restrict access to your media library files by user login/role/woocommerce purchase or paid memberships pro level, this plugin is for you!<br><br /> <a class="button button-primary" href="https://codecanyon.net/item/wp-file-access-manager/26430349" target="_blank">Buy/Download WP File Access Manager</a>',
				),

			),
		)
	);

	CSF::createSection(
		$prefix,
		array(
			'title'  => 'Export/Import',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => 'Export/Import Settings',
				),
				array(
					'type'    => 'subheading',
					'content' => 'Take backup of all the global settings and import if needed.',
				),

				array(
					'type' => 'backup',
				),
			),
		)
	);
}

=== Lightweight Accordion ===
Contributors: someguy9
Donate link: https://smartwp.com/
Tags: accordion, collapsible, performance, block, blocks
Requires at least: 5.0
Tested up to: 5.8
Requires PHP: 7.0
Stable tag: 1.5.7
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Extremely simple accordion for adding collapse elements to pages without affecting page load time. Works for Classic Editor via shortcode and Gutenberg via Block.

== Description ==

**Lightweight Accordion** plugin for WordPress allows you to add collapse elements to posts using a shortcode (via classic editor) or using a Gutenberg block. By using the details HTML tag and a few lines of CSS this allows for a javascript-free accordion for minimum page load.

**Extremely Lightweight (<1kb):** Without using Javascript the plugin uses the native details HTML tag and a few lines of code for almost no impact on front-end.

**Customizable:** Options include customizing the HTML tag used for the accordion title, open by default, orders, and colors.

= Shortcode Usage examples =

Here are a few examples of using the accordion plugin with shortcodes.

`[lightweight-accordion title="My Accordion"]My Content[/lightweight-accordion]`

Additionally you can display the accordion open on load with the accordion_open option.

`[lightweight-accordion title="My Accordion" accordion_open=true]My Content[/lightweight-accordion]`

You can also change the html tag wrapping the title of the accordion using the title_tag option.

`[lightweight-accordion title="My Accordion" title_tag="h3"]My Content[/lightweight-accordion]`

If you want to include FAQ schema you can add the schema option and set it to faq.

`[lightweight-accordion title="What is your return policy?" schema="faq"]You have 1 week to return your items[/lightweight-accordion]`

If you'd like put a border around the content of the accordion you can use the "bordered" attribute.

`[lightweight-accordion title="Bordered Content" bordered=true]My Content[/lightweight-accordion]`

= Shortcode Options =

Here is the full listing of shortcode options. Additionally all of these options are accessible when using the Gutenberg block.

* **title** (Required Default: null) The title of your accordion will be displayed at the top for users to click. A good example would be to include a user's question so they could click it for more details.
* **content** (Required Default: null) Content that will go into your accordion element.
* **title_tag** (Default: "span") This sets the html tag that wraps the title in the accordion summary. Useful if you want to make it a heading tag for SEO purposes.
* **accordion_open** (Default: false) Set this to true if you want your accordion to be open by default.
* **bordered** (Default: false) Set this to true if you want a border around the accordion content.
* **title_text_color** (Default: false) Set this to a hex value or CSS color to change the color of the accordion title text.
* **title_background** (Default: false) Set this to a hex value or CSS color to change the color of the accordion title text.
* **schema** (Default: false) Set this to faq if you'd like FAQ schema to be included.
* **class** (Default: false) Used to add a custom class to the parent container of the accordion.
* **anchor** (Default: null) Adds the value as an ID to the accordion div as an anchor.

= Additional Details =

If you'd like to remove the "lightweight-accordion.css" from being enqueued on your site use the filter below. It's recommend you style the accordion yourself if you use this filter.

`add_filter('lightweight_accordion_include_frontend_stylesheet', '__return_false' );`

If you'd like to remove the "lightweight-accordion/editor-styles.css" from being enqueued in the admin area of your site you can use the filter below.

`add_filter('lightweight_accordion_include_admin_stylesheet', '__return_false' );`

If you'd like to remove processing of shortcodes in accordion content you can use this filter.

`add_filter('lightweight_accordion_process_shortcodes', '__return_false' );`

If you'd like to use inline Microdata for FAQ schema you can use this filter.

`add_filter('lightweight_accordion_output_microdata', '__return_true' );`

== Installation ==

To install this plugin:

1. Download the plugin
2. Upload the plugin to the wp-content/plugins directory,
3. Go to "plugins" in your WordPress admin, then click activate.
4. Add the shortcode where you want the accordion to appear. Likewise in Gutenberg you can find the "Lightweight Accordion" block under the "widgets" section in the block selector.

== Frequently Asked Questions ==

== Screenshots ==

1. Example of the lightweight accordions on the front-end of the site.
2. Accordion options when using the Gutenberg block.

== Changelog ==

= 1.5.7 =
 * Tested up to WordPress 5.8
 * Bug fix for __ declaration

= 1.5.6 =
 * Bug fix for copy and pasting the accordion title in Safari.

= 1.5.5 =
 * Anchor support in Gutenberg and shortcode which adds an ID to be used as an anchor (can be found in the advanced tab of Gutenberg or using the 'anchor' attribute in the shortcode).
 * Fixes bug when enabling microdata using the filter (removes JSON-LD output when using microdata).

= 1.5.4 =
 * FAQ schema for accordions now output as JSON-LD in the footer instead of as Microdata. If you'd like to continue using Microdata you can set the lightweight_accordion_output_microdata filter to true.

= 1.5.3 =
 * PHP Warning bug fix for "class" and "className".

= 1.5.2 =
 * Empty array bug fix.
 * Included an example pane in the Gutenberg insert block page.

= 1.5.1 =
 * Readme update.
 * Added block.json to be included in Gutenberg block library.
 * Style bugfix in the Gutenberg editor.

= 1.5.0 =
 * New option to add a border around the accordion content on the front-end.
 * Shortcodes are now processed in the content of the accordion.
 * New filter to disable shortcode processing.

= 1.4.1 =
 * Tested up to WordPress 5.7.

= 1.4 =
 * New option for title and background color for the accordion tab (works with Gutenberg and shortcode).
 * New visual border to see what's inside the accordion while using Gutenberg.
 * New ability to append a custom class to the main accordion div.
 * No longer runs content clean up processing (wpautop/preg_replace) to tab content when using Gutenberg.

= 1.3.3 =
 * CSS style compatibility fix for some themes.

= 1.3.2 =
 * Tested up to WordPress 5.6.
 * Bug fix in Gutenberg editor styles.

= 1.3.1 =
 * Added a slight opacity change animation when opening accordions.

= 1.3.0 =
 * Ability to add FAQ schema to a collapsible using the new 'schema' option in the shortcode or dropdown in the Gutenberg editor.
 * Bug fixes for PHP warnings.

= 1.2.0 =
 * Better Gutenberg editor styles to tell what is inside a collapsible.
 * Tested up to WordPress 5.5.

= 1.1.1 =
* Bug fix: now runs wpautop() on the entire contents of the accordion (so the first paragraph won't be missing a p tag now)

= 1.1.0 =
 * New filter to denqueue the lightweight accordion CSS from the front-end.

`add_filter('lightweight_accordion_include_frontend_stylesheet', '__return_false' );`

= 1.0.0 =
 * Initial Release.
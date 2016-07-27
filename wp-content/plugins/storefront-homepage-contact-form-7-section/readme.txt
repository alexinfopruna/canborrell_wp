=== Storefront Homepage Contact 7 Section - SHC7S ===
Contributors: WPDevHQ
Tags: woocommerce, ecommerce, storefront, contact, form, map, email, address
Requires at least: 3.5
Tested up to: 4.5
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a "Contact Form 7" section to the Storefront homepage.

Simple plugin adds custom "Contact Form 7" homepage section to Storefront. Customise the display by adding your contact details via the Customizer and a widget for extra info.

This plugin requires the Storefront theme to be installed. Contact Form 7 is required for the contact form.

== Description ==

A simple plugin that adds custom "Contact Form 7" homepage section to Storefront. Customise the display by adding your contact details via the Customizer and a widget for extra info.

This plugin requires the Storefront theme to be installed. Contact Form 7 is required for the contact form.

Credits: woothemes, tiagonoronha.

Attribution: Forked from [Storefront Homepage Contact Section](https://wordpress.org/plugins/storefront-homepage-contact-section/)

The underlying code of this plugin is the same as attributed plugin above with modifications to suite the purpose.

Modifications done by Zulfikar Nore of [@WPDevHQ](https://twitter.com/WPDevHQ)

== Installation ==

1. Upload `storefront-homepage-contact7-section` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the display in the Customizer (look for the 'Homepage Contact' section).
4. Expand the panel, add your Contact Form 7 ID and title and save
5. Done!

== Frequently Asked Questions ==

= I installed the plugin but cannot see the "Contact" section =

This plugin will only work with the [Storefront](http://wordpress.org/themes/storefront/) theme.

= I can't see the contact form =

This plugin requires the [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) plugin for the contact form to work.

= I can't see the Contact section on the front end =

If you are using the [Homepage Control](https://wordpress.org/plugins/homepage-control/) plugin you may need to visit the Homepage Control section in the customizer 
and make sure the "Storefront Homepage Contact7 Section" is enabled.

= I don't see the opening hours section. How do I set it up? =

The section on the screenshot depicting the opening hours is a widget area. When you activate the plugin it will create a widget area called "Homepage Contact Section".
Navigate to your Widgets/Sidebar page and there you can add any widget to meet your needs. For the screenshot opening hours I used another plugin called [Woo Shopping Hours](https://wordpress.org/plugins/woo-shopping-hours/)

== Screenshots ==

1. The Homepage Contact Section

2. Customizer enable section via Homepage Control panel.

== Changelog ==

= 1.0.2 =
Added styles and applied default values to better match the theme's look and feel.
Minor code adjustment and improvements.
Renamed pot file to reflect the plugin name.

= 1.0.1 =
Added check for "is_active_sidebar( 'shc7s-1' )" to render the left pane of the contact us section.

= 1.0.0 =
Initial release.
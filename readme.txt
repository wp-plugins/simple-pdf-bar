=== Plugin Name ===
Contributors: andreasbutze
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=YHSALBZF3LNQ6&lc=DK&item_name=Simple%20PDF%20Bar%20%28WP%2dplugin%29&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: pdf, lightweight, lead, generation, bar, simple
Requires at least: 3.0.1
Tested up to: 4.2.2
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a lead generation bar to the top or bottom of your pdf documents

== Description ==

Adds a lead generation bar to the top or bottom of your pdf documents by creating a new post type suited for this purpose. Include text and buttons specific to each individual PDF-document in order to guide traffic from your PDF files.

To display PDF files in the browser, the user must of course have a PDF reader installed (e.g. Adobe Reader). Mobile users will load PDFs in their native PDF readers by default.

This plugin is sponsored by [Adapt A/S](http://adapt.dk/)


== Installation ==

1. Upload `simple-pdf-bar`-folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress 
3. Upload PDFs and configure the bar by clicking the `Simple PDF bar` link in the admin menu

== Frequently Asked Questions ==

= Is there a fallback for users with no PDF reader installed? =

Yes, such users will be provided with a direct download link to the PDF file.

= Why do I get a ‘page not found’ error when trying to view PDF? =

You probably need to update the permalink structure.
Go to Settings —> Permalinks and click the ‘Save changes’ button to update permalink structure.

= Why is my PDF not loading? =

It might be because you’ve tried to upload a file that’s too big. Check upload_max_filesize in your php.ini file. 

= In which browsers have the plugin been tested? =

Tested in IE11, IE10, IE9, Firefox, Safari, Chrome (with Adobe Reader installed)

= Can I overwrite the PDF Bar CSS if needed? =

Yes, you can do this directly from your own theme’s css.

== Screenshots ==

1. Admin page - Where each individual PDF is uploaded and the PDF bar is configured

2. PDF view - The PDF with the PDF bar activated

== Changelog ==

= 1.0.2 =
* PDF-Bar admin page layout updated

= 1.0.1 =
* Safari load problem fixed
* Double scrollbar removed

= 1.0 =
* First published version.

== Upgrade Notice ==

= 1.0.2 = Minor update to admin page layout

= 1.0.1 = Safari load issue fixed + double scrollbar removed

= 1.0 = First published version.

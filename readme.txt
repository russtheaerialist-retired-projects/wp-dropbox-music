=== Plugin Name ===
Contributors: Ostlund
Donate link:
Tags: dropbox, upload, integration, api, form
Requires at least: 3.0.0
Tested up to: 3.1.3
Stable tag: 0.1.5

Inserts a upload form for visitors to upload files to a Dropbox account

== Description ==

This plugin lets you insert a upload form on your pages so visitors can upload files to a Dropbox account.

== Installation ==

1. Upload `plugin-directory` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to https://www.dropbox.com/developers/ and create a application. You need to copy your Applications API Key and API Secret. Create the Application for the user you want to upload files to.
1. Place `[wp-dropbox]` on a page.

== Frequently Asked Questions ==

= Requirements =

This plugin requires PHP5.

= Is this your first Wordpress plugin =

Yes indeed, so don't blame me if it breaks.

== Screenshots ==

1. This is how it looks with Swedish translation on a page in Safari

== Changelog ==

= 0.1.5 =
* Quick bugfix with the new Dropbox class

= 0.1.2 =
* Updated dropbox class to latest version

= 0.1.1 =
* No need to store the users password

= 0.1.0 =
* Change from CURL to Dropbox native API
* I now use Tijs Verkoyen Dropbox class
* Plugin requires PHP5
* Bugfixes

= 0.0.5 =
* Bugfixes

= 0.0.3 =
* Fixing some bugs in readme.txt.
* Second initial release.
=== Likes Counter ===

Contributors: goncaloneves
Donate link: https://github.com/goncaloneves
Tags: facebook, fb, likes, like, counter, count, graph, shortcode, plugin
Requires at least: 3.0.1
Tested up to: 3.9.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Show the Likes Counter on your Wordpress website. You can set the following attributes: facebook page (or id), cache duration, offset and separator.


== Description ==

Likes Counter gets Facebook Likes of any page you want and stores the returning value temporarily in database so it doesn't bubble requests to Facebook API.

After the cache duration expires, it will make a new request and update the Likes value, again for the duration set.

This plugin store its values with Transients API, so it can be cachable outside database with memcached plugins. I recommend using [W3 Total Cache](http://wordpress.org/plugins/w3-total-cache/ 'W3 Total Cache').

I made this plugin to be as light as possible, so I ended up making a shortcode that gives the user the functionality to build a powerful Facebook Likes Counter.


= Usage =

You can place it anywhere in your post/page with [likescounter page='*page_name_or_id*'] shortcode.

Example:
> [likescounter page='WordPress' duration='30' offset='10' separator='dot']

In this example:
Gets Wordpress likes number,
Caches the value for 30 minutes,
Offsets likes count by 10,
Adds a thousand separator dot.

Inside your php files, for example in a Theme template, use [do_shortcode](http://codex.wordpress.org/Function_Reference/do_shortcode 'do_shortcode'):

    <?php echo do_shortcode( '[likescounter page="page_name_or_id"]' ); ?>


= Attributes =

*   **page (string):** facebook page name (ex: wordpress) or id (ex: 6427302910)
*   **duration (int) (default: 30):** duration in minutes to cache in database before making a new request [1 to 1440]
*   **offset (int) (default: 0):** Subtracts from Likes value and returns the rest. It can be used to reset likes count for a Likes goal objective in marketing campaigns. [0 to number of current likes]
*   **separator (string) (default: none):** thousand separator type [dot, comma or space]


= Important =

> Could not get likes data. Please verify if page is correct.

If you get this there are two possible reasons:

 - Page / id misspelled or doesn't exist (most likely),
 - Couldn't connect to Facebook Graph API or Timeout. It may happen if you reach Facebook policy limits, consider increasing cache duration.


**Thank you** for you interest in Likes Counter plugin.

If you need help please contact me via Support tab.

Feel free to contribute and fork, this plugin is at https://github.com/goncaloneves/likescounter


== Installation ==

1. Upload `likes-counter` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place [likescounter page='page_name_or_id'] shortcode with attributes in your post or page

or

 1. Install plugin directly in Wordpress through the 'Plugins', Add New -> Search panel
 2. Search for `Likes Counter`
 3. Place [likescounter page='page_name_or_id'] shortcode with attributes in your post or page


== Frequently Asked Questions ==

= Do you need support or found an issue ? =

Please write in Support tab or issue on Github at https://github.com/goncaloneves/likescounter/issues


== Screenshots ==

1. Likes Counter for Wordpress without formatting.
2. Likes Counter for Wordpress without formatting.
3. Likes Counter for Wordpress with formatting.
4. Likes Counter for Wordpress with formatting.


== Changelog ==

= 1.0 =
* First stable release.

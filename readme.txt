=== Likes Counter ===

Contributors: goncaloneves
Donate link: https://www.gittip.com/goncaloneves
Tags: facebook, fb, likes, like, counter, count, graph, shortcode, plugin
Requires at least: 3.0.1
Tested up to: 4.0
Stable tag: 1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Show multiple Likes Counter on your website. You can set: Facebook page (or id), cache duration, offset, separator and tag around each character.

== Description ==

Likes Counter gets Facebook Likes of any page you want and stores the returning value temporarily in database so it doesn't bubble requests to Facebook API.

Benefits:

1. You can use Likes Counter multiple times in the same code.

2. After the cache duration expires, it will make a new request and update the Likes value, again for the duration set.

3. This plugin stores its values with [Transients API](http://codex.wordpress.org/Transients_API 'Transients API'), so it can be cachable outside database with memcached plugins. I recommend using [W3 Total Cache](http://wordpress.org/plugins/w3-total-cache/ 'W3 Total Cache').

4. Easy to style span tags with css classes *likes-counter* and *likes-counter-separator*.

I made this plugin to be as light as possible, so I ended up making a shortcode that gives the user the functionality to build a powerful Facebook Likes Counter.

= Usage =

You can place it anywhere in your post/page with [likescounter page='*page_name_or_id*'] shortcode.

**Example:**

SHORTCODE IN POST/PAGE:

> [likescounter page='WordPress' duration='30' offset='10' separator='dot' tag='true']

-- Gets *842488* likes from Wordpress Facebook page,

-- Caches the value for 30 minutes,

-- Offsets likes count by 10: *842478*,

-- Adds a thousand dot separator: *842.478*,

-- Adds a span tag around each character.

    Returns : <span class="likes-counter">8</span>
              <span class="likes-counter">4</span>
              <span class="likes-counter">2</span>
              <span class="likes-counter-separator">.</span>
              <span class="likes-counter">4</span>
              <span class="likes-counter">7</span>
              <span class="likes-counter">8</span>

CSS:

Now lets add some CSS inside *style.css* of your active Theme:

    span.likes-counter {
    	background-color: #eeeeee;
    	border-bottom: 1px solid #aaaaaa;
    	border-left: 1px solid #cccccc;
    	border-radius: 5px;
    	border-right: 1px solid #dddddd;
    	border-top: 1px solid #cccccc;
    	color: #1e8cbe;
    	margin: 2px;
    	padding: 5px 10px;
    }
    
    span.likes-counter-separator {
    	color: #dddddd;
    	padding: 2px 4px;
    }

PHP:

If you need to use inside a Theme Template file, use [do_shortcode](http://codex.wordpress.org/Function_Reference/do_shortcode 'do_shortcode'):

    <?php echo do_shortcode( '[likescounter page="page_name_or_id"]' ); ?>

= Attributes =

*   **page (string):** facebook page name (ex: wordpress) or id (ex: 6427302910)
*   **duration (1 to 1440 - default: 30):** duration in minutes to cache in database before making a new request.
*   **offset (0 to number of current likes - default: 0):** subtracts from Likes value and returns the rest. It can be used to reset likes count for a Likes goal objective in marketing campaigns.
*   **separator (dot, comma, short, space or none - default: none):** thousand separator type. Short separator, shortens thousand to K, million to M and billion to B.
*   **tag (true or false - default: true):** span tag around each character for css styling. `<span class="likes-counter">number_character</span>` for number characters and `<span class="likes-counter-separator">separator_character</span>` for separators characters.

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

1. Likes Counter with css styling from Example in Description tab.
2. Likes Counter for Wordpress without formatting.
3. Likes Counter for Wordpress without formatting.
4. Likes Counter for Wordpress with formatting.
5. Likes Counter for Wordpress with formatting.

== Changelog ==

= 1.5 =
* Add plugin icons
* Update readme to WordPress 4.0

= 1.4 =
* Encapsulate plugin functions inside a singleton class.
* Update wp_remote_get to wp_safe_remote_get, for stronger security.
* Changed intval to (int) type for better performance.

= 1.3 =
* Add dot in short separator when likes are inferior to 10 000 likes.
* Fixed short separator to work only when likes are superior to 1000.

= 1.2 =
* Add short number separator (K for thousand, M for million and B for billion).

= 1.1 =
* Add add_character_tag function to create a span tag around each character for better css styling.

= 1.0 =
* First stable release.
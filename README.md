Likes Counter Plugin
============

Show the Likes Counter on your Wordpress website. Likes Counter shortcode comes with the following attributes: facebook page (or id), cache duration, offset and separator.

Likes Counter gets Facebook Likes of any page you want and stores the returning value temporarily in database so it doesn't bubble requests to Facebook API.

After the cache duration expires, it will make a new request and update the Likes value, again for the duration set.

This plugin store its values with Transients API, so it can be cachable outside database with memcached plugins. I recommend using [W3 Total Cache][1].

I made this plugin to be as light as possible, so I ended up making a shortcode that gives the user the functionality to build a powerful Facebook Likes Counter.


----------


## Usage ##

You can place it anywhere in your post/page with [likescounter page='*page_name_or_id*'] shortcode.

**Example:**
> [likescounter page='WordPress' duration='30' offset='10' separator='dot']

In this example:
Gets Wordpress likes number,
Caches the value for 30 minutes,
Offsets likes count by 10,
Adds a thousand separator dot.

Inside your php files, for example in a Theme template, use [do_shortcode][2]:

    <?php echo do_shortcode( '[likescounter page="page_name_or_id"]' ); ?>

----------

## Attributes ##

*   **page (string):** facebook page name (ex: wordpress) or id (ex: 6427302910)
*   **duration (int) (default: 30):** duration in minutes to cache in database before making a new request [1 to 1440]
*   **offset (int) (default: 0):** Subtracts from Likes value and returns the rest. It can be used to reset likes count for a Likes goal objective in marketing campaigns. [0 to number of current likes]
*   **separator (string) (default: none):** thousand separator type [dot, comma or space]

----------

## Important ##

> Could not get likes data. Please verify if page is correct.

If you get this there are two possible reasons:

 - Page / id misspelled or doesn't exist (most likely),
 - Couldn't connect to Facebook Graph API or Timeout. It may happen if you reach Facebook policy limits, consider increasing cache duration.

----------

**Thank you** for you interest in Likes Counter plugin.

If you need help please contact me via Support tab.

Feel free to contribute and fork, this plugin is at https://github.com/goncaloneves/likescounter

<?php
/**
 * Author: Gonçalo Neves
 * Author URI: https://github.com/goncaloneves
 * Plugin Name: Likes Counter 
 * Plugin URI: https://github.com/goncaloneves/likescounter
 * Description: Show multiple Likes Counter on your website. You can set: Facebook page (or id), cache duration, offset, separator and tag around each character.
 * License: License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Version: 1.1
 * Text Domain: likes-counter
 */


/**********************************************************************
  Plugin Init Hook to load Language Files
**********************************************************************/
function likes_counter_init() {
    load_plugin_textdomain( 'likes-counter', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

/**********************************************************************
  Plugin Init
**********************************************************************/
add_action('plugins_loaded', 'likes_counter_init');

/**********************************************************************
  Get Likes ( Page (name or ID), Expiration in minutes for Transient )
**********************************************************************/
function get_likes( $page, $expiration ) {
    $likes_transient = get_transient( 'likes_counter_' . strtolower( $page ) );

    if ( $likes_transient === false ) {
        $likes_data = json_decode( wp_remote_retrieve_body( wp_remote_get( 'https://graph.facebook.com/' . $page ) ) );
        $likes = $likes_data -> likes;

        if ( ! is_null( $likes ) ) {
            $expiration = intval( $expiration );
            if ( $expiration > 0 && $expiration <= 1440 ) {
                set_transient( 'likes_counter_' . strtolower( $page ), $likes, $expiration * MINUTE_IN_SECONDS );
            } else {
                set_transient( 'likes_counter_' . strtolower( $page ), $likes, 30 * MINUTE_IN_SECONDS );
            }
            return $likes;  
        } else {
            return false;
        }
    } else {
        return $likes_transient;
    }
}

/**********************************************************************
  Add Character Tag ( Number, Tag )
**********************************************************************/
function add_character_tag( $number, $tag ) {
    if ( $tag === 'false' ) {
        return $number;
    } else {
        $number_array = str_split( $number );
        foreach ( $number_array as $value ) {
            if ( $value === ' ' || $value === ',' || $value === '.' ) {
                $number_tag .= '<span class="likes-counter-separator">' . $value . '</span>';
            } else {
               $number_tag .= '<span class="likes-counter">' . $value . '</span>';
            }
        }
        return $number_tag;
    }
}

/**********************************************************************
  Add Separator ( Number, Type to format number )
**********************************************************************/
function add_separator( $number, $type ) {
    switch ( $type ) {
        case 'comma':
            $number = number_format( $number, 0, '', ',' );
            break;
        case 'dot':
            $number = number_format( $number, 0, '', '.' );
            break;
        case 'space':
            $number = number_format( $number, 0, '', ' ' );
            break;
    }
    return $number;
}

/**********************************************************************
  Add Offset ( Number, Offset to subtract )
**********************************************************************/
function add_offset( $number, $offset ) {
    $offset = intval( $offset );

    if ( $offset > 0 && $offset <= $number ) {
        $number_offset = $number - $offset;
        return $number_offset;
    } else {
        return $number;
    }
}

/**********************************************************************
  Likes Counter Hook ( Shorcode Attributes )
**********************************************************************/
function likes_counter( $atts ) {
	$likes_options = shortcode_atts( array(
        'duration' => '30',
        'offset' => '',
        'page' => '',
        'separator' => '',
        'tag' => 'true'
	), $atts );

    $page = $likes_options[ 'page' ];
    $likes = get_likes( $likes_options[ 'page' ], $likes_options[ 'duration' ] );

    if ( $likes === false ) {
        return __( 'Could not get likes data. Please verify if page is correct.', 'likes-counter' );
    } else {
        $offset = $likes_options[ 'offset' ];
        $separator = $likes_options[ 'separator' ];
        $tag = $likes_options[ 'tag' ];
        return add_character_tag( add_separator( add_offset( $likes, $offset ), $separator ), $tag );  
    }
}

/**********************************************************************
  Likes Counter Shortcode
**********************************************************************/
add_shortcode( 'likescounter', 'likes_counter' );

?>
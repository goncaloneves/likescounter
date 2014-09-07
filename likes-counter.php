<?php
/**
 * Author: Gonçalo Neves
 * Author URI: https://github.com/goncaloneves
 * Plugin Name: Likes Counter
 * Plugin URI: https://github.com/goncaloneves/likescounter
 * Description: Show multiple Likes Counter on your website. You can set: Facebook page (or id), cache duration, offset, separator and tag around each character.
 * License: License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Version: 1.5
 * Text Domain: likes-counter
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'Likes_Counter_Class' ) ) {
    final class Likes_Counter_Class {

        private static $_instance;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self;
            }
            return self::$_instance;
        }

        /**
         * Constructor.
         */
        private function __construct() {
            $this->actions();
        }

        /**
         * Cloning is forbidden.
         */
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'likes-counter' ), '1.0' );
        }

        /**
         * Unserializing instances of this class is forbidden.
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'likes-counter' ), '1.0' );
        }

        /**
         * Action Hooks.
         */
        private function actions(){
            add_action( 'plugins_loaded',  array( $this, 'load_text_domain' ) );
            add_shortcode( 'likescounter', array( $this, 'likes_counter' ) );
        }

        /**
         * Load Localisation Files.
         */
        public function load_text_domain() {
            $languages_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
            load_plugin_textdomain( 'likes-counter', $languages_dir );
        }

        /**
         * Get Likes from Facebook OpenGraph.
         *
         * @param string $page The page name or id number.
         * @param integer $expiration Cache duration for transient.
         *
         * @return integer|false
         */
        private function get_likes( $page, $expiration ) {
            $likes_transient = get_transient( 'likes_counter_' . strtolower( $page ) );

            if ( $likes_transient === false ) {
                $likes_data = json_decode( wp_remote_retrieve_body( wp_safe_remote_get( 'https://graph.facebook.com/' . $page ) ) );
                $likes = $likes_data -> likes;

                if ( ! is_null( $likes ) ) {
                    $likes = (int) $likes;
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
                $likes_transient = (int) $likes_transient;
                return $likes_transient;
            }
        }

        /**
         * Add span tag around each character.
         *
         * @param string|integer $number Number to add span tags.
         * @param string $tag True or false.
         *
         * @return string|integer
         */
        private function add_character_tag( $number, $tag ) {
            if ( $tag === 'false' ) {
                return $number;
            } else {
                $number_array = str_split( $number );
                $number_tag = '';
                foreach ( $number_array as $value ) {
                    if ( $value === ' ' || $value === ',' || $value === '.' ) {
                        $number_tag .= '<span class="likes-counter-separator">' . $value . '</span>';
                    } else if ( $value === 'K' || $value === 'M' || $value === 'B' ) {
                        $number_tag .= '<span class="likes-counter-separator">' . $value . '</span>';
                    } else {
                       $number_tag .= '<span class="likes-counter">' . $value . '</span>';
                    }
                }
                return $number_tag;
            }
        }

        /**
         * Add thousand separator.
         *
         * @param integer $number Number to add thousand separator.
         * @param string $type Thousand separator type.
         *
         * @return string|integer
         */
        private function add_separator( $number, $type ) {
            switch ( $type ) {
                case 'comma':
                    $number = number_format( $number, 0, '', ',' );
                    break;
                case 'dot':
                    $number = number_format( $number, 0, '', '.' );
                    break;
                case 'short':
                    if ( $number >= 1000 ) {
                        if ( $number < 10000 ) {
                            $number = substr( number_format( $number / 1000, 2 ), 0, -1 ) . 'K';
                        } else if ( $number < 1000000 ) {
                            $number = number_format( $number / 1000 ) . 'K';
                        } else if ( $number < 1000000000 ) {
                            $number = number_format( $number / 1000000 ) . 'M';
                        } else {
                            $number = number_format( $number / 1000000000 ) . 'B';
                        }
                    }
                    break;
                case 'space':
                    $number = number_format( $number, 0, '', ' ' );
                    break;
            }
            return $number;
        }

        /**
         * Subtract offset from number.
         *
         * @param integer $number Bigger number.
         * @param integer $offset Smaller number to subtract.
         *
         * @return integer The subtraction remainder.
         */
        private function add_offset( $number, $offset ) {
            if ( $offset > 0 && $offset <= $number ) {
                $number_offset = $number - $offset;
                return $number_offset;
            } else {
                return $number;
            }
        }

        /**
         * Likes Counter shortcode function.
         *
         * @param array $atts Shortcode attributes.
         *
         * @return string Formatted likes string.
         */
        public function likes_counter( $atts ) {
            $likes_options = shortcode_atts( array(
                'duration' => 30,
                'offset' => 0,
                'page' => '',
                'separator' => '',
                'tag' => 'true'
            ), $atts );

            $page = $likes_options[ 'page' ];
            $duration = (int) $likes_options[ 'duration' ];
            $likes = $this->get_likes( $page, $duration );

            if ( $likes === false ) {
                return __( 'Could not get likes data. Please verify if page is correct.', 'likes-counter' );
            } else {
                $offset = (int) $likes_options[ 'offset' ];
                $separator = $likes_options[ 'separator' ];
                $tag = $likes_options[ 'tag' ];
                return $this->add_character_tag( $this->add_separator( $this->add_offset( $likes, $offset ), $separator ), $tag );
            }
        }
    }
}

function Run_Likes_Counter_Class() {
    return Likes_Counter_Class::instance();
}

Run_Likes_Counter_Class();

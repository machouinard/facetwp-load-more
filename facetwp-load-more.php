<?php
/*
Plugin Name: FacetWP - Load More
Description: Adds a shortcode to generate a "Load more" button
Version: 0.4.4
Author: FacetWP, LLC
Author URI: https://facetwp.com/
GitHub URI: facetwp/facetwp-load-more
*/

defined( 'ABSPATH' ) or exit;

class FacetWP_Load_More_Addon
{

    function __construct() {
        add_filter( 'facetwp_assets', array( $this, 'assets' ) );
        add_filter( 'facetwp_shortcode_html', array( $this, 'shortcode' ), 10, 2 );
        add_filter( 'facetwp_query_args', array( $this, 'query_args' ), 10, 2 );
        add_action( 'init', array( $this, 'load_textdomain' ) );
    }


    /**
     * Translation support
     */
    function load_textdomain() {
        load_plugin_textdomain( 'fwp-load-more' );
    }


    /**
     * On pageload, update posts_per_page if we detect a "load_more" URL variable
     */
    function query_args( $args, $class ) {
        if ( isset( $class->ajax_params['is_preload'] ) ) {
            $url_var = FWP()->helper->get_setting( 'prefix' ) . 'load_more';

            if ( isset( $class->http_params['get'][ $url_var ] ) ) {
                $paged = (int) $class->http_params['get'][ $url_var ];
                $per_page = (int) empty( $args['posts_per_page'] ) ? get_option( 'posts_per_page' ) : $args['posts_per_page'];
                $args['posts_per_page'] = ( $paged * $per_page );
            }
        }

        return $args;
    }


    function assets( $assets ) {

        // Register the JS
        $assets['facetwp-load-more.js'] = plugins_url( '', __FILE__ ) . '/facetwp-load-more.js';

        // Set the translations
        FWP()->display->json['load_more'] = array(
            'default_text' => __( 'Load more', 'fwp-load-more' ),
            'loading_text' => __(' Loading...', 'fwp-load-more' )
        );

        return $assets;
    }


    function shortcode( $output, $atts ) {
        if ( isset( $atts['load_more'] ) ) {
            $label = isset( $atts['label'] ) ? $atts['label'] : __( 'Load more', 'fwp-load-more' );
            $output = '<button class="fwp-load-more">' . esc_attr( $label ) . '</button>';
        }
        return $output;
    }
}


new FacetWP_Load_More_Addon();

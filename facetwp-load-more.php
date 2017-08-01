<?php
/*
Plugin Name: FacetWP - Load More
Description: Adds a shortcode to generate a "Load more" button
Version: 0.1
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
    }


    function assets( $assets ) {
        $assets['facetwp-load-more.js'] = plugins_url( '', __FILE__ ) . '/facetwp-load-more.js';
        return $assets;
    }


    function shortcode( $output, $atts ) {
        if ( isset( $atts['load_more'] ) ) {
            $label = isset( $atts['label'] ) ? $atts['label'] : __( 'Load more', 'fwp-load-more' );
            $output = '<button>' . esc_attr( $label ) . '</button>';
        }
        return $output;
    }
}


new FacetWP_Load_More_Addon();

<?php

/*
Plugin Name: Simple Woocommerce Admin Stock Management
Description: A simple woocommerce extension will automatically manage stock levels when orders are edited by the administrator
Version: 1.0
Author: Simplistics, Jon Boss
Author URI: https://simplistics.ca
License: GPL
Copyright: Simplistics Web Design
*/

require( plugin_dir_path(__FILE__) . '/includes/ajax.php');

function simple_woocommerce_restock_load_assets($hook){

    global $post;
    if($post->post_type == 'shop_order'){

        wp_enqueue_style('simple_woo_restock_styles', plugin_dir_url(__FILE__) . '/admin-assets/simple-woocommerce-restock.css');

        wp_register_script('simple_restock_js', plugin_dir_url(__FILE__) . '/admin-assets/simple-woocommerce-restock.js', array('jquery'), '1.0');
        wp_enqueue_script('simple_restock_js');
        wp_localize_script('simple_restock_js', 'simple_restock_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce('simple_restock_nonce') ));
    }

}
add_action('admin_enqueue_scripts', 'simple_woocommerce_restock_load_assets');

function simple_woocommerce_restock_modal(){
    
    global $post;
    if($post->post_type == 'shop_order'){
        require_once( plugin_dir_path(__FILE__) . '/views/restock_modal.php' );
    }

}
add_action('in_admin_footer', 'simple_woocommerce_restock_modal');
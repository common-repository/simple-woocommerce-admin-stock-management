<?php

function simple_restock_this_order(){
    
    check_ajax_referer('simple_restock_nonce','simple_restock_nonce');

    $order_id = $_POST['order_id'];
    $order    = new WC_Order( $order_id );
    $products = $order->get_items();

    $added = array();
    foreach( $products as $item ){
        $variation_id = $item->get_variation_id();
        $product_id   = ($variation_id) ? $variation_id : $item->get_product_id();
        $quantity     = $item->get_quantity();
        $added[]      = wc_update_product_stock($product_id, $quantity, 'increase');
    }
    
    echo 'true';
    die();
}
add_action('wp_ajax_simple_restock_this_order', 'simple_restock_this_order');


function simple_admin_create_order_update_stock(){
    
    check_ajax_referer('simple_restock_nonce','simple_restock_nonce');

    $order_id = $_POST['order_id'];
    $order    = new WC_Order( $order_id );
    $products = $order->get_items();

    $added = array();
    foreach( $products as $item ){
        $variation_id = $item->get_variation_id();
        $product_id   = ($variation_id) ? $variation_id : $item->get_product_id();
        $quantity     = $item->get_quantity();
        $added[]      = wc_update_product_stock($product_id, $quantity, 'decrease');
    }

    echo 'true';
    die();
}
add_action('wp_ajax_simple_admin_create_order_update_stock', 'simple_admin_create_order_update_stock');
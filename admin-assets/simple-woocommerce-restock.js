jQuery(document).ready(function($){

    //INITIAL ORDER STATUS
    var load_val = $('#order_status').val();

    //TRIGGER MODAL BEFORE SUBMITTING THE ORDER
    $(document).on('click', '.order_actions .save_order', function(e){
        var order_status = $('#order_status').val();
        if('wc-cancelled' == order_status && load_val != 'wc-cancelled'){
            e.preventDefault();
            $('#simple_cancelling_order').fadeIn();
        }
        else if( (load_val == 'wc-cancelled' || load_val == 'wc-pending') && (order_status == 'wc-processing' || order_status == 'wc-completed') ){
            e.preventDefault();
            $('#simple_adding_order').fadeIn();
        }
    });

    //DISMISS MODAL
    $(document).on('click', '.cancel', function(){
        $('.simple_woo_restock_overlay').fadeOut();
    });

    //MAKE AJAX CALL - ADD OR REMOVE STOCK
    $(document).on('click', '.simple_woo_return_to_stock, .simple_woo_remove_from_stock', function(){
        data = {
            'order_id':$('#post_ID').val(),
            'simple_restock_nonce': simple_restock_ajax.nonce
        };
        data.action = ( $(this).hasClass('simple_woo_return_to_stock') ) ? 'simple_restock_this_order': 'simple_admin_create_order_update_stock';
        $('.simple_woo_restock_content').html('<h1>Loading ...</h1>');
        $.post(simple_restock_ajax.ajax_url, data, function(res){
            $('#post').submit();
        });
    });

    //USER DECIDES NOT TO USE THE FUNCTIONALITY
    $(document).on('click', '.simple_woo_dont_return_to_stock', function(){
        $('#post').submit();
    });
        
});
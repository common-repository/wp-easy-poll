<?php
add_action( 'init', 'code_button' );
function code_button() {
    add_filter( "mce_external_plugins", "code_add_button" );
    add_filter( 'mce_buttons', 'code_register_button' );
    
}
function code_add_button( $plugin_array ) {
    $plugin_array['mycodebutton'] = $dir = plugins_url( 'tiny_mce_button.js', __FILE__ );
    return $plugin_array;
}
function code_register_button( $buttons ) {
    array_push( $buttons, 'codebutton' );
    return $buttons;
}
?>
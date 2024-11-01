<?php 
/**
 * Plugin Name: WP EASY POLL
 * Description: Users could easily add voting poll in wordpress driven sites with necessary features 
 * Version: 1.0
 * Author: Mushfiqul Hasan (Tuhin)
 */
require_once("widget_poll.php");

require_once("show_poll_frontend.php"); 
require_once("function_ip.php");
require_once("frontend_poll_process.php");  
require_once("function_show_poll.php");
require_once("tiny_mce_button.php");

add_action('wp_footer','get_style_data');
function get_style_data(){
?>
    
    <script type="text/javascript">
    

          var element=parseInt(jQuery('#poll_class_tuh').css('width'))-18;
            jQuery('.image_bar').css('width',element+"px");
        jQuery('.image_bar').css('margin','0 auto');
      
    </script>
    
        
<?php                           
}
function widget_data_send(){
?>    
<script type="text/javascript">	
													
    
    function key_press(test,page_or_not,random_num){

 var value_widget=jQuery('#register'+test+'__'+random_num).serializeArray();

  if(value_widget.length!=0){
            
             	  jQuery(document).ajaxStart(function(){
    jQuery("#preloader_"+test+"__"+random_num).css("display","block");
     jQuery("#register"+test+"__"+random_num).css("display","none");
  });
  
  jQuery(document).ajaxComplete(function(){
    jQuery("#preloader_"+test+"__"+random_num).css("display","none");
    jQuery("#register"+test+'__'+random_num).css("display","block");
  });   
            
            
            
            
        var data = {
            url:        '<?php echo get_admin_url()?>admin-ajax.php',
            dataType:   'POST',
            action:     'tuh',
            hide  : test,
            page  : page_or_not,
            
            ans_name:   jQuery('#register'+test+'__'+random_num).serializeArray()
            
        };

        var myRequest = jQuery.post(ajax_object.ajaxurl, data, function(response){
            
            
            jQuery("#poll_"+test+'__'+random_num).html(response);
        });

    }
   
        
    else{
       
        alert("You have to select atleast one item or you have already voted.");
    }    
        
}
    
  

</script>  



<?php
}
if(!empty($_REQUEST['ans_name'])){


// this hook is fired if the current viewer is not logged in
do_action( 'wp_ajax_nopriv_' . $_REQUEST['ans_name'] );
 
// if logged in:
do_action( 'wp_ajax_' . $_POST['ans_name'] );

}


add_action('wp_enqueue_scripts','widget_data_send');


add_action( 'admin_head', 'admin_css' );
add_action( 'wp_head', 'admin_css' );
function admin_css()
{
echo '<link rel="stylesheet" type="text/css" href="'.plugins_url().'/wp-easy-poll/style_admin_back.css">';
}
require_once("hidden_page.php");
require_once("poll_process.php");

register_activation_hook(__FILE__,'install_poll');
function install_poll()
{
global $wpdb;

$table_name_2 = $wpdb->prefix."poll_question";
$sql_2="CREATE TABLE IF NOT EXISTS `$table_name_2` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `question` varchar(250) NOT NULL,
  `question_uid` varchar(250) NOT NULL,
  `is_login_req` int(4) NOT NULL,
  `poll_public`  int(4) NOT NULL,
  `method`  varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ";



$table_name = $wpdb->prefix."poll_answer";
$sql="CREATE TABLE IF NOT EXISTS `$table_name` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `answer` varchar(250) NOT NULL,
  `answer_type` int(4) NOT NULL,
  `question_id` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ";

$table_name_3 = $wpdb->prefix."poll_answer_result";
$sql_3="CREATE TABLE IF NOT EXISTS `$table_name_3` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `answer_id` varchar(250) NOT NULL,
  `ip` varchar(250) NOT NULL,
  `user_id` int(250) NOT NULL,
  `question_uid` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
dbDelta($sql_2);
dbDelta($sql_3);
}




function add_js(){
    ?>
    
    <script type="text/javascript">

function on_click(){
jQuery("#answer_div").append('<input type="text" size="40" name="answer[]" /> <br/>');
}

</script>
<?php
}



add_action('admin_menu','add_poll_admin');
function add_poll_admin(){
    
    add_object_page('wp EASY POLL','WP EASY POLL','','wp-easy-poll/poll_admin.php','');
    
    add_submenu_page( __FILE__, 'Add poll', 'Add poll', 'manage_options',
'wp-easy-poll/', 'show_add_poll' );

    
    add_submenu_page( __FILE__, 'Publish poll', 'Publish poll', 'manage_options',
__FILE__.'/includes', 'show_poll' );

add_submenu_page( __FILE__, 'Poll details', 'Poll details', 'manage_options',
__FILE__.'/show_poll', 'show_poll_result_backend' );

}

function show_add_poll(){
    require_once("wp_menu.php");
}


function show_poll(){
    require_once("includes/show_poll.php");
}
function show_poll_result_backend(){
    require_once('show_poll/backend_show_poll_result.php');
}
add_action('admin_enqueue_scripts','add_js');

<?php
function myplugin_action_admin_menu()  
{  
    global $_registered_pages;  
    $hookname = get_plugin_page_hookname('process-page', 'process.php');  
    if (!empty($hookname)) {  
        add_action($hookname, 'myplugin_adminpage_hidden');  
    }  
    $_registered_pages[$hookname] = true;  
}  
  
/** 
 * Admin page: hidden page 
 */  
function myplugin_adminpage_hidden()  
{  
    
    global $wpdb;
    // Page contents 
    $del_poll_code=esc_sql($_POST['del_poll']);
$table_name_question=$wpdb->prefix."poll_question";
    $table_name_answer=$wpdb->prefix."poll_answer";
    $table_result=$wpdb->prefix."poll_answer_result";




$cookie_id_remove=$_COOKIE['cookie_wp_poll'];
$cookie_id_to_remove=$del_poll_code;
$test = explode('_', $cookie_id_remove);
$arr_filter=array_filter($test);

$im=implode("__",$test);

$diff=array_filter(array_diff($arr_filter,$cookie_id_to_remove));
$string=implode("__",$diff);




setcookie( 'cookie_wp_poll', $string, time()+3600*24*300, COOKIEPATH, COOKIE_DOMAIN );

foreach($del_poll_code as $del_poll_arr){
    
    
$q1=$wpdb->query(
	"
	DELETE FROM $table_name_question WHERE question_uid='$del_poll_arr'
	"
);

$q2=$wpdb->query(
	"
	DELETE FROM $table_name_answer WHERE question_id='$del_poll_arr'
	"
);

$q3=$wpdb->query(
	"
	DELETE FROM $table_result WHERE question_uid='$del_poll_arr'
	"
);
    
    
}



    header("Location:?page=wp-easy-poll/poll_admin.php/includes");
     
}  
  
// Add actions  
add_action('admin_menu', 'myplugin_action_admin_menu');  
?>
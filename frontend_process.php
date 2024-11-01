<?php
function poll_hook_frontend()  
{  
    global $_registered_pages;       
    $hookname = get_plugin_page_hookname('process_frontend', 'process2.php');    
   if (!empty($hookname)) {  
        add_action($hookname, 'process_frontend');  
    } 
   $_registered_pages[$hookname] = true;  
}  
  
/** 
 * Admin page: hidden page 
 */  
function process_frontend()  
{  
$vote_result=$_POST['ans_name'];
$uid=uniqid(); 
global $wpdb;
$table_vote=$wpdb->prefix."poll_answer_result";
$count=count($vote_result);
 $hidden=$_POST['hide'];
 
$ans_data=$wpdb->get_results("SELECT  * FROM $table_vote WHERE question_id='$hidden'" );

if($count>1){
foreach($vote_result as $vote_arr){
   
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr,
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden
                        ));
 }
 
}

elseif($count==1){

     $wpdb->insert($table_vote,
                array('answer_id' => $vote_result,
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden
                        ));
}
}
// Add actions  
add_action('admin_menu', 'poll_hook_frontend');  
?>
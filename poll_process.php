<?php
function poll_hook()  
{  
    global $_registered_pages;       
    $hookname = get_plugin_page_hookname('add-poll-process', 'process.php');  
      
   if (!empty($hookname)) {  
        add_action($hookname, 'add_poll_hook');  
    }  
      
   $_registered_pages[$hookname] = true;  
}  
  
/** 
 * Admin page: hidden page 
 */  
function add_poll_hook()  
{  

 $question=esc_sql($_POST['question']);
$answer=esc_sql($_POST['answer']);
$user_can=esc_sql($_POST['vote_user']);
$answer_type=esc_sql($_POST['poll_type']);
$backend_poll_show=esc_sql($_POST['poll_publish_condition']);

$method = esc_sql($_POST['method']);


$uid=uniqid(); 
//echo $answer;
global $wpdb;

if(trim($question)!=""){
$table_name=$wpdb->prefix."poll_answer";

$table_name_2=$wpdb->prefix."poll_question";
if($user_can==1){
$wpdb->insert($table_name_2,
                array('question' => $question,
                      'question_uid' => $uid,
                      'is_login_req' => '1',
                      'poll_public'  => $backend_poll_show,
                      'method'       => $method
                        ));
 }
 elseif($user_can==0 ){
    $wpdb->insert($table_name_2,
                array('question' => $question,
                      'question_uid' => $uid,
                      'is_login_req' => '0',
                      'poll_public'  => $backend_poll_show,
                      'method'       => $method
                        ));
 
 }
foreach($answer as $print_answer){
    //echo $print_answer;
    if(trim($print_answer)!=""){
    
    if(trim($user_can)==1 && trim($answer_type)==1){
    $wpdb->insert($table_name,
                    array(
                        
                        'answer'   => $print_answer,

                        'answer_type' =>'1',
                        'question_id' =>$uid
    
      ));
    }
    elseif(trim($user_can)==0 && trim($answer_type)==1){
    $wpdb->insert($table_name,
                    array(
                        
                        'answer'   => $print_answer,
                    
                        'answer_type' =>'1',
                        'question_id' =>$uid
                        
    
      ));
    }
    elseif(trim($user_can)==0 && trim($answer_type)==0){
    $wpdb->insert($table_name,
                    array(
                        
                        'answer'   => $print_answer,
                     
                        'answer_type' =>'0',
                        'question_id' =>$uid
    
      ));
    }
      elseif(trim($user_can)==1 && trim($answer_type)==0){
    $wpdb->insert($table_name,
                    array(
                        
                        'answer'   => $print_answer,
                  
                        'answer_type' =>'0',
                        'question_id' =>$uid
    
      ));
    }
   

}
}
 }
 
 else{
    echo "Please fill up the question field.";
 }
 
     header("Location:admin.php?page=wp-easy-poll/poll_admin.php/includes");
}  
  
// Add actions  
add_action('admin_menu', 'poll_hook');  


?>
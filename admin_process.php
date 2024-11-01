<?php
$question=mysql_real_escape_string($_POST['question']);
$answer=trim($_POST['answer']);

$method=$_POST['method'];

$user_can=mysql_real_escape_string($_POST['vote_user']);
$answer_type=mysql_real_escape_string($_POST['poll_type']);
$uid=uniqid(); 
$backend=$_POST['poll_publish_condition'];
//echo $answer;
global $wpdb;


$table_name=$wpdb->prefix."poll_answer";

$table_name_2=$wpdb->prefix."poll_question";



if($user_can==1){
    
   
        
        $wpdb->insert($table_name_2,
                array('question' => $question,
                      'question_uid' => $uid,
                      'is_login_req' => '1',
                      'poll_public'  => $backend,
                      'method'       => $method
                        ));
        }
    

 
 elseif($user_can==0){
    $wpdb->insert($table_name_2,
                array('question' => $question,
                      'question_uid' => $uid,
                      'is_login_req' => '0',
                      'method'       => $method,
                      'poll_public'  => $backend
                        ));

 
 }
foreach($answer as $print_answer){
    //echo $print_answer;
    if($print_answer!=""){
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
?>
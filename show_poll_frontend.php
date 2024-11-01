<?php
function add_poll( $atts ) {
	extract( shortcode_atts( array(
		'poll_id' => 'no foo',
	
	), $atts, 'poll_id' ) );
    global $wpdb;
     
     
   $url = plugins_url()."/wp-easy-poll/";        
?>

<div id='poll_class_tuh'>
<?php
    $table_name_question=$wpdb->prefix."poll_question";
    $table_name_answer=$wpdb->prefix."poll_answer";
    $table_result=$wpdb->prefix."poll_answer_result";
    $question_data = $wpdb->get_results("SELECT  * FROM $table_name_question WHERE question_uid='$poll_id'" );
     $total_vote_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_result WHERE question_uid='$poll_id'" );
     $ans_data=$wpdb->get_results("SELECT  * FROM $table_name_answer WHERE question_id='$poll_id'" );
     $current_user = wp_get_current_user();
    $current_user_id=$current_user->ID;
     $current_user_count=$wpdb->get_var("SELECT COUNT(*) FROM $table_result WHERE user_id='".$current_user_id."' AND question_uid='$poll_id'" );
   $find_ip=$_SERVER['REMOTE_ADDR'];
   if(count($question_data)!=0){
   $ques=$question_data[0]->question_uid;
    $backend=$question_data[0]->poll_public;
   $is_login_req=$question_data[0]->is_login_req;
   }
   else{
    $ques=null;
    $backend=null;
   $is_login_req=null;
   }        
   $method_query=$wpdb->get_results("SELECT * FROM $table_name_question WHERE question_uid='$poll_id'") ;
   if(count($method_query)!=0){
   $method=$method_query[0]->method;
    }
    else{
       $method=null; 
    }
     $ip_restrict=$wpdb->get_var("SELECT COUNT(*) FROM $table_result WHERE ip='$find_ip' AND question_uid='$poll_id'"); 
    $is_unvoted=$wpdb->get_var("SELECT COUNT(*) FROM $table_result WHERE question_uid='$poll_id'"); 
    //processing cookie
    if(!empty($_COOKIE['cookie_wp_poll'])){
    $cookie_id=$_COOKIE['cookie_wp_poll'];
    }
    else{
        $cookie_id=null;
    }  
   $c2="__".$cookie_id;
  // echo "<h1>".$c2."</h1>";
   $s= explode('__', $c2);
    $unique_id=rand();    
    ////////////////////
    
      //  restriction method 
        

      /////////////////
 
    
    if(($method=="ip") && ($ip_restrict>0) && $is_login_req!=1 ){
   echo poll_func_ex($poll_id,0,"");
  }
  elseif(($method=="cookie")&& (in_array ( $poll_id , $s )) && $is_login_req!=1 ){      
        echo poll_func_ex($poll_id,0,"");
                
    }
    elseif(($method=="ci")&& ((in_array ( $poll_id , $s )) || ($ip_restrict>0) ) && $is_login_req!=1 ){
        echo poll_func_ex($poll_id,0,"");
  }        
       elseif($method=="user" && !is_user_logged_in() && $is_login_req!=1){
            echo   poll_func_ex($ques,0,"<h3 style='text-align:center'> This poll is restricted, only logged in users can vote</h3>");
       }
       elseif($method=="user" && is_user_logged_in() && ($current_user_count!="" || $current_user_count!=0 ) ){
            echo   poll_func_ex($ques,0,"");
       }
   elseif(($method=="cookie") && (!in_array ( $poll_id , $s ))){
    require("display_page_form.php");
        
   }
    elseif(($method=="ip") && $ip_restrict==0){
    require("display_page_form.php");
   }
   elseif(( $method=="ci") && ((!in_array ( $poll_id , $s )) && ($ip_restrict==0) ) ){
    require("display_page_form.php");
   }
   elseif((($method=="user")) && is_user_logged_in() && ($current_user_count=="" || $current_user_count==0 )){    
            require("display_page_form.php");
   }
   
   
   elseif(($is_login_req==1 && $method=="ip") && $ip_restrict==0){
    require("display_page_form.php");
   }
   elseif(($is_login_req==1 && $method=="ci") && ((!in_array ( $poll_id , $s )) && ($ip_restrict==0) ) ){
    require("display_page_form.php");
   }
   elseif((($method=="user")) && is_user_logged_in() && ($current_user_count=="" || $current_user_count==0 )){    
            require("display_page_form.php");
   }
   
   
    
  
?>
</div>

<?php
 }
 add_shortcode( 'poll', 'add_poll' );
?>
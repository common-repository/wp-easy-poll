<?php
add_action('wp_head', 'plugin_set_ajax_url');
function plugin_set_ajax_url() {
?>
    <script type="text/javascript">
        var ajax_object = {};
        ajax_object.ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php
}
?>
<?php
require_once("function_ip.php");
add_action( 'wp_ajax_nopriv_tuh', 'my_ajax' );
add_action( 'wp_ajax_tuh', 'my_ajax' );
add_action('init','poll_cookie');
function poll_cookie(){
   global $wpdb;
    $table_name_question=$wpdb->prefix."poll_question";
 if(!empty($_POST['hide'])) {  
    
 $hidden=$_POST['hide'];

$method_query=$wpdb->get_results("SELECT * FROM $table_name_question WHERE question_uid='$hidden'") ;


   
if(count($method_query)>0){
$method = $method_query[0]->method;  
$poll_public = $method_query[0]->poll_public;  
}
else{
   $method=null;   
   $poll_public=null; 
 
    
}


   if($method=="cookie" || $method=="ci"){ 
    
    if (!empty($_COOKIE['cookie_wp_poll'])){

 


$method=$method_query[0]->method;
    $vote_result=($_POST['ans_name']);

    $cookie_id=($_COOKIE['cookie_wp_poll']);
  
    
   $c2="__".$cookie_id;
  
   $s= explode('__', $c2);
   
   if ( in_array ( $hidden , $s ) ) {
      }
 else{
  
    $hidden=$_POST['hide'];

if(!empty($cookie_id)){
    
       setcookie( 'cookie_wp_poll', $cookie_id."__".$hidden, time()+3600*24*3000, COOKIEPATH, COOKIE_DOMAIN );

}
elseif(($cookie_id=="") && (count($vote_result)!=0) ){
      
       setcookie( 'cookie_wp_poll', $hidden, time()+3600*24*3000, COOKIEPATH, COOKIE_DOMAIN );
      $s[]=$hidden;
}


}
}


else {  
    

    
    
if(!empty($_POST['hide']) && !empty($_POST['ans_name']) ){
 $hidden=$_POST['hide'];

    $vote_result=$_POST['ans_name'];
}
    

      
       setcookie( 'cookie_wp_poll', $hidden, time()+3600*24*300, COOKIEPATH, COOKIE_DOMAIN );
     $s[]=$hidden;
      
    
}




}

}
}







function my_ajax(){
if(!empty($_POST['ans_name'])){
$vote_result=$_POST['ans_name'];
}

$uid=uniqid(); 
global $wpdb;
$table_vote=$wpdb->prefix."poll_answer_result";
$count=count($vote_result);
 $hidden=$_POST['hide'];
 $ref=$_SERVER["HTTP_REFERER"];
 if(!empty($_POST['ans_name1'])){
 $ans_page=$_POST['ans_name1'];
 }
 if(!empty($_POST['hide1'])){
 $hide_page=$_POST['hide1'];
 }
$page=$_POST['page'];

$current_user = wp_get_current_user();


$current_user_id=$current_user->ID;

if(empty($s)){
    $s[]=null;
}
if(empty($s_2)){
    $s_2[]=null;
}


$table_name_question=$wpdb->prefix."poll_question";
    $table_name_answer=$wpdb->prefix."poll_answer";    
    
    if(!empty($_POST['hide'])&& !empty($_COOKIE['cookie_wp_poll'])){
    
    $hidden=$_POST['hide'];

       $cookie_id=$_COOKIE['cookie_wp_poll'];
    
   
   $c2="__".$cookie_id;

   $s= explode('__', $c2);
    $s_2= explode('___', $c2);  
   
   
     

 
    }
    
    /******************************************************/
    

    
    $check_res=$wpdb->get_var("SELECT COUNT(*) FROM $table_vote WHERE ip='".get_client_ip()."' AND question_uid='$hidden'" );
    
    $current_user_count=$wpdb->get_var("SELECT COUNT(*) FROM $table_vote WHERE user_id='".$current_user_id."' AND question_uid='$hidden'" );

$method_query=$wpdb->get_results("SELECT * FROM $table_name_question WHERE question_uid='$hidden'") ;
$hide_poll_window=$method_query[0]->is_login_req;
//print_r($method_query);


$method=$method_query[0]->method;

if($hide_poll_window==0){




if($method=="ip"){
    
    
    
    
if(count($vote_result)>0 && $page!=0){



if( $check_res==0){
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
    
   if((($vote_arr['value'])!="") ){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden)
                        );
                        
 }
 }
 echo poll_func_ex($hidden,1,"<h3 style='text-align:center'>Your vote is successfully recived</h3>");

}


}
else{
     echo   poll_func_ex($hidden,1,"<h3 style='text-align:center'><h3 style='text-align:center'>Sorry , your vote could not be counted. Because you have already voted.</h3></h3>");
  
}
}

elseif(count($vote_result) > 0 && $page==0){




    
if($check_res==0){
   
if(is_array($vote_result)){
    

    
foreach($vote_result as $vote_arr){
   if(($vote_arr['value'])!=""){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden
                        ));
                        
 }
 }
 echo poll_func_ex($hidden,0,"<h3 style='text-align:center'>Your vote is successfully recived</h3>");

}


}
else{

       echo   poll_func_ex($hidden,0,"Sorry <h3 style='text-align:center'>Sorry , your vote could not be counted. Because you have already voted.</h3>");
 
}
}




}

//when logging method is cookie and ip
elseif($method=="ci"){
        
 
if(count($vote_result)>0 && $page==0){

echo in_array ( $hidden , $s );
if ( in_array ( $hidden , $s ) || $check_res!=0 ) {
   
   echo poll_func_ex($hidden,0,"<h3 style='text-align:center'>Sorry , your vote could not be counted. Because you have already voted.</h3>"); 
 
}


else{
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
    
   if((($vote_arr['value'])!="") ){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden)
                        );
                        
 }
 }
 echo poll_func_ex($hidden,0,"<h3 style='text-align:center'>Your vote is successfully recived</h3>");

}


}

}

elseif(count($vote_result)>0 && $page!=0){
if ( in_array ( $hidden , $s ) || $check_res!=0 ) {
   echo "Sorry <h3 style='text-align:center'>Sorry , your vote could not be counted. Because you have already voted.</h3>";
   echo poll_func_ex($hidden,1,"Sorry <h3 style='text-align:center'>Sorry , your vote could not be counted. Because you have already voted.</h3>"); 
    echo "test";
}


    
else{
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
   if(($vote_arr['value'])!=""){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden
                        ));
                        
 }
 }
 echo poll_func_ex($hidden,1,"<h3 style='text-align:center'>Your vote is successfully recived</h3>");

}


}

}



}



//when logging method is cookie
elseif($method=="cookie"){
     
   

if(count($vote_result)>0 && $page==0){


if ( (in_array ( $hidden , $s )) || (in_array ( $hidden , $s_2 )) ) {
    
    echo poll_func_ex($hidden,0,"<h3 style='text-align:center'>Sorry , your vote could not be counted. Because you have already voted.</h3>"); 
    
}


else{
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
    
   if((($vote_arr['value'])!="") ){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                     // 'ip' =>get_client_ip(),  
                      'question_uid' => $hidden)
                        );
                        
 }
 }
 echo poll_func_ex($hidden,0,"<h3 style='text-align:center;'> Your vote is successfully recived</h3>");

}


}

}

elseif(count($vote_result)>0 && $page!=0){




if ( in_array ( $hidden , $s ) ) {
    echo poll_func_ex($hidden,1,"<h3 style='text-align:center'><h3 style='text-align:center'>Sorry , your vote could not be counted. Because you have already voted.</h3></h3>"); 
    
}

    
else{
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
   if(($vote_arr['value'])!=""){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      //'ip' =>get_client_ip(),  
                      'question_uid' => $hidden
                        ));
                        
 }
 }
 echo poll_func_ex($hidden,1,"<h3 style='text-align:center'>Your vote is successfully recived</h3>");

}


}

}



}

elseif($method=="user" && is_user_logged_in()){
    
 
    
    
if(count($vote_result)>0 && $page!=0){

if( $current_user_count=="" || $current_user_count==0){
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
    
   if((($vote_arr['value'])!="") ){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'user_id'  => $current_user_id,
                      'question_uid' => $hidden)
                        );
                        
 }
 }
 echo poll_func_ex($hidden,1,"<h3 style='text-align:center'>Your vote is successfully recived</h3>");

}


}
else{
    echo   poll_func_ex($hidden,1,"<h3 style='text-align:center'>Sorry , your vote could not be counted. Because you have already voted.</h3>");
  
}
}

elseif(count($vote_result) > 0 && $page==0){




    

   if( $current_user_count=="" || $current_user_count==0){
if(is_array($vote_result)){
   
    
foreach($vote_result as $vote_arr){
   if(($vote_arr['value'])!=""){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'user_id'  => $current_user_id, 
                      'question_uid' => $hidden
                        ));
                        
 }
 }
 echo poll_func_ex($hidden,0,"<h3 style='padding:0;margin:0;text-align:center;'>Your vote is successfully recived </h3>");

}
}


else{


    echo   poll_func_ex($hidden,0,"<h3 style='padding:0;margin:0;text-align:center;'>Sorry , your vote could not be counted. Because you have already voted.</h3>");
  
}
}




}


}

elseif($hide_poll_window==1){
    

if($method=="ip"){
    
    
    
    
if(count($vote_result)>0 && $page!=0){


if( $check_res==0){
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
    
   if((($vote_arr['value'])!="") ){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden)
                        );
                        
 }
 }
 
?>
 <div class="hide_text_js"><?php echo poll_func_ex($hidden,1,"<h3 style='text-align:center;'> You have successfully voted </h3>"); ?></div>
 <?php
}


}

}

elseif(count($vote_result) > 0 && $page==0){




    
if($check_res==0){
   
if(is_array($vote_result)){
    
   
    
foreach($vote_result as $vote_arr){
   if(($vote_arr['value'])!=""){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden
                        ));
                        
 }
 }
 ?>
 <div class="hide_text_js"><?php echo poll_func_ex($hidden,0,"<h3 style='text-align:center;'> You have successfully voted </h3>"); ?></div>
 <?php
}


}

}




}

//when logging method is cookie and ip
elseif($method=="ci"){
        
 
if(count($vote_result)>0 && $page==0){


if ( in_array ( $hidden , $s ) || $check_res!=0 ) {
   
}


else{
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
    
   if((($vote_arr['value'])!="") ){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden)
                        );
                        
 }
 }
?>
 <div class="hide_text_js"><?php echo poll_func_ex($hidden,0,"<h3 style='text-align:center;'> You have successfully voted </h3>"); ?></div>
 <?php
}


}

}

elseif(count($vote_result)>0 && $page!=0){
if ( in_array ( $hidden , $s ) || $check_res!=0 ) {
      //echo poll_func_ex($hidden,1,"Sorry <h3 style='text-align:center'>Sorry , your vote could not be counted. Because you have already voted.</h3>"); 

}


    
else{
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
   if(($vote_arr['value'])!=""){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'ip' =>get_client_ip(),  
                      'question_uid' => $hidden
                        ));
                        
 }
 }
 ?>
 <div class="hide_text_js"><?php echo poll_func_ex($hidden,1,"<h3 style='text-align:center;'> You have successfully voted </h3>"); ?></div>
 <?php
}


}

}



}



//when logging method is cookie
elseif($method=="cookie"){
     
   

if(count($vote_result)>0 && $page==0){


if ( (in_array ( $hidden , $s )) || (in_array ( $hidden , $s_2 )) ) {
    
}


else{
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
    
   if((($vote_arr['value'])!="") ){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                     // 'ip' =>get_client_ip(),  
                      'question_uid' => $hidden)
                        );
                        
 }
 }
 ?>
 <div class="hide_text_js"><?php echo poll_func_ex($hidden,0,"<h3 style='text-align:center;'> You have successfully voted </h3>"); ?></div>
 <?php  
}


}

}

elseif(count($vote_result)>0 && $page!=0){




if ( in_array ( $hidden , $s ) ) {
   
}

    
else{
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
   if(($vote_arr['value'])!=""){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      //'ip' =>get_client_ip(),  
                      'question_uid' => $hidden
                        ));
                        
 }
 }
 ?>
 <div class="hide_text_js"><?php echo poll_func_ex($hidden,1,"<h3 style='text-align:center;'> You have successfully voted </h3>"); ?></div>
<?php
}


}

}



}

elseif($method=="user" && is_user_logged_in()){
    echo "zxfcl;kwa";
if(count($vote_result)>0 && $page!=0){

if( $current_user_count=="" || $current_user_count==0){
if(is_array($vote_result)){
foreach($vote_result as $vote_arr){
    
   if((($vote_arr['value'])!="") ){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'user_id'  => $current_user_id,
                      'question_uid' => $hidden)
                        );
                        
 }
 }


}
?>
<div class="hide_text_js"><?php echo poll_func_ex($hidden,1,"<h3 style='text-align:center;'> You have successfully voted </h3>"); ?></div>
<?php
}
}

elseif(count($vote_result) > 0 && $page==0){



if( $current_user_count=="" || $current_user_count==0){
if(is_array($vote_result)){
    
foreach($vote_result as $vote_arr){
   if(($vote_arr['value'])!=""){
    $wpdb->insert($table_vote,
                array('answer_id' => $vote_arr['value'],
                      'user_id'  => $current_user_id, 
                      'question_uid' => $hidden
                        ));
                        
 }
 }
 ?>
 
 <div class="hide_text_js"><?php echo poll_func_ex($hidden,0,"<h3 style='text-align:center;'> You have successfully voted </h3>"); ?></div>
 
 <?php
}
}

}




}

?>
<script type="text/javascript"> jQuery('.hide_text_js').delay(2000).fadeOut(); </script>
<?php


//header("Location:".$ref);
die(); 
}

}


?>

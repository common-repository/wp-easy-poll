<?php 
class poll_widget extends WP_Widget
{
  function poll_widget()
  {
    $widget_ops = array('classname' => 'WP EASY POLL', 'description' => 'Displays polls' );
    $this->WP_Widget('poll_widget', 'WP EASY POLL', $widget_ops);
  }
 
  function form($instance)
  {
   // $instance = wp_parse_args( (array) $instance, array( 'title' => 'widget_poll' ) );
    //$title = $instance['title'];

  $d = array('question' => '','question_id_wdg' => '');
  $instance = wp_parse_args( (array) $instance, $d );
  
 
  
  
    global $wpdb;
$table_name_question=$wpdb->prefix."poll_question";

$question_qid = $wpdb->get_results( 
	"SELECT * FROM $table_name_question"
);
$question_query = $wpdb->get_results( "SELECT * FROM $table_name_question");
      
 
 echo "<select id='".$this->get_field_id('question_id_wdg')."' name='".$this->get_field_name('question_id_wdg')."'>";
 
?>

<?php
foreach($question_query as $q_widget){
    $qus=$q_widget->question_uid;
    
    ?> 
    
  <option id="<?php echo $this->get_field_id('question_id_wdg') ?>" value="<?php echo $q_widget->question_uid ?>" <?php if ($qus==$instance['question_id_wdg']){ echo 'selected="selected"';} ?> ><?php echo $q_widget->question; ?> </option> 
  <?php
  
  }
  
  echo "</select>";
  
 
}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
              
		$instance['question'] = $new_instance['question'];
        $instance['question_id_wdg']= $new_instance['question_id_wdg'];
		return $instance;
	}
    
    
  function widget($args, $instance)
  {
    
            
            
         
    
    extract( $args );

    $title = apply_filters('widget_title', "WP EASY POLL");
    $question_wdg=$instance['question_id_wdg'];
   
         global $wpdb;
     
  
   $url = plugins_url()."/wp-easy-poll/";
   //echo $url;
   require_once("function_ip.php");
   
   
   /************ *******************/
   

   /***********************************************************/
  

      echo $before_widget;
      echo $before_title.$title.$after_title;
                
   
    $table_name_question=$wpdb->prefix."poll_question";
    $table_name_answer=$wpdb->prefix."poll_answer";
    $table_result=$wpdb->prefix."poll_answer_result";
    $find_ip=$_SERVER["REMOTE_ADDR"];
    
   
    
    
    
  //  echo $question_wdg;
    
   
   
   
   
   $ip_restrict=$wpdb->get_var("SELECT COUNT(*) FROM $table_result WHERE ip='$find_ip' AND question_uid='$question_wdg'"); 

    $query = $wpdb->get_results("SELECT  * FROM $table_name_question WHERE question_uid='$question_wdg'" );
    
    
    if(count($query)>0){
    $ques=$query[0]->question_uid;
    $backend=$query[0]->poll_public;
    $id_question=$query[0]->id;
    $method=$query[0]->method;
    $user_permit= $query[0]->is_login_req;
    $question=$query[0]->question;
    }
    else{
        $ques=null;
    $backend=null;
    $id_question=null;
    $method=null;
    $user_permit= null;
    $question=null;
    }
    
      
        $total_vote_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_result WHERE question_uid='$ques'" );
    
    $ans_data=$wpdb->get_results("SELECT  * FROM $table_name_answer WHERE question_id='$question_wdg'" );
        
    ?>
<script type="text/javascript">
jQuery(document).ajaxComplete(function(){
    jQuery("#preloader_<?php echo $ques ?>__<?php echo $random_number; ?>").css("display","none");
    //jQuery("#register<?php echo $ques; ?>").css("display","block");
  });
</script>


     <?php 


if(!empty($_COOKIE['cookie_wp_poll']))
{
$cookie_id=$_COOKIE['cookie_wp_poll'];

}
else{
    $cookie_id=null;
}
 $c2="__".$cookie_id;
   $s= explode('__', $c2); 
   
///////////////     
// Finding restriction method 
        
        //query
        $is_unvoted=$wpdb->get_var("SELECT COUNT(*) FROM $table_result WHERE question_uid='$question_wdg'"); 
        $method_query=$wpdb->get_results("SELECT * FROM $table_name_question WHERE question_uid='$question_wdg'") ;
        $current_user = wp_get_current_user();
        $current_user_id=$current_user->ID;
        $current_user_count=$wpdb->get_var("SELECT COUNT(*) FROM $table_result WHERE user_id='".$current_user_id."' AND question_uid='$question_wdg'" );
     
      if(count($method_query)>0){
        $method=$method_query[0]->method;
      }
      else{
        $method=null;
      }
      $random_number=rand();
      /////////////////
   
   
   
   
   
   
    if((($method=="ip") && ($ip_restrict>0) ) && $user_permit!=1 ){
     
    
    
      
   echo poll_func_ex($question_wdg,1,"");
  
  
  }
  
  elseif(($method=="cookie")&& (in_array ( $question_wdg , $s ))  && $user_permit!=1 ){
    
        echo poll_func_ex($question_wdg,1,"");
  
    
    }
 
  
    elseif(($method=="ci")&& ((in_array ( $question_wdg , $s )) || ($ip_restrict>0)) && $user_permit!=1 ){
         echo poll_func_ex($question_wdg,1,"");
         
  
  }
 elseif($method=="user" && !is_user_logged_in() ){
            echo   poll_func_ex($ques,1,"<h3 style='text-align:center'> This poll is restricted, only logged in users can vote</h3>");
       }
   
 
elseif($method=="user" && is_user_logged_in() && ($current_user_count!="" || $current_user_count!=0 ) ){
            echo   poll_func_ex($ques,1,"");
       }

 elseif($user_permit==0 || ($user_permit==1 && $method=="cookie") && (!in_array ( $question_wdg , $s ))){
    require("display_widget_form.php");
   }
    elseif($user_permit==0 || ($user_permit==1 && $method=="ip") && $ip_restrict==0){
    require("display_widget_form.php");
   }
   elseif($user_permit==0 || ($user_permit==1 && $method=="ci") && ((!in_array ( $question_wdg , $s )) && ($ip_restrict==0) ) ){
    require("display_widget_form.php");
   }
   elseif(($user_permit==0 || ($user_permit==1 && $method=="user")) && is_user_logged_in() && ($current_user_count=="" || $current_user_count==0 )){
                   
            require("display_widget_form.php");
            
   }
    elseif(($user_permit==0 || ($user_permit==1 && $method=="user")) && !is_user_logged_in() &&($current_user_count=="" || $current_user_count==0 )){
                   
            //require_once("display_widget_form.php");
        
   }
   
    elseif($user_permit==0 || ($user_permit==1 && $is_unvoted==0)){
 
   require("display_widget_form.php");
 }


    echo $after_widget;
    }
 
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("poll_widget");') );
?>

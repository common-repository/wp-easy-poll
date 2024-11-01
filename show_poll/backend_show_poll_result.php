<?php
global $wpdb;
$table_name_question=$wpdb->prefix."poll_question";
$table_name_answer=$wpdb->prefix."poll_answer";
$table_result=$wpdb->prefix."poll_answer_result";


$q = $wpdb->get_results( 
	"SELECT * FROM $table_name_question"
);

$url = plugins_url()."/wp-easy-poll/";
?>
<table class="widefat backend_poll">

<tr class="widefat tr_back">
            <td>
            
                <h3> #  </h3>
            
            </td>
            <td>
                
                <h3> Question </h3>
                
            </td>
            
            <td>
                
                <h3> Result </h3>
                
            </td>
            
            <td>
                
                <h3> Hide window after vote </h3>
                
            </td>
            <td>
                
                <h3> Show poll result only from backend </h3>
                
            </td>
            <td>
                
                <h3> Restriction method </h3>
                
            </td>
        </tr>


<?php
$k=0;
foreach($q as $q_arr){
    $question=$q_arr->question;
    $question_uid=$q_arr->question_uid;
    $hide_window=$q_arr->is_login_req;
    $poll_public=$q_arr->poll_public;
    $method=$q_arr->method;
     
     
     
     $total_vote_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_result WHERE question_uid='$question_uid'" );
$ans_data=$wpdb->get_results("SELECT  * FROM $table_name_answer WHERE question_id='$question_uid'" );

    $k++;
    
    ?>
        
    <tr class="post_table">
            <td>
            
                <h3> <?php echo $k; ?>  </h3>
            
            </td>
            <td >
                
                <h3> <?php echo $question; ?> </h3>
                
            </td>
            
            <td >
                <?php
                
                    
                    foreach($ans_data as $ans_res){
                          
                             $answer_id=$ans_res->id;
                             $type=$ans_res->answer_type;
                            $answer_name=$ans_res->answer;
                            $vote_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_result WHERE answer_id='$answer_id'" );
                         if($vote_count==0){
                                //error_reporting(0);
                                  
                            $vote_percent=0;
                            
                            $bar=$vote_percent;
                            $bar_another=(100-$vote_percent);
                             }
                            else{
                            $vote_percent=($vote_count*100)/$total_vote_count;
                            
                            $bar=$vote_percent;
                            $bar_another=(100-$vote_percent);
                            }

                         

                                
                ?>
                
                <h3> <?php echo $answer_name; ?> </h3>
                
                
                <div class="image">
                    <img class="bar floatleft" src="<?php echo $url."bar.png"; ?>" width="<?php echo $bar; ?>%" height="15"/>
                    <img class="bar2 floatright" src="<?php echo $url."bar2.png"; ?>" width="<?php echo $bar_another; ?>%" height="15"/>
                </div>
                <p>Total vote counted <?php echo $vote_percent."%"; ?> <?php echo $vote_count ?> out of <?php echo $total_vote_count ?> </p>
                <?php 
                    } 
                
                ?>
            </td>
            <td>
                
                <?php
                
                    if($hide_window==1){
                        ?>
                        
                        <img src="<?php echo $url.'/tick.png'; ?>" />
                        <?php
                    }
                    elseif($hide_window==0){
                        ?>
                        <img src="<?php echo $url.'/cross.png'; ?>" />
                        
                        <?php
                    }
                
                ?>
                
            </td>
            <td>
                
               <?php
                
                    if($poll_public==1){
                        ?>
                        
                        <img src="<?php echo $url.'/tick.png'; ?>" />
                        <?php
                    }
                    elseif($poll_public==0){
                        ?>
                        <img src="<?php echo $url.'/cross.png'; ?>" />
                        
                        <?php
                    }
                
                ?>
                
            </td>
            
               <td>
                
              <?php
              
              if($method=="ip"){
                ?>
                <h3>Restriction system of this poll is <i> IP based </i></h3>
                
                <?php
              }
              
               ?>
                
                
               <?php
              
              if($method=="ci"){
                ?>
                <h3>Restriction system of this poll is <i> COOKIE and IP based </i></h3>
                
                <?php
              }
              
               ?> 
                
                
                <?php
              
              if($method=="cookie"){
                ?>
                <h3>Restriction system of this poll is <i>COOKIE based</i> </h3>
                
                <?php
              }
              
               ?>
               
               
               <?php
              
              if($method=="user"){
                ?>
                <h3>Restriction system of this poll is <i>USER  based</i> </h3>
                
                <?php
              }
              
               ?>
               
                
                
                
            </td>
            
            
        </tr>
    
    <?php
    
    
}
?>

    
    </table>
<?php
function poll_func_ex($question_wdg,$page_or_widget,$extra_data){
    global $wpdb;
    $i=0;
   $url = plugins_url()."/wp-easy-poll/";
    $table_name_question=$wpdb->prefix."poll_question";
    $table_name_answer=$wpdb->prefix."poll_answer";
    $table_result=$wpdb->prefix."poll_answer_result";
    $query = $wpdb->get_results("SELECT  * FROM $table_name_question WHERE question_uid='$question_wdg'" );
 
    $ques=$query[0]->question_uid;
    $backend=$query[0]->poll_public;
    $ans_data=$wpdb->get_results("SELECT  * FROM $table_name_answer WHERE question_id='$question_wdg'" );
     $total_vote_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_result WHERE question_uid='$ques'" );

        $user_permit= $query[0]->is_login_req;
        if($page_or_widget==1){
        ?>
        <div id='poll_class_tuh_2'>
        <div class="full" id="poll_<?php echo $ques;?>">
        <div class="header">
            <p><?php echo "Q: ".$query[0]->question;?></p>
        </div>
        <div class="content">
            <?php 
                    echo $extra_data; 
                    
                        foreach($ans_data as $ans_res){
                            
                             $answer_id=$ans_res->id;
                             $type=$ans_res->answer_type;
                            
                            $vote_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_result WHERE answer_id='$answer_id'" );
                                    if($vote_count==0){
                                  
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
            <div class="input">           
                     <?php 
                            if($type==1){
                           
                            echo $ans_res->answer; 
                                
                            
                            }
                            elseif($type==0){
                                
                                echo $ans_res->answer; 
                                }
                                ?>
                <br />
                <?php 
                if($backend==0){
                ?>
                <div class="image">
                    <img class="bar floatleft" src="<?php echo $url."bar.png"; ?>" width="<?php echo $bar; ?>%" height="15"/>
                    <img class="bar2 floatright" src="<?php echo $url."bar2.png"; ?>" width="<?php echo $bar_another; ?>%" height="15"/>
                </div>
                <p>Total vote counted <?php echo $vote_percent."%"; ?> <?php echo $vote_count ?> out of <?php echo $total_vote_count ?> </p>
                <?php
                }
                else{
                    echo "<p style='color:red; text-align:center;'>Admin has restricted to show this poll result only from backend </p>";
                }
                ?>
                
                
            </div>
            <?php
                }
            ?>
                
                </div>
                </div> 
                 </div>                 
      <?php
            }
     elseif($page_or_widget==0){
        ?>
        <div id='poll_class_tuh_2'>
       <div class="full_page">
        <div class="header_page">
            <p><?php echo "Q: ".$query[0]->question; ?></p>
        </div>
        <div class="content_page">
        <?php echo $extra_data; ?>
        <?php
        //  if($user_permit==0 ){
        ?>
                  
                    <div id='vote_option'>
                    <?php
                        foreach($ans_data as $ans_res){
                          
                             $answer_id=$ans_res->id;
                             $type=$ans_res->answer_type;
                            
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
                            
                            
                              
                            
                            
                            
                            $number = $vote_percent;
                            if(is_float($number)) {
                             $number= number_format($number, 2);
                            }else {
                             $number= $number;
                            }
                            
                            
                            ?>
            <div class="input">
                                <?php 
                                    if($type==1){
                                 ?>
                                    <?php echo $ans_res->answer; 
                                }
                                elseif($type==0){
                                     echo $ans_res->answer; 
                                     }
                                     ?>                                     
                    
                    <?php if($backend==0){ ?>
                    <div id="display_bar" class="image_bar" >
                        <img class="bar floatleft" src="<?php echo $url.'bar.png'; ?>" width="<?php echo $bar; ?>%" height="15"/>
                        <img class="bar2 floatleft" src="<?php echo $url.'bar2.png'; ?>" width="<?php echo $bar_another; ?>%" height="15"/>
                    </div>
                     <p>Total vote counted <?php echo $number.'%'; ?> <?php echo $vote_count ?> out of <?php echo $total_vote_count ?> </p>
              <?php } 
              elseif($backend==1){
                    echo "<p style='color:red; text-align:center;'>Admin has restricted to show this poll result only from backend </p>";
              }
              ?>
            </div>
            <?php 
                }
            ?>
        </div>
        </div>
       </div>     
       <script type="text/javascript">
var element=parseInt(jQuery('#poll_class_tuh_2').css('width'))-18;
        jQuery('.image_bar').css('width',element+"px");
        jQuery('.image_bar').css('margin','0 auto');
</script>     
   </div>
<?php 
    }        
} 
?>
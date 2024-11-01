
    <div class="full" id="poll_<?php echo $ques ?>__<?php echo $random_number; ?>">
        <div class="header">
        <?php
        
        if($question!=null){
        
        ?>
        <p class="question"><?php echo "Q: ".$query[0]->question; ?></p>        
            <?php
            
            }
            else{
                ?>
                
                <p class="question">Poll removed or not exists</p>
                
                <?php
            }
            ?>
        </div>
        <div class="content">
        
        <?php
        if($question!=null){
        
         ?>
        
        
        <div style="display: none;margin:0 auto;" class="pre_class" id="preloader_<?php echo $ques; ?>__<?php echo $random_number; ?>">
            <img src="<?php echo $url; ?>demo_wait.gif" />
        </div>
                
        
            <form action="test.php" method="post" id="register<?php echo $ques; ?>__<?php echo $random_number; ?>" name="tuh">
      
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
                            ?>
            <div class="input">
                                <input type="hidden" name="" />
              
                                <?php 
                                if($type==1){
                                    ?>
                                  <label><input class='widefat' id='form_ans' type='radio' name='ans_name2' value='<?php echo $answer_id ?>'/> <?php echo $ans_res->answer; ?></label>
                                    
                                    <?php
                                }
                                elseif($type==0){
                                    ?>
                                  <label><input id='form_ans' class='checkBoxGroup widefat' type='checkbox' name='ans_name2' value='<?php echo $answer_id ?>'/> <?php echo $ans_res->answer; ?></label>
                                    <?php } ?>
                    <br />
                    
                    <?php 
                    
                    if($backend==0){ 
                        
                    ?>
                    
                    <div class="image">
                        <img class="bar floatleft" src="<?php echo $url."bar.png"; ?>" width="<?php echo $bar; ?>%" height="15"/>
                        <img class="bar2 floatright" src="<?php echo $url."bar2.png"; ?>" width="<?php echo $bar_another; ?>%" height="15"/>
                    </div>
                    <p>Total vote counted <?php echo $vote_percent."% (". $vote_count . " out of ".$total_vote_count.")" ; ?>  </p>
                    
                <?php
                    
                    }
                    elseif($backend==1){
                        echo "<p style='color:red; text-align:center;'>Admin has restricted to show this poll result only from backend </p>";
                    }
                    
                    
                    
                    
                ?>
              
              
            </div>
            
            <?php
                 
                }
               
            ?>
       <input onclick='key_press("<?php echo $question_wdg; ?>","1",<?php echo $random_number; ?>);ajax_send("<?php echo $ques; ?>")' type='button' value='Submit vote' id='tuhin_<?php echo $ques; ?>'/>
            </form>
        </div>
        
        <?php }
        
        else{
            ?>
            
            <p class="question">This poll has been removed or not exists</p>
            
            
            <?php
        }
        ?>
        
        
        
        </div>
    </div>
  
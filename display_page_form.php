 
 <div class="full_page" id="poll_<?php echo $ques; ?>__<?php echo $unique_id; ?>">
        <div class="header_page">
            <?php if ($ques!=""): ?>
            
            <p><?php echo "Q: ".$question_data[0]->question ?></p>
            <?php else: ?>
            <p>Poll removed or not exists</p>
            <?php endif; ?>
        </div>
        <div class="content_page">
        <div style="display: none;text-align: center;" class="pre_class" id="preloader_<?php echo $ques; ?>__<?php echo $unique_id; ?>">
            <img style="width:128px !important;height:128px !important; box-shadow: 0 1px 4px rgba(0, 0, 0, 0) !important; border-radius: 0px !important; border-radius: 0 !important; text-align: center;" src="<?php echo $url ?>demo_wait.gif" />
        </div>
        <?php if ($ques!=""):?>
        
        
          <form action="test.php" method="post" id="register<?php echo $ques; ?>__<?php echo $unique_id; ?>" name="tuhin">
            
            
            <!--
            <input type="hidden" value="0" name="page" />
            --!>
             
                  
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
            
            
          
               
                                <label>
                                <?php 
                                if($type==1){
                                    ?>
                                   <input class='widefat' id='form_ans' type='radio' name='ans_name1' value='<?php echo $answer_id ?>'/> <?php echo $ans_res->answer; ?>
                                    <?php
                                }
                                elseif($type==0){
                                    ?>
                                   <input id='form_ans' class='checkBoxGroup widefat' type='checkbox' name='ans_name1' value='<?php echo $answer_id ?>'/> <?php echo $ans_res->answer; ?>
                                    <?php } ?>
                                    </label>
                    <br />
                    
                    <?php 
                    if($backend==0){
                    ?>
                    <div class="image_bar_page" id="display_bar">
                        <img id="bar_vote" class="bar floatleft" src="<?php echo $url."bar.png"; ?>" width="<?php echo $bar; ?>%" height="15"/>
                        <img id="bar_unvote" class="bar2 floatleft" src="<?php echo $url."bar2.png"; ?>" width="<?php echo $bar_another;?>%" height="15"/>
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
       <input onclick='key_press("<?php echo $ques; ?>","0",<?php echo $unique_id; ?>);ajax_send("<?php echo $ques; ?>")' type='button' value='Submit vote' id='tuhin_<?php echo $ques; ?>'/>
            </form>
            <?php else: ?>
             <?php echo " <p style='text-align:center'> This poll has been removed or does not exist</p>"; ?>
           <?php endif; ?>
        </div>
        </div>
    </div>
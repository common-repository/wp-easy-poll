<div class="wrap">
<?php
$ab=0;
 global $wpdb;
 $table_name_question=$wpdb->prefix."poll_question";
 $table_name_answer=$wpdb->prefix."poll_answer";
$query = $wpdb->get_results("SELECT DISTINCT * FROM $table_name_question" );
$row=$wpdb->num_rows;

//$i=0;
echo "<div class='poll_class_tuh'>";
echo "<table class='poll_tab widefat'>";


echo "<form action='admin.php?page=process-page' method='post' />";



foreach($query as $query_arr)
{   
  //  $i++;
$ab++;
    $question = $query_arr->question;
    $uid   = $query_arr->question_uid;
    
    
    $q=$wpdb->get_results("SELECT * FROM $table_name_answer WHERE question_id='$uid'");
   echo "<thead>";
    echo "<tr class='poll_tr' >";
    
    //if($i==1){
    //echo "<h3 style='padding:0; margin:0;'>".."</h3>";
     echo "<th> $question </th>
            <th>poll publish code</th>
            <th>Select poll for delete</th>
     </tr><tr>";
     echo "<td>";
    foreach($q as $ans){
        $answer=$ans->answer;
        $type= $ans->answer_type;
        $qid=$ans->question_id;
        $qid_arr[]=$qid;
        if($type==1){
            echo " $answer<br/>";
        }
        elseif($type==0){
            echo " $answer<br/>";
        }
        
    }
    echo "<input type='hidden' value='$qid_arr' name='cookie_id' />";
    echo "</td>";
    echo "  <td>";
    
    echo "<input style='padding:10px' type='text' size='40' value='$uid' onclick='this.select()' /> <br/><br/>";
   echo "</td>";
   
  //echo widget_function($qid);
    
   echo "   <td>";
   
   
    echo "<label><input type='checkbox' name='del_poll[]' value='$uid' /> Delete poll<br/></label>";
   echo "</td></tr>";
   // }
    //echo "<input type='radio' name='radio_tuh[]' /> $answer<br/>";
    
    
}

echo "<tr><td></td><td></td><td></td><td>";
if(!empty($query_arr)){
if(count($query_arr)!=0){
 echo "<input class='button button-primary' type='submit' class='submit_poll' value='Delete selected poll' />";
 }
 }
    echo "</form>";
if($row==0){
    echo "<h3>No polls avalible</h3>";
}
//including file for delete poll
echo "</td></tr></table>";
echo "</div>";
?>
</div>
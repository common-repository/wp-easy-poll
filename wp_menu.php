<?php
    if(empty($_POST['question'])||($_POST['question'])==null){
    
    
    echo "<table class='widefat poll_form'> <tr> <td style='width:170px;'>";
    echo "Add polls question:";
    echo "</td> <td>";
    echo "<form action='admin.php?page=add-poll-process' method='post' id='form_poll'/>";
    echo "Poll title <br />";
    echo "<input type='text' size='40' name='question' />";
    echo "<br/>  Enter your options: <br/>";
    echo "<div id='answer_div'>";
    echo "<input type='text' name='answer[]' size='40' /> <br/>";
    echo "<input type='text' name='answer[]' size='40' /> <br/>";
    echo "</div>";
    echo "<input type='button' onclick='on_click()' value='Add more option' id='add_field' /><br/><br/>";
    
    echo "</td> </tr> <label> <tr> <td>";
    echo "<input type='checkbox' value='1' name='vote_user'/></td> <td>
    
    
     Hide poll window after vote  </td></tr></label> ";
     
    echo " <label> <tr> <td> <input type='checkbox' value='1' name='poll_type'/> </td> <td>
    
     User can only vote one item (radio button/check box)
           </td> </tr> </label> 
    
    ";
    echo "<label> <tr> <td> <input type='checkbox' value='1' name='poll_publish_condition'/> 
    </td> <td>
    Publish the poll result only from backend <br/>";
    echo "</td> </tr></label> <tr> <td>";
    
    
    echo "  
            Select restriction method: </td> <td>
            <select name='method'>
                <option value='cookie'> Cookie </option>
                <option value='ip'> IP </option>
                <option value='ci'> Cookie and IP </option>
                <option id='username' value='user'> User name </option>            
            </select>  
        
    
         ";
    echo "</td> </tr></table>";
    
    echo "<table class='widefat'> <tr> <td>";
    
    echo "<input style='margin:0 auto;' class='button button-primary' type='submit' value='Submit' />";
    echo "</td> </tr> </table>";
 
    echo "<form/> ";
    
    }
    else{
        require('admin_process.php');
        //header('Location:?page=wp-easy-poll/poll_admin.php');
    }
    //echo "Add polls options: <br/>";
?>
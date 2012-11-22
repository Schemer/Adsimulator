
<h2>Send a message:</h2> <br>
<div id="sendMessageTitles">
    To: <br> <br>
    Subject: <br>
</div>

<div id="sendMessageInputs">
<?php
    //require_once("adminSettings.php");
    require_once("classes/SessionClass.php");
    
    $userID = $_SESSION['user']['userID'];
    $session = new SessionClass();
    $currentSession = $session->getActiveSessionID($userID);
    //echo $currentSession;die;
    // Get a list of all users, except agents and current user's
    $sqlquery = "SELECT * 
                 FROM user 
                 WHERE (userID <> $userID AND 
                       type = 'user')";
    if($currentSession != 0) {
        $sqlquery .= " AND user.session = $currentSession";
    }                   
    $sqlquery .= "  
                 OR (userID <> $userID AND type = 'admin')
                 ORDER BY type ASC, name";
    $result = mysql_query($sqlquery); 
    if($result) {
        echo "<select class='inputSelect' id='userSelect'>
                    <option value='default'>Select user...</option>";
        // Show option to send message to all user if current user is administrator
        if($_SESSION['user']['type'] == 0) {
            echo "  <option value='0'>All Users</option>";
        }
        /* Fetch an admin Name  
        $adminquery = "SELECT adminName
                       FROM sessionsettings
                       WHERE sessionID = $currentSession";
        $adminresult = mysql_query($adminquery);
        $adminrow = mysql_fetch_array($adminresult);
                */
        while($row = mysql_fetch_assoc($result)){
            
           /* if($row['type'] == 'admin') {
                echo "
                    <option value='".$row['userID']."'>".$adminrow['name']."</option>";
            } else {*/
           echo "<option value='".$row['userID']."'>".$row['name']."</option>";
            /*  }   */
        }
        echo "</select> <br>";
        
    } else {
        echo "Error: Could not fetch user list<br>";
    }
    
?>
    <input type="text" id="messageSubject" class="inputField"/> <br> <br>
    <textarea rows="2" cols="20" id="sendMessageText"></textarea> <br> <br>
    <input type="button" onclick="sendMessage()" value="Send Message" class="newButton"> <br> <br>
    <div id="displayNotification"></div>
</div>
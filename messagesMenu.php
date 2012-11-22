<?php
    require_once("classes/MessagesClass.php");
    require_once("iniSessionSetting.php");
    
    // Verification check
    if (empty($_SESSION['user']))
    {
        echo "<h2>You must login in order to view your messages</h2><BR/>
              <h3>Please wait while you're being transferred.</h3>";
        echo "<script>setTimeout(\"document.location.href='index.php?tabID=Login'\",3000);</script>";
        return;
    }

    if ($_SESSION['user']['authorize']!=true) {
          require_once('./Logout.php');
          exit;
    }
    
    echo "
    <div id='messageMenuContainer'>
        <h3>Your Messages:</h3>";
    
    if($settings['userSendMsg'] == 'yes' || $_SESSION['user']['type'] == 'admin') {
        echo "
            <input type='button' value='Send Message' id='composeMessage' class='newButton' onclick='document.location.href=\"index.php?tabID=sendMessage\"'><br>";
    }
    echo"<table class='messageList'>
            <tr class='campaignListCat'>
                <td><input type='checkbox' id='checkAllMessages' value='All' onclick=toggleAllMessages()></td>
                <td class='fromCol'>From</td>
                <td class='subjectCol'>Subject</td>
                <td class='dateCol'>Date</td>
            </tr>";
    $messages = new Messages();         
    $result = $messages->getMessages($_SESSION['user']['userID']); // Getting all of user's messagess
    
    while($row = mysql_fetch_array($result)){
        $from = $messages->getUsername($row['fromID']);
        if($row['read'] == 0) {
            echo "
                <tr class='campaignLines'>
                    <td><input type='checkbox' id='".$row['id']."'></td>
                    <td class='fromCol' onclick=\"document.location.href='index.php?tabID=viewMessage&messageId=".$row['id']."'\"><b>".$from."</b></td>
                    <td class='subjectCol' onclick=\"document.location.href='index.php?tabID=viewMessage&messageId=".$row['id']."'\"><b>".$row['subject']."</b></td>
                    <td class='dateCol' onclick=\"document.location.href='index.php?tabID=viewMessage&messageId=".$row['id']."'\"><b>".date("d/m/Y H:i:s" ,$row['time'])."</b></td>
                </tr>
                 ";
        } else {
            echo "
                <tr class='campaignLines'>
                    <td><input type='checkbox' id='".$row['id']."' ></td>
                    <td class='fromCol' onclick=\"document.location.href='index.php?tabID=viewMessage&messageId=".$row['id']."'\">".$from."</td>
                    <td class='subjectCol' onclick=\"document.location.href='index.php?tabID=viewMessage&messageId=".$row['id']."'\">".$row['subject']."</td>
                    <td class='dateCol' onclick=\"document.location.href='index.php?tabID=viewMessage&messageId=".$row['id']."'\">".date("d/m/Y H:i:s" ,$row['time'])."</td>
                </tr>
                 ";
        }
    }
    echo "</table>
        <input type='button' class='newButton' onClick='deleteMessages()' value='DELETE MESSAGES'>
        </div>";    
?>

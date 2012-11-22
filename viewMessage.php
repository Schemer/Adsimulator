<?php
    include_once("classes/MessagesClass.php");
    
    // Verifications check
    if (empty($_SESSION['user']))
    {
        echo "<h2>You must login in order to view this message</h2><BR/>
              <h3>Please wait while you're being transferred.</h3>";
        echo "<script>setTimeout(\"document.location.href='index.php?tabID=Login'\",3000);</script>";
        return;
    }

    if ($_SESSION['user']['authorize']!=true) {
          require_once('./Logout.php');
          exit;
    }
    
    $messageID = $_GET['messageId'];
    $messages = new Messages(); 
    $messages->markMessageAsRead($messageID); // Mark message as 'read'
    
    $result = $messages->getMessageById($messageID);
    $row = mysql_fetch_array($result); // Get message information from DB
    
?>
    <div id="messageContainer">
        <div id="messageTitles">
            From: <br><br>
            Subject: <br>
        </div>  
     
<?php
    $from = $messages->getUsername($row['fromID']);
    echo "
        <div id='messageInfo'>
            <b>".$from." </b><br><br>
            <b>".$row['subject']."</b>
        </div>
    </div>
    <br>    
    <div id='messageContent'>".$row['content']."</div>";
?>
    

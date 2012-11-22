<?php
    require_once("classes/SessionClass.php");
    
    class Messages {
        
        function getMessages($userID){
              
            $currentSession = $_SESSION['user']['sessionID'];
            
            $query = "SELECT messages.messageID AS id, messages.fromID AS fromID, messages.toID AS toID, 
                             messages.subject AS subject, messages.content AS content, messages.time AS time, `read`
                      FROM messages,user 
                      WHERE messages.toID=$userID AND
                            messages.toID = user.userID AND
                            messages.active = 1";
            if(($_SESSION['user']['type'] == 'admin') && ($currentSession != 0)){
                $query .= " AND fromID IN (SELECT userID FROM user WHERE sessionID = $currentSession)";
            }          
            $query .= " 
                      ORDER BY messages.messageID DESC";
            $result = mysql_query($query);
            
            return $result;
        }
        
         // Get message by ID
        function getMessageById($messageID) {
            $result = mysql_query("SELECT * FROM messages WHERE messageID = $messageID");
            return $result;
        }
        
        // Get username by user id
        function getUsername($userID) {
            if($userID == 0) {
                return "ADs SIM";
            }
            $result = mysql_query("SELECT name, type FROM user WHERE userID=$userID");
            $row = mysql_fetch_array($result);
            if($row['type'] == 'admin') {
                $query = "SELECT adminName FROM sessionsettings";
                $result2 = mysql_query($query);
                $row2 = mysql_fetch_array($result2);
                $name = $row2['adminName'];
            } else {
                $name = $row['name'];
            }
            return $name;
        }
        
		// Get new messages amount
        function getMessagesAmount($userID) {
            $session = new SessionClass();
            $currentSession = $session->getActiveSessionID($userID);
            $query = "SELECT COUNT(toID) AS amount
                      FROM messages 
                      WHERE toID=$userID AND
			    messages.read = 0 AND
                            messages.active = 1";
            if(($_SESSION['user']['type'] == 'admin') && ($currentSession != 0)){
                $query .= " AND fromID IN (SELECT userID FROM user WHERE sessionID = $currentSession)";
            }          
            $result = mysql_query($query);
            if($row = mysql_fetch_array($result)) {
                return $row['amount'];
            } 
            else {
                return 0;
            }
        }
        
        // Create new message
        function newMessage($from, $to, $sub, $content){
            $sub = mysql_real_escape_string($sub);
            $content = mysql_real_escape_string($content);
            $currentTime = $_SESSION['time']['timestamp'] + time() - $_SESSION['time']['updateTime'];
            $query = "INSERT INTO messages (fromID, toID, subject, content, time) 
                                                         VALUES ('$from', '$to', '$sub', '$content', '$currentTime')";
            mysql_query($query);
            return mysql_error();
        }
        
        // Mark message as read
        function markMessageAsRead($id) {
            $query = "UPDATE messages SET `read` = 1 WHERE messageID = '$id'";
            return mysql_query($query);
        }
    }
    
?>
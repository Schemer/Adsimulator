<?php
    require_once("classes/SessionClass.php");
    
    Class UserClass{
        //checking if the user exist in the DB
        function CheckUser($user,$password){
            $sqlquery = "SELECT * FROM user WHERE name='$user' AND password='$password' and active='yes'" ;
            $result = mysql_query($sqlquery);
            if (($row = mysql_fetch_array($result)) && ($row['type']!='agent')){ // If user exists
                // Check if user's session is open
                $userSession = $row['sessionID'];
                $result = mysql_query("SELECT `active` FROM sessions WHERE sessionID = $userSession");
                $sessionDetails = mysql_fetch_array($result);
                if(($sessionDetails[0] == 0) && ($row['type'] != 'admin')) { // if session is closed
                    return 3;
                }
                else { // if session is open
                    $userID = $row['userID'];
                    $this->setUserSession($userID);
                    return 1;   
                }
            }
            else { return 2; }
        }
		
	function setUserSession($userID){
            $sqlquery = "SELECT * FROM user WHERE userID=$userID" ;
            $result = mysql_query($sqlquery);
            $row = mysql_fetch_array($result);
            $_SESSION['user']['userID']   = $row['userID'];
            $_SESSION['user']['name'] = $row['name'];
            $_SESSION['user']['type'] = $row['type'];
            $_SESSION['user']['sessionID'] = $row['sessionID'];
            $_SESSION['user']['authorize'] = true;
        }
        
        //register new user
        function RegisterNewUser($name,$password,$session){
            // Check if user already exists in the DB
            $sqlqueryUserExists = "select * from user where name='$name' and password='$password'";
            $result = mysql_query($sqlqueryUserExists); 
            if (mysql_num_rows($result) == 0){
                //user not exists
                return 2;
            }
            else{
                $row = mysql_fetch_array($result);
                $userID = $row['userID'];
            }
            // Check if session exists
            $query = "SELECT * FROM sessions WHERE `name` = '$session' AND `active` = 1";
            $result = mysql_query($query);
            if(mysql_num_rows($result) == 0) {
                return 3;
            }
     
            // Register new user in the DB
            $sqlqueryInsertUser = "UPDATE  user SET `active` =  'yes' WHERE `userID`=$userID";
            $result = mysql_query($sqlqueryInsertUser);
            if (mysql_error())
                return 1;
            else{
                $this->setUserSession($userID);
                return 0;
            }
        }
        
        function UnSession() {
            unset($_SESSION['user']);
        }
  
        function getUserList($sessionID) {
            $sqlquery = "SELECT * FROM user ";
            if($sessionID != 0){                
                $sqlquery .= "WHERE user.sessionID = $sessionID";
            }
            $sqlquery .= " ORDER BY user.name";
            $result = mysql_query($sqlquery);
        return $result;
        }
        
        function getUserSession($userID) {
            $sqlquery = "SELECT sessions.name AS sessionName FROM user,sessions 
                         WHERE user.userID=$userID AND sessions.sessionID = user.sessionID ";
            $result = mysql_query($sqlquery);
            $row = mysql_fetch_array($result);
            return $row['sessionName'];
        }
        
        function getUserType($typeID){
            switch ($typeID){
                case 'admin': return 'Administrator'; break;
                case 'user': return 'Regular'; break;            
                case 'agent': return 'Agent'; break;
            }
        }
        
        function getUserStatus($active){
            return ($active==1)?'YES':'NO';
        }
        
        function addNewUser($name,$password,$type,$sessionID){
            $sqlqueryUserExists = "SELECT * FROM user WHERE name='$name'";
            $active = $type=='user'?'no':'yes';
            $sqlquertInsertUser = "INSERT INTO `user` (`name` ,`password` ,`type`,`active`,`sessionID`)
                                   VALUES ('$name', '$password', '$type','$active','$sessionID');";
            $result = mysql_query($sqlqueryUserExists);
            if (mysql_num_rows($result) != 0){ 
                // //user exists
                echo '<h3><font color=red>Username already exists<br/>Choose a different user name.<br/><font></h3>';            
                return false;
            }  
            else {
                mysql_query($sqlquertInsertUser);
                return mysql_insert_id();
            }
        }
        
        function createUserState($userID,$sessionID){
         // select setting from DB according to sessionID
            $query = "SELECT * FROM sessionsettings WHERE sessionID = $sessionID";
            $sessionSet= mysql_fetch_array(mysql_query($query));
            
            $marketType = $sessionSet['marketType'];
            $companySize = $marketType=='same'?1:mt_rand(0,2);
            $sales = round(($sessionSet['sales']*(100+round(-$sessionSet['deviationBetweenUsers'] + (2*$sessionSet['deviationBetweenUsers']) * mt_rand(0, mt_getrandmax()) / mt_getrandmax(),2)))/100);
            $adBudgetPercent = $sessionSet['advertiseBudget']*(100+round(-$sessionSet['deviationBetweenUsers'] + (2*$sessionSet['deviationBetweenUsers']) * mt_rand(0, mt_getrandmax()) / mt_getrandmax(),2))/100;
            $onlineOfflineRatio = $sessionSet['onlineOfflineRatio']*(100+round(-$sessionSet['deviationBetweenUsers'] + (2*$sessionSet['deviationBetweenUsers'])* mt_rand(0, mt_getrandmax())/ mt_getrandmax(),2))/100;
            $Product = $sessionSet['productPromoted']*( 100+round(-$sessionSet['deviationBetweenUsers'] + (2*$sessionSet['deviationBetweenUsers']) * mt_rand(0, mt_getrandmax()) / mt_getrandmax(),2))/100;
            echo "<br>sales= $sales";
            
            $siteSize = $sessionSet['siteSize']*(100+round(-$sessionSet['deviationBetweenUsers'] + (2*$sessionSet['deviationBetweenUsers']) * mt_rand(0, mt_getrandmax()) / mt_getrandmax(),2))/100;
            $pageSeenPrecent = $sessionSet['pagesSeen']*(100+round(-$sessionSet['deviationBetweenUsers'] + (2*$sessionSet['deviationBetweenUsers']) * mt_rand(0, mt_getrandmax()) / mt_getrandmax(),2))/100;
            $webTraffic = $sessionSet['directAccessSize'] * $siteSize * $sessionSet['trafficFactor'];
            $mailsArrived = $sessionSet['directAccessSize'] * $siteSize *$sessionSet['trafficFactor']*$sessionSet['mailsArived']/100;
            $leftContact = $sessionSet['directAccessSize'] * $siteSize *$sessionSet['trafficFactor']*$sessionSet['leftContact']/100;
            $emailClient = $sessionSet['emailMarketSize']*(100+round(-$sessionSet['deviationBetweenUsers'] + (2*$sessionSet['deviationBetweenUsers']) * mt_rand(0, mt_getrandmax()) / mt_getrandmax(),2))/100;
            
            switch ($companySize){
                case '0': echo "small";
                    $sales = round($sales * ($sessionSet['smallCompany']/100));
                          $siteSize = round($siteSize * ($sessionSet['smallCompany']/100));
                          $emailClient = round($emailClient * ($sessionSet['smallCompany']/100));
                          break;
                case '2': echo "high";
                    $sales = round($sales * ((100+$sessionSet['largeCompany'])/100));
                          $siteSize = round($siteSize * ((100+$sessionSet['largeCompany'])/100));
                          $emailClient = round($emailClient * ($sessionSet['largeCompany']/100));
                          break;
            }
            
            $adBudget = round($sales*$adBudgetPercent/100);
            
            // sales
            $productSales = round($sales * $Product/100);
            
            $onlineSales = round($productSales * $onlineOfflineRatio / 100);
           
            $offlineSales = $productSales - $onlineSales;
            $otherSales = $sales - $productSales;
             
            $pagesSeen = $siteSize*($pageSeenPrecent/100);
            $timeInSite = round($pagesSeen*60*$sessionSet['timeInSite']*(100+round(-$sessionSet['deviationBetweenUsers'] + (2*$sessionSet['deviationBetweenUsers']) * mt_rand(0, mt_getrandmax()) / mt_getrandmax(),2))/100);
            $webTraffic = $sessionSet['directAccessSize'] * $siteSize * $sessionSet['trafficFactor'];
            $leftContact = $webTraffic*$sessionSet['leftContact']/100;
            $mailsArrived = $webTraffic*$sessionSet['mailsArived']/100;
            
            echo " <br>sales= $sales
                   <br>adbudgetprecnt= $adBudgetPercent budget= $adBudget
                   <br>product= $Product productsales= $productSales
                   <br>ratio= $onlineOfflineRatio<br>online = $onlineSales
                   <br>offline= $offlineSales
                   <br>other= $otherSales
                   <br>siteSirze= $siteSize
                   <br>ps%=$pageSeenPrecent ps=$pagesSeen
                   <br>webTraffic= $webTraffic
                   <br>timeinsite= $timeInSite
                   <br>MA%=".$sessionSet['mailsArived']." mailsArrived= $mailsArrived
                   <br>leftcontact= $leftContact
                   <br>emClient= $emailClient";
            
            $currentTime = time();
            $query = "INSERT INTO balance (campaignID, userID, amount, time)
                                    VALUES (-1, $userID, $adBudget, $currentTime)";
            mysql_query($query);
            $query = "INSERT INTO `usersattributes`
                        (`userID`, `sales`, `adBudget`, `product`, 
                         `onlineofflineRatio`, `productSales`, `onlineSales`, `offlineSales`,
                         `otherSales`, `siteSize`, `webTraffic`, `pagesSeen`,
                         `timeInSite`, `leftContact`, `mailsArrived`, `emailClient`)
                      VALUES ('$userID', '$sales', '$adBudget', '$Product',
                              '$onlineOfflineRatio', '$productSales', '$onlineSales', '$offlineSales',
                              '$otherSales', '$siteSize', '$webTraffic', '$pagesSeen',
                              '$timeInSite', '$leftContact', '$mailsArrived', '$emailClient');";
            
            mysql_query($query); 
            $query = "INSERT INTO sales (`userID`, `lastWeekOnline`, `lastWeekOffline`, `lastWeekOther`, 
                                         `accumulateOnline`, `accumulateOffline`, `accumulateOther`) 
                             VALUES ('$userID', '". ($onlineSales/60) ."', '". ($offlineSales/60) ."', '".($otherSales/60) ."',
                                     '0', '0', '0');";
            mysql_query($query);
                    
            
        }
        
        function getUserDetail($userID){
            $sqlquery = "SELECT * FROM user WHERE userID=$userID" ;
            $result = mysql_query($sqlquery);
            return $result;
        }
        
        function updUserDetail($id,$name,$password){
            $sqlqueryUserExists = "SELECT * FROM user WHERE name='$name' and userID<>$id";
            $sqlupdate = "UPDATE user 
                          SET `name` = '$name',`password` = '$password'
                          WHERE `user`.`userID` =$id;";
            $result = mysql_query($sqlqueryUserExists);
            if (mysql_num_rows($result) != 0){ //user exists
                echo '<h3><font color=red>User name already exists<br/>Choose a different user name.<br/>UPDATE FAIL<br/><font></h3>';
                return false;
            }
            else 
            {
                $result = mysql_query($sqlupdate);
                return true;
            }
        }
        
        function delUser($id){
            $sqlupdate = "UPDATE user SET `active` = 'no' WHERE `user`.`userID` =$id;";
            $result = mysql_query($sqlupdate);
            if ($result==1)
                $user = $this->getUserName($id);
                echo "<b>user <span class='blueText'>$user</span> has been deactivate</b><br/>";
            return true;
        }
        
        function getUserName($userID){
            $query = "SELECT name FROM user WHERE userID = $userID";
            $name = mysql_fetch_array(mysql_query($query));
            return $name['name'];
        }
        
        function getUserState($userID){
            $query = "SELECT * FROM usersattributes WHERE userID = $userID";
            $state = mysql_fetch_array(mysql_query($query));
            return $state;
            
        }
        
    }
?>

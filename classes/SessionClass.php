<?php
    class sessionClass {
	//GET functions
	function getSessionDetails($sessionID) {
                $query = "SELECT * FROM sessions WHERE sessionID = $sessionID";
                return mysql_fetch_array(mysql_query($query));
        }

        function getSessionName($sessionID) {
                $query = "SELECT `name` FROM sessions WHERE sessionID = $sessionID";
                $result= mysql_query($query);
                $row = mysql_fetch_array($result);
                return $row['name'];
        }	

        function getAllSessions(){
                $query = "SELECT * FROM sessions ORDER BY sessionID DESC";
                return mysql_query($query);
        }

        function getAdminID() {
                $result = mysql_query("SELECT userID FROM user WHERE type = 'admin'");
                $row = mysql_fetch_array($result);
                return $row['userID'];
        }

        function getActiveSession($userID){
                // $adminID = $this->getAdminID();
                $query = "SELECT sessions.sessionID AS sessionID, sessions.name AS name, sessions.startTime as startTime, sessions.endTime AS endTime
                                FROM sessions,user 
                                WHERE sessions.sessionID = user.sessionID AND
                                        user.userID = $userID";
                return mysql_query($query);
        }

        function getActiveSessionID($userID){
                if ($userID == -1)
                        $userID = $this->getAdminID();
                $query = "SELECT sessionID
                                FROM user 
                                WHERE userID = $userID";
                $result = mysql_query($query);
                if(mysql_num_rows($result) > 0) {
                        $row = mysql_fetch_array($result);
                        return $row['sessionID'];
                } else {
                        return 0;
                }
        }
        
        function getAllInactiveSessions() {
            $result = $this->getActiveSession();
            if(mysql_num_rows($result) > 0) {
                $row = mysql_fetch_array($result);
                $activeSession = $row['sessionID'];
            } else {
                $activeSession = 0;
            }
            $query = "SELECT * FROM sessions WHERE sessionID <> $activeSession ORDER BY sessionID DESC";
            return mysql_query($query);
        }
    
        // Get session's settings
        function getSessionSettings($sessionID) {
            $query = "SELECT * FROM sessionsettings WHERE sessionID = $sessionID";
            $result = mysql_query($query);
            $row = mysql_fetch_array($result);
            
            $query = "SELECT * FROM emailsettings WHERE sessionID = $sessionID";
            $result = mysql_query($query);
            $row2 = mysql_fetch_array($result);
            
            $query = "SELECT * FROM displaysettings WHERE sessionID = $sessionID";
            $result = mysql_query($query);
            $row3 = mysql_fetch_array($result);
            $query = "SELECT * FROM seosettings WHERE sessionID = $sessionID";
            $result = mysql_query($query);
            $row4 = mysql_fetch_array($result);
            $query = "SELECT * FROM ppcsettings WHERE sessionID = $sessionID";
            $result = mysql_query($query);
            $row5 = mysql_fetch_array($result);
            return array_merge ($row, $row2, $row3);//, $row4, $row5, $row6);
    }
	
	function getAllSessionNames(){
        $query = "SELECT `name` FROM `sessions`";
        $result = mysql_query($query);
        $names = "";
        while ($row = mysql_fetch_row($result)){
            $names .= $row[0].";;";
        }
        return $names;
    }
//-------------------------------------------------------------------------------------------------------
	//update function
	// Can only be made by an administrator
    function changeActiveSession($sessionID) {
        // Update session variable
        $_SESSION['user']['sessionID'] = $sessionID;
        // Update database
        $adminID = $this->getAdminID();
        $query = "UPDATE user SET sessionID = $sessionID WHERE userID = $adminID";
        return mysql_query($query);    
    }
	
	// Close a session
    function closeSession($sessionID) {
        $currentTime = time();
       
        $query = "UPDATE `sessions` SET `active` =  '0',`endTime`= $currentTime WHERE `sessionID`= $sessionID";
        mysql_query($query);
        return $currentTime;
    }
    
    // open a session
    function openSession($sessionID,$endDate) {
        $query = "UPDATE `sessions` SET `active` = '1',`endTime` = $endDate WHERE `sessionID` =$sessionID";
        mysql_query($query);
       
        return $endDate+7200;
    }
	
 function createSession($general,$mail, $display){//($desc, $pullSettingsFrom) {
        // Creating the new session
        $currentTime = time();
        print_r($general);
        $endDateArray = explode ('/',$general['endDate']);
        $endDate = new DateTime($endDateArray[2]."-".$endDateArray[1]."-".$endDateArray[0]);
        // name and dates
        $query = "INSERT INTO sessions (`name` ,`startTime` ,`endTime` ,`active`)
                         VALUES ('".$general['sessionName']."','".$currentTime."','".$endDate->getTimestamp()."','1');";
        
        if(mysql_query($query)==false)   
            return false;
        
        $sessionID = mysql_insert_id(); // get the ID of the new session
        
        //general setting
        $generalQuery = "INSERT INTO sessionsettings
                (`sessionID`, `daysPerDay`, `businessType`, `marketType`,   
                 `sales`, `trafficFactor`, `siteSize`, `pagesSeen`, 
                 `timeInSite`,`mailsArived`, `deviationBetweenUsers`, `smallCompany`, `largeCompany`,
                 `productPromoted`, `onlineOfflineRatio`, `advertiseBudget`, `activeAgent`, 
                 `agentNameAsUser`, `userSendMsg`, `adminName`, `SEMarketSize`, 
                 `SEMarketChange`, `directAccessSize`, `directAccessChange`, `PWebMarketSize`, 
                 `PWebMarketChange`, `mediaMarketSize`, `mediaMarketChange`, `emailMarketSize`, 
                 `emailMarketChange`, `competitionFactor`)";
        if (isset($general['pullFrom'])){ // pull/default
            $generalPull = mysql_fetch_array(mysql_query("SELECT * FROM sessionsettings WHERE sessionID =".$general['pullFrom']));
            $generalQuery .= 
                    " VALUES ('$sessionID','".$generalPull['daysPerDay']."','".$generalPull['businessType']."','".$generalPull['marketType']."','".        
                            $generalPull['sales']."','".$generalPull['trafficFactor']."','".$generalPull['siteSize']."','".$generalPull['pagesSeen']."','".
                            $generalPull['timeInSite']."','".$generalPull['mailsArived']."','".$generalPull['deviationBetweenUsers']."','".$generalPull['smallCompany']."','".
                            $generalPull['largeCompany']."','".$generalPull['productPromoted']."','".$generalPull['onlieOfflineRatio']."','".$generalPull['advertiseBudget']."','".
                            $generalPull['activeAgent']."','".$generalPull['agentNameAsUser']."','".$generalPull['userSendMsg']."','".$generalPull['adminName']."','".
                            $generalPull['SEMarketSize']."','".$generalPull['SEMarketChange']."','".$generalPull['directAccessSize']."','".$generalPull['directAccessChange']."','".
                            $generalPull['PWebMarketSize']."','".$generalPull['PWebMarketChange']."','".$generalPull['mediaMarketSize']."','".$generalPull['mediaMarketChange']."','".
                            $generalPull['emailMarketSize']."','".$generalPull['emailMarketChange']."','".$generalPull['competitionFactor']."');";
        }
        else{  //setup
            $generalQuery .= 
                    " VALUES ('$sessionID','".$general['daysPerDay']."','".$general['businessType']."','".$general['marketType']."','".
                            $general['sales']."','".$general['trafficFactor']."','".$general['siteSize']."','".$general['pagesSeen']."','".
                            $general['timeInSite']."','".$general['mailsArived']."','".$general['deviationBetweenUsers']."','";
            if($general['marketType']=='3type')
                $generalQuery .= $general['smallCompany']."','".$general['largeCompany']."','";
            else 
                $generalQuery .= "50','50','";
            $generalQuery.= $general['productPromoted']."','".$general['onlieOfflineRatio']."','".$general['advertiseBudget']."','".$general['activeAgent']."','".
                            $general['agentNameAsUser']."','".$general['userSendMsg']."','".$general['adminName']."','".$general['SEMarketSize']."','".
                            $general['SEMarketChange']."','".$general['directAccessSize']."','".$general['directAccessChange']."','".$general['PWebMarketSize']."','".
                            $general['PWebMarketChange']."','".$general['mediaMarketSize']."','".$general['mediaMarketChange']."','".$general['emailMarketSize']."','".
                            $general['emailMarketChange']."','".$general['competitionFactor']."');";
        }
        $emailQuery = "INSERT INTO emailsettings 
                (`sessionID`, `emailOncePrice`, `emailDailyPrice`, `emailWeeklyPrice`, 
                 `emailInfluanceDuration`, `emailWebTraffic`, `emailPagesView`, `emailTimeInSite`,
                 `emailLeftConn`, `emailMailsArrived`, `emailPurchaseOnSite`, `emailOfflineSales`,
                 `emailOtherSales`)";
        if (isset($mail['pullFrom'])){
            $emailPull = mysql_fetch_array(mysql_query("SELECT * FROM emailsettings WHERE sessionID =".$mail['pullFrom']));
            $emailQuery .= 
                    " VALUES ('$sessionID','".$emailPull['emailOncePrice']."','".$emailPull['emailDailyPrice']."','".$emailPull['emailWeeklyPrice']."','".
                            $emailPull['emailInfluanceDuration']."','".$emailPull['emailWebTraffic']."','".$emailPull['emailPagesView']."','".$emailPull['emailTimeInSite']."','".
                            $emailPull['emailLeftConn']."','".$emailPull['emailMailsArrived']."','".$emailPull['emailPurchaseOnSite']."','".$emailPull['emailOfflineSales']."','".
                            $emailPull['emailOtherSales']."');";
        }
        else{ // setup
            $emailQuery .=
                    " VALUES ('$sessionID','".$mail['emailOncePrice']."','".$mail['emailDailyPrice']."','".$mail['emailWeeklyPrice']."','".
                            $mail['emailInfluanceDuration']."','".$mail['emailWebTraffic']."','".$mail['emailPagesView']."','".$mail['emailTimeInSite']."','".
                            $mail['emailLeftConn']."','".$mail['emailMailsArrived']."','".$mail['emailPurchaseOnSite']."','".$mail['emailOfflineSales']."','".
                            $mail['emailOtherSales']."');";
        }
        
        $displayQuery = "INSERT INTO displaysettings
                (`sessionID`, `displayBannerPrice`, `displayMoviePrice`, `displayInfluanceBanDuration`,
                 `displayInfluanceMovDuration`, `displayBanWebTraffic`, `displayMovWebTraffic`, `displayBanPagesseen`,
                 `displayMovPagesSeen`, `displayBanTimeInSite`, `displayMovTimeInSite`, `displayBanLeftConn`, 
                 `displayMovLeftConn`, `displayBanMail`, `displayMovMail`, `displayBanOnlineSales`,
                 `displayMovOnlineSales`, `displayBanOfflineSales`, `displayMovOfflineSales`, `displayBanOtherSales`, 
                 `displayMovOtherSales`)";
        if (isset($display['pullFrom'])){
            $displayPull = mysql_fetch_array(mysql_query("SELECT * FROM displaysettings WHERE sessionID =".$display['pullFrom']));
            $displayQuery .=
                " VALUES ('$sessionID','".$displayPull['displayBannerPrice']."','".$displayPull['displayMoviePrice']."','".$displayPull['displayInfluanceBanDuration']."','".
                           $displayPull['displayInfluanceMovDuration']."','".$displayPull['displayBanWebTraffic']."','".$displayPull['displayMovWebTraffic']."','".$emailPull['displayBanPagesseen']."','".
                           $displayPull['displayMovPagesSeen']."','".$displayPull['displayBanTimeInSite']."','".$displayPull['displayMovTimeInSite']."','".$emailPull['displayBanLeftConn']."','".
                           $displayPull['displayMovLeftConn']."','".$displayPull['displayBanMail']."','".$displayPull['displayMovMail']."','".$displayPull['displayBanOnlineSales']."','".
                           $displayPull['displayMovOnlineSales']."','".$displayPull['displayBanOfflineSales']."','".$displayPull['displayMovOfflineSales']."','".$displayPull['displayBanOtherSales']."','".
                           $displayPull['displayMovOtherSales']."');";
        }
        else{ //setup
            $displayQuery .=
                "VALUES ('$sessionID','".$display['displayBannerPrice']."','".$display['displayMoivePrice']."','".$display['displayBanDuration']."','".
                          $display['displayMovDuration']."','".$display['displayBanWebTraffic']."','".$display['displayMovWebTraffic']."','".$display['displayBanPage']."','".
                          $display['displayMovPage']."','".$display['displayBanTimeInSite']."','".$display['displayMovTimeInSite']."','".$display['displayBanLeftConn']."','".
                          $display['displayMovLeftConn']."','".$display['displayBanMails']."','".$display['displayMovMails']."','".$display['displayBanPurchase']."','".
                          $display['displayMovPurchase']."','".$display['displayBanOffline']."','".$display['displayMovOffline']."','".$display['displayBanOtherSales']."','".
                          $display['displayMovOtherSales']."');";
        }
        mysql_query($generalQuery);
        mysql_query($emailQuery);
        mysql_query($displayQuery);
        
        return $sessionID;
    }
}
	
	
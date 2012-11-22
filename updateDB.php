<?php
    session_start();
    header("content-type:text/xml");
    require_once('iniSessionSetting.php');
    require_once('classes/SessionClass.php');
    // Enabling Ajax to perform tasks on the database using PHP
    require_once('initdb.php');
	
    switch ($_GET['func']){
        case 'createVisit':  
            $time = 7200 + time();                              
            $id = $_GET['id'];
            $query="INSERT INTO visits (userID, visitedAt, duration) VALUES ($id, $time, 0)";
            mysql_query($query);
            break; 
	case 'updateVisit' : $time = 7200 + time(); 
            $id = $_GET['id'];
            // Getting timeset of most recent visit
            $query="SELECT MAX(visitedAT) AS maxVisit FROM visits WHERE userID='$id'";
            $result = mysql_query($query);
            $arr = mysql_fetch_array($result);
            $maxVisit = $arr['maxVisit'];
            $query="UPDATE visits SET duration=$time-visitedAt WHERE userID='$id' AND visitedAt='".$maxVisit."'";
            mysql_query($query);
            break;
        case 'storeDatetime':
            // Updating time variables in session
            //$_SESSION['time']['offset'] = $settings['timeOffset'];
            $_SESSION['time']['updateTime'] = time();
            $_SESSION['time']['timestamp'] = time();
            $_SESSION['time']['date'] = date("d/m/Y", $_SESSION['time']['timestamp']);
            // Sending back response text in the format of: timestamp + date
            $currentTime = time();
            echo $currentTime." ";
            echo $_SESSION['time']['date'];
            break;
        case 'changeActiveSession':
            $session = new SessionClass();
            $viewedSession = $_GET['session'];
            // Set session as active
            $session->changeActiveSession($viewedSession);
            // Return new active session's details
            $row = $session->getSessionDetails($viewedSession);
            $endTime = $row['endTime'] ? date("H:i:s d/m/Y" , $row['endTime']) : "Still open...";
            echo $row['sessionID']. "^" . $row['name'] . "^" . date("H:i:s d/m/Y" , $row['startTime']) . "^" . $endTime;           
            break; 
        case 'getSessionsSettings':
            $session = new SessionClass();
            $selectedSession = $_GET['session'];
            $result = $session->getSessionSettings($selectedSession);
            $content = "
                <b><u>General Settings:</u></b><br>
                Days per real day: <b>".$result['daysPerDay']."</b><br>
                Agents enabled : <b>".$result['activeAgent']."</b>&nbsp&nbsp&nbsp
                Agents have same name as user: <b>".$result['agentNameAsUser']."</b><br>
                Users can send messages: <b>".$result['userSendMsg']."</b><br>
                Admin display name: <b>".$result['adminName']."</b><br><br>
                <b><u>Market Setting:</u></b><br>
                Business Type: <b>".$result['businessType']."</b>&nbsp&nbsp&nbsp
                Market Type: <b>".$result['marketType']."</b><br>
                Search Engine Market Size: <b>".$result['SEMarketSize']."</b>&nbsp&nbsp&nbsp
                Search Engine Market change: <b>".$result['SEMarketChange']."%</b><br>
                Direct Access Market Size: <b>".$result['directAccessSize']."</b>&nbsp&nbsp&nbsp
                Direct Access Market change: <b>".$result['directAccessChange']."%</b><br>
                PWeb Market Size: <b>".$result['PWebMarketSize']."</b>&nbsp&nbsp&nbsp
                PWeb Market change: <b>".$result['PWebMarketChange']."%</b><br>
                Media Market Size: <b>".$result['mediaMarketSize']."</b>&nbsp&nbsp&nbsp
                Media Market change: <b>".$result['mediaMarketChange']."%</b><br>
                Email Market Size: <b>".$result['emailMarketSize']."</b>&nbsp&nbsp&nbsp
                Email Market change: <b>".$result['emailMarketChange']."%</b><br>
                Market competition factor: <b>".$result['competitionFactor']."</b><br><br>
                <b><u>Companies Setting:</u></b><br>
                Sells: <b>".$result['sales']."$</b>&nbsp&nbsp&nbsp";
            if ($result['marketType'] == '3type'){ 
                $content .=" 
                    Small Company sells: <b>".$result['smallCompany']."</b>&nbsp&nbsp&nbsp
                    Large Company sells: <b>".$result['largeCompany']."</b>";
            }
            $content .="
                <br>OnLine/Offline Sells Ratio: <b>".$result['onlineOfflineRatio']."%</b><br>
                Advertise Budget: <b>".$result['advertiseBudget']."% of sales</b><br>
                Scope of Product: <b>".$result['productPromoted']."% of sales</b><br>             
                Deviation between users: <b>".$result['deviationBetweenUsers']."%</b><br>
                Site Size: <b>".$result['siteSize']."</b>&nbsp&nbsp&nbsp
                Traffic Factor: <b>".$result['trafficFactor']."</b><br>
                Page Seen (% of size): <b>".$result['pagesSeen']."%</b>&nbsp&nbsp&nbsp
                Time in site: <b>".$result['timeInSite']."sec</b><br>
                Mails Arrived (% of traffic): <b>".$result['mailsArived']."%</b><br>";

            $content .="<br><b><u>Campaigns Settings:</u></b><br>
                <b><u>Email Campaign Settings:</u></b><br>
                Cost for Once: <b>".$result['emailOncePrice']."</b>&nbsp&nbsp&nbsp 
                Cost for daily: <b>".$result['emailDailyPrice']."</b>&nbsp&nbsp&nbsp 
                Cost for weekly: <b>".$result['emailWeeklyPrice']."</b><br>
                Duration of influance: <b>".$result['emailInfluanceDuration']."</b><br>
                <u>Influance:</u>
                <table><tr><td>Web Traffic: <b>".$result['emailWebTraffic']."%</b></td> 
                    <td>Pages viewed: <b>".$result['emailPagesView']."%</b></td>
                    <td>Time in Site: <b>".$result['emailTimeInSite']."%</b><br></td></tr>
                    <tr><td>Customer left connection: <b>".$result['emailLeftConn']."%</b></td>
                    <td>Mails arrived: <b>".$result['emailMailsArrived']."%</b></td>
                    <td>Purchase On Site: <b>".$result['emailPurchaseOnSite']."%</b></td></tr>
                    <tr><td>Purchase offline: <b>".$result['emailOfflineSales']."%</b></td>
                    <td>Other product sales: <b>".$result['emailOtherSales']."%</b></td>
                    <td></td></tr>
                </table>";
            $content .="<b><u>Display setting:</u></b> UNDER CONSTRUCT";
            echo $content;
            
            break;
        case 'closeSession':
            $sessionID = $_GET['session'];
            $session = new SessionClass();
            $endTime = $session->closeSession($sessionID);
            echo date("d/m/Y" , $endTime);
            break; 
            
        case 'openSession':
            $sessionID = $_GET['session'];
            $endDate = $_GET['endDate'];
            $session = new SessionClass();
            $endTime = $session->openSession($sessionID,$endDate);
            echo date("d/m/Y" , $endTime);
            break;
        
        case 'deleteMessage':
            $id = $_GET['id'];
            $query = "UPDATE messages SET `active` = 0 WHERE messageID = $id";
            $result = mysql_query($query); 
            echo mysql_error();
            break;  
                             
        case 'sendMessage':     
            $from = $_SESSION['user']['userID'];
            $to = $_GET['sendTo'];
            $subject = mysql_real_escape_string($_GET['subject']);
            $content = mysql_real_escape_string($_GET['content']);
            $currentTime = $_SESSION['time']['timestamp'] + time() - $_SESSION['time']['updateTime'];
            if($to == "0") { // If message is supposed to be sent to all users (only available to admin)
                $session = new SessionClass();
                $currentSession = $session->getActiveSessionID();
                $query = "SELECT id FROM user WHERE type = '1'";
                if($currentSession != 0) {
                    $query .= " AND user.session = $currentSession";
                }
                $result = mysql_query($query);
                while($row = mysql_fetch_array($result)){
                    $to = $row['id'];
                    $query2="INSERT INTO messages (fromID, toID, subject, content, time)
                                VALUES ('".$from."', '".$to."', '".$subject."', '".$content."', '".$currentTime."')";
                    $result2 = mysql_query($query2);
                    if(mysql_error()) {
                        echo "0"; 
                        return;
                    }
                }
            } else { // Message to be sent to a single user
                $query="INSERT INTO messages (fromID, toID, subject, content, time)
                                VALUES ('".$from."', '".$to."', '".$subject."', '".$content."', '".$currentTime."')";
                $result = mysql_query($query);
                if(mysql_error()) {
                    echo "0"; 
                    return;
                }
            }
            echo "1";                             
            break; 
        case 'saveSettings':
            // Getting values to update
            $table = $_GET['setTable'];
            print_r($_GET);
            $session = new SessionClass();
            $activeSession = $session->getActiveSessionID(-1);
            switch ($table){
               case 'general':
                   $query = "UPDATE sessionsettings SET";
                   if ($_GET['deviationBetweenUsers']!="")
                       $query.=" deviationBetweenUsers = '".$_GET['deviationBetweenUsers']."',";
                   if ($_GET['smallCompany']!="")
                       $query.=" smallCompany = '".$_GET['smallCompany']."',";
                   if ($_GET['largeCompany']!="")
                       $query.=" largeCompany = '".$_GET['largeCompany']."',";
                   if ($_GET['productPromoted']!="")
                       $query.=" productPromoted = '".$_GET['productPromoted']."',";
                   if ($_GET['onlieOfflineRatio']!="")
                       $query.=" onlieOfflineRatio = '".$_GET['onlieOfflineRatio']."',";
                   if ($_GET['advertiseBudget']!="")
                       $query.=" advertiseBudget = '".$_GET['advertiseBudget']."',";
                   if ($_GET['trafficFactor']!="")
                       $query.=" trafficFactor = '".$_GET['trafficFactor']."',";
                   if ($_GET['siteSize']!="")
                       $query.=" siteSize = '".$_GET['siteSize']."',";
                   if ($_GET['pagesSeen']!="")
                       $query.=" pagesSeen = '".$_GET['pagesSeen']."',";
                   if ($_GET['timeInSite']!="")
                       $query.=" timeInSite = '".$_GET['timeInSite']."',";
                   if ($_GET['mailsArived']!="")
                       $query.=" mailsArived = '".$_GET['mailsArived']."',";
                   if ($_GET['leftContact']!="")
                       $query.=" leftContact = '".$_GET['leftContact']."',";
                   if ($_GET['directAccessChange']!="")
                       $query.=" directAccessChange = '".$_GET['directAccessChange']."',";
                   if ($_GET['SEMarketChange']!="")
                       $query.=" SEMarketChange = '".$_GET['SEMarketChange']."',";
                   if ($_GET['mediaMarketChange']!="")
                       $query.=" mediaMarketChange = '".$_GET['mediaMarketChange']."',";
                   if ($_GET['emailMarketChange']!="")
                       $query.=" emailMarketChange = '".$_GET['emailMarketChange']."',";
                   if ($_GET['PWebMarketChange']!="")
                       $query.=" PWebMarketChange = '".$_GET['PWebMarketChange']."',";
                   if ($_GET['competitionFactor']!="")
                       $query.=" competitionFactor = '".$_GET['competitionFactor']."',";
                   if ($_GET['adminName']!="")
                       $query.=" adminName = '".$_GET['adminName']."',";
                   $query.=" userSendMsg = '".$_GET['userSendMsg']."',";
                   $query.=" activeAgent = '".$_GET['activeAgent']."',";
                   $query.=" agentNameAsUser = '".$_GET['agentNameAsUser']."' ";
                   $query.="WHERE sessionID = $activeSession";
                   break;
               case 'email':
                   $query = "UPDATE emailsettings SET";
                   if ($_GET['emailOncePrice']!="")
                       $query.=" emailOncePrice = '".$_GET['emailOncePrice']."',";
                   if ($_GET['emailDailyPrice']!="")
                       $query.=" emailDailyPrice = '".$_GET['emailDailyPrice']."',";
                   if ($_GET['emailWeeklyPrice']!="")
                       $query.=" emailWeeklyPrice = '".$_GET['emailWeeklyPrice']."',";
                   if ($_GET['emailInfluanceDuration']!="")
                       $query.=" emailInfluanceDuration = '".$_GET['emailInfluanceDuration']."',";
                   if ($_GET['emailWebTraffic']!="")
                       $query.=" emailWebTraffic = '".$_GET['emailWebTraffic']."',";
                   if ($_GET['emailPagesView']!="")
                       $query.=" emailPagesView = '".$_GET['emailPagesView']."',";
                   if ($_GET['emailTimeInSite']!="")
                       $query.=" emailTimeInSite = '".$_GET['emailTimeInSite']."',";
                   if ($_GET['emailLeftConn']!="")
                       $query.=" emailLeftConn = '".$_GET['emailLeftConn']."',";
                   if ($_GET['emailMailsArrived']!="")
                       $query.=" emailMailsArrived = '".$_GET['emailMailsArrived']."',";
                   if ($_GET['emailPurchaseOnSite']!="")
                       $query.=" emailPurchaseOnSite = '".$_GET['emailPurchaseOnSite']."',";
                   if ($_GET['emailOfflineSales']!="")
                       $query.=" emailOfflineSales = '".$_GET['emailOfflineSales']."',";
                   if ($_GET['emailOtherSales']!="")
                       $query.=" emailOtherSales = '".$_GET['emailOtherSales']."',";
                   if ($query[strlen($query)-1] == ',')
                       $query[strlen($query)-1] = " ";
                   $query.=" WHERE sessionID = $activeSession";
                   break;
               case 'display':
                   $query = "UPDATE displaysettings SET";
                   if ($_GET['displayBannerPrice']!="")
                       $query.=" displayBannerPrice = '".$_GET['displayBannerPrice']."',";
                   if ($_GET['displayMoviePrice']!="")
                       $query.=" displayMoviePrice = '".$_GET['displayMoviePrice']."',";
                   if ($_GET['displayInfluanceBanDuration']!="")
                       $query.=" displayInfluanceBanDuration = '".$_GET['displayInfluanceBanDuration']."',";
                   if ($_GET['displayInfluanceMovDuration']!="")
                       $query.=" displayInfluanceMovDuration = '".$_GET['displayInfluanceMovDuration']."',";
                   if ($_GET['displayBanWebTraffic']!="")
                       $query.=" displayBanWebTraffic = '".$_GET['displayBanWebTraffic']."',";
                   if ($_GET['displayMovWebTraffic']!="")
                       $query.=" displayMovWebTraffic = '".$_GET['displayMovWebTraffic']."',";
                   if ($_GET['displayBanPagesseen']!="")
                       $query.=" displayBanPagesseen = '".$_GET['displayBanPagesseen']."',";
                   if ($_GET['displayMovPagesSeen']!="")
                       $query.=" displayMovPagesSeen = '".$_GET['displayMovPagesSeen']."',";
                   if ($_GET['displayBanTimeInSite']!="")
                       $query.=" displayBanTimeInSite = '".$_GET['displayBanTimeInSite']."',";
                   if ($_GET['displayMovTimeInSite']!="")
                       $query.=" displayMovTimeInSite = '".$_GET['displayMovTimeInSite']."',";
                   if ($_GET['displayBanLeftConn']!="")
                       $query.=" displayBanLeftConn = '".$_GET['displayBanLeftConn']."',";
                   if ($_GET['displayMovLeftConn']!="")
                       $query.=" displayMovLeftConn = '".$_GET['displayMovLeftConn']."',";
                   if ($_GET['displayBanMail']!="")
                       $query.=" displayBanMail = '".$_GET['displayBanMail']."',";
                   if ($_GET['displayMovMail']!="")
                       $query.=" displayMovMail = '".$_GET['displayMovMail']."',";
                   if ($_GET['displayBanOnlineSales']!="")
                       $query.=" displayBanOnlineSales = '".$_GET['displayBanOnlineSales']."',";
                   if ($_GET['displayMovOnlineSales']!="")
                       $query.=" displayMovOnlineSales = '".$_GET['displayMovOnlineSales']."',";
                   if ($_GET['displayBanOfflineSales']!="")
                       $query.=" displayBanOfflineSales = '".$_GET['displayBanOfflineSales']."',";
                   if ($_GET['displayMovOfflineSales']!="")
                       $query.=" displayMovOfflineSales = '".$_GET['displayMovOfflineSales']."',";
                   if ($_GET['displayBanOtherSales']!="")
                       $query.=" displayBanOtherSales = '".$_GET['displayBanOtherSales']."',";
                   if ($_GET['displayMovOtherSales']!="")
                       $query.=" displayMovOtherSales = '".$_GET['displayMovOtherSales']."',";
                   if ($query[strlen($query)-1] == ',')
                       $query[strlen($query)-1] = " ";
                   $query.=" WHERE sessionID = $activeSession";
                   break;                
            }
            echo $query;
                 /*           $userSend = mysql_real_escape_string($_GET['userSend']);
                            $agentName = mysql_real_escape_string($_GET['agentName']);
                            $agentBid = mysql_real_escape_string($_GET['agentBid']);
                            $initBalance = mysql_real_escape_string($_GET['initBalance']);
                            $auctionFee = mysql_real_escape_string($_GET['auctionFee']);
                            $bidFee = mysql_real_escape_string($_GET['bidFee']);
                            $paymentFailureFine = mysql_real_escape_string($_GET['paymentFine']);
                            $missingItemFine = mysql_real_escape_string($_GET['itemFine']);
                            $initItems = mysql_real_escape_string($_GET['initItems']);
                            $timeOffset = mysql_real_escape_string($_GET['timeOffset']);
                            $enableFixed = mysql_real_escape_string($_GET['enableFixed']);
                            $enableYankeeASC = mysql_real_escape_string($_GET['enableYankeeASC']);
                            $enableYankeeDESC = mysql_real_escape_string($_GET['enableYankeeDESC']);
                            $adminName = mysql_real_escape_string($_GET['adminName']);
                            $winningBid = mysql_real_escape_string($_GET['winningBid']);
                            $soldItem = mysql_real_escape_string($_GET['soldItem']);
                            $insufficientFunds = mysql_real_escape_string($_GET['insufficientFunds']);
                            $soldMissingItem = mysql_real_escape_string($_GET['soldMissingItem']);
                            $placedBid = mysql_real_escape_string($_GET['bidMessage']);
                            $auctionPost = mysql_real_escape_string($_GET['auctionPost']);
                            // Getting active session's id
                            $session = new SessionClass();
                            $activeSession = $session->getActiveSessionID();
                            // Updating admin settings in the DB
                            $query = "UPDATE settings SET userSend = '$userSend', agentNameAsUser = '$agentName', agentBid = $agentBid, 
                                                          initBalance = $initBalance, auctionFee = $auctionFee, bidFee = $bidFee, 
                                                          paymentFailureFine = $paymentFailureFine, missingItemFine = $missingItemFine,
                                                          timeOffset = $timeOffset, enableFixed = $enableFixed, enableYankeeAsc = $enableYankeeASC,
                                                          enableYankeeDesc = $enableYankeeDESC, adminName = '$adminName', winningBidMessage = '$winningBid',
                                                          soldItemMessage = '$soldItem', insufficientFundsMessage = '$insufficientFunds',
                                                          soldMissingItemMessage = '$soldMissingItem', bidMessage = '$placedBid', auctionPost = '$auctionPost'
                                      WHERE session = $activeSession";
                            mysql_query($query);*/
            
            $result = mysql_query($query);
            if ($result == false)
                echo "what";
            else {
                echo "OK";
            }
            break;           
       case 'ppcChoosePhrase':
			$sessionID = $_SESSION['user']['sessionID'];
            $sqlCategory = "SELECT businessType 
                            FROM sessionsettings
                            WHERE sessionID = $sessionID";
            $result = mysql_query($sqlCategory);
            $category = mysql_fetch_array($result);
                   $sqlquery = "SELECT * 
                                FROM ppccategory 
                                WHERE (category = '$category[0]')";
                    $result = mysql_query($sqlquery); 
                    
                    if($result) {
                          /* For debugging */
                          echo "<b>Business Category:</b> "; echo "<i>$category[0]</i><br/><br/>";
                     
                          echo "PPC Phrase:"; echo "<br/>";
                          echo "<select class='inputSelect' id='userSelect' onchange='makePpcBid(value)'>
                                 <option value=''>Select phrase...</option>";
                                                    
                          foreach(mysql_fetch_assoc($result) as $key=>$value) {
                              if ($key == "category") { continue;}
                              echo "<option value='".$key."'>"."$value"."</option>";
                          }
                          echo "</select> <br>";
        
                    } else {
                            echo "Error: Could not fetch phrases list<br>";
                      }
               break;
            
                                         
    }
 ?>    
 
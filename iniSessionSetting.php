<?php
    // Loading Admin settings from DB
    require_once('initdb.php');
    require_once("classes/SessionClass.php");
	
    //create initial setting list if none exists
    $query = "SELECT * FROM sessionsettings";
   // $query = "SELECT * FROM generalSettings";
    $result = mysql_query($query);
    if(mysql_num_rows($result) == 0) { // If no settings list exists
        // Create initial settings list
        $query = "INSERT INTO `sessionsettings` 
                            (`sessionID`, `daysPerDay`, `businessType`, `marketType`,
                             `sales`, `trafficFactor`, `siteSize`, `pagesSeen`, 
                             `timeInSite`,`mailsArived`, `leftContact`, `deviationBetweenUsers`, 
                             `smallCompany`, `largeCompany`, `productPromoted`, `onlineOfflineRatio`, 
                             `advertiseBudget`, `activeAgent`, `agentNameAsUser`, `userSendMsg`, 
                             `adminName`, `SEMarketSize`, `SEMarketChange`, `directAccessSize`, 
                             `directAccessChange`, `PWebMarketSize`, `PWebMarketChange`, `mediaMarketSize`,
                             `mediaMarketChange`, `emailMarketSize`, `emailMarketChange`, `competitionFactor`)
                     VALUES ('0', '7', 'cars', 'same',
                             '10000000', '1.2', '50', '50', 
                             '600','10','10', '5',
                             '50', '50', '50', '50',
                             '20', 'no', 'no', 'no',
                             'admin', '100000', '5', '100000',
                             '5', '100000', '5', '100000',
                             '5', '100000', '5', '5');";
       mysql_query($query);
        
	$query = "INSERT INTO emailsettings 
                            (`sessionID`, `emailOncePrice`, `emailDailyPrice`, `emailWeeklyPrice`,
                             `emailInfluanceDuration`, `emailWebTraffic`, `emailPagesView`, `emailTimeInSite`, 
                             `emailLeftConn`, `emailMailsArrived`, `emailPurchaseOnSite`, `emailOfflineSales`,
                             `emailOtherSales`) 
                     VALUES ('0', '1000', '2000', '1500',
                             '7', '5', '5', '5',
                             '5', '5', '5', '5', 
                             '5');";
                
        mysql_query($query);
        
        $query = "INSERT INTO displaysettings 
                            (`sessionID`, `displayBannerPrice`, `displayMoviePrice`, `displayInfluanceBanDuration`,
                             `displayInfluanceMovDuration`, `displayBanWebTraffic`, `displayMovWebTraffic`, `displayBanPagesseen`,
                             `displayMovPagesSeen`, `displayBanTimeInSite`, `displayMovTimeInSite`, `displayBanLeftConn`,
                             `displayMovLeftConn`, `displayBanMail`, `displayMovMail`, `displayBanOnlineSales`,
                             `displayMovOnlineSales`, `displayBanOfflineSales`, `displayMovOfflineSales`, `displayBanOtherSales`, 
                             `displayMovOtherSales`)
                     VALUES ('0', '1000', '2000', '7',
                             '14', '5', '10', '5',
                             '10', '5', '10', '5',
                             '10', '5', '10', '5',
                             '10', '5', '10', '5',
                             '10');";
        mysql_query($query);
    }
    
    if(isset($_SESSION['user']['userID']))  // If user is logged in
        $activeSession = $_SESSION['user']['sessionID'];
    else // If user is guest - not logged in
        $activeSession = 0;
    $query = "SELECT * FROM sessionsettings WHERE sessionID = $activeSession";
    $result = mysql_query($query);
    $settings = mysql_fetch_array($result); 
	
?>

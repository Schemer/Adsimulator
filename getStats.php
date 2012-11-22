<?php
// for User Information menu
    session_start();
    
    require_once('initdb.php');
    require_once('classes/AdminClass.php');
    require_once('iniSessionSetting.php');
    
    
    $adminClass = new AdminClass();
    ini_set("precision", "2"); // Sets floating point numbers' precision
    
    switch ($_GET['stats']) {
        case "siteVisits":      // Show number of times each user has visited to site
                                $fromDate = strtotime($_GET['from']);
                                $toDate = strtotime($_GET['to']);
                                $fromDate += 7200; // Adding 2 hour to convert from utc time to local time
                                $toDate += 7200;   // Adding 2 hour to convert from utc time to local time
                                $currentSession = $_SESSION['user']['sessionID'];
                                $query = "SELECT user.userID, user.name, COUNT(visits.userID) 
                                          FROM user, visits 
                                          WHERE user.userID = visits.userID AND 
                                                user.type = 'user' AND
                                                visitedAt BETWEEN $fromDate AND $toDate";
                                if($currentSession != 0) {
                                    $query .= " AND user.sessionID = $currentSession";
                                }
                                $query .= "
                                          GROUP BY userID, name 
                                          ORDER BY userID";
                                $result = mysql_query($query);
                                if (mysql_num_rows($result) > 0) {
                                    echo "<table id='visitsTable' class='campaignListTable'>
                                            <tr class='campaignListCat'>
                                                <td>ID</td>
                                                <td>Name</td>
                                                <td>No. of Visits</td>
                                            </tr>";
                                    while($arr = mysql_fetch_array($result)) {
                                    echo "
                                            <tr class='adminCampaignLines'>
                                                <td>".$arr[0]."</td>
                                                <td>".$arr[1]."</td>
                                                <td>".$arr[2]."</td>
                                            </tr>
                                            ";
                                    }
                                    echo "</table>";
                                    
                                    // Show the average amount of visits the users made to the site
                                    $query = "SELECT COUNT(DISTINCT visits.userID) AS users, COUNT(visits.userID) AS visitsAmount
                                          FROM visits, user 
                                          WHERE visits.userID = user.userID AND
                                                user.type = 'user' AND 
                                                visits.visitedAt BETWEEN $fromDate AND $toDate";
                                    if($currentSession != 0) {
                                        $query .= " AND user.sessionID = $currentSession";
                                    }
                                    $result = mysql_query($query);
                                    $arr = mysql_fetch_array($result);
                                    $averageVisits = $arr['visitsAmount'] / $arr['users'];
                                    echo "<table id='avgVisitsTable' class='campaignListTable'>
                                            <tr class='campaignListCat'>
                                                <td>No. of Users</td>
                                                <td>Average Site Visits</td>
                                            </tr>
                                            <tr class='admincampaignLines'>
                                                <td>".$arr['users']."</td>
                                                <td>".$averageVisits."</td>
                                            </tr>
                                          </table>";
                                }
                                break;
                                
        case "visitDuration":   // Display the amount of time each user spent on the site
                                $fromDate = strtotime($_GET['from']);
                                $toDate = strtotime($_GET['to']);
                                $currentSession = $_SESSION['user']['sessionID'];
                                $fromDate += 7200; // Adding 2 hour to convert from iso to utc time to local time
                                $toDate += 7200;   // Adding 2 hour to convert from iso to utc time to local time
                                $query = "SELECT user.userID, user.name, SUM(duration) 
                                          FROM user, visits 
                                          WHERE user.userID = visits.userID AND
                                                user.type = 'user' AND 
                                                visitedAt BETWEEN $fromDate AND $toDate";
                                if($currentSession != 0) {
                                    $query .= " AND user.sessionID = $currentSession";
                                }
                                $query .= " 
                                          GROUP BY userID, name 
                                          ORDER BY userID";
                                $result = mysql_query($query);
                                if (mysql_num_rows($result) > 0) {
                                    echo "<table id='visitDurationTable' class='campaignListTable'>
                                            <tr class='campaignListCat'>
                                                <td>ID</td>
                                                <td>Name</td>
                                                <td>Visits Duration</td>
                                            </tr>";
                                    while($arr = mysql_fetch_array($result)) {
                                        echo "
                                            <tr class='adminCampaignLines'>
                                                    <td>".$arr[0]."</td>
                                                    <td>".$arr[1]."</td>
                                        ";
                                        $totalSecLeft = $arr[2];
                                        // Get hours left
                                        if ($totalSecLeft / 3600 >= 1)  {
                                            $HourLeft = ($totalSecLeft - ($totalSecLeft % 3600)) / 3600;
                                            $totalSecLeft = $totalSecLeft - ($HourLeft * 3600);
                                        } else {
                                            $HourLeft=0;
                                        }
                                        // Get minutes left
                                        if ( $totalSecLeft / 60 >= 1)  {
                                            $MinLeft = ($totalSecLeft - ($totalSecLeft % 60)) / 60;
                                            $totalSecLeft = $totalSecLeft - ($MinLeft * 60);
                                        } else {
                                            $MinLeft=0;
                                        }
                                        // Get seconds left
                                        $SecLeft = $totalSecLeft;
                                        
                                        if ($HourLeft >= 24){
                                            $DaysLeft = floor($HourLeft / 24);
                                            $HourLeft = $HourLeft - $DaysLeft*24;
                                            echo "
                                                    <td>".$DaysLeft . 'd ' . $HourLeft . 'h ' . $MinLeft . 'm '."</td>
                                                </tr>
                                                ";
                                        } else {
                                            echo "
                                                    <td>".$HourLeft . 'h ' . $MinLeft . 'm ' . $SecLeft . 's'."</td>
                                                </tr>
                                                ";        
                                        }
                                    }
                                    echo "</table>";
                                }
                                
                                // Display the average amount of time users have spent on the site
                                $query = "SELECT COUNT(DISTINCT visits.userID) AS users, SUM(duration) AS durSum 
                                          FROM visits, user 
                                          WHERE visits.userID = user.userID AND
                                                user.type = 'user' AND
                                                visitedAt BETWEEN $fromDate AND $toDate";
                                if($currentSession != 0) {
                                    $query .= " AND user.sessionID = $currentSession";
                                }
                                $result = mysql_query($query);
                                $arr = mysql_fetch_array($result);
                                if ($arr['users']!='0')
                                    $durationAvg = $arr['durSum'] / $arr['users'];
                                else
                                    $durationAvg = '0';
                                echo "<table id='avgVisitsTable' class='campaignListTable'>
                                        <tr class='campaignListCat'>
                                            <td>No. of Users</td>
                                            <td>Average Visit Duration</td>
                                        </tr>
                                        <tr class='adminCampaignLines'>
                                            <td>".$arr['users']."</td>";
                                            
                                $totalSecLeft = $durationAvg;
                                // Get hours left
                                if ($totalSecLeft / 3600 >= 1)  {
                                    $HourLeft = ($totalSecLeft - ($totalSecLeft % 3600)) / 3600;
                                    $totalSecLeft = $totalSecLeft - ($HourLeft * 3600);
                                } else {
                                    $HourLeft=0;
                                }
                                // Get minutes left
                                if ( $totalSecLeft / 60 >= 1)  {
                                    $MinLeft = ($totalSecLeft - ($totalSecLeft % 60)) / 60;
                                    $totalSecLeft = $totalSecLeft - ($MinLeft * 60);
                                } else {
                                    $MinLeft=0;
                                }
                                // Get seconds left
                                $SecLeft = $totalSecLeft;
                                
                                if ($HourLeft >= 24){
                                    $DaysLeft = floor($HourLeft / 24);
                                    $HourLeft = $HourLeft - $DaysLeft*24;
                                    echo "
                                            <td>".$DaysLeft . 'd ' . $HourLeft . 'h ' . $MinLeft . 'm '."</td>
                                        </tr>
                                        ";
                                } else {
                                    echo "
                                            <td>".$HourLeft . 'h ' . $MinLeft . 'm ' . $SecLeft . 's'."</td>
                                        </tr>
                                        ";        
                                }
                                
                                echo "
                                      </table>";
                                break;
        
        case "createdCampaign":  // Show the number of Campaigns each user create
                                $fromDate = strtotime($_GET['from']);
                                $toDate = strtotime($_GET['to']);
                                $fromDate += 7200; // Adding 2 hour to convert from iso to utc time to local time
                                $toDate += 7200;   // Adding 2 hour to convert from iso to utc time to local time
                                $currentSession = $_SESSION['user']['sessionID'];
                                $query = "SELECT campaign.userID, user.name, count(campaign.userID) 
                                          FROM campaign , user
                                          WHERE user.userID = campaign.userID AND 
                                                campaign.startTime BETWEEN $fromDate AND $toDate";
                                if($currentSession != 0) {
                                    $query .= " AND user.sessionID = $currentSession";
                                }                
                                $query .= " 
                                          GROUP BY userID 
                                          ORDER BY userID";         
                                $result = mysql_query($query);
                                if (mysql_num_rows($result) > 0) {
                                    echo "<table id='viewedCampaignTable' class='campaignListTable'>
                                            <tr class='campaignListCat'>
                                                <td>ID</td>
                                                <td>Name</td>
                                                <td>No. of Created Campaigns</td>
                                            </tr>";
                                    while($arr = mysql_fetch_array($result)) {
                                        echo "
                                            <tr class='adminCampaignLines'>
                                                    <td>".$arr[0]."</td>
                                                    <td>".$arr[1]."</td>
                                                    <td>".$arr[2]."</td>
                                            </tr>
                                        ";
                                    }
                                echo "
                                      </table>";
                                }
                                
                                // Show the average amount of campaigns each user created
                                $query = "SELECT COUNT(DISTINCT campaign.userID) AS users, COUNT(campaign.userID) AS campaigns 
                                          FROM campaign, user 
                                          WHERE campaign.userID = user.userID AND
                                                campaign.startTime BETWEEN $fromDate AND $toDate";
                                if($currentSession != 0) {
                                    $query .= " AND user.sessionID = $currentSession";
                                } 
                                $result = mysql_query($query);
                                $arr = mysql_fetch_array($result);
                                $viewedAuctionsAvg = $arr['campaigns'] / $arr['users'];
                                echo "<table id='avgCampaignVisitsTable' class='campaignListTable'>
                                        <tr class='campaignListCat'>
                                            <td>No. of Users</td>
                                            <td>Average Campaigns Created</td>
                                        </tr>
                                        <tr class='adminCampaignLines'>
                                            <td>".$arr['users']."</td>
                                            <td>".$viewedAuctionsAvg."</td>
                                        </tr>
                                      </table>";
                                break;
        
        case "popularCampaigns": $fromDate = strtotime($_GET['from']);
                                $toDate = strtotime($_GET['to']);
                                $fromDate += 7200; // Adding 2 hour to convert from iso to utc time to local time
                                $toDate += 7200;   // Adding 2 hour to convert from iso to utc time to local time
                                $currentSession = $_SESSION['user']['sessionID'];
                                $query = "SELECT COUNT(campaign.subType) AS campaigns, campaign.subType AS subTypes, campaign.type AS type
                                          FROM campaign 
                                          WHERE  
                                                campaign.startTime BETWEEN $fromDate AND $toDate";
                                if($currentSession != 0) {
                                  //  $query .= " AND user.sessionID = $currentSession";
                                }                 
                                $query .= "
                                          GROUP BY subTypes 
                                          ORDER BY campaigns DESC";
                                $result = mysql_query($query);
                                $numRows = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM campaign"));
                                if (mysql_num_rows($result) > 0) {
                                    echo "<h3>Displaying Campaigns popularty: </h3>
                                        <table class='campaignListTable'>
                                            <tr class='campaignListCat'>
                                                <td>Campaign Type</td>
                                                <td>Campaign SubType</td>
                                                <td>created</td>
                                                <td>precent of all</td>
                                            </tr>";
                                    
                                    while($arr = mysql_fetch_array($result)) {
                                        echo "
                                            <tr class='adminAuctionLines'>
                                                    <td>".$arr[2]."</td>
                                                    <td>".$arr[1]."</td>
                                                    <td>".$arr[0]."</td>                                  
                                                    <td>".($arr[0]/$numRows[0]*100)."%</td>
                                            </tr>";
                                    }
                                echo "
                                      </table>";
                                }
                                break;
                                
        case "activeUsers":     $fromDate = strtotime($_GET['from']);
                                $toDate = strtotime($_GET['to']);
                                $fromDate += 7200; // Adding 2 hour to convert from iso to utc time to local time
                                $toDate += 7200;   // Adding 2 hour to convert from iso to utc time to local time
                                $currentSession = $_SESSION['user']['sessionID'];
                                $query = "SELECT visits.userID, user.name, MAX(visitedAt) 
                                          FROM user, visits 
                                          WHERE visits.visitedAt BETWEEN $fromDate AND $toDate AND 
                                                user.userID = visits.userID AND
                                                user.type = 'user'";
                                if($currentSession != 0) {
                                    $query .= " AND user.sessionID = $currentSession";
                                }                 
                                $query .= " 
                                          GROUP BY userID, name 
                                          ORDER BY userID";
                                $result = mysql_query($query);
                                if (mysql_num_rows($result) > 0) {
                                    echo "
                                        <table id='activeUsersTable' class='campaignListTable'>
                                            <tr class='campaignListCat'>
                                                <td>ID</td>
                                                <td>Name</td>
                                                <td>Last Visit</td>
                                            </tr>";
                                   while($arr = mysql_fetch_array($result)) {
                                       echo "<tr class='adminCampaignLines'>
                                                    <td>".$arr[0]."</td>
                                                    <td>".$arr[1]."</td>                                                   
                                                    <td>".date("d-m-Y H:i:s", ($arr[2]-7200))."</td>
                                             </tr>";
                                   }
                                echo "
                                      </table>";
                                }
                                break;
        
        case "default":         break;
    }
?>

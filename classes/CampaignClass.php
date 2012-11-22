<?php
    require_once("MessagesClass.php");
    require_once("BalanceClass.php");
    require_once("SessionClass.php");
    require_once("UserClass.php");

    Class CampaignClass	{
        function calculateTime($startTime,$duration){
            $sessionClass = new SessionClass();
            $session = $sessionClass->getSessionDetails($_SESSION['user']['sessionID']);
            $sessionSet = $sessionClass->getSessionSettings($_SESSION['user']['sessionID']);
            $timeTraffic = $sessionSet['daysPerDay'];
            $passTime = ($startTime-$session['startTime'])*$timeTraffic;

            $years = (floor($passTime/60/60/24))/360;
            $year =  ceil($years);
            $month = floor(($years- floor($years))*12)+1;
            $days =(($years- floor($years))*360)-($month-1)*30+1;
            if ($year<10) $year= '0'.$year;
            if ($month<10) $month= '0'.$month;
            if ($days<10) $days= '0'.$days;
            $startDate = array("year"=>$year, "month" => $month, "days" => $days);

            // calcuate ending date
            $year += floor($duration/360);
            $month += floor(($duration%360)/30);
            $days += floor(($duration%360)%30);
            if ($days>30){
                $days -= 30;
                $month +=1;
                if ($month>12){
                    $month = 1;
                    $year +=1;
                }
            }
            if ($year<10) $year= '0'.$year;
            if ($month<10) $month= '0'.$month;
            if ($days<10) $days= '0'.$days;
            $endDate = array("year"=>$year, "month" => $month, "days" => $days);
            return array ("start" =>$startDate,"end"=> $endDate);
        }

        function addCampaign($totalPrice,$startTime,$duration,$onGoing,$campaignType,$userID,$subType,$phrase){
            // Adding the new campaign to the DB
            $userClass = new userClass();
            $userState = $userClass->getUserState($userID);
            $sessionClass = new sessionClass();
            $campaignSetting = $this->getCampaignSetting($_SESSION['user']['sessionID'],$campaignType);
            switch ($campaignType) {
                case 'email':
                    $webTraffic = $userState['webTraffic'] * $campaignSetting['emailWebTraffic']/100;
                    $timeInSite = $userState['timeInSite'] * $campaignSetting['emailWebTraffic']/100;
                    $mailsArrived = $userState['mailsArrived'] * $campaignSetting['emailWebTraffic']/100;
                    $leftContact = $userState['leftContact'] * $campaignSetting['emailWebTraffic']/100;
                    $pagesSeen = $userState['pagesSeen'] * $campaignSetting['emailPagesView']/100;
                    $onlineSales = $userState['onlineSales'] * $campaignSetting['emailWebTraffic']/100;
                    $offlineSales = $userState['offlineSales'] * $campaignSetting['emailOfflineSales']/100;
                    $otherSales = $userState['otherSales'] * $campaignSetting['emailOtherSales']/100;
                    break;
                case 'display':
                    if ($subType == 'banner'){
                        $webTraffic = $userState['webTraffic'] * $campaignSetting['displayBanWebTraffic']/100;
                        $timeInSite = $userState['timeInSite'] * $campaignSetting['displayBanTimeInSite']/100;
                        $mailsArrived = $userState['mailsArrived'] * $campaignSetting['displayBanMail']/100;
                        $leftContact = $userState['leftContact'] * $campaignSetting['displayBanLeftConn']/100;
                        $pagesSeen = $userState['pagesSeen'] * $campaignSetting['displayBanPagesseen']/100;
                        $onlineSales = $userState['onlineSales'] * $campaignSetting['displayBanOnlineSales']/100;
                        $offlineSales = $userState['offlineSales'] * $campaignSetting['displayBanOfflineSales']/100;
                        $otherSales = $userState['otherSales'] * $campaignSetting['displayBanOtherSales']/100;
                    }
                    if ($subType == 'movie'){
                        $webTraffic = $userState['webTraffic'] * $campaignSetting['displayMovWebTraffic']/100;
                        $timeInSite = $userState['timeInSite'] * $campaignSetting['displayMovTimeInSite']/100;
                        $mailsArrived = $userState['mailsArrived'] * $campaignSetting['displayMovMail']/100;
                        $leftContact = $userState['leftContact'] * $campaignSetting['displayMovLeftConn']/100;
                        $pagesSeen = $userState['pagesSeen'] * $campaignSetting['displayMovPagesSeen']/100;
                        $onlineSales = $userState['onlineSales'] * $campaignSetting['displayMovOnlineSales']/100;
                        $offlineSales = $userState['offlineSales'] * $campaignSetting['displayMovOfflineSales']/100;
                        $otherSales = $userState['otherSales'] * $campaignSetting['displayMovOtherSales']/100;
                    }break;
               case 'seo':
                     if ($subType == 'simple')
                     {
                        $webTraffic = $userState['webTraffic'] * $campaignSetting['seoWebTraffic']/100;
                        $timeInSite = $userState['timeInSite'] * $campaignSetting['seoTimeInSite']/100;
                        $mailsArrived = $userState['mailsArrived'] * $campaignSetting['seoMail']/100;
                        $leftContact = $userState['leftContact'] * $campaignSetting['seoLeftConn']/100;
                        $pagesSeen = $userState['pagesSeen'] * $campaignSetting['seoPagesView']/100;
                        $onlineSales = $userState['onlineSales'] * $campaignSetting['seoOnlineSales']/100;
                        $offlineSales = $userState['offlineSales'] * $campaignSetting['seoOfflineSales']/100;
                        $otherSales = $userState['otherSales'] * $campaignSetting['seoOtherSales']/100;  
                        break;
                     }
                     if ($subType == 'complex')
                     {
                        $webTraffic = $userState['webTraffic'] * $campaignSetting['seoWebTraffic']/100;
                        $timeInSite = $userState['timeInSite'] * $campaignSetting['seoTimeInSite']/100;
                        $mailsArrived = $userState['mailsArrived'] * $campaignSetting['seoMail']/100;
                        $leftContact = $userState['leftContact'] * $campaignSetting['seoLeftConn']/100;
                        $pagesSeen = $userState['pagesSeen'] * $campaignSetting['seoPagesView']/100;
                        $onlineSales = $userState['onlineSales'] * $campaignSetting['seoOnlineSales']/100;
                        $offlineSales = $userState['offlineSales'] * $campaignSetting['seoOfflineSales']/100;
                        $otherSales = $userState['otherSales'] * $campaignSetting['seoOtherSales']/100;
                     }break;
               case 'ppc': 
                    /* switch ($subType){
                        case 'Google':  $coefficient =
                        case 'Yahoo':
                        case 'Bing':
                        case 'Baidu':
                        case 'Walla':
                        case 'Yandex':
                     }
                     $sqlquery = "SELECT * FROM selist WHERE site = $subType";
*/
                   
                        if ($subType == 'Google.com'){
                            $webTraffic = $userState['webTraffic'] * $campaignSetting['displayBanWebTraffic']/100;
                            $timeInSite = $userState['timeInSite'] * $campaignSetting['displayBanTimeInSite']/100;
                            $mailsArrived = $userState['mailsArrived'] * $campaignSetting['displayBanMail']/100;
                            $leftContact = $userState['leftContact'] * $campaignSetting['displayBanLeftConn']/100;
                            $pagesSeen = $userState['pagesSeen'] * $campaignSetting['displayBanPagesseen']/100;
                            $onlineSales = $userState['onlineSales'] * $campaignSetting['displayBanOnlineSales']/100;
                            $offlineSales = $userState['offlineSales'] * $campaignSetting['displayBanOfflineSales']/100;
                            $otherSales = $userState['otherSales'] * $campaignSetting['displayBanOtherSales']/100;
                        }
                        if ($subType == 'Yahoo.com'){
                            $webTraffic = $userState['webTraffic'] * $campaignSetting['displayMovWebTraffic']/100;
                            $timeInSite = $userState['timeInSite'] * $campaignSetting['displayMovTimeInSite']/100;
                            $mailsArrived = $userState['mailsArrived'] * $campaignSetting['displayMovMail']/100;
                            $leftContact = $userState['leftContact'] * $campaignSetting['displayMovLeftConn']/100;
                            $pagesSeen = $userState['pagesSeen'] * $campaignSetting['displayMovPagesSeen']/100;
                            $onlineSales = $userState['onlineSales'] * $campaignSetting['displayMovOnlineSales']/100;
                            $offlineSales = $userState['offlineSales'] * $campaignSetting['displayMovOfflineSales']/100;
                            $otherSales = $userState['otherSales'] * $campaignSetting['displayMovOtherSales']/100;
                        }
                        if ($subType == 'Bing.com'){
                            $webTraffic = $userState['webTraffic'] * $campaignSetting['displayBanWebTraffic']/100;
                            $timeInSite = $userState['timeInSite'] * $campaignSetting['displayBanTimeInSite']/100;
                            $mailsArrived = $userState['mailsArrived'] * $campaignSetting['displayBanMail']/100;
                            $leftContact = $userState['leftContact'] * $campaignSetting['displayBanLeftConn']/100;
                            $pagesSeen = $userState['pagesSeen'] * $campaignSetting['displayBanPagesseen']/100;
                            $onlineSales = $userState['onlineSales'] * $campaignSetting['displayBanOnlineSales']/100;
                            $offlineSales = $userState['offlineSales'] * $campaignSetting['displayBanOfflineSales']/100;
                            $otherSales = $userState['otherSales'] * $campaignSetting['displayBanOtherSales']/100;
                        }
                        if ($subType == 'Baidu.com'){
                            $webTraffic = $userState['webTraffic'] * $campaignSetting['displayMovWebTraffic']/100;
                            $timeInSite = $userState['timeInSite'] * $campaignSetting['displayMovTimeInSite']/100;
                            $mailsArrived = $userState['mailsArrived'] * $campaignSetting['displayMovMail']/100;
                            $leftContact = $userState['leftContact'] * $campaignSetting['displayMovLeftConn']/100;
                            $pagesSeen = $userState['pagesSeen'] * $campaignSetting['displayMovPagesSeen']/100;
                            $onlineSales = $userState['onlineSales'] * $campaignSetting['displayMovOnlineSales']/100;
                            $offlineSales = $userState['offlineSales'] * $campaignSetting['displayMovOfflineSales']/100;
                            $otherSales = $userState['otherSales'] * $campaignSetting['displayMovOtherSales']/100;
                        }
                        if ($subType == 'Walla.co.il'){
                            $webTraffic = $userState['webTraffic'] * $campaignSetting['displayBanWebTraffic']/100;
                            $timeInSite = $userState['timeInSite'] * $campaignSetting['displayBanTimeInSite']/100;
                            $mailsArrived = $userState['mailsArrived'] * $campaignSetting['displayBanMail']/100;
                            $leftContact = $userState['leftContact'] * $campaignSetting['displayBanLeftConn']/100;
                            $pagesSeen = $userState['pagesSeen'] * $campaignSetting['displayBanPagesseen']/100;
                            $onlineSales = $userState['onlineSales'] * $campaignSetting['displayBanOnlineSales']/100;
                            $offlineSales = $userState['offlineSales'] * $campaignSetting['displayBanOfflineSales']/100;
                            $otherSales = $userState['otherSales'] * $campaignSetting['displayBanOtherSales']/100;
                        }
                        if ($subType == 'Yandex.ru'){
                            $webTraffic = $userState['webTraffic'] * $campaignSetting['displayMovWebTraffic']/100;
                            $timeInSite = $userState['timeInSite'] * $campaignSetting['displayMovTimeInSite']/100;
                            $mailsArrived = $userState['mailsArrived'] * $campaignSetting['displayMovMail']/100;
                            $leftContact = $userState['leftContact'] * $campaignSetting['displayMovLeftConn']/100;
                            $pagesSeen = $userState['pagesSeen'] * $campaignSetting['displayMovPagesSeen']/100;
                            $onlineSales = $userState['onlineSales'] * $campaignSetting['displayMovOnlineSales']/100;
                            $offlineSales = $userState['offlineSales'] * $campaignSetting['displayMovOfflineSales']/100;
                            $otherSales = $userState['otherSales'] * $campaignSetting['displayMovOtherSales']/100;
                        }break;
            }
            $sessionSetting = $sessionClass->getSessionSettings($_SESSION['user']['sessionID']);

            $sql = "INSERT INTO `campaign` (`userID`,`type`, `subType`, `Price`,`startTime`,`onGoing`,`duration`,
                                            `webTraffic`,`timeInSite`,`leftContact`,`pagesSeen`,`mailsArived`,`onlineSale`,
                                            `offlineSale`,`otherSale`)                        
                            VALUES ('$userID','$campaignType','$subType','$totalPrice','$startTime','$onGoing','$duration',
                                    '$webTraffic','$timeInSite','$leftContact','$pagesSeen','$mailsArrived','$onlineSales',
                                    '$offlineSales','$otherSales');";
            mysql_query($sql);
            if(mysql_error()) {
                    return mysql_error();
            } else {
                    $id = mysql_insert_id();
            }	
            
            return $id; // Return the ID generated for the campaign
        }
        
        function delCampaign($campaignID){
            
            
            
            
        }

        function getcampaignDetail($campaignID){
            $sqlquery = "SELECT * FROM campaign WHERE campaignID=$campaignID";
            $result = mysql_fetch_array(mysql_query($sqlquery));
            if ($result==FALSE) {echo 'error';}
            return $result;   
        }

        function campaignListByType($userID,$type){
            $sqlquery = "SELECT * FROM campaign 
                         WHERE campaign.userID = $userID AND campaign.type = '$type'
                         ORDER BY  campaign.campaignID DESC ";
                         //AND campaign.close = 1";
            $result = mysql_query($sqlquery);
            return $result;
        }
        
        function getActiveCampaigns($userID){
            $sqlquery = "SELECT * FROM campaign 
                         WHERE userID=$userID And onGoing= 'yes'
                         ORDER BY startTime DESC";
            $result=(mysql_query($sqlquery));
            return $result;
        }
        
        function getPassedCampaigns($userID){
            $sqlquery = "SELECT * FROM campaign 
                         WHERE userID=$userID And onGoing= 'no'
                         ORDER BY startTime DESC";
            $result=(mysql_query($sqlquery));
            return $result;
        }
        
        function getCampaignsByType($userID,$type){
            $sqlquery = "SELECT * FROM campaign WHERE userID=$userID And type ='$type'
                        ";
            $result=(mysql_query($sqlquery));
            return $result;
        }
        
        function getCampaignSetting($sessionID,$type){
            switch ($type){
                case 'email':    $typeString = 'emailsettings'; break;
                case 'display' : $typeString = 'displaysettings'; break;
                case 'seo':      $typeString = 'seosettings'; break;
                case 'ppc':      $typeString = 'ppcsettings'; break;
            }
            $sqlquery = "SELECT * FROM $typeString WHERE sessionID = $sessionID";
            return mysql_fetch_array(mysql_query($sqlquery));
        }
        
        function getCampaignPrice($type){
            if(isset($_SESSION['user'])){
                $currentSession = $_SESSION['user']['sessionID'];
            } else {
            $currentSession = 0;
            }
            $d= "";
            
            switch ($type){
                case 'email':
                    $sqlquery = "SELECT  emailOncePrice,emailDailyPrice,emailWeeklyPrice
                                 FROM  emailsettings
                                 WHERE sessionID = $currentSession";
                    break;
                case 'display':
                    $sqlquery = "SELECT  displayBannerPrice, displayMoviePrice
                                 FROM  displaysettings
                                 WHERE sessionID = $currentSession";
                    break;
                case 'ppc':
                    break;
                case 'seo':
                    $sqlquery = "SELECT  seoSimplePrice, seoComplexPrice
                                 FROM  seosettings
                                 WHERE sessionID = $currentSession";
                    break;
            }
            $result = mysql_query($sqlquery);
            $row =  mysql_fetch_array($result);
            for ($index = 0; $index < sizeof($row)/2; $index++) {
                $d.= $row[$index]. ";";
            }
            return $d;
        }
    }
?>
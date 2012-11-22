<?php
    include_once("classes/CampaignClass.php");
    include_once("classes/BalanceClass.php");
    include_once("classes/SessionClass.php");
    $balance = new BalanceClass();
    $sessionClass = new SessionClass();
    $session = $sessionClass->getSessionDetails($_SESSION['user']['sessionID']);
    
    if (empty($_SESSION['user']))
    {
        echo "<h2>You must login in order to view your account</h2><BR/>
              <h3>Please wait while you're being transferred.</h3>";
        echo "<script>setTimeout(\"document.location.href='index.php?tabID=Login'\",3000);</script>";
        return;
    }
    
    if ($_SESSION['user']['authorize']!=true) {
          require_once('./Logout.php');
          exit;
    }
    $campaignClass = new CampaignClass();
    echo "<h2 align=center>".$_SESSION['user']['name']."'s Dashboard</h2>";
    echo "<div id='dashboardTitles'>
            Current Budget: <b>" . $balance->getBalance($_SESSION['user']['userID']) . "$</b><br>
          </div>";
    
    $activeCampaigns = $campaignClass->getActiveCampaigns($_SESSION['user']['userID']);  
    echo "<div id='accountContainer'>
            <h3>Active Campaigns:</h3>";
    
    $displayCampaigns= "";
    $emailCampaigns="";
    $seoCampaigns="";
    $ppcCampaigns="";
	
    while($row = mysql_fetch_array($activeCampaigns)){
        switch ($row['type']){            
            case 'email':
                $endTime = $row['startTime'] + round($row['duration']*86400/7);
                $emailCampaigns .= 
                    "<tr class='adminCampaignLines'>
                        <td>".$row['subType']."</td>
                        <td>".$row['Price']."$</td>
                        <td>".date('d/m/Y',$row['startTime'])."</td>
                        <td>".date('d/m/Y',$endTime).
                    "</td>
                 </tr>";
                break;
            case 'seo':
                $endTime = $row['startTime'] + round($row['duration']*86400/7);
                $seoCampaigns .= 
                "<tr class='adminCampaignLines'>
                    <td>".$row['subType']."</td>
                    <td>".$row['Price']."$</td>
                    <td>".date('d/m/Y',$row['startTime'])."</td>
                    <td>".date('d/m/Y',strtotime($row['endTime']))."</td>
                                </tr>";
                break;
            case 'ppc':
                $endTime = $row['startTime'] + round($row['duration']*86400/7);
                $ppcCampaigns .= 
                 "<tr class='adminCampaignLines'>
                    <td>".$row['subType']."</td>
                    <td>".$row['Price']."$</td>
                    <td>".date('d/m/Y',strtotime($row['startTime']))."</td>
                    <td>".date('d/m/Y',strtotime($row['endTime']))."</td>
                  </tr>";
                break;
            case 'display':
                $endTime = $row['startTime'] + round($row['duration']*86400/7);
                $displayCampaigns .= 
                 "<tr class='adminCampaignLines'>
                    <td>".$row['subType']."</td>
                    <td>".$row['Price']."$</td>
                    <td>".date('d/m/Y',strtotime($row['startTime']))."</td>
                    <td>".date('d/m/Y',strtotime($row['endTime']))."</td>
                  </tr>";
                break;
        }
    }
    if ($emailCampaigns=="")
        $emailCampaigns = "<h4>E-Mail Campaigns:</h4>
                            <i>None E-Mail Campaigns has been Activated</i>";
    else{
        $emailCampaigns = "<h4>E-Mail Campaigns:</h4>
        <table class='campaignListTable'>
        <tr class='campaignListCat'>
            <td>SubType</td>
            <td>Fee</td>
            <td>Starting Time</td>
            <td>Ending Time</td>
        </tr>". $emailCampaigns."</table>";
    }
	if ($seoCampaigns == "")
        $seoCampaigns = "<h4>SEO Campaigns:</h4>
                         <i>None SEO Campaigns has been Activated</i>";
    else{
        $seoCampaigns = "<h4>SEO Campaigns:</h4>
        <table class='campaignListTable'>
        <tr class='campaignListCat'>
            <td>SubType</td>
            <td>Fee</td>
            <td>Starting Time</td>
            <td>Ending Time</td>
        </tr>". $seoCampaigns."</table>";
    }
        
    if ($ppcCampaigns == "")
        $ppcCampaigns = "<h4>PPC Campaigns:</h4>
                         <i>None PPC Campaigns has been Activated</i>";
    else{
        $ppcCampaigns = "<h4>PPC Campaigns:</h4>
        <table class='campaignListTable'>
        <tr class='campaignListCat'>
            <td>SubType</td>
            <td>Fee</td>
            <td>Starting Time</td>
            <td>Ending Time</td>
        </tr>". $ppcCampaigns."</table>";    
    }
    if ($displayCampaigns=="")
        $displayCampaigns = "<h4>Display Campaigns:</h4>
                             <i>None Dispaly Campaigns has been Activated</i>";
    else{
        $displayCampaigns = "<h4>Display Campaigns:</h4>
        <table class='campaignListTable'>
        <tr class='campaignListCat'>
            <td>SubType</td>
            <td>Fee</td>
            <td>Starting Time</td>
            <td>Ending Time</td>
        </tr>". $displayCampaigns."</table>";
    }
    echo "$emailCampaigns 
		  $seoCampaigns
		  $ppcCampaigns
          $displayCampaigns";

	$passedCampaigns = $campaignClass->getPassedCampaigns($_SESSION['user']['userID']);  
	echo "<div id='accountContainer'>
            <h3>Passed Campaigns:</h3>";
    
    $displayCampaigns = "";
    $emailCampaigns = "";
    $seoCampaigns = "";
    $ppcCampaigns = "";
    
    while($row = mysql_fetch_array($passedCampaigns)){
        switch ($row['type']){            
            case 'email':
                $endTime = $row['startTime'] + round($row['duration']*86400/7);
                $emailCampaigns .= 
                 "<tr class='adminCampaignLines'>
                     <td>".$row['subType']."</td>
                     <td>".$row['Price']."$</td>
                     <td>".date('d/m/Y',$row['startTime'])."</td>
                     <td>".date('d/m/Y',strtotime($row['endTime']))."</td>
                     <td>".date('d/m/Y', $row['endTime'])."</td>
                 </tr>";
                break;
            case 'seo': 
                $endTime = $row['startTime'] + round($row['duration']*86400/7);
                $seoCampaigns .= 
                 "<tr class='adminCampaignLines'>
                    <td>".$row['subType']."</td>
                    <td>".$row['Price']."$</td>
                    <td>".date('d/m/Y',$row['startTime'])."</td>
                    <td>".date('d/m/Y',strtotime($row['endTime']))."</td>
                  </tr>";
                break;
            case 'ppc': 
                $endTime = $row['startTime'] + round($row['duration']*86400/7);
                $ppcCampaigns .= 
                 "<tr class='adminCampaignLines'>
                    <td>".$row['subType']."</td>
                    <td>".$row['Price']."$</td>
                    <td>".date('d/m/Y',strtotime($row['startTime']))."</td>
                    <td>".date('d/m/Y',strtotime($row['endTime']))."</td>
                  </tr>";
                break;
            case 'display':
                $endTime = $row['startTime'] + round($row['duration']*86400/7);
                $displayCampaigns .= 
                 "<tr class='adminCampaignLines'>
                    <td>".$row['subType']."</td>
                    <td>".$row['Price']."$</td>
                    <td>".date('d/m/Y',strtotime($row['startTime']))."</td>
                    <td>".date('d/m/Y',strtotime($row['endTime']))."</td>
                  </tr>";
                break;
        }
    }
    if ($emailCampaigns == "")
        $emailCampaigns = "<h4>E-Mail Campaigns:</h4>
                           <i>None E-Mail Campaigns has been Ended</i>";
    else{
        $emailCampaigns = "<h4>E-Mail Campaigns:</h4>
        <table class='campaignListTable'>
        <tr class='campaignListCat'>
            <td>SubType</td>
            <td>Fee</td>
            <td>Starting Time</td>
            <td>Ending Time</td>
        </tr>". $emailCampaigns."</table>";
    }
    
    if ($seoCampaigns == "")
        $seoCampaigns = "<h4>SEO Campaigns:</h4>
                         <i>None SEO Campaigns has been Ended</i>";
    else{
        $seoCampaigns = "<h4>SEO Campaigns:</h4>
        <table class='campaignListTable'>
        <tr class='campaignListCat'>
            <td>SubType</td>
            <td>Fee</td>
            <td>Starting Time</td>
            <td>Ending Time</td>
        </tr>". $seoCampaigns."</table>";
    }
        
    if ($ppcCampaigns == "")
        $ppcCampaigns = "<h4>PPC Campaigns:</h4>
                         <i>None PPC Campaigns has been Ended</i>";
    else{
        $ppcCampaigns = "<h4>PPC Campaigns:</h4>
        <table class='campaignListTable'>
        <tr class='campaignListCat'>
            <td>SubType</td>
            <td>Fee</td>
            <td>Starting Time</td>
            <td>Ending Time</td>
        </tr>". $ppcCampaigns."</table>";    
    }
    
    if ($displayCampaigns == "")
        $displayCampaigns = "<h4>Display Campaigns:</h4>
                             <i>None Dispaly Campaigns has been Ended</i>";
    else{
        $displayCampaigns = "<h4>Display Campaigns:</h4>
        <table class='campaignListTable'>
        <tr class='campaignListCat'>
            <td>SubType</td>
            <td>Fee</td>
            <td>Starting Time</td>
            <td>Ending Time</td>
        </tr>". $displayCampaigns."</table>";
    }
    echo "$emailCampaigns
          $seoCampaigns
          $ppcCampaigns
          $displayCampaigns";
    
    echo "<h3>Site Traffic:</h3>
            <table class='campaignListTable'>
                <tr class='campaignListCat'>
                    <td>Source</td>
                    <td>Traffic</td>
                    <td>Percent</td>
                </tr>";
    $query = "SELECT sum(webTraffic) AS traffic FROM campaign WHERE userID=".$_SESSION['user']['userID'];
    $campaignTraffic = mysql_fetch_array(mysql_query($query));
    
    $query = "SELECT webTraffic FROM usersattributes WHERE userID = ".$_SESSION['user']['userID'];
    $startTraffic = mysql_fetch_array(mysql_query($query));
    $totTraffic = $startTraffic['webTraffic'] + $campaignTraffic['traffic'];
    echo "<tr class='adminCampaignLines'>
            <td>Direct Access</td>
            <td>".$startTraffic['webTraffic']."</td>
            <td>".number_format($startTraffic['webTraffic']*100/$totTraffic,2) ."%</td></tr>";
    $query = "SELECT * FROM campaign WHERE userID = ".$_SESSION['user']['userID'];
    $result = mysql_query($query);
    
    // get the traffic from DB 
    while($row = mysql_fetch_array($result)) {
        echo "<tr class='adminCampaignLines'>
                <td>".$row['type']."</td>
                <td>".$row['webTraffic']."</td>
                <td>".number_format($row['webTraffic']*100/$totTraffic,2) ."%</td>
              </tr>";
    }
    echo "<tr class='adminCampaignLines' style='border-top: 5px solid black;'>
        <td></td>
        <td>$totTraffic</td>
        <td>100%</td></tr></table>";
    
    $query = "SELECT * FROM sales WHERE userID =".$_SESSION['user']['userID'];
    $sales = mysql_fetch_array(mysql_query($query));
    $query = "select sales,product,onlineSales,offlineSales,otherSales,onlineofflineRatio FROM usersattributes WHERE userID=".$_SESSION['user']['userID'];
    $userState = mysql_fetch_array(mysql_query($query));
    $weekSale =$userState['sales']/60;
    
    $weekSaleOffline = number_format($userState['offlineSales']/60,2);
    $weekSaleOnline = number_format($userState['onlineSales']/60,2);
    $weekSaleOther = number_format($userState['otherSales']/60,2);
    $t= $weekSale*($userState['product']/100);
    $currentSales=100000; //for testing
    echo "product = ".$userState['product'];
    echo "<br>sales = ".$userState['sales']/60;
    echo "<br>onoffratio = ".$userState['onlineofflineRatio'];
    echo "<br>productSale = ". round($userState['sales']*$userState['product']/100);
    $numberOfWeek = 6;
  // $weekSaleOffline = $t-$weekSaleOnline;
    echo "
            <h3>Sales:</h3>
            <table class='campaignListTable'>
                <tr class='campaignListCat'>
                    <td>&nbsp</td>
                    <td>START</td>
                    <td>Last Week<br>(from start)</td>
                    <td>Current Week<br>(from last week)</td>
                    <td>Total Sale<br>(change yearly)</td>
                </tr>
                <tr class='adminCampaignLines'>
                    <th>OnLine Sales</th>
                    <td>".$weekSaleOnline ."</td>
                    <td>".number_format($sales['lastWeekOnline'],2)."
                    <br>(";
                    $change =($sales['lastWeekOnline']/($userState['onlineSales']/60)-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'>".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'>".number_format($change,2)."%</span>";
                echo ")</td>
                    <td>".$currentSales."<br>(";
                $change = ($currentSales/$sales['lastWeekOnline']-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'>".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'>".number_format($change,2)."%</span>";
                echo ")</td>
                    <td>".$sales['accumulateOnline']."<br>(";
                $change = ($sales['accumulateOnline']/($weekSaleOnline*$numberOfWeek)-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'>".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'>".number_format($change,2)."%</span>";
                echo ")</td>       
                </tr>
                <tr class='adminCampaignLines'>
                    <th>OffLine Sales</th>
                    <td>".$weekSaleOffline."</td>
                    <td>".number_format($sales['lastWeekOffline'],2)."<br>(";
                        $change = ($sales['lastWeekOffline']/($userState['offlineSales']/60)-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'>".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'>".number_format($change,2)."%</span>";
                echo ")</td>
                    <td>".$currentSales."<br>(";
                $change = ($currentSales/$sales['lastWeekOffline']-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                echo ")</td>
                    <td>".$sales['accumulateOffline']."<br>(";
                $change = ($sales['accumulateOffline']/($weekSaleOffline*$numberOfWeek)-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'>".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'>".number_format($change,2)."%</span>";
                echo ")</td>
                </tr>
                
                <tr class='adminCampaignLines'>
                    <th>Total sales of product</th>
                    <td>".number_format($userState['offlineSales']/60+$userState['onlineSales']/60,2)."</td>
                    <td>".  number_format($sales['lastWeekOffline']+$sales['lastWeekOnline'],2)."<br>(";
                $change = (($sales['lastWeekOffline']+$sales['lastWeekOnline'])/(($userState['onlineSales']/60)+($userState['offlineSales']/60))-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                echo ")</td>
                    
                    <td>".$currentSales*2 ."<br>(";
                $change = (($currentSales*2)/($sales['lastWeekOffline']+$sales['lastWeekOnline'])-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                echo ")</td>
                    <td>".($sales['accumulateOffline']+$sales['accumulateOnline'])."<br>(";
                $change = (($sales['accumulateOffline']+$sales['accumulateOnline'])/(($weekSaleOffline+$weekSaleOnline)*$numberOfWeek)-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'>".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'>".number_format($change,2)."%</span>";
                echo ")</td>
                </tr>
                
                <tr class='adminCampaignLines'>
                    <th>Other Products Sales</th>
                    <td>".$weekSaleOther."</td>
                    <td>".number_format($sales['lastWeekOther'],2)."<br>(";
                $change = ($sales['lastWeekOther']/($userState['otherSales']/60)-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                echo ")</td>
                    
                    <td>".$currentSales*20 ."<br>(";
                $change = ($currentSales*20/$sales['lastWeekOther']-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                echo ")</td>
                    <td>".$sales['accumulateOther']."<br>(";
                $change = ($sales['accumulateOther']/(($weekSale-$t)*$numberOfWeek)-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'>".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'>".number_format($change,2)."%</span>";
                echo ")</td></tr>
                    
                <tr class='adminCampaignLines' style='border-top: 5px solid black;'>
                    <th>Total Sales</th>
                    <td>".number_format($weekSale,2)."</td>
                    <td>".number_format($sales['lastWeekOther']+$sales['lastWeekOffline']+$sales['lastWeekOnline'],2)."<br>(";
                $change = (($sales['lastWeekOther']+$sales['lastWeekOffline']+$sales['lastWeekOnline'])/($weekSale)-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                echo ")</td>
                    
                    <td>".($currentSales*20+200000) ."<br>(";
                $change = (($currentSales*20+200000)/($sales['lastWeekOther']+$sales['lastWeekOffline']+$sales['lastWeekOnline'])-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'> ".number_format($change,2)."%</span>";
                echo ")</td>
                    
                    <td>".($sales['accumulateOther']+$sales['accumulateOffline']+$sales['accumulateOnline'])."<br>(";
                $change = (($sales['accumulateOther']+$sales['accumulateOffline']+$sales['accumulateOnline'])/(($userState['sales']/60)*$numberOfWeek)-1)*100;
                if ($change >= 0)
                    echo "<span style='color: green;font-weight: bolder;'>".number_format($change,2)."%</span>";
                else
                    echo "<span style='color: red;font-weight: bolder;'>".number_format($change,2)."%</span>";
                echo ")</td></tr>
            </table>";
            $totalWeek = number_format($userState['offlineSales']/60+$userState['onlineSales']/60,2);
             
            echo $totalWeek."
        </div>";
?>
<?php
    require_once('./classes/CampaignClass.php');
    require_once('./classes/BalanceClass.php');
    require_once('iniSessionSetting.php');
    require_once('./classes/MessagesClass.php');
    require_once ('./classes/SessionClass.php');

    $campaignClass = new CampaignClass();
    $balance = new BalanceClass();
    $message = new Messages();
    $sessionClass = new SessionClass();

    $userID = $_SESSION['user']['userID'];

    echo "<h2 align=center>PPC Campaigns Menu</h2>";
    if (!empty($_GET['action'])){
        if (!empty($_GET['go'])){
            
            $campaignType = $_GET['campaignsType'];
            //subType will be as SE site
            $subType = $_GET['subType'];
            $startTime = $_GET['startTime'];
            $totalPrice = $_GET['totalCost'];
            //duration will be as maxBid
            $duration = $_GET['duration'];
            $phrase = $_GET['phrase'];
            $ongoing = 'yes';
            $result = $campaignClass->addCampaign($totalPrice,$startTime,$duration,$ongoing,$campaignType,$_SESSION['user']['userID'],$subType,$phrase);    
            $balance->newActivity($result, $userID, -1 * $_GET['totalCost'],$_GET['startTime']);
            $row = $campaignClass->getcampaignDetail($result);
            $time = $campaignClass->calculateTime($row['startTime'],0);
            $message->newMessage("ADs Simulator:", $_SESSION['user']['userID'], "You have posted a new campaign",
                                "<br><b>Information:</b><br>-----------------<br>
                                Campaign Type: <b>".$row['type']."</b><br>
                                Start at: <b>".$time['start']['days']."/".$time['start']['month']."/".$time['start']['year']."</b><br>
                                Your bid: <b>".$row['duration']."</b><br>    
                                Campaign Fee: <b>".$row['Price']."</b><br>");
            if ($result==true){
                $sqlquery = "SELECT max(campaignID) FROM campaign";
		$result = mysql_query($sqlquery);
                $row = mysql_fetch_array($result);
                $campaignID = $row[0];
                echo "<script type=\"text/javascript\">  
			function ajaxFunction(){       
                            var ajaxRequest = getAjaxObject();                  
                            ajaxRequest.open('GET','campaignThread.php?id=' + $campaignID, true);
                            ajaxRequest.send();  
			}
			ajaxFunction();
                    </script>";
		echo "<b>Campaign added successfully. Please wait...</b>";
                echo "<script>setTimeout(\"document.location.href='index.php?tabID=userMain&subID=ppc'\",3000);</script>";
		return;
            }
            else { echo "error - $result";
                return; }
        }
	else { 
            require_once('ppcForm.php');
            return;
	}
    }
    echo "<input type='button' class='newButton' onClick=\"document.location.href='index.php?tabID=userMain&subID=ppc&action=new'\" value='Add a new campaign'>";
    
    $result = $campaignClass->campaignListByType($userID,'ppc');
    
    $num = mysql_num_rows($result);
        if ($num==0)
            echo "<br/> No open campaigns found";
        else {
            echo "<br/>
            <table class='campaignListTable'>
                <tr class='campaignListCat'>
                   <td><b>Type</b></td>
                   <td><b>Start Time</b></td>
                   <td><b>SE</b></td>
                   <td><b>Phrase</b></td>
                   <td><b>Bid</b></td> 
                   <td><b>Budget</b></td> 
                   <td class='onGoingTag'><b>On Going</b></td>
                   <td><b>Delete</b></td>
                </tr>";
            while($row = mysql_fetch_array($result)){
                $sessionDate = $campaignClass->calculateTime($row['startTime'],$row['duration']);
                $sessionSet = $sessionClass->getSessionSettings($_SESSION['user']['sessionID']);
                $daysToSec= 86400;
                $realTime = $row['startTime'] + ceil($row['duration']*$daysToSec/$sessionSet['daysPerDay']);
                
                echo "<tr class='campaignLines'>
                    <td onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".$row['type']."</td>       
                    <td class='endTag' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".date("d/m/Y" ,$row['startTime'])."<br>(".$sessionDate['start']['days']."/".$sessionDate['start']['month']."/".$sessionDate['start']['year'].")</td>
                    <td onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".$row['subType']."</td>
                    <td onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".$row['ppcPhrase']."</td>
                    <td class='endTag' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".$row['duration']."</td>
                    <td onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".$row['Price']."</td>
                    <td class='onGoingTag' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">";
                echo $row['onGoing'];
                echo "</td> 
                   <td><a href=\"./index.php?tabID=userMain&subID=Campaigns&action=del&id=". $row['campaignID'] ."\">
                   <img src='images/delete.png' alt='Del' class='deleteImg'/> </td> 
                   </tr>";
            }
            echo   "</table><br />";
        }
        
     		
?>
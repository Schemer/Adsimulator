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

    echo "<h2 align=center>Display Campaigns Menu</h2>";
    if (!empty($_GET['action'])){
        if (!empty($_GET['go'])){
            
            $campaignType = $_GET['campaignsType'];
            $subType = $_GET['subType'];
            $startTime = $_GET['startTime'];
            $totalPrice = $_GET['totalCost'];
            $duration = $_GET['duration'];
            $ongoing  = 'yes';
            $result = $campaignClass->addCampaign($totalPrice,$startTime,$duration,$ongoing,$campaignType,$_SESSION['user']['userID'],$subType);    
            $balance->newActivity($result, $userID, -1 * $_GET['totalCost'],$_GET['startTime']);
            $row = $campaignClass->getcampaignDetail($result);
            $time = $campaignClass->calculateTime($row['startTime'],$row['duration']);
            $message->newMessage("ADs Simulator:", $_SESSION['user']['userID'], "You have posted a new campaign",
                                "<br><b>Information:</b><br>-----------------<br>
                                Campaign Type: <b>".$row['type']."</b><br>
				Sub-Type: <b>".$row['subType']."</b><br>
                                Start at: <b>".$time['start']['days']."/".$time['start']['month']."/".$time['start']['year']."</b><br>
                                Ends at: <b>".$time['end']['days']."/".$time['end']['month']."/".$time['end']['year']."</b><br>    
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
                echo "<script>setTimeout(\"document.location.href='index.php?tabID=userMain&subID=display'\",3000);</script>";
		return;
            }
            else { echo "error - $result";
                return; }
        }
	else { 
            require_once('displayForm.php');
            return;
	}
    }
    echo "<input type='button' class='newButton' onClick=\"document.location.href='index.php?tabID=userMain&subID=display&action=new'\" value='Add a new campaign'>";

	$result = $campaignClass->campaignListByType($userID,'display');
    
    $num = mysql_num_rows($result);
        if ($num==0)
            echo "<br/>No open campaigns found";
        else {
	echo "<br/>
            <table class='campaignListTable'>
                <tr class='campaignListCat'>     
                   <td><b>Type</b></td>
                   <td><b>Sub-Type</b></td>
                   <td><b>Start Time<br>(session Time)</b></td>
                   <td class='endTag'><b>End Time<br>(session Time)</b></td> 
                   <td><b>Price</b></td> 
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
                    <td onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".$row['subType']."</td>
                
                    <td class='endTag' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".date("d/m/Y" ,$row['startTime'])."<br>(".$sessionDate['start']['days']."/".$sessionDate['start']['month']."/".$sessionDate['start']['year'].")</td>
                    <td class='endTag' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".date("d/m/Y" ,$realTime)."</br>(".$sessionDate['end']['days']."/".$sessionDate['end']['month']."/".$sessionDate['end']['year'].")</td>
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

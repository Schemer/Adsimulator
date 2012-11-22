<?php
    require_once('./include/regularClass.php');
    require_once("include/BalanceClass.php");
    require_once("adminSettings.php");
    require_once('include/MessagesClass.php');
    
    $regClass = new regularClass();
    $balance = new BalanceClass();
    $message = new Messages();
    $userID = $_SESSION['user']['id'];

    echo "<h2 align=center>Search Engine Campaigns Menu</h2>";
    
    if (!empty($_GET['action']))
        {         
            if (!empty($_GET['go']))
            { 
               $campaignType = $_GET['campaignsType'];
               $subType = $_GET['subType'];
               $startTime = $regClass->configTime($_GET['startTime']);
               $totalPrice = $_GET['totalCost'];
               $endTime = $regClass->configTime($_GET['endTime']);
               $ongoing = 1;
               $result = $regClass->addCampaign($totalPrice,$startTime,$endTime,$ongoing,$campaignType,$_SESSION['user']['id'],$subType);    
          //   $balance->newActivity($result, $_SESSION['user']['id'], "New auction fee", -1 * $settings['auctionFee']);
          //    $seller = new SellerClass();
               $row = $regClass->getcampaignDetail($result);
               $message->newMessage("ADs Simulator:", $_SESSION['user']['id'], "You have posted a new campaigns",
                                        "<br><b>Information:</b><br>-----------------<br>
                                        Campaign Type: <b>".$row['type']."</b><br>
                                        Sub-Type: <b>".$row['subType']."</b><br>
                                        Start at: <b>".date('d/m/Y', strtotime($row['startTime']))."</b><br>    
                                        Ends at: <b>".date('d/m/Y', strtotime($row['endTime']))."</b><br>
                                        Campaign Fee: <b>".$row['Price']."</b><br>");

               if ($result==true){
                    $sqlquery = "SELECT max(campaignID) FROM campaign";
                    $result = mysql_query($sqlquery);
                    $row = mysql_fetch_array($result);
                    $campaignID = $row[0];
                    echo " 
                    <script type=\"text/javascript\">  
            
                        function ajaxFunction()
                        {       
                            var ajaxRequest = getAjaxObject();                  
                            ajaxRequest.open('GET','campaignThread.php?id=' + $campaignID, true);
                            ajaxRequest.send();  
                        }
                        ajaxFunction();
                        </script>";
                    echo "<b>Campaign added successfully. Please wait...</b>";
                    echo "<script>setTimeout(\"document.location.href='index.php?tabID=userMain&subID=seo'\",3000);</script>";
                    return;
                }
                else {
                    echo "error - $result";
                }

            }
           else{ 
               require_once('seoForm.php');
               return;
           }
        }
    echo "<input type='button' class='newButton' onClick=\"document.location.href='index.php?tabID=userMain&subID=seo&action=new'\" value='Add a new campaign'>";
    echo "<br/>
            <table class='auctionListTable'>
                <tr class='auctionListCat'>
                   
                         
                   <td><b>Type</b></td>
                   <td><b>Sub-Type</b></td>
                   <td><b>Start Time</b></td>
                   <td class='endTag'><b>End Time</b></td>
                   <td><b>Price</b></td> 
                   <td class='onGoingTag'><b>On Going</b></td>
                   <td><b>Delete</b></td>
                </tr>";
    
    $result = $regClass->campaignListByType($userID,'seo');
    
    $num = mysql_num_rows($result);
        if ($num==0)
            echo "No open campaigns found";
        else {
            
            while($row = mysql_fetch_array($result)){
                echo "<tr class='auctionLines'>
                            
                            
                            <td onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".$row['type']."</td>
                            <td onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">";
                            
                                $id = $row['campaignID'];
                                $seoQuery = "SELECT type 
                                              FROM seo 
                                              WHERE campaignID = '$id'";
                                $result1 = mysql_query($seoQuery);
                                $seoType = mysql_fetch_array($result1);
                                
                                echo $seoType['type'];
                           
                            echo"</td>
                            <td class='endTag' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".date("d/m/Y" ,strtotime($row['startTime']))."</td>    
                            <td class='endTag' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".date("d/m/Y" ,strtotime($row['endTime']))."</td>
                            <td onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">".$row['Price']."</td>    
                            <td class='onGoingTag' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaignID']."','mywindow','width=500,height=700,scrollbars=1')\">";
                                if ($row['onGoing']==0) 
                                    echo"no";
                                else echo "yes";
               echo "       </td> 
                            <td><a href=\"./index.php?tabID=userMain&subID=Campaigns&action=del&id=". $row['campaignID'] ."\">
                                <img src='images/delete.png' alt='Del' class='deleteImg'/> </td> 
                     </tr>";
            }
        }
        echo   "</table><br />";
        
        

?>
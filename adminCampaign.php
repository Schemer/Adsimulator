<?php
    include_once('./classes/AdminClass.php');
    $adminClass = new AdminClass();
  
    echo "<h2 align=center>Campaigns</h2>";

    // getting the date of the auction that finished last and putting the value in toDate box
    $maxQuery = "SELECT MIN(startTime) AS min FROM campaign";
    $theMin = mysql_query($maxQuery);
    $res = mysql_fetch_array($theMin);
    if ($res['min']=="") $date = new DateTime(); // if there are no campaigns (select today)
    else   
        $date = new DateTime("@".$res['min']);
    $dateFormat1 = $date->format('d/m/Y'); 
    $dateFormat2 = $date->format('Y,m,d-1'); 
    $today = new DateTime();
    $todayFormat = $today->format('Y,m,d-1');   
?> 
<form action='index.php' method='get' name='showCampaignsForm' onsubmit='return showCampaigns()'>
    <div id='fromDateContainer'> 
        Display Campaign from: <input type='text' readOnly name='fromDate' id='fromDate' class='inputField' value='<?php echo $dateFormat1;?>'>
        <a href='javascript:void(0)' onClick='if(self.gfPop)
            {gfPop.fPopCalendar(document.showCampaignsForm.fromDate, [[<?php echo $dateFormat2; ?>],[<?php echo $todayFormat; ?>]]);
            return false;
            }' >
            <img src='images/cal.gif' class='dateImage' id='pickFromDate' alt='Click Here to Pick the date'></a>
    </div>
          
    <div id='submitCont'>
        <input type='submit' value='Submit' class='newButton' id='adminGetCampaigns'>
        <input type='button' value='Export to file' class='newButton' id='export' onclick='exportCampaigns()'>
    </div>    
</form>
<br/>
<div id='replaceCampaignsDiv'>
 <?php  /* <table class='campaignListTable'>
        <tr class='campaignListCat'>
            <td class='idTag'>ID</td>
            <td>User Name</td>
            <td>Price</td>
            <td>Type</td>
            <td class='onGoingTag'>On Going</td>
            <td>Delete</td>
        </tr>
        <?php  /* 
          //  $result = $adminClass->getAllCampaignList($dateFormat1);
          //  $num = mysql_num_rows($result);
            if ($num==0)
                echo "No open campaigns found";
            else {
                while($row = mysql_fetch_array($result)){
            /*       echo " <tr class='adminCampaignLines'>
                            <td class='idTag'>".$row['campaignID']."</td>
                            <td>".$row['name']."</td>
                            <td>".$row['price']."</td>
                            <td>".$row['type']."</td>
                            <td class='onGoingTag'>".$row['onGoing']."</td> 
                            <td><a href=\"./index.php?tabID=userMain&subID=Campaigns&action=del&id=". $row['campaignID'] ."\">
                            <img src='images/delete.png' alt='Del' class='deleteImg'/> </td>
                        </tr>";
                }
            } 
        
    </table>/*?>
</div>
<br />

<script type="text/javascript">
// export data
    function exportCampaigns(){
        var fromDate = document.getElementById("fromDate").value;
        var toDate = document.getElementById("toDate").value;
        fromDate = dateFormat(fromDate);
        toDate = dateFormat(toDate);
        document.location.href = "getAdminAuctions.php?avoidcahe="+getTimestamp()+"&fromDate="+fromDate+"&toDate="+toDate+"&job=export";       
    }
    
</script>

<iframe name='gToday:normal:agenda.js' id='gToday:normal:agenda.js'
    src='ipopeng.htm' scrolling='no' frameborder='0'
    style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'>
    <LAYER name='gToday:normal:agenda.js' src='npopeng.htm' background='npopeng.htm'>     </LAYER>
</iframe>
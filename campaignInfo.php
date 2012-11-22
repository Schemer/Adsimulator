<?php
    //include_once('./classes/AdminClass.php');
    
   // $adminClass = new AdminClass();
    
    echo "<h2 align=center>Campaign Information</h2>";

    $maxQuery = "SELECT MIN(startTime) AS time FROM campaign";
    $theMax = mysql_query($maxQuery);
    $res = mysql_fetch_array($theMax);
    if ($res['time']=="") $date = new DateTime(); // if there are no campaigns (select today)
    else
        $date = new DateTime("@".$res['time']);
    
    $dateFormat1 = $date->format('d/m/Y');
    $dateFormat2 = $date->format('Y,m,d-1');
    $today = new DateTime();
    
?>
    <div id='campaignInfoDiv'>
        <select id='campaignInfoSelect' class='inputSelect' onchange='showInfo(value)'>
            <option value='chooseInfo'>Choose an option...</option>
            <option value='specificInfo'>Specific information</option>
            <option value='generalInfo'>General information</option>
        </select>
    </div>
    <br>
    <div id='datePicker'>
        <form action='index.php' method='GET'  name='showCampaignsForm' onsubmit='return showCampaignsInfo()'>
            <div id='realDateContainer'> 
                Display Campaigns from: <input type='text' readOnly name='fromRealDate' id='fromRealDate' class='inputField' style='width:80px;' value='<?php echo $dateFormat1; ?>'>
                <a href='javascript:void(0)' onClick='if(self.gfPop){
                    gfPop.fPopCalendar(document.showCampaignsForm.fromRealDate, [[<?php echo $dateFormat2;?>],[<?php echo $today->format('Y,m,d-1'); ?>]]);
                    return false;}' >
                    <img src='images/cal.gif' class='dateImage' id='pickFromDate' alt='Click Here to Pick the date'></a>
            </div>
             
            <div id="campaignInfoButton">
                <input type='submit' value='Submit' class='newButton' >
                <input type='button' value='Export to file' class='newButton' id='export' onclick='exportAuctions()'>
            </div>
        </form>
    </div>
     

    <!-- This div would be filled by the AJAX function which will retrieve the campaigns from the DB -->
    <div id='campaignsTable'></div>

<script type="text/javascript">
// export data
    function exportAuctions(){
        var selectValue = document.getElementById("campaignInfoSelect").value;
        var fromDate = document.getElementById("fromDate").value;
        fromDate = dateFormat(fromDate);
        document.location.href = "getCampaignsInfo.php?avoidcache=" + getTimestamp() + "&stats=" + selectValue +"&from=" + fromDate + "&to=" + toDate + "&job=export";       
    }
    
</script>
    
<iframe name='gToday:normal:agenda.js' id='gToday:normal:agenda.js'
    src='ipopeng.htm' scrolling='no' frameborder='0'
    style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'>
    <LAYER name='gToday:normal:agenda.js' src='npopeng.htm' background='npopeng.htm'>     </LAYER>
</iframe>
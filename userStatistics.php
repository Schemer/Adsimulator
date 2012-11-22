<h2 align="center">User Statistics</h2> 
<br/>

<form onsubmit="return statSelectChange()" name="statsForm">
    <div id="statSelectContainer">
        <select id="statOption" class="inputSelect" onchange="showDatePicker()">
            <option value="default">Choose an option...</option>
            <option value="siteVisits">Site visits</option>
            <option value="visitDuration">Site visits duration</option>
            <option value="createdCampaign">created Campaigns</option>
            <option value="popularCampaigns">Popular Campaigns</option>
            <option value="activeUsers">Active users</option>
        </select>
    </div>
    
<?php  
    $currentTime = time();
    $displayToFormat = date('d/m/Y H:i:s', $currentTime); 
  //  $dateFormat2 = date('Y,m,d H:i:s', $currentTime); 
  //  $dateFormat3 = date('Y-m-d H:i:s', $currentTime);
    // Reformatting today's date to be able to limit From and To dates choices
    $currentDate = $_SESSION['time']['date'];
    $currentDateArr = explode("/", $currentDate);
    $dateToFormat = $currentDateArr[2] . "," . $currentDateArr[1] . "," . ($currentDateArr[0]-1);
    if ($_SESSION['user']['sessionID']!='0')
        $query = "SELECT startTime FROM sessions WHERE sessionID =".$_SESSION['user']['sessionID'];
    else
        $query = "SELECT MIN(startTime) AS startTime FROM sessions";
    $result = mysql_fetch_array(mysql_query($query));
    $dispalyFromDate = date('d/m/Y H:i:s', $result['startTime']);
    $DateFromFormat = date('Y,m,d-1', $result['startTime']);
    

?>
    
    <div id="statsDateContainer">
         Display information from: <input type='text' readOnly name='fromDate' id="statsFromDate" class='inputField' value='<?php echo $dispalyFromDate; ?>'>
                                <a href='javascript:void(0)'
                                onClick='
                                    if(self.gfPop){
                                     <?php  echo "gfPop.fPopCalendar(document.statsForm.fromDate, [[".$DateFromFormat."],[".$dateToFormat."]]);"; ?>
                                       return false;
                                    }' >
         <img src='images/cal.gif' class='dateImage' id='pickFromDate' alt='Click Here to Pick the date'></a>
         &nbsp;&nbsp;
         to: <input type='text' readOnly name='toDate' id="statsToDate" class='inputField' value='<?php echo $displayToFormat; ?>'>
                 <a href='javascript:void(0)'
                                onClick='
                                    if(self.gfPop){
                                       <?php  echo "gfPop.fPopCalendar(document.statsForm.toDate, [[".$DateFromFormat."],[".$dateToFormat."]]);"; ?>
                                       return false;
                                    }' >
         <img src='images/cal.gif' class='dateImage' id='pickToDate' alt='Click Here to Pick the date'></a>
                
    
        &nbsp;&nbsp;
        <input type='submit' value='Submit' class='newButton' id='adminGetAuctions'>
    </div>
</form>

<br/>

<div id="statsErrors"></div>

<div id="statsChartContainer"></div>


<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop:plugins_timeSec.js' id='gToday:datetime:agenda.js:gfPop:plugins_timeSec.js' src='ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'></iframe>
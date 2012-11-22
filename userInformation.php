<?php
    include_once('./classes/AdminClass.php');
    
   // $adminClass = new AdminClass();
   // $dateString ='';
    echo "<h2 align=center>User Information</h2>";

    $date = new DateTime(date('Y-m-d H:i:s', time()));
    $dateFormat1 = $date->format('d/m/Y'); 
    $dateFormat2 = $date->format('Y,m,d-1'); 
    //$dateFormat3 = $date->format('Y-m-d');

?>   
<!-- Date picker -->
<form name='exportUserInfo' onsubmit='return exportUserInfo()'>
    <div id='fromDateContainer'> 
        Display info from: <input type='text' readOnly name='fromDate' id='fromDate' class='inputField' value='01/01/2000'>
        <a href='javascript:void(0)' onClick='if(self.gfPop){
                                            gfPop.fPopCalendar(document.exportUserInfo.fromDate, [[2000,01,01],[<?php echo $dateFormat2; ?>]]);
                                            return false; }' >
            <img src='images/cal.gif' class='dateImage' id='pickFromDate' alt='Click Here to Pick the date'></a>
    </div>
    <div id='toDateContainer'>
        to: <input type='text' readOnly name='toDate' id='toDate' class='inputField' value='<?php echo $dateFormat1; ?>'>
        <a href='javascript:void(0)' onClick='if(self.gfPop){ 
                                            gfPop.fPopCalendar(document.exportUserInfo.toDate, [[2000,01,01],[<?php echo $dateFormat2;?>]]);
                                            return false; }' >
            <img src='images/cal.gif' class='dateImage' id='pickToDate' alt='Click Here to Pick the date'></a>
                    <input type='button' value='Export to file' class='newButton' onclick='exportUsers()'>
    </div>
</form>  

<script type="text/javascript">

// export data
    function exportUsers(){
        var fromDate = document.getElementById("fromDate").value;
        var toDate = document.getElementById("toDate").value;
        fromDate = dateFormat(fromDate);
        toDate = dateFormat(toDate);
        document.location.href = "getUserInfo.php?avoidcache=" + getTimestamp() + "&from=" + fromDate + "&to=" + toDate + "&job=export";       
    }
    
</script>
    
<iframe name='gToday:normal:agenda.js' id='gToday:normal:agenda.js'
    src='ipopeng.htm' scrolling='no' frameborder='0'
    style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'>
    <LAYER name='gToday:normal:agenda.js' src='npopeng.htm' background='npopeng.htm'>     </LAYER>
</iframe>
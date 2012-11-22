<?php
    
?>

<html>
    <body>
        
    
        <form id="openSession" method="GET" onsubmit="return checkDate();">
            <input type="hidden" name="tabID" value="adminMain">
            <input type="hidden" name="subID" id="subID" value="openSession">
            <h2>Open closed Session</h2>
            Please Select Ending time:<br>
            <input type="text" size="8" class="numInputField" name="endDate" id="endDate" readonly>
            
                <a href='javascript:void(0)' onClick='if(self.gfPop){
                                                 gfPop.fPopCalendar(document.openSession.endDate);
                                                 return false;
                                              }' >
                <img src='images/cal.gif' class='dateImage' alt='Click Here to Pick the date'></a>
            <br><input type="submit" value="OK">
        </form>
      <script>
          function checkDate(){
            var valid=true;
            var endDate=document.getElementById('endDate').value;
            if  (endDate == ""){ 
                alert ('Please Enter Date');
                valid = false;
            }
            else{
            openSession(<?php echo $_GET['sessionID']; ?>,endDate);
        }
            return valid;
          }
        
        </script>
        <iframe width=188 height=166 name='gToday:datetime:agenda.js' id='gToday:datetime:agenda.js' src='ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'></iframe><iframe width=188 height=166 name='gToday:datetime:agenda.js' id='gToday:datetime:agenda.js' src='ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'></iframe>

    </body>
</html>

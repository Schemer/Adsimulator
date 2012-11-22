<form name="setSessionForm" id="setSessionForm" onsubmit="return dSessionValidate(this);">
    <input type="hidden" name="tabID" value="adminMain"/>
    <input type='hidden' name='subID' value='createSession'/>
    <input type='hidden' name='create' value='ok'/>
    <input type="hidden" name="useSettingsFrom" id="useSettingsFrom" value="default"/>
    <?php
        require_once("classes/SessionClass.php");
        $sessionclass = new SessionClass();
        if ($_GET['useSettingsFrom']!='pull'){
            echo '<div id="pull" class="hiddenContainer">';
        }
        else
            echo '<div>';
    ?>
    <script>showSessionSettings(0);</script>

    <h2>Select session to pull from:</h2>
        <select class='inputSelect' name='pullSettingsFrom' id='pullSettingsFrom' onchange="showSessionSettings(value)">
            <option value="0">Default</option>
            <?php
                $session = new SessionClass();
                $result = $session->getAllSessions();
                while($row = mysql_fetch_array($result)){
                    echo "<option value='".$row['sessionID']."'>".$row['name']."</option>";                
                }
            ?> 
        </select>
    <br><br>
    <?php echo '</div>' ?>
    
    <table style="border: 1px solid black;" width="280">
        <caption style="text-align:left;"><h2>Session Settings:</h2></caption>
        <tr>
            <td>Session Name:</td>
            <td><input class="numInputField" style="text-align:left;" name="sessionName" id="sessionName" type="text" size="15" maxlength="20">   
        </tr>
        <tr>
            <td>End Date:</td>
            <td><input type='text' class="numInputField" size="8" name="endDate" id='endDate' readOnly>
                <a href='javascript:void(0)' onClick='if(self.gfPop){
                                                 gfPop.fPopCalendar(document.setSessionForm.endDate);
                                                 return false;
                                              }' >
                <img src='images/cal.gif' class='dateImage' alt='Click Here to Pick the date'></a>
            </td>
        </tr>   
    </table>
    
    <input type="submit" value="Create Session">
</form>
<div id="sessionDetailsCont"></div>
    


<iframe width=188 height=166 name='gToday:datetime:agenda.js' id='gToday:datetime:agenda.js' src='ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'></iframe><iframe width=188 height=166 name='gToday:datetime:agenda.js' id='gToday:datetime:agenda.js' src='ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'></iframe>

<script type="text/javascript"> 
    function dSessionValidate(){
        var sessionName = document.getElementById('sessionName').value;
        var date = document.getElementById('endDate').value;
        
        var msg="";
        var valid=true;
        
        if (sessionName != ""){
            var i;
            var names = "<?php echo $sessionclass->getAllSessionNames() ?>";
            var listnames = names.split(';;');
            for (i=0;i<listnames.length;i++) {
                if (listnames[i] == sessionName){
                    msg += "\nERROR: Session name already exits, type new name";
                    valid = false;
                    }
            }
        }
        else {
            msg += "\nERROR: Session name is empty, please enter name";
            valid = false
        }
        if (date==""){
            msg += "\nERROR: End Date field is empty, please select date";
            valid = false;    
        }
        if (msg!="")
            alert (msg);
        if (valid==true && '<?php echo $_GET['useSettingsFrom']; ?>' =='pull'){
            document.getElementById('useSettingsFrom').value = 'pull';
        }
        return valid;
    }
         
</script>

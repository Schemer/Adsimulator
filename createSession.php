<?php
    require_once("classes/SessionClass.php");
    $session = new SessionClass();
    if(!empty($_GET['create'])){
        $generalsetting = array();
        $mailsetting = array();
        $displaysetting = array();
        $seosetting = array();
            
        if ($_GET['useSettingsFrom'] != 'set'){
            $generalsetting['sessionName']= $_GET['sessionName'];
            $generalsetting['endDate']= $_GET['endDate'];
            if ($_GET['useSettingsFrom']== "pull"){
                $generalsetting['pullFrom']= $_GET['pullSettingsFrom'];
                
                $mailsetting['pullFrom']= $_GET['pullSettingsFrom'];
                
                $displaysetting['pullFrom']= $_GET['pullSettingsFrom'];
            }
            else{
                $generalsetting['pullFrom']= '0';
                $mailsetting['pullFrom']='0';
                $displaysetting['pullFrom']='0';
                $seosetting['pillFrom']='0';
            }
        }
        else{ //set
           $generalsetting= $_GET['generalSetting'];
           if ($_GET['activeMail'] == 'manual'){
               $mailsetting = $_GET['emailSetting'];
           }
           else{
               $mailsetting['pullFrom']='0';
           }
           if ($_GET['activeDisplay'] == 'manual'){
               $displaysetting = $_GET['displaySetting'];
           }
           else{
               $displaysetting['pullFrom']='0';                       
           }
           if ($_GET['activeSEO'] == 'manual'){
               $seosetting = $_GET['seoSetting'];               
           }
           else{
               $seosetting['pullFrom']='0';
           }
        }
        $result = $session->createSession($generalsetting, $mailsetting, $displaysetting, $seosetting);
        if($result){
            // Set newly created session as current active session for admin account
            $session->changeActiveSession($result);
            echo "<br><b>Session created successfully.</b>";
            echo "<script>setTimeout(\"document.location.href='index.php?tabID=adminMain&subID=sessions'\",300000);</script>";
            return;
        } 
        else {
            echo "ERROR";
        }
    }
?>

<h2 align=center>Sessions Menu</h2>
<h3>Create a new session:</h3>
<div id='createSessionCont'>
<form action="index.php" method="GET" onsubmit="return check()">
    <input type="hidden" name="tabID" value="adminMain">
    <input type="hidden" name="subID" id="subID" value="defaultSession">
    <input type="hidden" name="create" value="ok">
    
    Settings options: <br>
    <select class='inputSelect' name='useSettingsFrom' id='useSettingsFrom' onchange="showSessionsSelect(value)">
        <option value='default'>Default</option>
        <option value='pull'>Pull from other session</option>
        <option value='set'>setup new session</option>
    </select>
    <br><br>
    <div id="createButton">
    <input type="submit" id="createSessionButton" class='newButton' value='Create session'>
    </div>
</form>

</div>  <!-- end of createSessionCont div -->

<script type="text/javascript">
    // Show/hide the option to pull settings from other session
    function showSessionsSelect(value){
        // Get selected option
        switch (value){
            case "default": 
                document.getElementById("createSessionButton").value = "Create Session";
                break;
            case "pull":  
                document.getElementById("createSessionButton").value = "Pull Session";
                break;
            case "set":   
                document.getElementById("createSessionButton").value = "Setup Session";
                break;
        }
    }
    
    // Validate input and continue to process request
    function check() {
       
        var e = document.getElementById("useSettingsFrom");
        var selectedOption = e.options[e.selectedIndex].value;
       
        if(selectedOption == "pull") { // If user chose to pull settings from previous session
            document.getElementById("subID").value = "defaultSession";    
        }
        if (selectedOption == "default"){
            document.getElementById("subID").value = "defaultSession";
        }
        if (selectedOption == "set") {
            document.getElementById("subID").value = "setupSession";   
        }
        
        return true;
    }
</script>

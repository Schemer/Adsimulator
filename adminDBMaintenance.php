<?php

    include_once('./classes/AdminClass.php');
    $AdminClass = new AdminClass();

    echo "<h2 align=center>Maintenance Menu </h2>";    

    if (!empty($_GET['action']))
    {  
        switch ($_GET['action'])
        {
            case '1':
                echo "Delete all users and agents";  
                $result = $AdminClass->deleteAllUsers();
                break;
            case '2':
                echo "Delete all campaigns";                       
                $result = $AdminClass->deleteAllCloseCampaigns();
                break;
            case '3':                                             
                echo "Delete all campaign log files";
                $result = $AdminClass->deleteAllCampaignLogFiles();
                break;
            case '4':
                echo "Delete all agent log files";
                $result = $AdminClass->deleteAllAgentLogFiles();
                break;
            case '5':
                echo "Close all campaigns";
                $result = $AdminClass->closeAllCampaigns();
                break;
            case '6':
                echo "Reset database";
                $result = $AdminClass->resetDatabase();
                break;
                
        }
    }
    else {
        $userList = $AdminClass->getUsertList();
        $agentList = $AdminClass->getAgentList();
    }       
?>

<form action="index.php" method="get" name="adminStatic" onsubmit="return check()">
    <input type="hidden" name="tabID" value="adminMain"/>
    <input type="hidden" name="subID" value="dbMaintenance"/>
<?php
    $report = new ArrayObject();
    $report[1] = 'Delete all users and and agents.';
    $report[2] = 'Delete all closed campaigns.';
    $report[3] = 'Delete all campaign log files.';
    $report[4] = 'Delete all agent log files.';
    $report[5] = 'Close all campaigns.';
    $report[7] = 'Reset database (WARNING: this action will delete all information stored in the DB)';
    foreach($report as $key=>$value){  
        echo "  <input type=\"radio\" name=\"action\"  value=\"$key\"/>$value<div id=\"$key\"></div>";
    }
?>        
<br/><input type="submit" class='newButton' value="Submit"/>    

</form>     
<script type="text/JavaScript">
function check()
{
    var selection = document.adminStatic.action;
    flag = false;
    var num=0;
    for (i=0; i<selection.length; i++)
      if (selection[i].checked == true)
        {
            flag = !flag;
            num = i;
        }
    if (flag != true) 
    {
        alert('Please choose');
        return false;
    }
    
    var answer = confirm("Are You Sure?")
    if (answer)
    {
        return true
    }
    else
    {
        return false
    }
}

</script>          
        
        
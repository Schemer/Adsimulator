<?php
    if ($_SESSION['user']['authorize']!=true){
        require_once('./Logout.php');
        exit; 
    }
    if (!empty($_GET['subID'])){
         switch ($_GET['subID']) {
             case 'Campaigns':       include_once('adminCampaign.php');     break;
             case 'statistic':       include_once('adminStatistic.php');    break;
             case 'userMaintenance': include_once('adminMaintenance.php');  break;
             case 'dbMaintenance':   include_once('adminDBMaintenance.php');break;
             case 'userStatistics':  include_once('userStatistics.php');    break;
             case 'userInfo':        include_once('userInformation.php');   break;
             case 'campaignInfo':    include_once('campaignInfo.php');      break;
             case 'statsDisplay':    include_once('statsDisplay.php');      break;
             case 'settings':        include_once('adminSettingsMenu.php'); break;
             case 'userStats':       include_once('userStats.php');         break;
             case 'sessions':        include_once('adminSessions.php');     break;
             case 'createSession':   include_once('createSession.php');     break;
             case 'setupSession':    include_once('setupSession.php');      break;
             case 'defaultSession':  include_once('defaultSession.php');    break; 
         }  
         return;
     }

?>
  
<div id='adminMain'>
    <h1>Administration Account</h1>
</div>
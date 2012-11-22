<?php
    if (empty($_SESSION['user']))
    {
        echo "<h2>You must login first...</h2><BR/>
              <h3>Please wait while you're being transferred.</h3>";
        echo "<script>setTimeout(\"document.location.href='index.php?tabID=Login'\",3000);</script>";
        return;
    }

    if ($_SESSION['user']['authorize']!=true) {
          require_once('./Logout.php');
          exit;
    }

    if (!empty($_GET['subID'])){
         switch ($_GET['subID']){
             case 'Campaigns':  include_once('userCampaigns.php'); break;
             case 'agent':      include_once('userAgent.php');     break;
             case 'test':       include_once('setSession.php');    break;
             case 'email':      include_once ('email.php');        break;
             case 'seo':        include_once ('seo.php');          break;
             case 'ppc':        include_once ('ppc.php');          break;
             case 'display':    include_once ('display.php');           break;
             case 'management': include_once ('management.php');        break;
         }
         return;
    }
    include_once('main.php');
?>  
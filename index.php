<?php 
	session_start()
?>
<!DOCTYPE html>
<?	
	error_reporting(E_ALL);
    ini_set('display_errors', true);
    ini_set('log_errors', 1);
    ini_set('error_log', 'IADS/error_log.txt');
    ini_set('html_errors',true);
    date_default_timezone_set('Israel');
	
	require_once('initdb.php'); //loding DB
	require_once('iniSessionSetting.php'); //setup starting session
	require_once('./classes/SessionClass.php');
	
	$sessionClass = new SessionClass();
?>
<!--
/*********************************************************************/

This simulator system project was created by Shlomi & Michael  (2012)

Last updated: 28/10/2012

/*********************************************************************/
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
        <title>AD simulator</title>
        <link href="css/Style.css" rel="stylesheet" type="text/css" >
        <script type="text/ajax" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="javascripts/functions.js"></script>
        <meta http-equiv="refresh" content="600">
		<link href="/ADsim/images/logo1.jpg" rel="shortcut icon" type="image/x-icon" > 
		</head>
    <body>
        <?php
            // Update users visit in the database
            if (isset($_SESSION['user']['userID'])){
                echo "<script type='text/javascript'>updateVisit(".$_SESSION['user']['userID'].");</script>"; // dropped the 'window.onload'
            }
        ?>
        <div class='mainContainer'>
            <?php
                if (isset($_SESSION['user'])){
                    if ($_SESSION['user']['type'] == 'admin'){
                        echo "<a href='index.php?tabID=adminMain'>
                            <img src='images/adlogo3.jpg' border='1' width=150px alt='ADsim' /></a>";
                    }
                    else{
                        echo "<a href='index.php?tabID=userMain'>
                            <img src='images/adlogo3.jpg' border='1' width=150px alt='ADsim' /></a>";
                    }
                }
                else{
                    echo "<a href='index.php?tabID=main'>
                            <img src='images/adlogo3.jpg' border='1' width=150px alt='ADsim' /></a>";
                }
            ?>
            <!--Including the top navigation bar-->
            <?php include_once('topNav.php'); ?>
            <!--Including the left navigation bar-->
            <div id='leftNav'>
                <?php include_once("leftNav.php"); ?>
            </div>
            <div id='contentContainer'>
                <?php 
                    if (!empty($_GET['tabID'])){
                        switch ($_GET['tabID']){
                            case "main":     include_once('main.php');      break;
                            case "Login":    include_once('login.php');     break;
                            case "Logout":   include_once('Logout.php');    break;
                            case "Register": include_once ('Register.php'); break;
                            case "sendMessage":    include_once('sendMessage.php');     break;
							case "userMain": include_once('userMain.php');  break;
                            case "adminMain":include_once('adminMain.php'); break;
                            case "messages": include_once ('messagesMenu.php'); break;
                            case "viewMessage": include_once('viewMessage.php');        break;
                            case "budget":     include_once('userBudget.php');        break;
                            case "account":  include_once('account.php'); break;
                           
                        }
                    }
                    else include_once('main.php');
                ?>
            </div>
            <!--Including the footer div-->
            <?php include_once('footer.php'); ?>
        </div>
    </body>
    <?php
        $timeFactor = 1;
        if (!isset($_SESSION['user']['userID'])){
            $startTime=0;
        }
        else if ($_SESSION['user']['sessionID']==0){
            $startTime=0;
        }
        else{
            $session = $sessionClass->getSessionDetails($_SESSION['user']['sessionID']);
            $query = "SELECT daysPerDay AS timeFactor FROM sessionsettings WHERE sessionID=".$session['sessionID'];
            
            $startTime = $session['startTime'];
            $timeFactor = mysql_fetch_array(mysql_query($query));
        }               
        $topNavTime = time();
        $topNavDate = date("d/m/Y" ,$topNavTime);
        // Sets the time & date in top navigation bar
       
      echo "<script type='text/javascript'>
               var topNavTime = $topNavTime;
               var topNavDate = '".$topNavDate."';
               var startTime = $startTime;
               var timeFactor =".$timeFactor['timeFactor']."
               setTopNavTime(startTime, topNavTime, topNavDate, timeFactor);
            </script>";
      ?>
    <script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
    <script type="text/javascript">
    _uacct = "UA-2027963-2";
    urchinTracker();
    </script>
</html>
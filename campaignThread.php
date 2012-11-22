<?php
	require_once("classes/CampaignClass.php");
	
	class CampaignThreadClass{
		var $fh;
		function init($campaignID,$type){           
			$this->fh = fopen("./campaign_logs/AuctionID.".$campaignID."_Type.".$type."_".date("d-m-Y_H.i.s", time()).".txt", 'w');        
		}
	}
	
	require_once('initdb.php');
	require_once('classes/BalanceClass.php');
	require_once('classes/MessagesClass.php');
	require_once('classes/CampaignClass.php');
	
	
	set_time_limit(0);
	date_default_timezone_set('Israel');
	
	$balance = new BalanceClass();
	$message = new Messages();
	$campaignThreadClass = new CampaignThreadClass();
	$campaignClass = new CampaignClass();
	$campaignID = $_GET['id'];
	$sqlquery = "SELECT * FROM campiagn
				WHERE campaignID = $campaignID";
	$row = mysql_fetch_array(mysql_query($sqlquery);
	
	$type = $row['type'];
	$userID = $row['userID'];
	$startTime = $row['startTime'];
	$duration = $row['duration'];
	$onGoing = $row['onGoing'];
	$price = $row['price'];
	$subType = $row['subType'];
	
	
	
	$CampaignThreadClass->init($campaignID,$type);
	
	$sqlquery = "SELECT sessionID 
              FROM user 
              WHERE userID = $userID" ;
	$session = mysql_fetch_array(mysql_query($sqlquery));
	$userSession = $session['sessionID'];
	$query = "SELECT * FROM settings WHERE sessionID = $userSession";
	$settings = mysql_fetch_array(mysql_query($query));
	
	$campaignTime = campaignClass->calculateTime($startTime,$duration);
	$campaignThreadClass->fw("\nCurrent Time:".date('Y-m-d H:i:s',$time()).
							 "\nType:$type
							  \nSubType:$subType
							  \nPrice:$price
							  \nstartTime:$startTimeTime
							  \nOnGoing:$onGoing
							  \n"); 
	$campaignThreadClass->fw("\n----------------------------------\n");
	
	switch ($type)
	{
		case 'mail':{ // e-mail campaign
			$sqlquery = "SELECT * FROM campaign WHERE id=$auctionID";
            $result = mysql_query($sqlquery);
            $row = mysql_fetch_array($result);
			
{	
<?php  
ini_set("precision", "2");
require_once("classes/SessionClass.php");

       
Class AdminClass
{   
    function getAllCampaignList($from)
    {
        $session = new SessionClass();
        $adminID = $session->getAdminID(); 
        $currentSession =$session->getActiveSessionID($adminID);
        $dateArr= explode('/',$from);
        $time = $dateArr[0].'-'.$dateArr[1].'-'.$dateArr[2];
        echo($time);
        
        $sqlquery = "    SELECT     campaign.campaignID AS campaignID,
                                    campaign.Price AS price,
                                    campaign.startTime As startTime,
                                    campaign.duration AS duration,
                                    campaign.onGoing AS onGoing,
                                    campaign.type AS type,
                                    campaign.subType AS subType,
                                    user.name AS name
                           FROM     campaign, user
                           WHERE    campaign.userID = user.userID AND
                                    campaign.startTime >= '".strtotime($time)."'";
        if($currentSession != 0) {
            $sqlquery .= " AND user.sessionID = $currentSession";
        }
        $sqlquery .= " ORDER BY campaignID";
        $result = mysql_query($sqlquery);
        return $result;
         
    }
    
    function allOpenCampaigns()  // 'Show all open campaigns;
    {
        $session = new SessionClass();
        
        $currentSession = $session->getActiveSessionID(-1);
        $sqlquery = "SELECT campaign.campaignID AS campaign, user.name AS userName, 
                            campaign.type AS type,
                            campaign.Price AS price,
                            campaign.startTime AS startTime
                     FROM campaign,user
                     WHERE onGoing='yes' AND campaign.userID = user.userID";
        if($currentSession != 0) {
            $sqlquery .= " AND user.sessionID = $currentSession";
        }
        $result = mysql_query($sqlquery);
        if (mysql_num_rows($result)==0)            
        {
            echo "<br>No Results! ! !";
            return;
        }
        echo " 
                <table class='campaignListTable'>
                    <tr class='campaignListCat'>
                            <td>Campaign ID</td>
                            <td>Campaign Type</td>
                            <td>User Name</td>
                            <td>Start Time</td>
                            <td>Price</td>
                            
                    </tr>";        
        while($row = mysql_fetch_array($result)){
            echo "<tr class='campaignLines' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaign']."','mywindow','width=500,height=600,scrollbars=1')\" style=\"cursor:hand\" name=open>";
            echo "<td>".$row['campaign']."</td>
                    <td>".$row['type']."</td>
                    <td>".$row['userName']."</td>
                    <td>".$row['startTime']."</td>
                    <td>".$row['price']."</td>
                  </tr>";
        }
       echo  "</table>"; 
       return;
    }
    
    function allCloseCampaigns() // 'Show all close Campaigns';
    {
        $session = new SessionClass();
        $currentSession = $session->getActiveSessionID(-1);
        $sqlquery = "SELECT campaign.campaignID AS campaign,campaign.type as type,
                            user.name AS name,
                            campaign.Price AS Price, campaign.endTime AS endTime
                     FROM   campaign, user 
                     WHERE  campaign.userID = user.userID AND                        
                            campaign.onGoing='no'";
        if($currentSession != 0) {
            $sqlquery .= " AND user.sessionID = $currentSession";
        }
        $result = mysql_query($sqlquery);
        if (mysql_num_rows($result)==0)            
        {
            echo "<br>No Results!";
            return;
        }            
        echo "                 
                <table class='campaignListTable'>
                    <tr class='campaignListCat'>              
                            <td>Campaign ID</td>
                            <td>Campaign Type</td>
                            <td>User Name</td>
                            <td>Price</td>
                            <td>End Time</td>
                    </tr>";        
                  
        while($row = mysql_fetch_array($result))
        {
            echo "<tr class='campaignLines' onClick=\"window.open('infowindows.php?action=1&id=".$row['campaign']."','mywindow','width=500,height=600,scrollbars=1')\" style=\"cursor:hand\" name=open>";
            echo "

                    <td>".$row['campaign']."</td>
                    <td>".$row['type']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['Price']."</td>
                    <td>".$row['endTime']."</td>
              </tr>";
        }
        echo  "</table>";
        
        return;        
    }

    function allCampaignWithUser($userID)   //'Show all auctions who participate user:';
    {
        if($userID == null){
            echo "**No agent specified";
            return;
        }
        $session = new SessionClass();
        $currentSession = $session->getActiveSessionID(); 
        $sqlquery = "
		SELECT	
				distinct auction.id AS AuctionID,
				user.name as username,
				auction.type AS AuctionType,
				auction.minPrice AS minPrice,
				auction.onGoing AS onGoing,
				auction.endTime AS endTime,
				product.name AS ProductName,
				product.priceList AS ProductPriceList,
				product.picture AS picture

		FROM 	auction, bid, product,user 
		
		WHERE 	(auction.id = bid.auctionID) AND
				(auction.productID = product.id) AND
				(bid.bidderID = user.id) AND
				(user.id=$userID)";
        if($currentSession != 0) {
            $sqlquery .= " AND user.sessionID = $currentSession";
        }

                            
        $result = mysql_query($sqlquery);
        if (mysql_num_rows($result)==0)            
        {
            echo "<br>No Results! ! !";
            return;
        }            
        echo "                 
                <table class='auctionListTable'>
                    <tr class='auctionListCat'>              
                            <td>Auction ID</td>
							<td>UserName</td> 
                            <td>Auction Type</td>
                            <td>Minimum Price</td>
							<td>on going</td>
							<td>end time</td>
							<td>Product Name</td>
							<td>Price List</td>
                            <td>Picture</td> 
                    </tr>";        

        $i=0;            
        while($row = mysql_fetch_array($result))
       {
            echo "<tr class='auctionLines' onClick=\"window.open('infowindows.php?action=1&id=".$row['AuctionID']."','mywindow','width=500,height=600,scrollbars=1')\" style=\"cursor:hand\" name=open>";
            echo "
                    <td>".$row['AuctionID']."</td>
					<td>".$row['username']."</td>
                    <td>".$this->getAuctionType($row['AuctionType'])."</td>
                    <td>".$row['minPrice']."</td>
                    <td>".$this->getOnGoingType($row['onGoing'])."</td>
					<td>".$row['endTime']."</td>
					<td>".$row['ProductName']."</td>
					<td>".$row['ProductPriceList']."</td>
					<td><img src='thumb.php?url=".$row['picture']."&width=40&height=40' alt=\"picture\" border=0 /></td>
              </tr>";
        }
        echo "</table>";      
        return;   
    }
   
    function allAuctionWithAgent($agentID)    //'Show all auctions  participate agent:';
    {
        if($agentID == null){
            echo "**No agent specified";
            return;
        }
        $session = new SessionClass();
        $currentSession = $session->getActiveSessionID(); 
        $sqlquery = "
        select	
	        distinct auction.id AS AuctionID,
	        user.name as agentname,
	        auction.type AS AuctionType,
	        auction.minPrice AS minPrice,
	        auction.onGoing AS onGoing,
	        auction.endTime AS endTime,
	        product.name AS ProductName,
	        product.priceList AS ProductPriceList,
	        product.picture AS picture

        from 	auction, bid, product,user 

        where 	(auction.id = bid.auctionID) and
	        (auction.productID = product.id) and
	        (bid.bidderID = user.id) and
	        (user.id=$agentID)";
    if($currentSession != 0) {
        $sqlquery .= " AND user.sessionID = $currentSession";
    }
                    
    $result = mysql_query($sqlquery);
    if (mysql_num_rows($result)==0)            
    {
    echo "<br>No Results! ! !";
    return;
    }            
        echo "                 
                <table class='auctionListTable'>
                    <tr class='auctionListCat'>              
                    <td>Auction ID</td>
				    <td>Agent Name</td> 
                    <td>Auction Type</td>
                    <td>Minimum Price</td>
				    <td>on going</td>
				    <td>end time</td>
				    <td>Product Name</td>
				    <td>Price List</td>
                    <td>Picture</td> 
            </tr>";        
            

        $i=0;            
        while($row = mysql_fetch_array($result))
       {
            echo "<tr class='auctionLines' onClick=\"window.open('infowindows.php?action=1&id=".$row['AuctionID']."','mywindow','width=500,height=600,scrollbars=1')\" style=\"cursor:hand\" name=open>";
            echo "            
            <td>".$row['AuctionID']."</td>
		    <td>".$row['agentname']."</td>
            <td>".$this->getAuctionType($row['AuctionType'])."</td>
            <td>".$row['minPrice']."</td>
            <td>".$this->getOnGoingType($row['onGoing'])."</td>
		    <td>".$row['endTime']."</td>
		    <td>".$row['ProductName']."</td>
		    <td>".$row['ProductPriceList']."</td>
		    <td><img src='thumb.php?url=".$row['picture']."&width=40&height=40' alt=\"picture\" border=0 /></td>
      </tr>";
    }
    echo "</table>";      
    return;   
    }
   
    function getAgentList()
    {
       $sqlquery = "select * from user where type=3";
       $result = mysql_query($sqlquery);
       
       $agentList="<select name=\'agentID\'><option value=\'\'>Choose</option>";
        
        if (mysql_num_rows($result)!=0)
        while($row = mysql_fetch_array($result))
        {
             $agentList = "$agentList+\"<option value=\'".$row['id']."\'>".$row['name']."</option>\"";
        }
        $agentList ="$agentList+\"</select>";
        return  $agentList;
      } 

    function getUsertList()
    {
       $sqlquery = "select * from user where type='user'";
       $result = mysql_query($sqlquery);
       
       $userList="<select name=\'userID\'><option value=\'\'>Choose</option>";
       if (mysql_num_rows($result)!=0)
       while($row = mysql_fetch_array($result))
       {
         $userList = "$userList+\"<option value=\'".$row['userID']."\'>".$row['name']."</option>\"";
       }
       $userList = "$userList+\"</select>"; 
       return $userList;          
      } 
      
    function deleteAllUsers() // "Delete all users and agent";   // 1  
    {   
        $session = new SessionClass();
        $adminID = $session->getAdminID();
        $currentSession = $session->getActiveSessionID($adminID); 
        // changing all user activation beside the admin: id=1
        $sqlquery =  "UPDATE user SET `active` = 'no' WHERE type <> 'admin'";
        if($currentSession != 0){
            $sqlquery .= " AND user.sessionID = $currentSession";
        }
        mysql_query($sqlquery);
        echo "<br/>Done ! ! ! ".mysql_error();
        return;
    }
    
    function deleteAllCloseCampaigns()
    {   
        $session = new SessionClass();
        $adminID = $session->getAdminID();
        //echo $adminID;die;
        $currentSession = $session->getActiveSessionID($adminID);
        //echo $currentSession;die;
        $sqlquery =  "delete from campaign where onGoing = 'no' ";
        if($currentSession != 0){
            $sqlquery .= " AND user.sessionID = $currentSession";
        }
        mysql_query($sqlquery);
        echo "<br/>Done ! ! ! ".mysql_error();
        return;
        
    }
    
    function deleteAllCampaignLogFiles()
    {
        foreach (glob("./campaign_logs/*.txt") as $filename) 
        {
            unlink($filename);
        }
        echo "<br/>Done ! ! ! ".mysql_error();
        return;
    }
    
    function deleteAllAgentLogFiles()
    {
        foreach (glob("./agent_logs/*.txt") as $filename) 
        {
            unlink($filename);
        }
        echo "<br/>Done ! ! ! ".mysql_error();
        return;
    }

    function closeAllCampaigns()       //avi - close all campaigns
    {   
        $session = new SessionClass();
        $adminID = $session->getAdminID();
        $currentSession = $session->getActiveSessionID($adminID);
        $sqlquery =  "UPDATE campaign SET onGoing = 'no' ";
        if($currentSession != 0){
            $sqlquery .= " WHERE sessionID = $currentSession";
        }
        $result = mysql_query($sqlquery);
        echo "<br/>Done ! ! ! ".mysql_error();
        return;
    }
    
    function getUsernameById($userID) {
        $query = "SELECT name FROM user WHERE id = $userID";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        return $row['name'];
    }
    
    // Returns the numbers of campaigns - by type
    function getNumberOfCampaign($from, $type) {
        $session = new SessionClass();
        $adminID = $session->getAdminID();
        $currentSession = $session->getActiveSessionID($adminID);
        $dateArr= explode('/',$from);
        $time = $dateArr[0].'-'.$dateArr[1].'-'.$dateArr[2];
        if ($type != "0") {  // Check what type of auction to pull the info for. 0 means for ALL types.
            $query = "SELECT COUNT(campaign.campaignID) AS num
                      FROM campaign, user 
                      WHERE campaign.userID = user.userID AND
                            campaign.startTime > '".strtotime($time)."' AND
                            campaign.type = '$type'";
            if($currentSession != 0) {
                $query .= " AND user.sessionID = '$currentSession'";
            }
        } else {
            $query = "SELECT COUNT(campaign.campaignID) AS num
                      FROM campaign,user 
                      WHERE campaign.userID = user.userID AND
                            campaign.startTime > '".strtotime($time)."'";
            if($currentSession != 0) {
                $query .= " AND user.sessionID = $currentSession";
            }
        }
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        return $row['num'];
    }
    
    function resetDatabase(){
        mysql_query("DELETE FROM agent");
        mysql_query("DELETE FROM campaign");
        mysql_query("DELETE FROM auctionvisits");
        mysql_query("DELETE FROM balance");
        mysql_query("DELETE FROM messages");
        mysql_query("DELETE FROM sessions");
        mysql_query("DELETE FROM settings WHERE session <> 0");
        mysql_query("DELETE FROM user WHERE type <> 'admin'");
        mysql_query("DELETE FROM visits");
        echo "<br/>Done ! ! ! ".mysql_error();
    }
    
}
?>
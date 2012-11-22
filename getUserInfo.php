<?php
    $filename ="userInfo.xls";
    header('Content-type: application/ms-excel');
    header('Content-Disposition: attachment; filename='.$filename);
    
    require_once('classes/UserClass.php');
    //require_once('include/regularClass.php');
    require_once("classes/SessionClass.php");
    require_once("classes/BalanceClass.php");
    require_once("classes/AdminClass.php");
    
    $user = new UserClass();
    //$seller = new regularClass();
    $session = new SessionClass();
    $balance = new BalanceClass();
    $admin = new AdminClass();
    
    $from = $_GET['from'];
    $to = $_GET['to'];

    // Get current admin's active session
    
    $adminID = $session->getAdminID();
    $currentSession = $session->getActiveSessionID($adminID);
    // Get the active session's initial balance amount
    $getSettings = mysql_query("SELECT * FROM sessionsettings WHERE sessionID = $currentSession");
    $getSet = mysql_fetch_array($getSettings);
    //$initBalance = $getSet['initBalance'];
    
    
    $content = "
        <table>
            <tr>
                <td><b>User</b></td>
                
                <td><b>Created Auctions (English)</b></td>
                <td><b>Created Auctions (Dutch)</b></td>
                <td><b>Created Auctions (First Sealed)</b></td>
                <td><b>Created Auctions (Second Sealed)</b></td>
                <td><b>Created Auctions (Fixed)</b></td>
                <td><b>Created Auctions (Yankee ASC)</b></td>
                <td><b>Created Auctions (Yankee DESC)</b></td>
                
                <td><b>Created Auctions That Sold (English)</b></td>
                <td><b>Created Auctions That Sold (Dutch)</b></td>
                <td><b>Created Auctions That Sold (First Sealed)</b></td>
                <td><b>Created Auctions That Sold (Second Sealed)</b></td>
                <td><b>Created Auctions That Sold (Fixed)</b></td>
                <td><b>Created Auctions That Sold (Yankee ASC)</b></td>
                <td><b>Created Auctions That Sold (Yankee DESC)</b></td>
                
                <td><b>No. of Auctions Bidded On (English)</b></td>
                <td><b>No. of Auctions Bidded On (Dutch)</b></td>
                <td><b>No. of Auctions Bidded On (First Sealed)</b></td>
                <td><b>No. of Auctions Bidded On (Second Sealed)</b></td>
                <td><b>No. of Auctions Bidded On (Fixed)</b></td>
                <td><b>No. of Auctions Bidded On (Yankee ASC)</b></td>
                <td><b>No. of Auctions Bidded On (Yankee DESC)</b></td>
                
                <td><b>No. of Bids (English)</b></td>
                <td><b>No. of Bids (Dutch)</b></td>
                <td><b>No. of Bids (First Sealed)</b></td>
                <td><b>No. of Bids (Second Sealed)</b></td>
                <td><b>No. of Bids (Fixed)</b></td>
                <td><b>No. of Bids (Yankee ASC)</b></td>
                <td><b>No. of Bids (Yankee DESC)</b></td>
                
                <td><b>Viewed Auctions</b></td>
                
                <td><b>Won Auctions (English)</b></td>
                <td><b>Won Auctions (Dutch)</b></td>
                <td><b>Won Auctions (First Sealed)</b></td>
                <td><b>Won Auctions (Second Sealed)</b></td>
                <td><b>Won Auctions (Fixed)</b></td>
                <td><b>Won Auctions (Yankee ASC)</b></td>
                <td><b>Won Auctions (Yankee DESC)</b></td>
                
                <td><b>Initial Balance</b></td>
                <td><b>Current Balance</b></td>
                
                <td><b>Initial Items</b></td>
                <td><b>Item's Quantity</b></td>
                
                <td><b>Current Items</b></td>
                <td><b>Item's Quantity</b></td>
                
                <td><b>Total Site Visits</b></td>
                
                <td><b>Total Time Spent</b></td>
                
                <td><b>Messages Sent</b></td>
            </tr>
    ";
    
    // Get all user of current session
    $result = $user->getUserList();
    //Populate chart with users' info
    while($row = mysql_fetch_array($result)){
        if($adminItems == 1) { // If user account is initialized with admin defined items
            $result2 = $seller->itemList($row['id']);
            $itemsNum = mysql_num_rows($result2);
            $result3 = $admin->getAdminItemList($currentSession);
            $adminItemsNum = mysql_num_rows($result3);
            $counter = ($itemsNum > $adminItemsNum) ? $itemsNum : $adminItemsNum;
        } else { // If user account is NOT initialized with any items
            $result2 = $seller->itemList($row['id']);
            $itemsNum = mysql_num_rows($result2);
            $counter = $itemsNum;
        }
        while($counter--){
            $row2 = mysql_fetch_array($result2);
            if(isset($result3)){
                $row3 = mysql_fetch_array($result3);
            }
            if(($itemsNum == mysql_num_rows($result2)) || ((isset($result3)) && ($adminItemsNum == mysql_num_rows($result3)))) {
                $itemsNum--;
                if($adminItems == 1){
                    $adminItemsNum--;
                }
                $content .= "
                    <tr>
                        <td>".$row['name']."</td>
                        
                        <td>".$seller->createdAuctionsByType($row['id'], 1, $from, $to)."</td>
                        <td>".$seller->createdAuctionsByType($row['id'], 2, $from, $to)."</td>
                        <td>".$seller->createdAuctionsByType($row['id'], 3, $from, $to)."</td>
                        <td>".$seller->createdAuctionsByType($row['id'], 4, $from, $to)."</td>
                        <td>".$seller->createdAuctionsByType($row['id'], 5, $from, $to)."</td>
                        <td>".$seller->createdAuctionsByType($row['id'], 6, $from, $to)."</td>
                        <td>".$seller->createdAuctionsByType($row['id'], 7, $from, $to)."</td>
                        
                        <td>".$seller->createdAuctionsThatSoldByType($row['id'], 1, $from, $to)."</td>
                        <td>".$seller->createdAuctionsThatSoldByType($row['id'], 2, $from, $to)."</td>
                        <td>".$seller->createdAuctionsThatSoldByType($row['id'], 3, $from, $to)."</td>
                        <td>".$seller->createdAuctionsThatSoldByType($row['id'], 4, $from, $to)."</td>
                        <td>".$seller->createdAuctionsThatSoldByType($row['id'], 5, $from, $to)."</td>
                        <td>".$seller->createdAuctionsThatSoldByType($row['id'], 6, $from, $to)."</td>
                        <td>".$seller->createdAuctionsThatSoldByType($row['id'], 7, $from, $to)."</td>
                        
                        <td>".$user->biddedOnByType($row['id'], 1, $from, $to)."</td>
                        <td>".$user->biddedOnByType($row['id'], 2, $from, $to)."</td>
                        <td>".$user->biddedOnByType($row['id'], 3, $from, $to)."</td>
                        <td>".$user->biddedOnByType($row['id'], 4, $from, $to)."</td>
                        <td>".$user->biddedOnByType($row['id'], 5, $from, $to)."</td>
                        <td>".$user->biddedOnByType($row['id'], 6, $from, $to)."</td>
                        <td>".$user->biddedOnByType($row['id'], 7, $from, $to)."</td>
                        
                        <td>".$user->bidsNumByType($row['id'], 1, $from, $to)."</td>
                        <td>".$user->bidsNumByType($row['id'], 2, $from, $to)."</td>
                        <td>".$user->bidsNumByType($row['id'], 3, $from, $to)."</td>
                        <td>".$user->bidsNumByType($row['id'], 4, $from, $to)."</td>
                        <td>".$user->bidsNumByType($row['id'], 5, $from, $to)."</td>
                        <td>".$user->bidsNumByType($row['id'], 6, $from, $to)."</td>
                        <td>".$user->bidsNumByType($row['id'], 7, $from, $to)."</td>
                        
                        <td>".$user->visitedAuctions($row['id'], $from, $to)."</td>
                        
                        <td>".$user->auctionsWonByType($row['id'], 1, $from, $to)."</td>
                        <td>".$user->auctionsWonByType($row['id'], 2, $from, $to)."</td>
                        <td>".$user->auctionsWonByType($row['id'], 3, $from, $to)."</td>
                        <td>".$user->auctionsWonByType($row['id'], 4, $from, $to)."</td>
                        <td>".$user->auctionsWonByType($row['id'], 5, $from, $to)."</td>
                        <td>".$user->auctionsWonByType($row['id'], 6, $from, $to)."</td>
                        <td>".$user->auctionsWonByType($row['id'], 7, $from, $to)."</td>
                        
                        <td>".$initBalance."</td>
                        <td>".$balance->getBalance($row['id'])."</td>";
                
                if($adminItems == 1){
                    $content .= "
                        <td>".$row3['name']."</td>
                        <td>".$row3['quantity']."</td>
                        <td>".$row2['name']."</td>
                        <td>".$row2['quantity']."</td>
                    ";
                } else {
                    $content .= "
                        <td>0</td>
                        <td>0</td>
                        <td>".$row2['name']."</td>
                        <td>".$row2['quantity']."</td>
                    ";
                }
                
                $content .= "                        
                        <td>".$user->siteVisits($row['id'], $from, $to)."</td>
                        
                        <td>".$user->timeSpent($row['id'], $from, $to)."</td>
                        
                        <td>".$user->messagesSent($row['id'], $from, $to)."</td>
                        
                    </tr>";
            } else {
                $content .= "
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>";
                if($adminItems == 1){
                    $content .= "
                        <td>".$row3['name']."</td>
                        <td>".$row3['quantity']."</td>
                        <td>".$row2['name']."</td>
                        <td>".$row2['quantity']."</td>
                    ";
                } else {
                    $content .= "
                        <td></td>
                        <td></td>
                        <td>".$row2['name']."</td>
                        <td>".$row2['quantity']."</td>
                    ";
                }
                $content .= "                        
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>";
            }
        }
    }
    */
    $content .= "
        </table>";
           
    echo $content;
?>

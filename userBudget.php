<?php
    require_once("classes/BalanceClass.php");
    
    echo "<h2>Current Balance:</h2>
          <table class='campaignListTable'>
            <tr class='campaignListCat'>
                <td>Activity</td>
                <td>Time</td>
                <td>Amount</td>
            </tr>
         ";
    
    $balance = new BalanceClass();         
    $result = $balance->userActivities($_SESSION['user']['userID']);
    $total = 0;
    
    while($row = mysql_fetch_array($result)){
        $total += $row['total'];
        $date = explode(" ", date("d/m/Y H:i:s" ,$row['time']));
        echo "  
            <tr class='adminCampaignLines'>";
        if($row['campaignID'] == -1) {
            echo "<td>AD Simulator </td>";
        } else {
            echo "
                <td>campaign</td>";
        }
        echo "
                
                <td>".$date[0]."<br>".$date[1]."</td>
                <td>".$row['amount']."</td>
                </tr>
             ";
    }
    
    echo "  
            <tr class='adminCampaignLines'>
                <td><b></b></td>
                <td></td>
                <td>Total: <b>".$total."</b></td>
                </tr>
          </table>
         ";
?>

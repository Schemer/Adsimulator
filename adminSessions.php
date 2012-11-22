<?php
    require_once("classes/SessionClass.php");
?>
<h2 align=center>Sessions Menu</h2>
<div id='viewedSessionCont'>
    Currently viewed session:
    <select name='viewedSession' id='viewedSession' class='inputSelect' onchange="changeActiveSession()">
    <?php
        $session = new SessionClass();
        $adminID = $session->getAdminID();
        $result = $session->getActiveSession($adminID);
        if($row = mysql_fetch_array($result)){ // If there is an active session
            echo "<option value='".$row['sessionID']."'>".$row['name']."</option>";
        }
        echo "<option value='0'>All</option>";
        $result = $session->getAllInactiveSessions();
        while($row = mysql_fetch_array($result)){
            echo "<option value='".$row['sessionID']."'>".$row['name']."</option>";
        }
    ?>    
    </select> <br><br>
    Session ID: <span id='sessionID'></span> <br>
    Description: <span id='sessionDesc'></span> <br>
    Started at: <span id='sessionStart'></span> <br>
    Ended at: <span id='sessionEnd'></span> <br>   
</div>
<h3>All sessions:</h3>
<button class='newButton' onclick="document.location.href='index.php?tabID=adminMain&subID=createSession'">Create a new session</button>
<table class='campaignListTable' >
    <tr class='campaignListCat'>
            <td>ID</td>
            <td>Description</td>
            <td>Start Time</td>
            <td>End Time</td>
            <td>Status</td>
    </tr>
    
<?php
    $result = $session->getAllSessions();
    while($row = mysql_fetch_array($result)) {
        $endTime = $row['endTime'] ? date("d/m/Y" , $row['endTime']) : "---";
        $status = $row['active'] ? "Open<br><div class='closeSessionButton' onmousedown=\"closeSession(".$row['sessionID'].");\">(Close)</div>" : 
                                   "Closed<br><div class='openSessionButton' onmousedown=\"openSession(".$row['sessionID'].");\">(Open)</div>";
        echo "
            <tr class='adminAuctionLines'>
                <td>".$row['sessionID']."</td>
                <td>".$row['name']."</td>
                <td>".date("d/m/Y" , $row['startTime'])."</td>
                <td id='end".$row['sessionID']."'>".$endTime."</td>
                <td id='s".$row['sessionID']."'>".$status."</td>
            </tr>";
    }
?>
                    
</table>
<script type="text/javascript">
    // Fills in the currently viewed session fields
    changeActiveSession();
</script>
<?php
    require_once("iniSessionSetting.php");

    class BalanceClass{
        
        // Get user's current balance
        function getBalance($userID) {
            $query = "SELECT SUM(amount) AS total
                      FROM balance
                      WHERE userID = $userID";
            $result = mysql_query($query);
            $row = mysql_fetch_array($result);
            $total = ($row['total']) ? $row['total'] : "0";
            return $total;
        }

        function newActivity($campaignID, $userID, $amount,$time) {
            $currentTime = time();
            $query = "INSERT INTO balance (campaignID, userID, amount, time)
                      VALUES ($campaignID, $userID, $amount, $time)";
            return mysql_query($query);
        }
        
        // Fetch user's activity
        function userActivities($userID) {
            $query = "SELECT campaignID, userID, amount, time, SUM(amount) AS total
                      FROM  balance
                      WHERE userID = $userID
                      GROUP BY campaignID, userID, amount, time
                      ORDER BY time DESC";
            $result = mysql_query($query);
            return $result;
        }
        
    }
?>
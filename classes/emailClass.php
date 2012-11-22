<?php

Class EmailClass
{
    function getEmailPrice()
    {
        if(isset($_SESSION['user'])){
            $currentSession = $_SESSION['user']['sessionID'];
        } else {
            $currentSession = 0;
        }
        $d= "";
        $sqlquery = "SELECT  emailOncePrice,emailDailyPrice,emailWeeklyPrice
            FROM  emailsettings
            WHERE sessionID = $currentSession";
        $result = mysql_query($sqlquery);
        $row =  mysql_fetch_array($result);
        echo sizeof($row);
        for ($index = 0; $index < sizeof($row)/2; $index++) {
            $d.= $row[$index]. ";";
        }
        return $d;
    }
}

?>

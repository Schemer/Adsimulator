<?php              
             
    //local machine                       
    $hostname = "localhost";
    $userid = "root";
    $database = "adSimDB";
    $password = "";
    mysql_connect($hostname,$userid,$password) or die("Could not connect to MySQL");
    @mysql_select_db($database) or die("Unable to select database $database");        
                                  
?>
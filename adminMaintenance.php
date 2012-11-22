<?php
    include_once('./classes/UserClass.php');
    include_once('./classes/SessionClass.php');
    
    $UserClass = new UserClass();
    $sessionClass = new SessionClass();
    if (!empty($_GET['action'])){
        if (!empty($_GET['go'])){
            $password = $_GET['password'];
            $name = $_GET['name'];
            switch ($_GET['action']){
                case 'new' :{
                    
                    $type = $_GET['type'];
                    $sessionID = $_GET['sessionID'];
                    $result = $UserClass->addNewUser($name,$password,$type,$sessionID);
                    if ($result != FALSE){
                        $UserClass->createUserState($result, $sessionID);
                    }
                    break;
                }
                case 'upd' :{
                    $id = $_GET['id'];
                    $result = $UserClass->updUserDetail($id,$name,$password);
                    break;
                }
                case 'del' :{
                    $id = $_GET['id'];
                    $result = $UserClass->delUser($id);
                    break;
                }
            }   
            if ($result!=false){
                echo "Done! ! !";   
            }
            else
                echo "Error";
            echo "<script type=\"text/JavaScript\">setTimeout(\"document.location.href='index.php?tabID=adminMain&subID=userMaintenance'\",500000);</script>";
                return;
        }
        else{
           require_once('adminUserMainForm.php');
           return;
        }
    }

    echo "<h2 align=center>Users Menu</h2>";
    echo "<input type='button' class='newButton' onClick=\"document.location.href='index.php?tabID=adminMain&subID=userMaintenance&action=new'\" value='Add new user'> <br><br>";
    
     echo "<select name='session' class='inputSelect' onChange=\"document.location.href='index.php?tabID=adminMain&subID=userMaintenance&session='+this.value\">
                <option value=''>select session</option>
                <option value='0'>ALL</option>";
               
    $sessions = $sessionClass->getAllSessions();
    while ($row=mysql_fetch_array($sessions)){
        echo "<option value='".$row['sessionID']."'>".$row['name']."</option>";
    }
    echo "</select> <br>"; 
    echo"<br/>
        <table class='campaignListTable' >
                    <tr class='campaignListCat'>
                            <td>User ID</td>
                            <td>User Name</td>
                            <td>Password</td>
                            <td>Session</td>
                            <td>User Type</td>
                            <td>Active</td>
                            <td>Delete</td>
                            <td>Update</td>
                    </tr>";
        if (isset($_GET['session'])){
            $result = $UserClass->getUserList($_GET['session']);
            if ($_GET['session']!=0)
                echo '<b>Users in '.$sessionClass->getSessionName($_GET['session']).':</b><br>';
            else              
                echo '<b>Users in ALL sessions:</b><br>';
        }
        else {
            $result = $UserClass->getUserList(0);
            echo '<b>Users in ALL sessions:</b><br>';
        }
        $num = mysql_num_rows($result);
        if ($num==0)
            echo "<br>No users found";
        else {
            while($row = mysql_fetch_array($result)){
                echo "
                    <tr class='campaignLines'>
                        <td onclick=\"document.location.href='index.php?tabID=adminMain&subID=userStats&userID=".$row['userID']."'\">".$row['userID']."</td>
                        <td onclick=\"document.location.href='index.php?tabID=adminMain&subID=userStats&userID=".$row['userID']."'\">".$row['name']."</td>
                        <td onclick=\"document.location.href='index.php?tabID=adminMain&subID=userStats&userID=".$row['userID']."'\">".$row['password']."</td>
                        <td onclick=\"document.location.href='index.php?tabID=adminMain&subID=userStats&userID=".$row['userID']."'\">".$UserClass->getUserSession($row['userID'])."</td>
                        <td onclick=\"document.location.href='index.php?tabID=adminMain&subID=userStats&userID=".$row['userID']."'\">".$UserClass->getUserType($row['type'])."</td>
                        <td onclick=\"document.location.href='index.php?tabID=adminMain&subID=userStats&userID=".$row['userID']."'\">".(($row['active']=='yes')?'YES':'NO')."</td>
                        <td><a href=\"./index.php?tabID=adminMain&subID=userMaintenance&action=del&id=". $row['userID'] ."\"><img src='images/delete.png' alt='del' class='deleteImg'></a></td>
                        <td><a href=\"./index.php?tabID=adminMain&subID=userMaintenance&action=upd&id=". $row['userID'] ."\"><img src='images/update.png' alt='upd' class='updateImg'></a></td>
                    </tr>";   
            }
        }      
        echo   "</table><br />";
?>
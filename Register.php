<?php
    require_once("classes/BalanceClass.php");
   
    require_once("iniSessionSetting.php");
    require_once('classes/UserClass.php');

    if (!empty($_SESSION['BackPage'])){
          $back = $_SESSION['BackPage'];
    } else {
          $back = "index.php?tabID=Login";
    }

    $UserClass = new UserClass();
    $UserClass->UnSession();

    if (!empty($_GET['name']) && !empty($_GET['password']) && !empty($_GET['session']) )
    {
        $name = $_GET['name'];
        $password = $_GET['password'];
        $session = $_GET['session'];
       
        
        $check = $UserClass->RegisterNewUser($name, $password, $session);
        switch ($check){
            case '0':   // User added successfuly
                echo "<script type='text/javascript'>window.onload=storeDatetime();</script>";
                // Display approval message
                echo "<h1>User Added</h1>
                      <br/>Wait while you're being transfered...";
                echo "<script>setTimeout(\"document.location.href='$back'\",3000);</script>";
                return;
            case '1':
                echo "<font size=\"4\" color=\"red\">User Already register</font>";
                break;
            case '2':
                echo "<font size=\"4\" color=\"red\">User Name or password don't Exists</font>";
                break;
            case '3':
                echo "<font size=\"4\" color=\"red\">Session is closed or doesn't exist</font>";
                break;
        }
    }
    else{
        if (!empty($_GET['name']) || !empty($_GET['password']) || !empty($_GET['session']))
            echo "<font size=\"4\" color=\"red\">Please fill in all fields</font>";
    }
?>

<div id='regContainer'>
    <h1>Register</h1>
    <form action="index.php" method="get">
                     <input type="hidden" name="tabID" value="Register"/>
                     <input type="hidden" name="type" value='user'/>
        Username: <br/>  <input type="text" name="name" tabindex="1" class='inputField'/> <br/>
        Password: <br/>  <input name="password" type="password" tabindex="2" class='inputField'/> <br/>
        Session: <br/>  <input name="session" type="text" tabindex="3" class='inputField'/> <br/> <br/>        
                    <input type="submit" value="Register" tabindex="4" class='newButton'>  
    </form>
</div>

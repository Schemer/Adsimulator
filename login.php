<?php
    if (!empty($_SESSION['BackPage'])){
        $back = $_SESSION['BackPage'];
    } else {
        $back = "index.php";
    }

    include_once('./classes/UserClass.php');
	
    $userClass = new UserClass();

    if ((!empty($_GET['user'])) && (!empty($_GET['password']))){
        $user=$_GET['user'];
        $password=$_GET['password'];
        $check = $userClass->CheckUser($user,$password);
        if ($check==1){
            if (!empty($_SESSION['BackPage'])){
                unset($_SESSION['BackPage']);
                echo "<script>document.location.href='$back';</script>";
                exit;
            } elseif ($_SESSION['user']['type'] == 'admin'){
                $page = 'index.php?tabID=adminMain';    // admin
            } else {
                $page = 'index.php?tabID=userMain';    // regular user
            }
            if (isset($_SESSION['user']['userID'])){ 
                // Creating a new user visit
                echo "<script>createVisit(".$_SESSION['user']['userID'].", '$page');</script>"; // dropped the 'window.onload'
                // Get current time and update the data in session variables
                echo "<script type='text/javascript'>storeDatetime();</script>"; // dropped the 'window.onload'
               
            }
        } else if($check==2) {
            echo  "<h3>** Username or password do not match</h3>";
        } else {
            echo  "<h3>** Your session is closed</h3>";
        }
    } else if (isset($_GET['user']) || isset($_GET['password'])) {
        echo "<h3>** Required field cannot be left blank</h3>";
    }
?>
<div id='loginContainer'>
        <h1>Login</h1>
        <form action="index.php" method="GET">
            <input type="hidden" name="tabID" value="Login">
			Username: <br/>  <input type="text" name="user" class='inputField'> <br/>
			Password: <br/>  <input type="password" name="password" class='inputField'> <br/> <br/>
			<input type="submit" value="Sign in" class='newButton'>

        </form>
</div>

<?php
	include_once("classes/BalanceClass.php");
	include_once("classes/MessagesClass.php");
    include_once("classes/SessionClass.php");
	
	$balance = new BalanceClass();
	$messages = new Messages(); 
    $session = new SessionClass();
?>

<div id='topNavContainer'>
    <div id='serverTimer'></div><br>
    <div id='simulateTime' align="right"> </div>
    
	<div id='topNavLinks'>
		<?php
			echo "<span class='redText'>Hello </span>";
			if (isset($_SESSION['user'])){
				$name = $_SESSION['user']['name'];
				$type = $_SESSION['user']['type'];
				echo "<span class='redText'> $name </span> &nbsp;
					<a href='index.php?tabID=Logout'>(Logout)</a>
					<span class='redText'>: </span>
					</br>";
				if($type != 'admin'){ // If regular type user
					echo"<a href='index.php?tabID=account'>Dashboard</a>
						<span class='grayText'> | </span>
						<a href='index.php?tabID=messages'>Messages: ".$messages->getMessagesAmount($_SESSION['user']['userID'])." </a>
						<span class='grayText'> | </span>
                                                <a href='index.php?tabID=budget'>Budget: ".$balance->getBalance($_SESSION['user']['userID'])." </a>
						<span class='grayText'> | </span>";
				} 
				else { // If administrator type user
					$result = $session->getActiveSession($_SESSION['user']['userID']);
					if (mysql_num_rows($result) > 0) {
						$row = mysql_fetch_array($result);
						$currentSession = $row['sessionID'];
					}
					else {
						$currentSession = "All";
					}
					echo "<a href='index.php?tabID=adminMain&subID=sessions'>Current Session: ".$currentSession." </a>
						<span class='grayText'> | </span>
						<a href='index.php?tabID=messages'>Messages: ".$messages->getMessagesAmount($_SESSION['user']['userID'])." </a>
						<span class='grayText'> | </span>";
				}
			}
			else { // If not logged in
				echo "<span class='redText'>Guest :</span></br>
					<a href='index.php?tabID=Login'>Login</a><span class='grayText'> | </span>
					<a href='index.php?tabID=Register'>Register</a>";
			}
			echo "<span class='grayText'> | </span><a href='index.php'>ADsim[home page]</a>";
		?>
	</div>
    	
</div>
				
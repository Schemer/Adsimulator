<?php
	require_once('iniSessionSetting.php');
	echo "<div id='leftNavCont'>";
        if(isset($_SESSION['user'])){
            
            if (isset($_SESSION['user']['type'])) {
		if ($_SESSION['user']['type']=='user') { // If regular user
                    
                  echo "<span class='leftNavHeader'>Campaign Types:</span>
                        <ul>
                            <li><a href='index.php?tabID=userMain&subID=email'>E-Mail</a></li>
                            <li><a href='index.php?tabID=userMain&subID=seo'>Serch Engine Opt.</a></li>
                            <li><a href='index.php?tabID=userMain&subID=ppc'>Pay Per Click</a></li>
                            <li><a href='index.php?tabID=userMain&subID=display'>Display</a></li>
                        </ul>";
                    echo"<span class='leftNavHeader'>".$_SESSION['user']['name']."'s Place:</span>
			<ul>
                            <li><a href='index.php?tabID=userMain&subID=Campaigns'>Campaigns</a></li>
                            <li><a href='index.php?tabID=userMain&subID=publicInfo'>Public Info</a></li>
                            <li><a href='index.php?tabID=userMain&subID=management'>Management</a><li>
                        </ul>";		
		}
		elseif ($_SESSION['user']['type']=='admin'){
		    echo "<span class='leftNavHeader'>Administration:</span>
						<ul>
                            <li><a href='index.php?tabID=adminMain&subID=campaignInfo'>Campaign Information</a></li>
                            <li><a href='index.php?tabID=adminMain&subID=Campaigns'>Campaigns</a></li>
                            <li><a href='index.php?tabID=adminMain&subID=dbMaintenance'>Maintenance</a></li>
                            <li><a href='index.php?tabID=adminMain&subID=sessions'>Sessions</a></li>
							<li><a href='index.php?tabID=adminMain&subID=settings'>Settings</a></li>
                            <li><a href='index.php?tabID=adminMain&subID=statistic'>Statistics</a></li>
                            <li><a href='index.php?tabID=adminMain&subID=userInfo'>User Information</a></li>
                            <li><a href='index.php?tabID=adminMain&subID=userStatistics'>User Statistics</a></li>
                            <li><a href='index.php?tabID=adminMain&subID=userMaintenance'>Users</a></li>
                        </ul>";
			}
		}
    }
    else {
        echo "
                    <span class='leftNavHeader'>what You want to do?</span>
                        <ul>
                            <li><a href='index.php?tabID=Login'>Login</a></li>
                            <li><a href='index.php?tabID=Register'>Register</a></li>
                            
                        </ul>";
    }
	echo "</div>";
?>

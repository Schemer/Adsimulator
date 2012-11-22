<?php
/*
    This file is responsible of killing all the session's that are open
    to the login user, after that he link to user to the main page in order
    to relogin.
*/
echo "<script type='text/javascript'>updateVisit(".$_SESSION['user']['userID'].");</script>"; // dropped the 'window.onload'
session_destroy();
session_unset();
echo "<script>document.location.href='index.php'</script>";
exit;
?>
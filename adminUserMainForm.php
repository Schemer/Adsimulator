<?php
    include_once('./classes/SessionClass.php');
    include_once('./classes/UserClass.php');
    $UserClass = new UserClass();
    $sessionClass = new SessionClass();
    $action = $_GET['action'];
    
    if ($action=='upd' || $action=='del'){
        $id = $_GET['id'];
        
        $result  = $UserClass->getUserDetail($id);
        $row = mysql_fetch_array($result);
        
        $name= $row['name'];
        $password=$row['password'];
    }
    else{
        $name=null;
        $password=null;
        
    }
    switch($action){
        case 'new': echo "<h3>Add new user</h3>"; break;        
        case 'upd': echo "<h3>Update user details</h3>"; break;
        case 'del': echo "<h3>Delete user</h3>"; break;
    }
?>

<form action="index.php" method="get" name="userMain" onsubmit="return check();">
    <input type='hidden' name='tabID' value='adminMain'>   
    <input type='hidden' name='subID' value='userMaintenance'>
    <input type='hidden' name='go' value='ok'>
    <input type='hidden' name='action' value="<?php echo $action; ?>">
    <?php 
        if ($action=='upd' || $action=='del'){
            echo "<input type='hidden' name='id' value='$id'>";
        }
    ?>
    Name: <br><input type="text" id="name" name="name" value="<?php echo $name; ?>" class='inputField'/> <br>
    Password: <br><input type="text" id="password" name="password" value="<?php echo $password?>" class='inputField'/> <br>
    
    <?php
        if ($action=='new'){
            echo " Type: <br>
                <select name='type' id='type' class='inputSelect'>
                    <option value=''>Choose type</option>
                    <option value='user'>Regular user</option>
                    <option value='agent'>Agent</option>
                </select> <br>
                Session: <br>
                <select name='sessionID' id='session' class='inputSelect'>
                <option value=''>Select Session...</option>";
            $sessions = $sessionClass->getAllSessions();
            while ($row=mysql_fetch_array($sessions)){
                echo "<option value='".$row['sessionID']."'>".$row['name']."</option>";
            }
    echo "</select><br><br>";
    }
    ?>
    <input type="submit" value="Submit" class="newButton"/>
</form>
<script language='javascript'>
    
    if ('<?php echo $action; ?>' == 'del'){
        document.getElementById('name').readOnly = true;
        document.getElementById('password').readOnly = true;
        function check(){return false;}
    }
    else{       
      function check(){
          if(document.getElementById('name').value==''){
                    alert('Please enter user name');
                    return false;
          }
          if ('<?php echo $action; ?>'=='new'){
              var name = new Array();
              var i=0;
              <?php  
                 $index = 0;
                 $result = mysql_query("SELECT name FROM user");
                 while ($row=mysql_fetch_array($result)){
                     echo "name['$index']='".$row['name']."';";
                     $index += 1; 
                 }
              ?>
              
              while (i< name.length){
                  if(document.getElementById('name').value==name[i]){
                      alert ('User name already exist');
                      return false;
                  }
                  i++;
              }             
          }
          if(document.getElementById('password').value==''){
              alert('Please enter user password');
              return false;
          }
          if ('<?php echo $action; ?>'=='new'){ 
              if(document.getElementById('session').value==''){
                  alert('Please select session');
                  return false;              
              }
              if(document.getElementById('type').value==''){
                alert('Please select user type');
                return false;       
              }
          }
          return true;
      }
  }       
</script>

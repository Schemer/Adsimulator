<?php
    include_once('./classes/AdminClass.php');
    $AdminClass = new AdminClass();
    

    if (!empty($_GET['action']))
    {  
        switch ($_GET['action'])
        {
            case '1':
                echo "<h3>Show all open campaigns</h3>";
                $result = $AdminClass->allOpenCampaigns();
                break;
            case '2':
                echo "<h3>Show all closed campaigns</h3>";
                $result = $AdminClass->allCloseCampaigns();
                break;
            case '3':
                     
            case '4':
                
            case '5':
                
            case '6':
               
            case '7':
                
            case '8':
                
            case '9':
               
            case '10':
                
            case '11':
                
            case '12':
               
        }
        return;
      }
          
    else 
    {
        echo "<h2 align=center>Statistic Menu</h2>";    
        $userList = $AdminClass->getUsertList();
        $agentList = $AdminClass->getAgentList();
    }       
?>

<script type="text/javascript">
function getValue(x)
  {
      switch (x)
      {
          case '9' :
                document.getElementById(x).innerHTML = '<input type="input" name="listPrice" size=1/>'
                break;
          case '10' :
                document.getElementById(x).innerHTML = '<input type="input" name="numBidder" size=1/>Bidder/Bidders'
                break; 
          case '11' :
                document.getElementById(x).innerHTML = '<?php echo $userList;?>'
                break; 
          case '12' :
                document.getElementById(x).innerHTML = '<?php echo $agentList;?>'
                break; 

      }
      disableAll(x)
  
  }
function disableAll(id)
{   
    var selection = document.adminStatic.action; 
    for (i=1;i<=selection.length;i++)
    {
        if (i!=id)
            document.getElementById(i).innerHTML = ''
    }
}

function check()
{
    
    var selection = document.adminStatic.action;
    flag = false;
    var num=0;
    for (i=0; i<selection.length; i++)
      if (selection[i].checked == true)
        {
            flag = !flag;
            num = i;
        }
    if (flag == true)
    {     
        if (num=='8' || num=='9' || num=='10' || num=='11')
        {     
            switch (num)
            {
                case 8:  val1 = document.getElementById('listPrice').value; break;
                case 9:  val1 = document.getElementById('numBidder').value;   break;
                case 10: val1 = document.getElementById('userID').value;  break;
                case 11: val1 = document.getElementById('agentID').value;  break;
            }
            
            if (val1 == '')
            {
                  alert('Please enter value')
                  return false;
            }
            else 
                return true;
        }
        else return true;
       
    }
    else 
    {
      alert('Please choose an option')
      return false
    }


 
}
</script>
               <br/>

<form action="index.php" method="get" name="adminStatic" onsubmit="return check()">
    <table border="0" cellspacing="0" cellpadding="1" align="left" width=95%>        
    <input type="hidden" name="tabID" value="adminMain"/>
    <input type="hidden" name="subID" value="statistic"/>
<?php
$report[1] = 'Show all active campaigns';
$report[2] = 'Show all passed campaigns';
$report[3] = 'Show all .....................';
$report[4] = 'Show all .....................';
$report[5] = 'Show all .....................';
$report[6] = 'Show all .....................';
$report[7] = 'Show all .....................';
$report[8] = 'Show all .....................';
$report[9] = 'Show all .....................';
$report[10] = 'Show all .....................';
$report[11] = 'Show all .....................';
$report[12] = 'Show all .....................';

$i=0;
 foreach($report as $key=>$value) 
    {        
        $i++;
        $odd=is_float($i/2);
        if ($odd==true) { 
            echo "<tr class='TableOdd' onmouseOver=\"this.className='mouseOver'\"  ONMOUSEOUT=\"this.className='mouseOutOdd'\">";
        } else {
            echo "<tr class='TableEven' onmouseOver=\"this.className='mouseOver'\"  ONMOUSEOUT=\"this.className='mouseOutEven'\">";
        }

     
        echo "
                    <td align=left>
                        <input type='radio' name='action'  value='$key' onclick='getValue(\"$key\");'/>
                
                $value
                <td><div id=\"$key\"></div></td>
              </tr>";
    }

?>        
     <tr>
        <td><br><input type="submit" value="Submit" class="newButton"/></td>     
     </tr>   
    </table>       
   
</form>        
        
        

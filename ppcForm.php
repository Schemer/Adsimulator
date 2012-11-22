<?php
    require_once('iniSessionSetting.php');
    require_once('classes/CampaignClass.php');
    
    $campaignClass = new CampaignClass();
    
?>
<h3> Create New Pay Per Click Campaign:</h3>
<form action='index.php' method='get' name='ppcCampaigns' onsubmit="return validate('ppc');"> 
    <input type='hidden' name='tabID' value='userMain'>   
    <input type='hidden' name='subID' value='ppc'>
    <input type='hidden' name='action' value='new'>
    <input type='hidden' name='go' id="go" value='ok'>
    <input type='hidden' name='campaignsType' id="campaignType" value="ppc">
    
    <!--SubType will be as SE site -->
    <input type="hidden" name="subType" id="subType"/>
    <!--Duration will be as maxBid-->
    <input type="hidden" name="duration" id="duration"/>
    <input type="hidden" name="startTime" id="startTime" value= "<?php echo time(); ?>"/>
    <input type="hidden" name='totalCost' id="totalCost"/>
    <input type="hidden" name='phrase' id="phrase"/>

    
    <div id='ppcContainer'> 
        <!-- SE -->
        Search Engine: <br/>
            <select id="seType" class="inputSelect" onchange='ppcChoosePhrase(value)'>
          <?php 
            $sessionID = $_SESSION['user']['sessionID'];
            $query = "SELECT * 
                      FROM selist 
                      WHERE sessionID = $sessionID";
            $result = mysql_query($query);
            foreach(mysql_fetch_assoc($result) as $key=>$value) {
                       if ($key == "sessionID") 
                       { echo "<option value=''>Choose search engine...</option>"; continue;}
                       echo "<option value='".$key."'>"."$key"."</option>";
            }
            
            //For externPrice below
            $query = "SELECT externPrice 
                      FROM ppcsettings 
                      WHERE sessionID = $sessionID";
            $result = mysql_fetch_array(mysql_query($query));
          ?>
            </select> 
            <br/><br/>    
            
       <div id="ppcPhrase" class="hiddenContainer">
       <!-- Container for phrase list by AJAX  from DB -->   
       </div>
       <div id="ppcDetails" class="hiddenContainer" onkeypress="validateNumber(event)" maxlength="8">
           <br />Your bid:<br/>
           <input type='text' id='maxBid' class="inputField"><br/>
           Your budget:<br/>
           <input type='text' id='ppcBudget' class="inputField"><br/>
           <br/>
           <input type='checkbox' id='external'>
           Advertise at social networks as well.<br/>&nbsp;<i>For additional fee of</i>
           <div id='extern'></div>
           <input type='text' id='externPrice' readonly class="numinputField" value="<?php echo $result['externPrice']; ?>"/><br/>
       </div>
      <br/>
        <div id="totalPrice"  class="hiddenContainer">
           Total Price:<br/>
           <input type='text' size="4" id='totalCampaignCost' readonly class="inputField"/>
       </div>
</div>
<div id="submitCampaignContainer">
        <input type='submit' id='ppcSubmitButton' class='newButton' value='Create New Campaign' /> 
</div>
</form>  
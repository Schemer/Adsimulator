<?php
    require_once('iniSessionSetting.php');
    require_once('classes/CampaignClass.php');
    
    $campaignClass = new CampaignClass();
     
  
?>
<h3> Create New Display Campaign:</h3>
<form action='index.php' method='get' name='displayCampaigns' onsubmit="return validate('display');"> 
    <input type='hidden' name='tabID' value='userMain'>   
    <input type='hidden' name='subID' value='display'>
    <input type='hidden' name='action' value='new'>
    <input type='hidden' name='go' id="go" value='ok'>
    <input type='hidden' name='campaignsType' id="campaignType" value="display">
    
    <input type="hidden" name="subType" id="subType"/>
    
    <input type="hidden" name="startTime" id="startTime" value= "<?php echo time(); ?>"/>
    <input type="hidden" name='totalCost' id="totalCost"/>
    
<div id='displayContainer'> 
        <!-- display type -->
        Type of display: <br/>
            <select id="displayType" class="inputSelect" onchange='chooseDisplayType(value, "<?php echo $campaignClass->getCampaignPrice('display'); ?>")'>
                <option value=''>Choose type...</option>
                <option value="banner">Banners</option>
                <option value="movie">Movies</option>
            </select> 
            <br/><br/>    
       <!-- display Price -->
       <div id="typePrice" class="hiddenContainer" ></div>
       <div id="displayPrice" class="hiddenContainer">
           <input type='text' id='price' readOnly class="inputField">                   
       </div>
       <div id="numDays" class="hiddenContainer">
           Enter Number of Days: <br/>
           <input type='text' size="4" name='duration' id='duration' class="inputField" onchange="calcCampaignPrice();" onkeypress="validateNumber(event)" maxlength="3"/>
       </div>
       <div id="totalPrice"  class="hiddenContainer">
           Total Price:<br/>
           <input type='text' size="4" id='totalCampaignCost' readonly class="inputField" />
       </div>
</div>
<div id="submitAuctionContainer">
        <input type='submit' id='emailsubmitButton' class='newButton' value='Create New Campaign' /> 
</div>
</form>  
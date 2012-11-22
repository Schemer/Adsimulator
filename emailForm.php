<?php
    require_once('iniSessionSetting.php');
    require_once('classes/CampaignClass.php');
    
    $campaignClass = new CampaignClass();
    
    
?>
<h3> Create New E-Mail Campaign:</h3>
<form action='index.php' method='get' name='emailCampaigns' onsubmit="return validate('email');"> 
    <input type='hidden' name='tabID' value='userMain'>   
    <input type='hidden' name='subID' value='email'>
    <input type='hidden' name='action' value='new'>
    <input type='hidden' name='go' id="go" value='ok'>
    <input type='hidden' name='campaignsType' id="campaignType" value="email">
    
    <input type="hidden" name="subType" id="subType"/>
    
    <input type="hidden" name="startTime" id="startTime" value= "<?php echo time(); ?>"/>
    <input type="hidden" name='totalCost' id="totalCost"/>
    
<div id='emailContainer'> 
        <!-- email type -->
        Type of email: <br/>
            <select id="emailType" class="inputSelect" onchange='chooseMailType(value, "<?php echo $campaignClass->getCampaignPrice('email'); ?>")'>
                <option value=''>Choose type...</option>
                <option value="once">Once</option>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
            </select> 
            <br/><br/>    
       <!-- email Price -->
       <div id="typePrice" class="hiddenContainer" ></div>
       <div id="emailPrice" class="hiddenContainer">
           <input type='text' id='price' readOnly class="inputField">                   
       </div>
       <div id="numDaysWeeks" class="hiddenContainer">
           Enter Number of Days/Weeks: <br/>
           <input type='text' size="4" name='duration' id='duration' class="inputField" onchange="calcCampaignPrice();" onkeypress="validateNumber(event)" maxlength="3"/>
       </div>
       <div id="totalPrice"  class="hiddenContainer">
           Total Price:<br/>
           <input type='text' size="4" id='totalCampaignCost' readonly class="inputField" />
       </div>
</div>
<div id="submitCampaignContainer">
        <input type='submit' id='emailsubmitButton' class='newButton' value='Create New Campaign' /> 
</div>
</form>  
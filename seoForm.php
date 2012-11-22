<?php

require_once('iniSessionSetting.php');
require_once('classes/CampaignClass.php');
    
$campaignClass = new CampaignClass();
?>

<h3>Create New SEO Campaign:</h3>
<form action='index.php' method='get' name='seoCampaigns' onsubmit="return validate('seo');"> 
    <input type='hidden' name='tabID' value='userMain'>   
    <input type='hidden' name='subID' value='seo'>
    <input type='hidden' name='action' value='new'>
    <input type='hidden' name='go' id="go" value='ok'>
    <input type='hidden' name='campaignsType' id="campaignType" value="seo">
    
    <input type="hidden" name="subType" id="subType"/>
    <input type="hidden" name="startTime" id="startTime" value= "<?php echo time(); ?>"/>
    <input type="hidden" name='totalCost' id="totalCost"/>
    
<div id='seoContainer'>
        Search Engine Optimization type: <br/> 
        <select id='seoType' class='inputSelect' onchange='chooseSeoType(value,"<?php echo $campaignClass->getCampaignPrice('seo'); ?>")'>
            <option value=''>Choose type...</op>
            <option value='simple'>simple SEO</option>
            <option value='complex'>complex SEO</option>
	</select>
        <br/>
        <div id="typePrice" class="hiddenContainer" ></div>
        <div id="seoPrice" class="hiddenContainer">
            <input type='text' id='price' readOnly class="inputField"/>                   
        </div> 
        <div id="numWeeks" class="hiddenContainer">
           Enter Number of Weeks: <br/>                                     
           <input type='text' size="4" name='duration' id='duration' class="inputField" onchange="calcCampaignPrice();" onkeypress="validateNumber(event)" maxlength="3"/>
       </div>
       <div id="totalPrice"  class="hiddenContainer">
           Total Price:<br/>
           <input type='text' size="4" id='totalCampaignCost' readonly class="inputField" />
       </div>
</div>
<div id="submitCampaignContainer">
        <input type='submit' id='seoSubmitButton' class='newButton' value='Create New Campaign' /> 
</div>
</form>


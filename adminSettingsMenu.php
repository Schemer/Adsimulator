<script type="text/javascript"> 
    window.onload = initSettings();
</script>
<?php
    include_once ('./classes/SessionClass.php');
    
    $sessionClass = new SessionClass();
    
    $sessionSetting = $sessionClass->getSessionSettings($_SESSION['user']['sessionID'])
   
?>
<h2 align="center">Settings</h2>
<h3>Select Setting To Update:</h3>
<select id="selectSetting">
    <option value=""></option>
    <option value="general">General Setting</option>
    <option value="email">Email Setting</option>
    <option value="display">Display Setting</option>
    <option value="PPC">PPC Setting</option>
    <option value="SEO">SEO Setting</option>
</select>
<input type="button" value="select" onClick="selectSetting()">
<br><hr>									
<div id="general" class="hiddenContainer">
    <h4>NEW USERS SETTINGS:</h4>
    
    <b>Deviation Between Users:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="deviationBetweenUsers" size="3" maxlength="5" onkeypress="validateNumber(event)">%
    &nbsp; (<?php echo $sessionSetting['deviationBetweenUsers']; ?>%)<br>
    <b>Small Company:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="smallCompany" size="1" maxlength="5" onkeypress="validateNumber(event)"/>%   
    &nbsp;( <?php echo $sessionSetting['smallCompany']; ?>%)<br>
    <b>Large Company:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="largeCompany" size="1" maxlength="5" onkeypress="validateNumber(event)"/>%
    &nbsp;( <?php echo $sessionSetting['largeCompany']; ?>%)<br>
    <b>Product Promoted:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="productPromoted" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['productPromoted']; ?>%)<br>
    <b>Online/offline Ratio:</b>
    <input type="text" size="3" maxlength="3" class="numInputField" name="generalSetting[]" id="onlieOfflineRatio" onkeypress="validateNumber(event)">%
    &nbsp;( <?php echo $sessionSetting['trafficFactor']; ?>%)<br>
    <b>Advertise Budget:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="advertiseBudget" size="3" maxlength="3" onkeypress="validateNumber(event)">%
    &nbsp; (<?php echo $sessionSetting['advertiseBudget']; ?>% <br>
    <b>Traffic Factor:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="trafficFactor" size="3" maxlength="3" onkeypress="validateNumber(event)">%
    &nbsp;( <?php echo $sessionSetting['trafficFactor']; ?>%)<br>
    <b>Site Size:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="siteSize" size="5" maxlength="5" onkeypress="validateNumber(event)">
    &nbsp;( <?php echo $sessionSetting['siteSize']; ?>)<br>
    <b>Page Seen:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="pagesSeen" size="3" maxlength="3" onkeypress="validateNumber(event)">%
    &nbsp;( <?php echo $sessionSetting['pagesSeen']; ?>)<br>
    <b>Time In Site:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="timeInSite" size="3" maxlength="3" onkeypress="validateNumber(event)">sec
    &nbsp;( <?php echo $sessionSetting['timeInSite']; ?>)<br>
    <b>Mails Arrived:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="mailsArived" size="3" maxlength="3" onkeypress="validateNumber(event)">%
    &nbsp;( <?php echo $sessionSetting['mailsArived']; ?>)<br>     
    <b>Left Contact:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="leftContact" size="3" maxlength="5" onkeypress="validateNumber(event)">%
    &nbsp;( <?php echo $sessionSetting['leftContact']; ?>)<br>    
    
    <h4>MARKET SETTING:</h4>
    <b>Direct Access Change:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="directAccessChange" size="3" maxlength="5" onkeypress="validateNumber(event)">%
    &nbsp; (<?php echo $sessionSetting['directAccessChange']; ?>%)<br>
    <b>Search Engine Market Change:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="SEMarketChange" size="1" maxlength="5" onkeypress="validateNumber(event)"/>%   
    &nbsp;( <?php echo $sessionSetting['SEMarketChange']; ?>%)<br>
    <b>Media Market Change:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="mediaMarketChange" size="1" maxlength="5" onkeypress="validateNumber(event)"/>%
    &nbsp;( <?php echo $sessionSetting['mediaMarketChange']; ?>%)<br>
    <b>email Market Change:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="emailMarketChange" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['emailMarketChange']; ?>%)<br>
    <b>Professional Web Market Change:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="PWebMarketChange" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['PWebMarketChange']; ?>%)<br>
    <b>Competition Factor:</b>
    <input type="text" class="numInputField" name="generalSetting[]" id="competitionFactor" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['competitionFactor']; ?>%)<br>
    
    <h4>GENERAL SETTING:</h4>
    <b>Admin Name:</b> 
    <input type="text" name="generalSetting[adminName]" value="Admin"/>
    &nbsp;( <?php echo $sessionSetting['adminName']; ?>)<br>
    <b>User Can Send Messages:</b>
    <label><input type="radio" name="generalSetting[userSendMsg]" value="yes"/>YES</label>
    <label><input type="radio" name="generalSetting[userSendMsg]" value="no" checked/>NO</label>
    &nbsp;( <?php echo $sessionSetting['userSendMsg']; ?>)<br> 
    <b>Active Agent:</b>
    <label><input type="radio" name="generalSetting[activeAgent]" value="yes"/>YES</label>
    <label><input type="radio" name="generalSetting[activeAgent]" value="no" checked/>NO</label>
    &nbsp;( <?php echo $sessionSetting['activeAgent']; ?>)<br>                 
 
    <b>Agent Name As User:</b>
    <label><input type="radio" name="generalSetting[agentNameAsUser]" value="yes"/>YES</label>
    <label><input type="radio" name="generalSetting[agentNameAsUser]" value="no" checked/>NO</label>
    &nbsp;( <?php echo $sessionSetting['agentNameAsUser']; ?>)<br>
</div>
<div id="email" class="hiddenContainer">
    <h4>E-Mail Prices:</h4>	
    <b>Once Price:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailOncePrice" size="3" maxlength="5" onkeypress="validateNumber(event)">%
    &nbsp; (<?php echo $sessionSetting['emailOncePrice']; ?>$)<br>
    <b>Daily Price:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailDailyPrice" size="1" maxlength="5" onkeypress="validateNumber(event)"/>%   
    &nbsp;( <?php echo $sessionSetting['emailDailyPrice']; ?>$)<br>
    <b>Weekly Price:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailWeeklyPrice" size="1" maxlength="5" onkeypress="validateNumber(event)"/>%
    &nbsp;( <?php echo $sessionSetting['emailWeeklyPrice']; ?>$)<br>
    
    <h4>INFLUENCE SETTING:</h4>
    <b>Influence Duration:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailInfluanceDuration" size="3" maxlength="5" onkeypress="validateNumber(event)">days
    &nbsp; (<?php echo $sessionSetting['emailInfluanceDuration']; ?>days)<br>
    <b>Web Traffic:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailWebTraffic" size="1" maxlength="5" onkeypress="validateNumber(event)"/>%   
    &nbsp;( <?php echo $sessionSetting['emailWebTraffic']; ?>%)<br>
    <b>Pages viewed:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailPagesView" size="1" maxlength="5" onkeypress="validateNumber(event)"/>%
    &nbsp;( <?php echo $sessionSetting['emailPagesView']; ?>%)<br>
    <b>Time In Site:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailTimeInSite" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['emailTimeInSite']; ?>%)<br>
    <b>Left Connection:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailLeftConn" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['emailLeftConn']; ?>%)<br>
    <b>Mails Arrived:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailMailsArrived" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['emailMailsArrived']; ?>%)<br>
    <b>Online Sales:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailPurchaseOnSite" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['emailPurchaseOnSite']; ?>%)<br>
    <b>Offline Sales:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailOfflineSales" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['emailOfflineSales']; ?>%)<br>
    <b>Other Sales:</b>
    <input type="text" class="numInputField" name="emailSetting[]" id="emailOtherSales" size="3" maxlength="3" onkeypress="validateNumber(event)">% 
    &nbsp;( <?php echo $sessionSetting['emailOtherSales']; ?>%)<br>
</div>   
<div id="display" class="hiddenContainer">
    <h4>Display Prices:</h4>
   
    <b>Banners Price:</b>
    <input type="text" class="numInputField" name="displaySetting[]" id="displayBannerPrice" size="3" maxlength="5" onkeypress="validateNumber(event)">%
    &nbsp; (<?php echo $sessionSetting['displayBannerPrice']; ?>$)<br>
    <b>Movies Price:</b>
    <input type="text" class="numInputField" name="displaySetting[]" id="displayMoviePrice" size="1" maxlength="5" onkeypress="validateNumber(event)"/>%   
    &nbsp;( <?php echo $sessionSetting['displayMoviePrice']; ?>$)<br>
      
    <h4>INFLUENCE SETTING:</h4>
    <table>
        <tr style="border: 1px gray solid;">
            <td>&nbsp;</td>
            <td align="center"><b>BANNERS</b></td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td align="center"><B>MOVIES</b></td>
        </tr>
        <tr>
            <td><b>Influence Duration:</b></td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayInfluanceBanDuration" size="3" maxlength="5" onkeypress="validateNumber(event)">days
            &nbsp; (<?php echo $sessionSetting['displayInfluanceBanDuration']; ?>days)</td>
            <td>&nbsp;&nbsp;&nbsp;
            </td><td><input type="text" class="numInputField" name="displaySetting[]" id="displayInfluanceMovDuration" size="3" maxlength="5" onkeypress="validateNumber(event)">days
            &nbsp; (<?php echo $sessionSetting['displayInfluanceMovDuration']; ?>days)</td>   
        </tr>
        <tr>
            <td><b>Web Traffic:</b></td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayBanWebTraffic" size="3" maxlength="5" onkeypress="validateNumber(event)">days
            &nbsp; (<?php echo $sessionSetting['displayBanWebTraffic']; ?>days)</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayMovWebTraffic" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayMovWebTraffic']; ?>%)</td>
        </tr>
        <tr>
            <td><b>Page viewed:</b></td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayBanPagesseen" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayBanPagesseen']; ?>%)</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayMovPagesSeen" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayMovPagesSeen']; ?>%)</td>
              
        </tr>
        <tr>
            <td><b>Time In Site:</b></td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayBanTimeInSite" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayBanTimeInSite']; ?>%)</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayMovTimeInSite" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayMovTimeInSite']; ?>%)</td>
              
        </tr>
        <tr>
            <td><b>Left Contact:</b></td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayBanLeftConn" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayBanLeftConn']; ?>%)</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayMovLeftConn" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayMovLeftConn']; ?>%)</td>
              
        </tr>
        <tr>
            <td><b>Mails Arrived:</b></td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayBanMail" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayBanMail']; ?>%)</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayMovMail" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayMovMail']; ?>%)</td>  
        </tr>
        <tr>
            <td><b>Mails Arrived:</b></td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayBanOnlineSales" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayBanOnlineSales']; ?>%)</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayMovOnlineSales" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayMovOnlineSales']; ?>%)</td>  
        </tr>
        <tr>
            <td><b>Mails Arrived:</b></td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayBanOfflineSales" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayBanOfflineSales']; ?>%)</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayMovOfflineSales" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayMovOfflineSales']; ?>%)</td>  
        </tr>
        <tr>
            <td><b>Mails Arrived:</b></td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayBanOtherSales" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayBanOtherSales']; ?>%)</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" class="numInputField" name="displaySetting[]" id="displayMovOtherSales" size="3" maxlength="5" onkeypress="validateNumber(event)">%
            &nbsp; (<?php echo $sessionSetting['displayMovOtherSales']; ?>%)</td>  
        </tr>
    </table>
</div>
<div id="seo" class="hiddenContainer">hi</div>
<div id="ppc" class="hiddenContainer">bye</div>
<input type="button" id="submitButton" class="newButton" style="display: none;" value="Save settings" onclick="saveSettings()"> <div id="loadingMessage"></div>

<script>
    function selectSetting(){
        
        var set = document.getElementById('selectSetting').value;
        switch (set){
            case 'general': document.getElementById('general').style.display = "block";
                            document.getElementById('email').style.display = "none";
                            document.getElementById('display').style.display = "none";
                            document.getElementById('seo').style.display = "none";
                            document.getElementById('ppc').style.display = "none";
                            document.getElementById('submitButton').style.display = "block";
                            break;
            case 'email':   document.getElementById('general').style.display = "none";
                            document.getElementById('email').style.display = "block";
                            document.getElementById('display').style.display = "none";
                            document.getElementById('seo').style.display = "none";
                            document.getElementById('ppc').style.display = "none";
                            document.getElementById('submitButton').style.display = "block";
                            break;
            case 'display': document.getElementById('general').style.display = "none";
                            document.getElementById('email').style.display = "none";
                            document.getElementById('display').style.display = "block";
                            document.getElementById('seo').style.display = "none";
                            document.getElementById('ppc').style.display = "none";
                            document.getElementById('submitButton').style.display = "block";
                            break;
            case 'SEO':     document.getElementById('general').style.display = "none";
                            document.getElementById('email').style.display = "none";
                            document.getElementById('display').style.display = "none";
                            document.getElementById('seo').style.display = "block";
                            document.getElementById('ppc').style.display = "none";
                            document.getElementById('submitButton').style.display = "block";
                            break;
            case 'PPC':     document.getElementById('general').style.display = "none";
                            document.getElementById('email').style.display = "none";
                            document.getElementById('display').style.display = "none";
                            document.getElementById('seo').style.display = "none";
                            document.getElementById('ppc').style.display = "block";
                            document.getElementById('submitButton').style.display = "block";
                            break;
            default:        document.getElementById('general').style.display = "none";
                            document.getElementById('email').style.display = "none";
                            document.getElementById('display').style.display = "none";
                            document.getElementById('seo').style.display = "none";
                            document.getElementById('ppc').style.display = "none";
                            document.getElementById('submitButton').style.display = "none";
                            break;
        }
            
    }
</script>
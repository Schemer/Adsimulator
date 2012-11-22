<?php
    require_once("classes/SessionClass.php");
    $sessionclass = new SessionClass();
?>

<form name="setSessionForm" id="setSessionForm" onsubmit="return sessionValidate(this);">
    
    <input type="hidden" name="tabID" value="adminMain"/>
    <input type='hidden' name='subID' value='createSession'/>
    <input type='hidden' name='create' value='ok'/>
    <input type="hidden" name="useSettingsFrom" value="set"/>
    
    <table>
        <caption style="text-align:left;"><h2>GENERAL SETTING:</h2></caption>
        <tr>
            <td valign="top">
                <table style="border: 1px solid black;" width="280">
                    <tr>
                        <td colspan="2"><b style="text-decoration: underline; font-size: 130%; color: navy"> Name & Date:</b></td>
                    </tr>
                    <tr>
                        <td>Session Name:</td>
                        <td><input class="numInputField" style="text-align:left;" name="generalSetting[]" id="sessionName" type="text" size="15" maxlength="20">   
                    </tr>
                    <tr>
                    <td>End Date:</td>
                        <td><input type='text' class="numInputField" size="8" name="generalSetting[]" id='endDate' readOnly>
                            <a href='javascript:void(0)' onClick='if(self.gfPop){
                                                 gfPop.fPopCalendar(document.setSessionForm.endDate);
                                                 return false;
                                              }' >
                            <img src='images/cal.gif' class='dateImage' alt='Click Here to Pick the date'></a></td>
                    </tr>
                    <tr>
                        <td>
                            Days per 24Hour:
                        </td>
                        <td><input type="text" size="3" maxlength="3" class="numInputField" 
                                   name="generalSetting[]" id="daysPerDay" onkeypress="validateNumber(event)" 
                                   onChange="calcsessionlength(value)">days</td>
                        
                    </tr>
                    
                </table>
            </td>
            <td>&nbsp;</td>
            <td valign="top">
                <table style="border: 1px solid black;" width="290">
                    <tr>
                        <td colspan="2"><b style="text-decoration: underline; font-size: 130%; color: navy">General Settings:</b></td>
                    </tr>
                    <tr>
                        <td>Admin name:</td>
                        <td>
                            <input type="text" name="generalSetting[adminName]" value="Admin"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Users can send messages:</td>
                        <td>
                            <label><input type="radio" name="generalSetting[userSendMsg]" value="yes"/>YES</label>
                            <label><input type="radio" name="generalSetting[userSendMsg]" value="no" checked/>NO</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Enable Agents:</td>
                        <td>
                            <label><input type="radio" name="generalSetting[activeAgent]" value="yes"/>YES</label>
                            <label><input type="radio" name="generalSetting[activeAgent]" value="no" checked/>NO</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Agent have Same name as user:</td>
                        <td>
                            <label><input type="radio" name="generalSetting[agentNameAsUser]" value="yes"/>YES</label>
                            <label><input type="radio" name="generalSetting[agentNameAsUser]" value="no" checked/>NO</label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="border: 1px solid black;">
        <caption style="text-align:left; "><h2>ECONOMY SETTINGS:</h2></caption>
        <tr>
            <td>Type of Business:</td>
            <td>
                <select name="generalSetting[]" id="businessType" onchange="newBusiness(value)">
                    <option value="0">select kind...</option>
                    <option value="computers">computers</option>
                    <option value="cars">cars</option>
                    <option value="medicine">medicine</option>
                    <option value="electronics">electronics</option>
                    <option value="other">other...</option>     
                </select>
            </td>
            <td><span id="newKindLabel" style="display:none">New Kind:</span></td>
            <td><input type="text" name="generalSetting[newKind]" id="newKind" size="10" style="display:none"></td>
        </tr>
        <tr>
            <td>Market type:</td>
            <td>
                <label><input type="radio" name="generalSetting[marketType]" id="same" value="same" checked onchange="cchange(this)"/>All same</label>
                <br><label><input type="radio" name="generalSetting[marketType]" id="3type" value="3type" onchange="cchange(this)"/>3 types</label>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Company size:</td>
            <td>Small: <input type="text" class="numInputField" name="generalSetting[]" id="smallCompany" size="1" maxlength="5" onkeypress="validateNumber(event)" disabled/>%</td>
            <td>Large: <input type="text" class="numInputField" name="generalSetting[]" id="largeCompany" size="1" maxlength="5" onkeypress="validateNumber(event)" disabled/>%</td>
            <td></td>
        </tr>
        <tr>
            <td>Deviation between users:</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="deviationBetweenUsers" size="3" maxlength="5" onkeypress="validateNumber(event)">%</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Sales:</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="sales" size="10" maxlength="12" onkeypress="validateNumber(event)"/>M$</td>
            <td>Advertising Budget:</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="advertiseBudget" size="3" maxlength="3" onkeypress="validateNumber(event)">%</td>

        </tr>
        <tr>
            <td>Scope of Product:</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="productPromoted" size="3" maxlength="3" onkeypress="validateNumber(event)">%</td>
            <td>Online/Offline ratio:</td>
            <td><input type="text" size="3" maxlength="3" class="numInputField" name="generalSetting[]" id="onlieOfflineRatio" onkeypress="validateNumber(event)">%</td>
        </tr>
        <tr>
            <td>Site Size:</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="siteSize" size="5" maxlength="5" onkeypress="validateNumber(event)"></td>
            <td>Traffic factor:</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="trafficFactor" size="3" maxlength="3" onkeypress="validateNumber(event)">%</td>
        </tr>
        <tr>
            <td>Page Seen(%):</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="pagesSeen" size="3" maxlength="3" onkeypress="validateNumber(event)">%</td>
            <td>Time In Site:</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="timeInSite" size="3" maxlength="3" onkeypress="validateNumber(event)">sec</td>
        </tr>
        <tr>
            <td>Mails Arrived(%):</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="mailsArived" size="3" maxlength="3" onkeypress="validateNumber(event)">%</td>
            <td>Left Contact Info(%):</td>
            <td><input type="text" class="numInputField" name="generalSetting[]" id="leftContact" size="3" maxlength="5" onkeypress="validateNumber(event)">%</td>
        </tr>
        <tr>
            <td>Search Engine Market Size:</td>
            <td><input type="text" size="11" maxlength="20" class="numInputField" name="generalSetting[]" id="SEMarketSize" onkeypress="validateNumber(event)"/></td>
            <td>Change per week:</td>
            <td><input type="text" size="3" maxlength="3" class="numInputField" name="generalSetting[]" id="SEMarketChange" onkeypress="validateNumber(event)"/>%</td>
        </tr>
        <tr>
            <td>PWeb Market Size:</td>
            <td><input type="text" size="11" maxlength="20" class="numInputField" name="generalSetting[]" id="PWebMarketSize" onkeypress="validateNumber(event)"/></td>
            <td>Change per week:</td>
            <td><input type="text" size="3" maxlength="3" class="numInputField" name="generalSetting[]" id="PWebMarketChange" onkeypress="validateNumber(event)"/>%</td>
        </tr>
        <tr>
            <td>Direct Access Market Size:</td>
            <td><input type="text" size="11" maxlength="20" class="numInputField" name="generalSetting[]" id="directAccessSize" onkeypress="validateNumber(event)"/></td>
            <td>Change per week:</td>
            <td><input type="text" size="3" maxlength="3" class="numInputField" name="generalSetting[]" id="directAccessChange" onkeypress="validateNumber(event)"/>%</td>
        </tr>
        <tr>
            <td>Email Market Size:</td>
            <td><input type="text" size="11" maxlength="20" class="numInputField" name="generalSetting[]" id="emailMarketSize" onkeypress="validateNumber(event)"/></td>
            <td>Change per week:</td>
            <td><input type="text" size="3" maxlength="3" class="numInputField" name="generalSetting[]" id="emailMarketChange" onkeypress="validateNumber(event)"/>%</td>
        </tr>
        <tr>
            <td>Media Market Size:</td>
            <td><input type="text" size="11" maxlength="20" class="numInputField" name="generalSetting[]" id="mediaMarketSize" onkeypress="validateNumber(event)"/></td>
            <td>Change per week:</td>
            <td><input type="text" size="3" maxlength="3" class="numInputField" name="generalSetting[]" id="mediaMarketChange" onkeypress="validateNumber(event)"/>%</td>
        </tr>
        <tr>
            <td>Competition Factor:</td>
            <td><input type="text" size="11" maxlength="10" class="numInputField" name="generalSetting[]" id="competitionFactor" onkeypress="validateNumber(event)"/></td>
            <td colspan="2"></td>
        </tr>

    </table>
    <table>
        <caption style="text-align:left;"><h2>CAMPAIGNS SETTING:</h2></caption>
        <tr>
            <td valign="top">
                <!-- e-Mail setting -->
                <table style="border: 1px solid black;">
                    <tr><td colspan="2"><b style="text-decoration: underline; font-size: 130%; color: navy"> E-Mail Campaign Settings:</b></td></tr>
                    <tr>
                        <td colspan="2">
                            <label><input type="radio" name="activeMail" id="emailDefault" value="default" checked onchange="cchange(this);">Default</label>
                            <label><input type="radio" name="activeMail" id="emailManual" value="manual" onchange="cchange(this);">Manual</label>
                        </td>
                    </tr>
                    <tr><td colspan="2"><b style="text-decoration: underline; color: green;">E-Mail Prices:</b></td></tr>
                    <tr>
                        <td id="oncePriceLabel">Email once Price:</td>
                        <td><input type="text" class="numInputField" disabled size="6" name="emailSetting[]" id="emailOncePrice" onkeypress="validateNumber(event)" maxlength="8"/>$</td>
                    </tr>
                    <tr>
                        <td id="dailyPriceLabel">Email daily Price:</td>
                        <td><input type="text" class="numInputField" disabled size="6" name="emailSetting[]" id="emailDailyPrice" onkeypress="validateNumber(event)" maxlength="8"/>$</td>
                    </tr>
                    <tr>
                        <td id="weeklyPriceLabel">Email weekly Price:</td>
                        <td><input type="text" class="numInputField" disabled size="6" name="emailSetting[]" id="emailWeeklyPrice" onkeypress="validateNumber(event)" maxlength="8"/>$</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b style="text-decoration: underline; color: green;">Influence Setting:</b></td>
                    </tr>
                    <tr>
                        <td id="emailDurationLabel">Duration:</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="emailSetting[]" id="emailInfluanceDuration" onkeypress="validateNumber(event)" maxlength="3"/>days</td>
                    </tr>
                    <tr>
                        <td id="emailWebTrafficLabel">Web Traffic (%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="emailSetting[]" id="emailWebTraffic" onkeypress="validateNumber(event)" maxlength="3" />%</td>
                    </tr>
                    <tr>
                        <td id ="emailPageLabel">Pages view change(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="emailSetting[]" id="emailPagesView" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="emailTimeLabel">Time in site(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="emailSetting[]" id="emailTimeInSite" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="emailLeftConnLabel">Left Connection(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="emailSetting[]" id="emailLeftConn" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="emailMailsLabel">Mails arrived (%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="emailSetting[]" id="emailMailsArrived" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="emailPurchaseLabel">Purchase on site(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="emailSetting[]" id="emailPurchaseOnSite" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="emailOfflineLabel">Offline sales(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="emailSetting[]" id="emailOfflineSales" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="emailOtherLabel">Other products sales(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="emailSetting[]" id="emailOtherSales" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                </table>
            </td>
            <td></td>
           <td valign="top">
                <!-- Display setting -->
                <table style="border: 1px solid black;">
                    <tr>
                        <td colspan="3"><b style="text-decoration: underline; font-size: 130%; color: navy"> Display Campaign Settings:</b></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <label><input type="radio" name="activeDisplay" id="displayDefault" value="default" checked onchange="cchange(this);">Default</label>
                            <label><input type="radio" name="activeDisplay" id="displayManual" value="manual" onchange="cchange(this);">Manual</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><b style="text-decoration: underline; color: green;">Display Prices:</b></td>
                    </tr>
                    <tr>
                        <td id="bannerPriceLabel">Banners Price:</td>
                        <td colspan="2"><input type="text" class="numInputField" disabled size="6" name="displaySetting[]" id="displayBannerPrice" onkeypress="validateNumber(event)" maxlength="8"/>$</td>
                    </tr>
                    <tr>
                        <td id="moviePriceLabel">Movies Price:</td>
                        <td colspan="2"><input type="text" class="numInputField" disabled size="6" name="displaySetting[]" id="displayMoivePrice" onkeypress="validateNumber(event)" maxlength="8"/>$</td>
                    </tr>
                    <tr><td colspan="3">
                        &nbsp;</td>
                        
                    </tr>
                    <tr>
                        <td colspan="3"><b style="text-decoration: underline; color: green;">Influence Setting:</b></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><u>BANNERS:</u></td>
                        <td><u>MOVIES:</u></td>
                    </tr>
                    <tr>
                        <td id="displayDurationLabel">Duration:</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayBanDuration" onkeypress="validateNumber(event)" maxlength="3"/>days</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayMovDuration" onkeypress="validateNumber(event)" maxlength="3"/>days</td>
                    </tr>
                    <tr>
                        <td id="displayWebTrafficLabel">Web Traffic (%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayBanWebTraffic" onkeypress="validateNumber(event)" maxlength="3" />%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayMovWebTraffic" onkeypress="validateNumber(event)" maxlength="3" />%</td>
                    </tr>
                    <tr>
                        <td id ="displayPageLabel">Pages view change(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayBanPage" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayMovPage" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
               
                    </tr>
                    <tr>
                        <td id ="displayTimeInSiteLabel">Time in site(%)</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayBanTimeInSite" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayMovTimeInSite" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="displayLeftConnLabel">Left Connection(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayBanLeftConn" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayMovLeftConn" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="displayMailsLabel">Mails arrived (%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayBanMails" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayMovMails" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="displayPurchaseLabel">Purchase on site(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayBanPurchase" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayMovPurchase" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                   
                    </tr>
                    <tr>
                        <td id ="displayOfflineLabel">Offline sales(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayBanOffline" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayMovOffline" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    
                    </tr>
                    <tr>
                        <td id ="displayOtherLabel">Other products sales(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayBanOtherSales" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="displaySetting[]" id="displayMovOtherSales" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td valign="top" colspan="3">
                <!-- Display setting -->
                <table style="border: 1px solid black;">
                    <tr>
                        <td colspan="3"><b style="text-decoration: underline; font-size: 130%; color: navy"> S.E.O Campaign Settings:</b></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <label><input type="radio" name="activeSEO" id="seoDefault" value="default" checked onchange="cchange(this);">Default</label>
                            <label><input type="radio" name="activeSEO" id="seoManual" value="manual" onchange="cchange(this);">Manual</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><b style="text-decoration: underline; color: green;">S.E.O Prices:</b></td>
                    </tr>
                    <tr>
                        <td id="simplePriceLabel">Simple SEO  Price:</td>
                        <td colspan="2"><input type="text" class="numInputField" disabled size="6" name="seoSetting[]" id="seoSimplePrice" onkeypress="validateNumber(event)" maxlength="8"/>$</td>
                    </tr>
                    <tr>
                        <td id="complexPriceLabel">Complex SEO Price:</td>
                        <td colspan="2"><input type="text" class="numInputField" disabled size="6" name="seoSetting[]" id="seoComplexPrice" onkeypress="validateNumber(event)" maxlength="8"/>$</td>
                    </tr>
                    <tr><td colspan="3">
                        &nbsp;</td>
                        
                    </tr>
                    <tr>
                        <td colspan="3"><b style="text-decoration: underline; color: green;">Influence Setting:</b></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><u>BANNERS:</u></td>
                        <td><u>MOVIES:</u></td>
                    </tr>
                    <tr>
                        <td id="seoDurationLabel">Duration:</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoSimpleDuration" onkeypress="validateNumber(event)" maxlength="3"/>days</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoComplexDuration" onkeypress="validateNumber(event)" maxlength="3"/>days</td>
                    </tr>
                    <tr>
                        <td id="seoWebTrafficLabel">Web Traffic(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoSimpleWebTraffic" onkeypress="validateNumber(event)" maxlength="3" />%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoComplexWebTraffic" onkeypress="validateNumber(event)" maxlength="3" />%</td>
                    </tr>
                    <tr>
                        <td id ="seoPageLabel">Pages view change(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoSimplePage" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoComplexPage" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
               
                    </tr>
                    <tr>
                        <td id ="seoTimeInSiteLabel">Time in site(%)</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoSimpleTimeInSite" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoComplexTimeInSite" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="seoLeftConnLabel">Left Connection(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoSimpleLeftConn" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoComplexLeftConn" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="seoMailsLabel">Mails arrived (%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoSimpleMails" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoComplexMails" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    </tr>
                    <tr>
                        <td id ="seoPurchaseLabel">Purchase on site(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoSimplePurchase" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoComplexPurchase" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                   
                    </tr>
                    <tr>
                        <td id ="seoOfflineLabel">Offline sales(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoSimpleOffline" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoComplexOffline" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    
                    </tr>
                    <tr>
                        <td id ="seoOtherLabel">Other products sales(%):</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoSimpleOtherSales" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                        <td><input type="text" size="1" class="numInputField" disabled name="seoSetting[]" id="seoComplexOtherSales" onkeypress="validateNumber(event)" maxlength="3"/>%</td>
                    
                    </tr>
                </table>
            </td></tr>
        
    </table>
    <input type="submit" value="Create">
</form>

<iframe width=188 height=166 name='gToday:datetime:agenda.js' id='gToday:datetime:agenda.js' src='ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'></iframe><iframe width=188 height=166 name='gToday:datetime:agenda.js' id='gToday:datetime:agenda.js' src='ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:fixed; top:-500px; left:-500px;'></iframe>
    
<script type="text/javascript">  
    function sessionValidate(){
        
        var general = document.getElementsByName("generalSetting[]");
        var mail = document.getElementsByName('activeMail');
        var emailSetting = document.getElementsByName("emailSetting[]");
        var display = document.getElementsByName('activeDisplay');
        var displaySetting = document.getElementsByName("displaySetting[]");
        var seo = document.getElementsByName('activeSEO');
        var seoSetting = document.getElementsByName("seoSetting[]");
        var msg="";
        var index = 0;
        var valid=true;
        
        for (index=0;index<general.length;index++){
            switch (general[index].id){
                case 'sessionName':{                      
                    if (general[index].value!=""){
                        var newName = general[index].value;
                        var names = "<?php echo $sessionclass->getAllSessionNames() ?>";
                        var listnames = names.split(';;');
                        var i=0;
                        for (i=0;i<listnames.length;i++){
                            if (listnames[i] == newName){
                                msg += "\nERROR: Session name already exits, type new name";
                                break;
                            }
                        }   
                    }
                    else { msg += "\nERROR: Session name is empty, please enter name";}
                    break;
                }
                case 'endDate':{ 
                    if (general[index].value =="") {
                        msg += "\nERROR: End Date field is empty, please select date";}
                    break;
                }
                case 'businessType':{
                    if (general[index].value=='0'){
                        msg+="\nERROR: Business kind didn't selected, please select kind";
                    }
                    if (general[index].value=='other' && document.getElementById('newKind').value == ''){
                        msg+="\nERROR: New kind field is empty,  please fill new kind or select kind from list";
                    }  
                    break;
                }
                default:{
                    if (general[index].value==""){
                        
                        if ((general[index].id != 'smallCompany') && (general[index].id != 'largeCompany' )){
                            msg+="\nERROR: "+general[index].id+" is empty, please enter value";                    
                        }
                        else if (document.getElementById('3type').checked == true)
                            msg+="\nERROR: "+general[index].id+" is empty, please enter value"
                            
                    }
                    else if (isNaN(general[index].value)==true){
                        msg+="\nERROR:"+general[index].id+" is not a number, please enter compatible number";                
                    }
                    break;
                }
            }
        }
        
        if (mail['emailManual'].checked){
            for (index=0;index<emailSetting.length;index++){
                if (emailSetting[index].value == ""){
                    msg +=  "\nERROR: "+emailSetting[index].id+" is empty, please enter value";
                }
                else if (isNaN(emailSetting[index].value)==true){
                    msg+="\nERROR: "+emailSetting[index].id+" is not a number, please enter compatible number";                     
                }
            }
        }
        
        if (display['displayManual'].checked){
            for (index=0;index<displaySetting.length;index++){
                if (displaySetting[index].value == ""){
                    msg +=  "\nERROR: "+displaySetting[index].id+" is empty, please enter value";
                }
                else if (isNaN(displaySetting[index].value)==true){
                    msg+="\nERROR: "+displaySetting[index].id+" is not a number, please enter compatible number";                     
                }
            }
        }
        
        if (seo['seoManual'].checked){
            for (index=0;index<seoSetting.length;index++){
                if (seoSetting[index].value == ""){
                    msg +=  "\nERROR: "+seoSetting[index].id+" is empty, please enter value";
                }
                else if (isNaN(seoSetting[index].value)==true){
                    msg+="\nERROR: "+seoSetting[index].id+" is not a number, please enter compatible number";                     
                }
            }
        }
        
        if (msg !=""){
            alert (msg);
            valid =false;
        }
        else{
            for (index=0;index<general.length;index){
                
                general[index].name = 'generalSetting['+general[index].id+']';
            }
            for (index=0;index<emailSetting.length;index){
                emailSetting[index].name = 'emailSetting['+emailSetting[index].id+']';
            }
            for (index=0;index<displaySetting.length;index){
                displaySetting[index].name = 'displaySetting['+displaySetting[index].id+']';
            }
            for (index=0;index<seoSetting.length;index){
                seoSetting[index].name = 'seoSetting['+seoSetting[index].id+']';
            }
        }
        return valid;
    }
    
    function cchange(type){
        var i;
        switch (type.name){
            case 'activeMail':
                if (type.value == 'manual'){
                   for (i=0;i<document.setSessionForm.elements['emailSetting[]'].length;i++)
                       document.setSessionForm.elements['emailSetting[]'].item(i).disabled = false;                  
                }
                else{
                   for (i=0;i<document.setSessionForm.elements['emailSetting[]'].length;i++)
                       document.setSessionForm.elements['emailSetting[]'].item(i).disabled = true;                   
                }
                break;
            case 'generalSetting[marketType]':
                if (type.value == '3type'){
                    document.setSessionForm.smallCompany.disabled = false;
                    document.setSessionForm.largeCompany.disabled = false;
                }
                else{
                    document.setSessionForm.smallCompany.disabled = true;
                    document.setSessionForm.largeCompany.disabled = true; 
                }
                break;
            case 'activeDisplay':
                if (type.value == 'manual'){
                    for (i=0;i<document.setSessionForm.elements['displaySetting[]'].length;i++)
                        document.setSessionForm.elements['displaySetting[]'].item(i).disabled = false;
                }
                else{
                   for (i=0;i<document.setSessionForm.elements['displaySetting[]'].length;i++)
                       document.setSessionForm.elements['displaySetting[]'].item(i).disabled = true;                   
                }
            case 'activeSEO':
                if (type.value == 'manual'){
                    for (i=0;i<document.setSessionForm.elements['seoSetting[]'].length;i++)
                        document.setSessionForm.elements['seoSetting[]'].item(i).disabled = false;
                }
                else{
                   for (i=0;i<document.setSessionForm.elements['seoSetting[]'].length;i++)
                       document.setSessionForm.elements['seoSetting[]'].item(i).disabled = true;                   
                }
        }
    }
    
function calcsessionlength(value){
    var date = document.getElementById('endTime').value;
    var d= date.split("/");
    var date1= new Date(d[2],d[1]-1,d[0]);
    var days;
   
       // The number of milliseconds in one day
        var ONE_DAY = 1000 * 60 * 60 * 24

         // Convert both dates to milliseconds
        var date1_ms = date1.getTime()
        var date2_ms = today.getTime()

    // Calculate the difference in milliseconds
        var difference_ms = Math.abs(date1_ms - date2_ms);
    
        // Convert back to days and return
        alert (value*Math.round(difference_ms/ONE_DAY));
        
}

function newBusiness(value){
    if (value=='other'){
        document.getElementById('newKind').style.display = "block";
        document.getElementById('newKindLabel').style.display = "block";
    }
    else{
        document.getElementById('newKind').style.display = "none";
        document.getElementById('newKindLabel').style.display = "none";
        document.getElementById('newKind').value = "";
    }
}
</script>
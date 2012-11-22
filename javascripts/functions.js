/////////////////// General javascript function/////////////////////

// returns an xmlhttp object for use in Ajax based functions
function getAjaxObject() {
    try {
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            return new XMLHttpRequest();
        } else {// code for IE6, IE5
            return new ActiveXObject("Microsoft.XMLHTTP");
        }
    }catch (err) {
        alert(err.description);
    }
}

// Returns a timestamp. Used to avoid IE caching Ajax requests.
function getTimestamp(){
    tstmp = new Date();    
    return tstmp.getTime();
} 
// Creates a new user visit whenever a user logs in to the website
function createVisit(userID, page) {
    var xmlhttp = getAjaxObject();
    xmlhttp.onreadystatechange=function()
    {
        
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.location.href=page;
        }
    }
    
    xmlhttp.open("GET", "updateDB.php?avoidcache=" + getTimestamp() + "&func=createVisit&id=" + userID, true);
    
    xmlhttp.send();
}

// Stores current time and date in session variables
function storeDatetime() {
    var xmlhttpobj = getAjaxObject();
    
    xmlhttpobj.onreadystatechange=function()
    {
        if (xmlhttpobj.readyState==4 && xmlhttpobj.status==200)
        {
            datetime = xmlhttpobj.responseText.split(" ");
            var theTime = Number(datetime[0]);  // Typecast the time from string to integer before passing it to setTopNavTime
            var theDate = datetime[1];
           // setTopNavTime(0,theTime, theDate,1);    // datetime[0] contains timestamp, datetime[1] contains date
        }
    }
    xmlhttpobj.open("GET", "updateDB.php?avoidcache=" + getTimestamp() + "&func=storeDatetime", false);
    xmlhttpobj.send();
}

// Updates user's visit details in the DB
function updateVisit(userID) {
    var xmlhttp = getAjaxObject();
    xmlhttp.open("GET", "updateDB.php?avoidcache=" + getTimestamp() + "&func=updateVisit&id=" + userID, true);
    xmlhttp.send();
}

// Updates top nav bar's time & date
function setTopNavTime(startTime,topNavTime, topNavDate, timeFactor){
    var currentTime = new Date();
    if (startTime != 0){
        var passTime = (topNavTime-startTime)*timeFactor;
        var years = (passTime/86400)/360;
        var year = Math.floor(years)+1;
        var month = Math.floor((years- Math.floor(years))*12)+1;
        var days =Math.floor(((years- Math.floor(years))*360)-(month-1)*30+1);
        var hour = Math.floor((((passTime / (86400))-(days-1+(month-1)*30+(year-1)*360)))*24);
        var minute = Math.floor((((passTime / (86400))-(days-1+(month-1)*30+(year-1)*360))*24 - hour)*60);
        if (hour < 10) {hour = '0' + hour;}
        if (minute < 10) {minute = '0' + minute;}
        if (days <10){days = '0' + days;}
        if (month < 10){month = '0' + month;}
        if (year < 10){year = '0' +year;}
       
        document.getElementById('simulateTime').innerHTML = 'Session Date & Time: ' +days+ '/' +month + '/' + year + '&nbsp;&nbsp;' + hour + ':' + minute; 
    }
    currentTime.setTime(topNavTime*1000);
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();
    var seconds = currentTime.getSeconds();
    if (hours < 10) { // Adds leading 0 to hours
        hours = '0' + hours;
    }
    if (minutes < 10) { // Adds leading 0 to minutes
        minutes = '0' + minutes;
    }
    if (seconds < 10) { // Adds leading 0 to seconds
        seconds = '0' + seconds;
    }
    topNavTime++;
    
    document.getElementById('serverTimer').innerHTML = 'Real Time: ' + topNavDate + '&nbsp;&nbsp;' + hours + ':' + minutes + ':' + seconds;
    setTimeout("setTopNavTime("+startTime+", "+ topNavTime +", '"+ topNavDate +"', "+timeFactor+")",1000);    
}

function chooseMailType(type, price)
{
    
    var p = price.split(";");
    
    switch (type){
         case 'once':
                document.getElementById('duration').value = 0;
                document.getElementById('typePrice').style.display = "block";
		document.getElementById('typePrice').innerHTML="Price for once: <br/>";
		document.getElementById('totalPrice').style.display = "none";
		document.getElementById('price').value = p[0];
		document.getElementById('numDaysWeeks').style.display = "none";
		break;
         case 'daily':
		document.getElementById('typePrice').style.display = "block";
		document.getElementById('typePrice').innerHTML="Price for a day: <br/>";
		document.getElementById('numDaysWeeks').style.display = "block";
		document.getElementById('duration').value = "";
		document.getElementById('totalPrice').style.display = "block";
		document.getElementById('price').value = p[1];
		document.getElementById('totalCampaignCost').value = "";
		break;
         case 'weekly':
                document.getElementById('typePrice').style.display = "block";
		document.getElementById('typePrice').innerHTML="Price for a week: <br/>";
		document.getElementById('totalPrice').style.display = "block";
                document.getElementById('price').value = p[2];
                document.getElementById('duration').value = "";
		document.getElementById('numDaysWeeks').style.display = "block";
		document.getElementById('totalCampaignCost').value = "";
		break;
        default:
		document.getElementById('typePrice').innerHTML="";
                document.getElementById('typePrice').style.display = "none";
                document.getElementById('totalPrice').style.display = "none";
                document.getElementById('numDaysWeeks').style.display = "none";
                break;
    }
    if (type!=''){
        document.getElementById('emailPrice').style.display = "block";
    }
    else{
        document.getElementById('emailPrice').style.display = "none";
    }
}


function chooseSeoType(type, price)
{
    
    var p = price.split(";");
    switch (type){
         case 'simple':
                //document.getElementById('duration').value = 0;
                document.getElementById('typePrice').style.display = "block";
		document.getElementById('typePrice').innerHTML="Price for one week\n: <br/>";
                document.getElementById('numWeeks').style.display = "block";
                document.getElementById('totalPrice').style.display = "block";
		document.getElementById('price').value = p[0];
                document.getElementById('totalCampaignCost').value = "";
		break;	
         case 'complex':
                document.getElementById('typePrice').style.display = "block";
		document.getElementById('typePrice').innerHTML="Price for one week\n: <br/>";
                document.getElementById('numWeeks').style.display = "block";
                document.getElementById('totalPrice').style.display = "block";
		document.getElementById('price').value = p[1];
                document.getElementById('totalCampaignCost').value = "";
		break;
        default:
		document.getElementById('typePrice').innerHTML="";
                document.getElementById('seoPrice').style.display = "none";
                document.getElementById('totalPrice').style.display = "block";
                document.getElementById('totalPrice').style.display = "none";
                document.getElementById('numWeeks').style.display = "none";
                break;
    }
    if (type!=''){
        document.getElementById('seoPrice').style.display = "block";
    }
    else{
        document.getElementById('seoPrice').style.display = "none";
    }
}


function makePpcBid(value)
{
    switch (value){
        case '':
            document.getElementById('ppcDetails').style.display = "none";
            document.getElementById('ppcPrice').style.display = "none";
            document.getElementById('totalCost').style.display = "none";
            break;
        default:
            document.getElementById('ppcDetails').style.display = "block";
            document.getElementById('ppcPrice').style.display = "block";
            document.getElementById('totalCost').style.display = "block";
            document.getElementById('phrase').value = value;
            break;
    }       
}

/*function isaDigit()
{
  var val;
 
  if (field.value == '')
      return alert('No value entered....');
 
  val = parseInt(field.value);
  if (isNaN(val))
      return alert('Non-integer value....');
 
  if (val != form.value)
      return alert('Not an integer.......');
 
  if (val <= 0)
      return alert('Please, enter positive value...');
}

function choosePpcCategory(value)
{
    switch (value){
        case '':
            document.getElementById('ppcCategory').style.display = "none";
            document.getElementById('ppcDetails').style.display = "none";
            document.getElementById('ppcPhrase').style.display = "none";
            break;
        default:
            document.getElementById('ppcCategory').style.display = "block";
            document.getElementById('ppcDetails').style.display = "none";
            break;
    }
       
}*/

function ppcChoosePhrase(value) {
    switch (value){
        case '':
            document.getElementById('ppcPhrase').style.display = "none";
            document.getElementById('ppcDetails').style.display = "none";
            break;
        default:
            document.getElementById('ppcPhrase').style.display = "block";
            document.getElementById('ppcDetails').style.display = "none";
            break;
    }
   
    var xmlhttp = getAjaxObject();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("ppcPhrase").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "updateDB.php?avoidcache=" + Math.random() + "&func=ppcChoosePhrase" + "&se=" + value, true);
    xmlhttp.send();
    return false;
}


function chooseDisplayType(type, price)
{
    
    var p = price.split(";");
    
    switch (type){
         case 'banner':
                document.getElementById('typePrice').style.display = "block";
                document.getElementById('typePrice').innerHTML="Price for Banners per Day: <br/>";
		document.getElementById('numDays').style.display = "block";
		document.getElementById('duration').value = "";
                document.getElementById('totalPrice').style.display = "block";
                document.getElementById('price').value = p[0];
                document.getElementById('totalCampaignCost').value = "";
		break;
         case 'movie':
                document.getElementById('typePrice').style.display = "block";
		document.getElementById('typePrice').innerHTML="Price for a Movies per Day: <br/>";
		document.getElementById('numDays').style.display = "block";
		document.getElementById('duration').value = "";
		document.getElementById('totalPrice').style.display = "block";
		document.getElementById('price').value = p[1];
		document.getElementById('totalCampaignCost').value = "";
				break;
         
        default:
		document.getElementById('typePrice').innerHTML="";
                document.getElementById('typePrice').style.display = "none";
                document.getElementById('totalPrice').style.display = "none";
          
                break;
    }
    if (type!=''){
        
        document.getElementById('displayPrice').style.display = "block";alert ('hi')
    }
    else{
        document.getElementById('displayPrice').style.display = "none";
    }
}

function calcCampaignPrice(){
    
    var basePrice = document.getElementById('price').value;
    var time = document.getElementById('duration').value;
    document.getElementById('totalCampaignCost').value= time*basePrice;
    document.getElementById('totalCampaignCost').style.visibility = "visible";
}

//function ca

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode == 8 || event.keyCode == 46
        || event.keyCode == 37 || event.keyCode == 13) 
    {
        if (event.keyCode == 13)
        { 
          window.event.keyCode=9; // IE
        }
        return true;
    }
    else if ( key < 48 || key > 57 ) {
        event.preventDefault();
        return false;
    }
    else return true;
}

function validate(type)
{
    var valid = true;
    var today = document.getElementById('startTime').value; // get time from server
    alert(today)
    switch (type){
        case 'email':
            var subType = document.getElementById('emailType').value; 
            if (document.getElementById('duration').value == ""){
                alert ("Invalid duration selected\nplease select new duration");
                valid=false;
            }
            else {
                document.getElementById('subType').value = subType; // send subtype
                document.getElementById('startTime').value = today; // send starting time
                if (subType == 'once'){ 
                    document.getElementById('totalCost').value = document.getElementById('price').value;
                }
                else{
                    document.getElementById('totalCost').value = document.getElementById('totalCampaignCost').value;
                }
                if (subType == 'weekly'){
                    document.getElementById('duration').value *= 7;
                }
            }
            break;
        case 'seo':
            
            subType = document.getElementById('seoType').value; 
            if (document.getElementById('duration').value == ""){
                alert ("Invalid duration selected\nPlease select new duration");
                valid=false;
            }
            else {
                document.getElementById('startTime').value = today;
                //document.getElementById('endTime').value = document.getElementById('seoEndTime').value;
                document.getElementById('totalCost').value = document.getElementById('totalCampaignCost').value;
                document.getElementById('subType').value = subType;
                document.getElementById('duration').value *= 7;
           }
            break;
        case 'ppc':
            if (document.getElementById('maxBid').value == ""){
                alert ("Invalid bid selected\nPlease select new bid");
                valid=false;
                }
            else if (document.getElementById('ppcBudget').value == ""){
                    alert ("Invalid budget selected\nPlease select new budget");
                    valid=false;
                 }
                 else if (document.getElementById('maxBid').value > document.getElementById('ppcBudget').value){
                     alert ("Budget has to be grater than your bid\nPlease select new budget");
                     valid = false;
                 }
            if(document.getElementById('external').checked){
                 document.getElementById('totalCost').value = parseInt(document.getElementById('ppcBudget').value) + parseInt(document.getElementById('externPrice').value);
            }
            else document.getElementById('totalCost').value = document.getElementById('ppcBudget').value
            //SubType will be as SE site
            document.getElementById('subType').value = document.getElementById('seType').value;
            //Duration will be as maxBid
            document.getElementById('duration').value = document.getElementById('maxBid').value;
            document.getElementById('startTime').value = today;
            break;
        case 'display':
            subType = document.getElementById('displayType').value; 
            if (document.getElementById('duration').value == ""){
                alert ("Invalid duration selected\nplease select new duration");
                valid=false;
            }
            else {
                document.getElementById('subType').value = subType; // send subtype
                document.getElementById('startTime').value = today; // send starting time
                document.getElementById('totalCost').value = document.getElementById('totalCampaignCost').value;
                             
            }
            break;
            
    }
    return valid;
    
}

function showInfo(select) {
    document.getElementById("campaignInfoButton").style.display = "none";
    document.getElementById("realDateContainer").style.display = "none";
    document.getElementById("campaignInfoButton").style.display = "none";
    if (select != "chooseInfo") {
        document.getElementById("campaignsTable").style.display = "block";
        document.getElementById("realDateContainer").style.display = "block";
        document.getElementById("campaignInfoButton").style.display = "block";
    } else {
        document.getElementById("campaignsTable").style.display = "none";
        document.getElementById("realDateContainer").style.display = "none";
        document.getElementById("campaignInfoButton").style.display = "none";
    }
}

function selectTimeType(select){
    switch (select){
        case "chooseInfo":
            document.getElementById("campaignInfoButton").style.display = "none";
            document.getElementById("realDateContainer").style.display = "none";
            document.getElementById("simDateContainer").style.display = "none";
            break;
        case "realTime":
            document.getElementById("realDateContainer").style.display = "block";
            document.getElementById("simDateContainer").style.display = "none";
            document.getElementById("campaignInfoButton").style.display = "block";
            break;
        case "simTime":
            document.getElementById("realDateContainer").style.display = "none";
            document.getElementById("simDateContainer").style.display = "block";
            document.getElementById("campaignInfoButton").style.display = "block";
            break;
    }
}

function dateFormat(date){
    newDate = date.split("/");
    date = newDate[2] + "-" + newDate[1] + "-" + newDate[0];
    return date;
}

function showCampaignsInfo() {
    var selectValue = document.getElementById("campaignInfoSelect").value;
    var fromDate = document.getElementById("fromRealDate").value;
    document.getElementById("campaignsTable").innerHTML = "";
    var xmlhttp = getAjaxObject();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("campaignsTable").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "getCampaignsInfo.php?avoidcache=" + getTimestamp() + "&stats=" + selectValue +"&from=" + fromDate +"&job=inner", true);
    xmlhttp.send();
    return false;
}


function showCampaigns()
{
    var fromDate = document.getElementById('fromDate').value;
    
    //fromDate = dateFormat(fromDate);
    
    var xmlhttp=getAjaxObject();    
    if (fromDate=="")
    {
        fromDate = '01/01/2001';
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("replaceCampaignsDiv").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","getAdminCampaigns.php?avoidcache=" + getTimestamp() + "&fromDate="+fromDate+"&job='build'",true);
    xmlhttp.send();
    return false;
}

// Presents info on the currently viewed session in Sessions menu
function changeActiveSession() {
    var xmlhttp = getAjaxObject();
    var e = document.getElementById("viewedSession");
    var viewedSession = e.options[e.selectedIndex].value;
    
    xmlhttp.open("GET", "updateDB.php?avoidcache="+getTimestamp()+"&func=changeActiveSession"+"&session="+viewedSession, true);
    xmlhttp.send();
        
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            if(viewedSession == "0") { // If selected option is ALL (sessions)
                document.getElementById("sessionID").innerHTML = "---";
                document.getElementById("sessionDesc").innerHTML = "---";
                document.getElementById("sessionStart").innerHTML = "---";
                document.getElementById("sessionEnd").innerHTML = "---";
            } else {
                var getResponse = xmlhttp.responseText;
                var sessionInfo = getResponse.split("^");
                document.getElementById("sessionID").innerHTML = sessionInfo[0];
                document.getElementById("sessionDesc").innerHTML = sessionInfo[1];
                document.getElementById("sessionStart").innerHTML = sessionInfo[2];
                document.getElementById("sessionEnd").innerHTML = sessionInfo[3];
            }
        }
    }  
}

function showSessionSettings(selectedSession){
    var xmlhttp = getAjaxObject();
    xmlhttp.open("GET", "updateDB.php?avoidcache="+getTimestamp()+"&func=getSessionsSettings"+"&session="+selectedSession, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("sessionDetailsCont").innerHTML = xmlhttp.responseText;
            document.getElementById("sessionDetailsCont").style.display = "block";
        }
    }  
}

// Close session
function closeSession($sessionID){
    var answer = confirm("Are you sure you want to close the session?");
    if(!answer) {
        return;
    }
    var xmlhttp = getAjaxObject();
    xmlhttp.open("GET", "updateDB.php?avoidcache="+getTimestamp()+"&func=closeSession"+"&session="+$sessionID, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("s" + $sessionID).innerHTML = "Closed<br><div class='openSessionButton' onclick=\"openSession('"+$sessionID+"')\">(Open)</div>";
            document.getElementById("end" + $sessionID).innerHTML = xmlhttp.responseText;
        }
    }
}


// Open session
function openSession($sessionID){
    var answer = confirm("Are you sure you want to open the session?");
    if(!answer) {
        return;
    }
    var currentDate = new Date();
    var endDate = new Date();
    var ok=false;
    
    while (ok==false){
        var newDate = prompt("Plese Enter Date:\n(format:DD/MM/YYYY):");
        newDate = newDate.split("/");
        
               endDate =new Date(newDate[2],newDate[1]-1,newDate[0]);
               
               if (endDate > currentDate) 
                   ok=true;
               else
                   ok=false;
    }
    var xmlhttp = getAjaxObject();
    xmlhttp.open("GET", "updateDB.php?avoidcache="+getTimestamp()+"&func=openSession"+"&session="+$sessionID+"&endDate="+endDate.getTime()/1000, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("s" + $sessionID).innerHTML = "Open<br><div class='closeSessionButton' onclick=\"closeSession('"+$sessionID+"')\">(Close)</div>";
            document.getElementById("end" + $sessionID).innerHTML = xmlhttp.responseText;//"---";
        }
    }
}

// Toggle all checkboxes in messages menu
function toggleAllMessages() {
    var c = new Array();
    checked = document.getElementById("checkAllMessages").checked;
    c = document.getElementsByTagName('input');
    for (var i = 0; i < c.length; i++){
        if (c[i].type == 'checkbox'){
          if(checked == true){
            c[i].checked = true;
          } else {
              c[i].checked = false;
          }
        }
    }
}


// Send a message to a user
function sendMessage(){
    var selectBox = document.getElementById("userSelect");
    var sendTo = selectBox.options[selectBox.selectedIndex].value;
    var subject = document.getElementById("messageSubject").value;
    var content = document.getElementById("sendMessageText").value;
    
    var xmlhttp = getAjaxObject();
    xmlhttp.open("GET","updateDB.php?avoidcache=" + getTimestamp() + "&func=sendMessage&sendTo=" + sendTo +
                        "&subject=" + subject + "&content=" + content, true);
    xmlhttp.send();
    document.getElementById("displayNotification").innerHTML = "<img src='images/loading.gif'/> Sending message...";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            if(xmlhttp.responseText == "0") {
                document.getElementById("displayNotification").innerHTML = "Error: could not send message."
            } else {
                document.getElementById("displayNotification").innerHTML = "Message sent!";
            }
        }
    }
}

// Delete checked messages
function deleteMessages() {
    
    var xmlhttp = getAjaxObject();
    var c = new Array();
    c = document.getElementsByTagName('input');
    for (var i = 0; i < c.length; i++){
        
        if ((c[i].type == 'checkbox') && (c[i].checked == true)&& (c[i].id != 'checkAllMessages')){
            //alert (c[i].id);
            xmlhttp.open("GET","updateDB.php?avoidcache=" + getTimestamp() + "&func=deleteMessage&id="+c[i].id, false);
            xmlhttp.send();
        }
    }
    window.location.reload( false );
}

// Gets information to populate statistics page according to the selected option
function statSelectChange() {
    var selectValue = document.getElementById("statOption").value;
    var fromDate = document.getElementById("statsFromDate").value;
    var toDate = document.getElementById("statsToDate").value;
    // Checking if From & To dates were picked
    if(fromDate == "" || toDate == "") {
        document.getElementById("statsErrors").innerHTML = "<h3>**Please choose From and To dates</h3>";
        return false;
    }
    var fromDateSplit = fromDate.split(" ");
    fromDate = dateFormat(fromDateSplit[0]) + " " + fromDateSplit[1]; // Properly reformatting From date for MySQL
    var toDateSplit = toDate.split(" ");
    toDate = dateFormat(toDateSplit[0]) + " " + toDateSplit[1];    //Properly reformatting To date for MySQL
    var xmlhttp = getAjaxObject();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            if(xmlhttp.responseText == "") {
                document.getElementById("statsErrors").innerHTML = "<h3>**No activity for the specified time</h3>";
                document.getElementById("statsChartContainer").innerHTML = xmlhttp.responseText;
            } else {
                document.getElementById("statsErrors").innerHTML = "";
                document.getElementById("statsChartContainer").innerHTML = xmlhttp.responseText;
            }
        }
    }
    xmlhttp.open("GET", "getStats.php?avoidcache=" + getTimestamp() + "&stats=" + selectValue +"&from=" + fromDate + "&to=" + toDate, true);
    xmlhttp.send();
    return false;
}

function saveSettings() {
    var xmlhttp = getAjaxObject();
    
    var setting, setting2,setting3,setting4,setting5;
    var setTable = document.getElementById('selectSetting').value;
    var setArray = new Array();
    
    switch (setTable){
        case 'general':
            var index=0;
            setting = document.getElementsByName("generalSetting[]");
            setting2 = document.getElementsByName("generalSetting[adminName]");
            setting3 = document.getElementsByName("generalSetting[userSendMsg]");
            setting4 = document.getElementsByName("generalSetting[activeAgent]");
            setting5 = document.getElementsByName("generalSetting[agentNameAsUser]");
            for (i = 0; i < setting.length; i++)
                 setArray[index++] = setting[i];
            setArray[index] = setting2[0];
            setArray[index++].id = 'adminName';
            setArray[index] = setting3[0].checked ? setting3[0] : setting3[1];
            setArray[index++].id = 'userSendMsg';
            setArray[index] = setting4[0].checked ? setting4[0] : setting4[1];
            setArray[index++].id = 'activeAgent';
            setArray[index] = setting5[0].checked ? setting5[0] : setting5[1];
            setArray[index++].id = 'agentNameAsUser';
            break;
        case 'email':
            setArray = document.getElementsByName("emailSetting[]");
            break;
        case 'display':
            setArray = document.getElementsByName("displaySetting[]");
            break;
        case 'SEO':
            setArray = document.getElementsByName("seoSetting[]");
            break;
        case 'PPC':
            setArray = document.getElementsByName("ppcSetting[]");
            break;
    }
    var content = "updateDB.php?avoidcache="+getTimestamp()+"&func=saveSettings&setTable="+setTable;
       for (index=0;index<setArray.length;index++){
           content +="&"+setArray[index].id+"="+setArray[index].value;   
       }
        
    document.getElementById('loadingMessage').innerHTML = "<img src='images/loading.gif' alt='loading'/> Saving settings...";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('loadingMessage').innerHTML = "Settings saved.";  
	}  
    }
    xmlhttp.open("GET", content, true);
    xmlhttp.send();
}





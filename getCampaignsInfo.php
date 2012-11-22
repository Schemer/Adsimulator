<?php

    if ($_GET['job']=='export'){
        $filename ="auctionsInfo.xls";
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$filename);
    }
    
    ini_set("precision", "2"); // Sets floating point numbers' precision
    
    require_once('initdb.php');
    require_once('classes/AdminClass.php');
    
    $adminClass = new AdminClass();
    if($_GET['stats']=="specificInfo") {    
        $content = "
                <br/>
                <table id='CampaignInfoTable' class='campaignListTable'>
                    <tr class='campaignListCat'>
                            <td class='idTag'>Campaign ID</td>
                            <td>USER</td>
                            <td>Price</td>     
                            <td>Type</td>
                            <td>Status</td>
                    </tr>"; 
                        
        $result = $adminClass->getAllCampaignList($_GET['from']);
        $num = mysql_num_rows($result);
        if ($num==0){
            $content = $content . "<b>** No campaigns found</b>";
        } else {
            while($row = mysql_fetch_array($result)){
                $content = $content .  "
                    <tr class='.adminCampaignLines'>
                    <td class='idTag'>".$row['campaignID']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['price']."</td>  
                    <td>".$row['type']."</td>";
                if($row['onGoing'] == 'no') {
                    $content = $content . "<td>InActive</td>";                              
                } else {
                    $content = $content . "<td>Active</td>";
                }
                $content = $content . "</tr>";
            }
        }  
        $content = $content . "</table>";
    } else if($_GET['stats']=="generalInfo"){
        
        $allNum = $adminClass->getNumberOfCampaign($_GET['from'], '0');
        $eMailNum = $adminClass->getNumberOfCampaign($_GET['from'], 'email');
        $seoNum = $adminClass->getNumberOfCampaign($_GET['from'], 'seo');
        $ppcNum = $adminClass->getNumberOfCampaign($_GET['from'], 'ppc');
        $displayNum = $adminClass->getNumberOfCampaign($_GET['from'], 'display');
        $content = "<br/>
                <table id='campaignsInfoTable' class='campaignListTable'>
                    <tr class='campaignListCat'>
                        <td></td>
                        <td>E-Mail</td>
                        <td>Search Engine Opt.</td>
                        <td>Pay Per Click</td>
                        <td>Display</td>
                        <td><b>All</b></td>
                    </tr>        
                    <tr class='admincampaignLines'>
                        <td><b>No. of Campaigns</b></td>
                        <td>".$eMailNum."</td>
                        <td>".$seoNum."</td>
                        <td>".$ppcNum."</td>
                        <td>".$displayNum."</td>
                        <td>".$allNum."</td>
                    </tr>
                    <tr class='adminCampaignLines'>
                        <td><b>Percentage of Total Campaigns</b></td>
                        <td>".@(($eMailNum/$allNum)*100)."%</td>
                        <td>".@(($seoNum/$allNum)*100)."%</td>
                        <td>".@(($ppcNum/$allNum)*100)."%</td>
                        <td>".@(($displayNum/$allNum)*100)."%</td>
                        <td>".@(($allNum/$allNum)*100)."%</td>
                    </tr>
                </table>";
    }
    echo $content;
?>

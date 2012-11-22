<?php
    if ($_GET['job']=='export'){
        $filename ="campaigns.xls";
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$filename);
    }
    
    include_once('./classes/AdminClass.php');
    require_once('initdb.php'); 
    $adminClass = new AdminClass();
    
    $content = "<table class='campaignListTable'>
                <tr class='campaignListCat'>
                        <td class='idTag'>ID</td>
                        <td>Type</td>
                        <td>SubType</tD>
                        <td>Price</td>
                        <td>Start Date</td>     
                        <td>Duration</td>
                        <td class='onGoingTag'>On Going</td>";
    if($_GET['job']!='export') {
        $content = $content . "<td>Delete</td>";
    }
    $content = $content . "</tr>";
    $result = $adminClass->getAllCampaignList($_GET['fromDate']);
        $num = mysql_num_rows($result);
        if ($num==0)
            $content = $content . "<b>** No open campaigns found</b>";
        else {
            while($row = mysql_fetch_array($result)){
                $date = new DateTime('@'.$row['startTime']);
                
                $content = $content . "<tr class='campaignLines'>
                            <td class='idTag'>".$row['campaignID']."</td>
                            <td>".$row['type']."</td>
                            <td>".$row['subType']."</td>
                            <td>".$row['price']."</td>
                            <td>".$date->format('d/m/Y')."</td>
                            <td>".$row['duration']."</td>
                            <td class='onGoingTag'>".$row['onGoing']."</td>";
                if($_GET['job']!='export') {
                    $content = $content."<td><a href=\"./index.php?tabID=userMain&subID=campaign&action=del&id=". $row['campaignID'] ."\">
                             <img src='images/delete.png' alt='Del' class='deleteImg'/> </td>";
                }
                $content = $content."</tr>";
            }
        }
        $content = $content . "</table>";
        echo $content; 
?>

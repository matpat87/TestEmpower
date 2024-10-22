<?php
    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

    // Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=HandleRejectTRDistroAndItems
    handleRejectTRDistroAndItems();

    function handleRejectTRDistroAndItems()
    {
        global $db;

        $db = DBManagerFactory::getInstance();
        $sql = "SELECT tr_technicalrequests.id FROM tr_technicalrequests
                LEFT JOIN tr_technicalrequests_cstm ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c
                WHERE tr_technicalrequests.deleted = 0 AND tr_technicalrequests.approval_stage = 'closed_rejected'
                ORDER BY tr_technicalrequests_cstm.technicalrequests_number_c ASC";
        $result = $db->query($sql);

        while($row = $db->fetchByAssoc($result) ) {
            $trBean = BeanFactory::getBean('TR_TechnicalRequests', $row['id']);
            
            echo '<br>';
            echo "TR ID: {$trBean->id}";
            echo '<br>';
            echo "TR#: {$trBean->technicalrequests_number_c}";
            echo '<br>';
            echo "Version: {$trBean->version_c}";
            echo '<br>';
            echo "Name: {$trBean->name}";
            echo '<br>';

            TechnicalRequestHelper::closeIncompleteDistroAndTRItems($trBean);
        }
    }
?>
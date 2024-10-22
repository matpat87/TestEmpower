<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=UpdateTRWorkgroupCSRToQuoteManager
updateTRWorkgroupCSRToQuoteManager();

function updateTRWorkgroupCSRToQuoteManager()
{
  global $db;

  $db = DBManagerFactory::getInstance();
  $sql = "SELECT tr_technicalrequests.id FROM tr_technicalrequests WHERE tr_technicalrequests.deleted = 0 ORDER BY tr_technicalrequests.name ASC";
  $result = $db->query($sql);

  while($row = $db->fetchByAssoc($result) ) {
    $trBean = BeanFactory::getBean('TR_TechnicalRequests', $row['id']);

    if ($trBean && $trBean->id) {
        $quoteManagerUserBean = retrieveUserBySecurityGroupTypeDivision('Quote Manager', 'TRWorkingGroup', $trBean->site, $trBean->division);
        
        if ($quoteManagerUserBean && $quoteManagerUserBean->id) {
            $workgroupBeanList = $trBean->get_linked_beans(
                'tr_technicalrequests_trwg_trworkinggroup_1',
                'TRWG_TRWorkingGroup',
                array(),
                0,
                -1,
                0,
                "trwg_trworkinggroup.tr_roles = 'CSRManager'"
            );
            
            if (! empty($workgroupBeanList) && count($workgroupBeanList) > 0) {
                echo '<<<< WORKGROUP UPDATES -- START >>>>';
                echo '<br><br>';

                foreach ($workgroupBeanList as $workgroupBean) {
                    $updateWorkgroupSQL = "UPDATE trwg_trworkinggroup SET tr_roles = 'QuoteManager', parent_id = '{$quoteManagerUserBean->id}' WHERE id = '{$workgroupBean->id}'";
                    echo $updateWorkgroupSQL;
                    $db->query($updateWorkgroupSQL);
                }

                echo '<br><br>';
                echo '<<<< WORKGROUP UPDATES -- END >>>>';
                echo '<br><br>';

                $trItemBeanList = $trBean->get_linked_beans(
                    'tri_technicalrequestitems_tr_technicalrequests',
                    'TRI_TechnicalRequestItems',
                    array(),
                    0,
                    -1,
                    0,
                    "tri_technicalrequestitems.status IN ('new', 'in_process') AND tri_technicalrequestitems.name IN ('quote')"
                );
    
                if (! empty($trItemBeanList) && count($trItemBeanList) > 0) {
                    echo '<<<< ITEM UPDATES -- START >>>>';
                    echo '<br><br>';
    
                    foreach($trItemBeanList as $trItemBean) {
                        $updateItemSQL = "UPDATE tri_technicalrequestitems SET assigned_user_id = '$quoteManagerUserBean->id' WHERE id = '$trItemBean->id'";
                        echo $updateItemSQL;
                        $db->query($updateItemSQL);
                    }
                    echo '<br><br>';
                    echo '<<<< ITEM UPDATES -- END >>>>';
                    echo '<br><br>';
                }
            }
        }
    }
  }
}
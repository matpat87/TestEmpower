<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/TRWG_TRWorkingGroup/helpers/TRWorkingGroupHelper.php');

// Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=UpdateOnHoldTRItemsDistroItems
updateOnHoldTRItemsDistroItems();

function updateOnHoldTRItemsDistroItems()
{
    global $db, $log;

    $trBean = BeanFactory::getBean('TR_TechnicalRequests');
    $beanList = $trBean->get_full_list('date_entered', "tr_technicalrequests.status IN ('awaiting_target_resin', 'more_information')", false, 0);
    $trCount = count($beanList);
    $distroItemCount = 0;
    $trItemCount = 0;

    if (count($beanList) > 0) {

        foreach ($beanList as $trBean) {
            $updateStatus = 'onHold';
            $prevStatus = 'new';
            
            // GET TR > Distro Items where status == $prevStatus
            $distroBean = BeanFactory::getBean('DSBTN_Distribution');
            $distroBeanList = $distroBean->get_full_list('', "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$trBean->id}'", false, 0);
            $distroItemCount = count($distroItemBeanList);
            if ($distroBeanList != null && count($distroBeanList) > 0) {
                foreach ($distroBeanList as $distroBean) {
                    $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems');
                    $distroItemBeanList = $distroItemBean->get_full_list('dsbtn_distributionitems_cstm.distribution_item_c', "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}' AND dsbtn_distributionitems_cstm.status_c = '{$prevStatus}'", false, 0);
                    $distroItemCount = count($distroItemBeanList);

                    if ($distroItemBeanList != null && count($distroItemBeanList) > 0) {

                        $distroItemIds = implode(",", array_map(function($item) {
                            return "'{$item}'";
                        }, array_column($distroItemBeanList, 'id')));

                        // Set the status of New Distro Items to On Hold
                        $updateSql = $db->query("
                            UPDATE dsbtn_distributionitems_cstm 
                            SET 
                                status_c = '{$updateStatus}'
                            WHERE
                                id_c IN ({$distroItemIds});
                        ");
                        
                    }

                    
                }
            }

            // GET TR> TR Items where status == $prevStatus
            $trBean->load_relationship('tri_technicalrequestitems_tr_technicalrequests');
            if(isset($trBean->tri_technicalrequestitems_tr_technicalrequests)) {

                $trItemIdList = $trBean->tri_technicalrequestitems_tr_technicalrequests->get();

                if ($trItemIdList && count($trItemIdList) > 0) {
                    $trItemIds = implode(",", array_map(function($item) {
                        return "'{$item}'";
                    }, $trItemIdList));

                    $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems');
                    $newTrItems =  $trItemBean->get_full_list('name', "tri_technicalrequestitems.id IN ({$trItemIds}) AND tri_technicalrequestitems.status = '{$prevStatus}'", false, 0);
                    $trItemCount = count($newTrItems);

                    if ($newTrItems && count($newTrItems) > 0) {
                        $trItemIds = implode(",", array_map(function($item) {
                            return "'{$item}'";
                        }, array_column($newTrItems, 'id')));

                        // Set the status of New TR Items to On Hold
                        $trItemUpdateSql = $db->query("
                            UPDATE tri_technicalrequestitems 
                            SET 
                                status = '{$updateStatus}'
                            WHERE
                                id IN ({$trItemIds});
                        ");
                        
                    }
                }

                
                
            }
        }
    }

    echo "<pre>";
    echo "{$trCount} Technical Requests are of status = 'Approved awaiting Target/Resin/Awaiting More information' </br>";
    echo "{$distroItemCount} Related Distro Items set to OnHold </br>";
    echo "{$trItemCount} Related TR Items set to OnHold </br>";
    echo "</pre>";
}
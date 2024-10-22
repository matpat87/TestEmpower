<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

// Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=HandleDelTRData
handleDelTRData();

function handleDelTRData(){
    $trs_to_remove = "('938', '936', '937', '940', '946', '937', '947')";
    //$trs_to_remove = "('575')";

    $trBean = BeanFactory::newBean('TR_TechnicalRequests');

    $trBeanList = $trBean->get_list(
        //Order by the accounts name
        'name',
        //Only accounts with industry 'Media'
        "tr_technicalrequests_cstm.technicalrequests_number_c in {$trs_to_remove}",
        //Start with the 30th record (third page)
        -1,
        //No limit - will default to max page size
        -1
        //10 items per page
    );

    foreach($trBeanList['list'] as $trBean){
        //Call
        $trBean->load_relationship('tr_technicalrequests_activities_1_calls');
        $callBeanList = $trBean->tr_technicalrequests_activities_1_calls->getBeans();

        foreach($callBeanList as $callBean){
            echo '<br/> call id: ' . $callBean->id;
            removeByTable('calls', $callBean->id);
        }

        //TR Items
        $trBean->load_relationship('tri_technicalrequestitems_tr_technicalrequests');
        $trItemsBeanList = $trBean->tri_technicalrequestitems_tr_technicalrequests->getBeans();

        foreach($trItemsBeanList as $trItemsBean){
            echo '<br/> TRI_TechnicalRequestItems id: ' . $trItemsBean->id;
            removeByTable('tri_technicalrequestitems', $trItemsBean->id);
        }

        //Distribution
        $trBean->load_relationship('tr_technicalrequests_dsbtn_distributionitems_1');
        $distroBeanList = $trBean->tr_technicalrequests_dsbtn_distributionitems_1->getBeans();

        foreach($distroBeanList as $distroBean){
            echo '<br/> Disto Items id: ' . $distroBean->id;
            removeByTable('dsbtn_distributionitems', $distroBean->id);
        }

        //Product Master
        $trBean->load_relationship('tr_technicalrequests_aos_products_2');
        $beanList = $trBean->tr_technicalrequests_aos_products_2->getBeans();

        foreach($beanList as $bean){
            echo '<br/> Product Master id: ' . $bean->id;
            removeByTable('aos_products', $bean->id);
        }

        //Opportunities
        $trBean->load_relationship('tr_technicalrequests_opportunities');
        $beanList = $trBean->tr_technicalrequests_opportunities->getBeans();

        foreach($beanList as $bean){
            echo '<br/> Opportunity id: ' . $bean->id;
            $trBean->tr_technicalrequests_opportunities->delete($trBean->id, $bean);
        }

        //Contacts
        $trBean->load_relationship('tr_technicalrequests_contacts_1');
        $beanList = $trBean->tr_technicalrequests_contacts_1->getBeans();

        foreach($beanList as $bean){
            echo '<br/> Contact id: ' . $bean->id;
            $trBean->tr_technicalrequests_contacts_1->delete($trBean->id, $bean);
        }

        //Accounts
        $trBean->load_relationship('tr_technicalrequests_accounts');
        $beanList = $trBean->tr_technicalrequests_accounts->getBeans();

        foreach($beanList as $bean){
            echo '<br/> Account id: ' . $bean->id;
            $trBean->tr_technicalrequests_accounts->delete($trBean->id, $bean);
        }

        //Security Groups
        removeSecGroups($trBean->id);

        removeByTable('tr_technicalrequests', $trBean->id);
    }
    
}

function removeByTable($table, $id){
    global $db;

    $sql = "update {$table} 
            set deleted = 1
            where id = '{$id}' ";

    echo '<br/>' . $sql;
    

    $result = $db->query($sql);
    
    return $result;
}

function removeSecGroups($tr_id){
    global $db;

    $sql = "update securitygroups_records
            set deleted = 1
            where module = 'TR_TechnicalRequests'
                and record_id = '{$tr_id}'; ";
    
    $result = $db->query($sql);
    
    return $result;
}

?>
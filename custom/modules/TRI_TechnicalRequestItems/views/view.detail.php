<?php

require_once 'include/MVC/View/views/view.detail.php';
require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class TRI_TechnicalRequestItemsViewDetail extends ViewDetail
{
    function preDisplay()
    {
        parent::preDisplay();
    }

    function display()
    {
        global $app_list_strings;

        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $this->bean->tri_techni0387equests_ida);
        $this->bean->technical_request_number_non_db = $trBean->technicalrequests_number_c;
        $this->bean->technical_request_version_non_db = $trBean->version_c;
        
        $trBean->load_relationship('tr_technicalrequests_aos_products_2');
        $productMasterIds = $trBean->tr_technicalrequests_aos_products_2->get();

        if (count($productMasterIds) > 0) {
            $productMasterBean = BeanFactory::getBean('AOS_Products', $productMasterIds[0]);
        }
        
        $this->ss->assign("product_master_id", $productMasterBean->id ?? '');

        // This will be used to change the label at the header level
        // Ex. TECHNICAL REQUEST ITEMS: SAMPLE CONCENTRATE
        $this->bean->name = $app_list_strings['distro_item_list'][$this->bean->name];
        
        $timeBean = BeanFactory::getBean('Time')->retrieve_by_string_fields([
            'parent_type' => 'TRI_TechnicalRequestItems',
            'parent_id' => $this->bean->id
        ]);

        if ($timeBean && $timeBean->id) {
            $this->ss->assign("time_id", $timeBean->id);

            $this->bean->work_performed_non_db = $timeBean->name;
            $this->bean->date_worked_non_db = convertDateFormatToLoggedUserFormat($timeBean->date_worked);
            $this->bean->time_non_db = $timeBean->time;
            $this->bean->work_description_non_db = $timeBean->description;
        }

        parent::display();
    }
}
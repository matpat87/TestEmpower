<?php

require_once 'include/MVC/View/views/view.edit.php';
require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class TRI_TechnicalRequestItemsViewEdit extends ViewEdit
{
    function preDisplay()
    {
        parent::preDisplay();
    }

    function display()
    {
        global $app_list_strings;

        if (! $this->bean->tri_techni0387equests_ida) {
            $this->bean->tri_techni0387equests_ida = isset($_REQUEST['tri_techni0387equests_ida']) ? $_REQUEST['tri_techni0387equests_ida'] : '';
        }

        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $this->bean->tri_techni0387equests_ida);
        $this->bean->technical_request_number_non_db = $trBean->technicalrequests_number_c;
        $this->bean->technical_request_version_non_db = $trBean->version_c;
        $this->ss->assign('TR_STATUS', $trBean->status);

        // TR_ITEM is used to convert the codes for name field to behave like a Distribution Item dropdown field similar to how it works in the Distribution Module
        // Disable field if it is distro generated, else display it as custom dropdown field
        if ($this->bean->distro_generated_c) {
            $trItemLabel = $app_list_strings['distro_item_list'][$this->bean->name];

            $this->ss->assign('TR_ITEM', "
                <input tabindex='0' type='text' name='name_display' id='name_display' value='{$trItemLabel}' maxlength='255' class='custom-readonly' readonly='readonly' />
                <input tabindex='0' type='hidden' name='name' id='name' value='{$this->bean->name}' />
            ");

            if (! $this->bean->due_date) {
                $this->ss->assign('TR_ID', $this->bean->tri_techni0387equests_ida);
            }
        } else {
            $this->ss->assign('TR_ID', $this->bean->tri_techni0387equests_ida);
            $this->ss->assign('TR_ITEM', TechnicalRequestItemsHelper::GetDistributionDropdown($this->bean->name));
        }

        
        $trBean->load_relationship('tr_technicalrequests_aos_products_2');
        $productMasterIds = $trBean->tr_technicalrequests_aos_products_2->get();

        if (count($productMasterIds) > 0) {
            $productMasterBean = BeanFactory::getBean('AOS_Products', $productMasterIds[0]);
        }
        
        if ($productMasterBean->id) {
            // If New Record or if record does not have a product number
            if (! $this->bean->id || ! $this->bean->product_number) {
                $this->bean->product_number = $productMasterBean->product_number_c ?? '';    
            }

            $this->ss->assign("product_master_id", $productMasterBean->id ?? '');
        }
        
        // Add after assigning to TR_ITEM since this will be used to change the label at the header level
        // Ex. TECHNICAL REQUEST ITEMS: SAMPLE CONCENTRATE >> EDIT
        $this->bean->name = $app_list_strings['distro_item_list'][$this->bean->name];

        $timeBean = BeanFactory::getBean('Time')->retrieve_by_string_fields([
            'parent_type' => 'TRI_TechnicalRequestItems',
            'parent_id' => $this->bean->id
        ]);

        if ($timeBean && $timeBean->id) {
            $this->bean->work_performed_non_db = $timeBean->name;
            $this->bean->date_worked_non_db = convertDateFormatToLoggedUserFormat($timeBean->date_worked);
            $this->bean->time_non_db = $timeBean->time;
            $this->bean->work_description_non_db = $timeBean->description;
        } else {
            $this->bean->work_performed_non_db = $this->bean->name;
            $this->bean->date_worked_non_db = convertDateFormatToLoggedUserFormat(date('Y-m-d'));
        }

        
        parent::display();
        
        // Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script src='custom/modules/TRI_TechnicalRequestItems/js/edit.js?v={$guid}'></script>";
    }
}
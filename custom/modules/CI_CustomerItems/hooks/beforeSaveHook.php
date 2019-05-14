<?php
	
class beforeSaveHook
{

	public function setAssignedUser($bean, $event, $arguments)
	{
		global $current_user;

    	// Set default "Assigned To" value to logged user when creating new record
    	if($bean->fetched_row == false) {
    		$bean->assigned_user_id = $current_user->id;
    	}
	}

	public function accountQuickCreateCustomerItem($bean, $event, $arguments) {
		if($_REQUEST['module'] == 'CI_CustomerItems' && $_REQUEST['return_module'] == 'Accounts' && $bean->fetched_row == false) {
			$beanItemMasterID = $bean->ci_customeritems_im_itemmasterim_itemmaster_ida;

			$itemMaster = BeanFactory::getBean('IM_ItemMaster', $beanItemMasterID);

			$bean->name = $itemMaster->name;
			$bean->part_number = $itemMaster->part_number;
			$bean->status = $itemMaster->status;
			$bean->cost = $itemMaster->cost;
			$bean->price = $itemMaster->price;
		}
	}

}
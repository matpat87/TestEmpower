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
			$beanProductID = $bean->aos_products_ci_customeritems_1aos_products_ida;

			$product = BeanFactory::getBean('AOS_Products', $beanProductID);

			$bean->name = $product->name;
			$bean->part_number = $product->part_number;
			$bean->status = $product->status_c;
			$bean->cost = $product->cost;
			$bean->price = $product->price;
		}
	}

}
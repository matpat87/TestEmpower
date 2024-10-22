<?php

	class ContactsBeforeSaveHook {
		public function setDefaultStatus($bean, $event, $arguments)
		{
            if (! $bean->status_c) {
                $bean->status_c = 'Active';
            }
		}

		public function saveDistibutionItems(&$bean, $event, $arguments)
		{
			//Save Line Items
			if(isset($_POST['qty']))
			{
					$count = count($_POST['qty']);
					$qty_list = $_POST['qty'];
					$uom_list =  $_POST['uom'];
					$distribution_item_list =  $_POST['distribution_item'];
					$shipping_method_list =  $_POST['shipping_method'];
					$account_information_list =  $_POST['account_information'];
					$date_entered = date("Y-m-d H:i:s");

					$this->remove_distributions($bean->id);
					for($i = 0; $i < $count; $i++)
					{
							$this->insert_distribution_line_item($bean->id, $qty_list[$i], $distribution_item_list[$i], $shipping_method_list[$i], $account_information_list[$i], ($i +1), $bean->created_by, $uom_list[$i]);
					}
			}
		}

		private function insert_distribution_line_item($contactId, $qty, $distribution_item, $shipping_method, $account_information, $row_order, $created_by, $uom)
		{
				if(!empty($distribution_item) && !empty($qty) && !empty($shipping_method))
				{
						$distribution_items_bean = BeanFactory::newBean('DSBTN_DistributionItems');
						$distribution_items_bean->qty_c = $qty;
						$distribution_items_bean->distribution_item_c = $distribution_item;
						$distribution_items_bean->shipping_method_c = $shipping_method;
						$distribution_items_bean->account_information_c = $account_information;
						$distribution_items_bean->uom_c = $uom;
						$distribution_items_bean->row_order_c = $row_order;
						$distribution_items_bean->created_by = $created_by;
						$distribution_items_bean->contact_id_c = $contactId;
						$distribution_items_bean->save();
				}
		}

		private function remove_distributions($contactId)
        {
            global $db;
            
            $query = "DELETE  a, b 
                FROM    dsbtn_distributionitems a
                INNER JOIN dsbtn_distributionitems_cstm b
                    ON b.id_c = a.id
                WHERE  b.contact_id_c = '{$contactId}'";

            $db->query($query);
        }
	}
?>
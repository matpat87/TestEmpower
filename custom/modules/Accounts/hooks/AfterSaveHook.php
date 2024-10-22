<?php
	class AccountsAfterSaveHook 
	{
		public function handleOEMFieldParentChildMapping(&$bean, $event, $arguments)
        {
            global $db;

            if ($bean->status_c == 'Active' && $bean->fetched_row['oem_c'] != $bean->oem_c) {
                if ($bean->account_type == 'CustomerParent') {
                    // Crawl child accounts and update OEM values
                    $updateSQL = "UPDATE accounts
                    LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c
                    SET accounts_cstm.oem_c = '{$bean->oem_c}'
                    WHERE accounts.parent_id = '{$bean->id}'
                    AND accounts_cstm.status_c = 'Active'
                    AND accounts.deleted = 0";
                } else {
                    $parentAccountBean = BeanFactory::getBean('Accounts', $bean->parent_id);

                    if (! $parentAccountBean->id) return;

                    // Crawl parent account and run through child accounts and update OEM values
                    $updateSQL = "UPDATE accounts
                    LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c
                    SET accounts_cstm.oem_c = '{$bean->oem_c}'
                    WHERE accounts.parent_id = '{$parentAccountBean->id}' OR accounts.id = '{$parentAccountBean->id}'
                    AND accounts_cstm.status_c = 'Active'
                    AND accounts.deleted = 0";
                }

                (isset($updateSQL) && $updateSQL) ? $db->query($updateSQL) : '';
            }
        }
	}
?>
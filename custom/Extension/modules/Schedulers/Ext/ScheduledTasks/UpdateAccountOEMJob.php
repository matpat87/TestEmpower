<?php
require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class UpdateAccountOEMJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    global $db;

    $db = DBManagerFactory::getInstance();

    $accountSQL = "SELECT accounts.id FROM accounts 
                    LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c 
                    WHERE accounts.deleted = 0 
                    AND accounts.account_type = 'CustomerParent'
                    AND accounts_cstm.status_c = 'Active'
                    ORDER BY accounts_cstm.oem_c DESC";
    $accountResult = $db->query($accountSQL);

    while($accountRow = $db->fetchByAssoc($accountResult) ) {
      // Account Bean
      $parentBean = BeanFactory::getBean('Accounts', $accountRow['id']);

      if ($parentBean->oem_c == 'Yes') {
        // Crawl child accounts and update OEM values
        $updateSQL = "UPDATE accounts
                      LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c
                      SET accounts_cstm.oem_c = 'Yes'
                      WHERE accounts.parent_id = '{$parentBean->id}'
                      AND accounts_cstm.status_c = 'Active'
                      AND accounts.deleted = 0";

      } else {
        $oemChildAccountBeanList = BeanFactory::getBean('Accounts')->get_full_list(
          'name', "accounts.parent_id = '{$parentBean->id}' AND accounts_cstm.status_c = 'Active' AND accounts_cstm.oem_c = 'Yes'"
        );

        if (isset($oemChildAccountBeanList) && count($oemChildAccountBeanList) > 0) {
          // Crawl parent account and run through child accounts and update OEM values
          $updateSQL = "UPDATE accounts
                        LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c
                        SET accounts_cstm.oem_c = 'Yes'
                        WHERE accounts.parent_id = '{$parentBean->id}' OR accounts.id = '{$parentBean->id}'
                        AND accounts_cstm.status_c = 'Active'
                        AND accounts.deleted = 0";
        }
      }

      (isset($updateSQL) && $updateSQL) ? $db->query($updateSQL) : '';
    }

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}
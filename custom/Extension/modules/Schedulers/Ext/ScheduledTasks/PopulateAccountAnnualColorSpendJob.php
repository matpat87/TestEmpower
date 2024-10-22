<?php
require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class PopulateAccountAnnualColorSpendJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    global $db, $log;

    $db = DBManagerFactory::getInstance();

    $sql = "SELECT accounts.id, accounts_cstm.annual_revenue_potential_c, accounts_cstm.annual_spend_c FROM accounts
                    LEFT JOIN accounts_cstm
                      ON accounts.id = accounts_cstm.id_c
                    WHERE accounts.deleted = 0
                      AND (accounts_cstm.annual_revenue_potential_c = '' OR accounts_cstm.annual_revenue_potential_c IS NULL)
                      AND accounts_cstm.annual_spend_c <> ''";
    $result = $db->query($sql);

    $log->fatal("Populate Account Annual Color Spend Job - START");

    while($row = $db->fetchByAssoc($result) ) {
      $accountBean = BeanFactory::getBean('Accounts', $row['id']);

      $updateSQL = "UPDATE accounts
                    LEFT JOIN accounts_cstm 
                      ON accounts.id = accounts_cstm.id_c
                    SET accounts_cstm.annual_revenue_potential_c = '{$accountBean->annual_spend_c}'
                      WHERE accounts.id = '{$accountBean->id}'
                    AND accounts.deleted = 0";
      $db->query($updateSQL);

      $log->fatal("Account ID: {$accountBean->id}");
      $log->fatal("Account Customer #: {$accountBean->cust_num_c}");
      $log->fatal("Old Value: {$accountBean->annual_revenue_potential_c}");
      $log->fatal("New Value: {$accountBean->annual_spend_c}");
    }

    $log->fatal("Populate Account Annual Color Spend Job - END");

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}
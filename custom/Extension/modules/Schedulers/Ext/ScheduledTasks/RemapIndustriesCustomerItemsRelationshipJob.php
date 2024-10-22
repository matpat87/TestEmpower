<?php

class RemapIndustriesCustomerItemsRelationshipJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    $db = DBManagerFactory::getInstance();
    $deleteSQL = "DELETE FROM mkt_markets_ci_customeritems_1_c";
    $db->query($deleteSQL);

    $sql = "SELECT ci_customeritems.id FROM ci_customeritems";
    $result = $db->query($sql);

    while ($row = $db->fetchByAssoc($result)) {
        $bean = BeanFactory::getBean('CI_CustomerItems', $row['id']);

        if ($bean && $bean->id) {
            if (! $bean->sub_industry_c) {
                $updateSQL = "UPDATE ci_customeritems_cstm SET ci_customeritems_cstm.industry_c = '' WHERE ci_customeritems_cstm.id_c = '{$bean->id}'";
                $db->query($updateSQL);
            } else {
                $newId = create_guid();
                $insertSQL = "INSERT INTO mkt_markets_ci_customeritems_1_c 
                    (`id`, `date_modified`, `deleted`, `mkt_markets_ci_customeritems_1mkt_markets_ida`, `mkt_markets_ci_customeritems_1ci_customeritems_idb`)
                    VALUES
                    ('{$newId}', NOW(), 0, '{$bean->sub_industry_c}', '{$bean->id}')
                ";
                $db->query($insertSQL);
            }
        }
    }

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}
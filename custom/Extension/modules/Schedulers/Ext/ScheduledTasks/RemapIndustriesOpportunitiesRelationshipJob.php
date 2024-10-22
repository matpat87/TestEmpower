<?php

class RemapIndustriesOpportunitiesRelationshipJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    $db = DBManagerFactory::getInstance();
    $deleteSQL = "DELETE FROM mkt_markets_opportunities_1_c"; // purge existing relationship data
    $db->query($deleteSQL);

    $sql = "SELECT opportunities.id FROM opportunities";
    $result = $db->query($sql); 

    while ($row = $db->fetchByAssoc($result)) {
        $bean = BeanFactory::getBean('Opportunities', $row['id']);

        if ($bean && $bean->id) {

            if (! $bean->sub_industry_c) {

                $updateSQL = "UPDATE opportunities_cstm SET opportunities_cstm.sub_industry_c = '' WHERE opportunities_cstm.id_c = '{$bean->id}'";
                $db->query($updateSQL);

            } else {

                $newId = create_guid();
                $insertSQL = "INSERT INTO mkt_markets_opportunities_1_c 
                    (`id`, `date_modified`, `deleted`, `mkt_markets_opportunities_1mkt_markets_ida`, `mkt_markets_opportunities_1opportunities_idb`)
                    VALUES
                    ('{$newId}', NOW(), 0, '{$bean->sub_industry_c}', '{$bean->id}')
                ";

                $db->query($insertSQL);
                
            }
        } // end of if ($bean && $bean->id)
    } // end of while loop

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}
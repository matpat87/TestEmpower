<?php

class UpdateTRItemProductNumberJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    global $db, $log;

    $db = DBManagerFactory::getInstance();
    $sql = "SELECT tri_technicalrequestitems.id FROM tri_technicalrequestitems WHERE tri_technicalrequestitems.deleted = 0";
    $result = $db->query($sql);

    while ($row = $db->fetchByAssoc($result)) {
      $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems', $row['id']);
      
      if (! $trItemBean->id) continue;

      $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trItemBean->tri_techni0387equests_ida);

      if (! $trBean->id) continue;

      $trBean->load_relationship('tr_technicalrequests_aos_products_2');

      $productMasterIds = $trBean->tr_technicalrequests_aos_products_2->get();
      $productMasterBean = ($productMasterIds[0]) ? BeanFactory::getBean('AOS_Products', $productMasterIds[0]) : BeanFactory::newBean('AOS_Products');

      if (! $productMasterBean->id) continue;

      if ((! $trItemBean->product_number) || ($trItemBean->product_number && $trItemBean->product_number !== $productMasterBean->product_number_c)) {
        $trItemBean->product_number = $productMasterBean->product_number_c;
        $trItemBean->aos_products_tri_technicalrequestitems_1aos_products_ida = $productMasterBean->id;
        $trItemBean->save();
      }
    }

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}
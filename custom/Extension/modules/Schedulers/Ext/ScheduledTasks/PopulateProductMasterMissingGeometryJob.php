<?php

class PopulateProductMasterMissingGeometryJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
      global $db, $log;

      $sql = "SELECT aos_products.id, aos_products_cstm.product_number_c, aos_products.type, aos_products_cstm.status_c, aos_products_cstm.geometry_c
            FROM aos_products
            LEFT JOIN aos_products_cstm
                ON aos_products.id = aos_products_cstm.id_c
            WHERE aos_products.deleted = 0
                AND aos_products.created_by <> (SELECT users.id FROM users WHERE users.user_name = 'INTEGRATION' LIMIT 1)
                AND (aos_products_cstm.geometry_c IS NULL OR aos_products_cstm.geometry_c = '')
        ";

      $result = $db->query($sql);

      $log->fatal("Populate Product Master Missing Geometry Job - END");

      while ($row = $db->fetchByAssoc($result)) {
          $bean = BeanFactory::getBean('AOS_Products', $row['id']);

          if (! $bean->id) continue;

          if (strlen($bean->product_number_c) >= 14) {
              $geometry = substr($bean->product_number_c, 8, 2);
              $updateSQL = "UPDATE aos_products_cstm SET aos_products_cstm.geometry_c = '{$geometry}' WHERE aos_products_cstm.id_c = '{$bean->id}'";

              $log->fatal("PM Record ID: {$bean->id}");
              $log->fatal("Product #: {$bean->product_number_c}");
              $log->fatal("Stage: {$bean->type}");
              $log->fatal("Status: {$bean->status_c}");
              $log->fatal("Geometry: {$geometry}");
              $log->fatal("Update SQL: {$updateSQL}");
              $db->query($updateSQL);
          }
      }

    $log->fatal("Populate Product Master Missing Geometry  - END");

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}
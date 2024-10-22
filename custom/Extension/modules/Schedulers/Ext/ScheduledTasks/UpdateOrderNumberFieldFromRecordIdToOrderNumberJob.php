<?php

class UpdateOrderNumberFieldFromRecordIdToOrderNumberJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    global $db;

    $invoiceQuery = "SELECT aos_invoices.id 
                      FROM aos_invoices 
                     LEFT JOIN aos_invoices_cstm 
                      ON aos_invoices.id = aos_invoices_cstm.id_c 
                     WHERE aos_invoices.deleted = 0
                      AND (aos_invoices_cstm.odr_salesorders_id_c != '' AND aos_invoices_cstm.odr_salesorders_id_c IS NOT NULL)";
    $invoiceResult = $db->query($invoiceQuery);

    while ($invoiceRow = $db->fetchByAssoc($invoiceResult)) {
      $invoiceBean = BeanFactory::getBean('AOS_Invoices', $invoiceRow['id']);

      if (! $invoiceBean->odr_salesorders_id_c) {
          continue;
      }

      $orderQuery = "SELECT odr_salesorders.id 
                      FROM odr_salesorders 
                     WHERE odr_salesorders.deleted = 0
                      AND (odr_salesorders.id = '{$invoiceBean->odr_salesorders_id_c}' OR odr_salesorders.number = '{$invoiceBean->odr_salesorders_id_c}')";

      $orderId = $db->getOne($orderQuery);
      $orderBean = BeanFactory::getBean('ODR_SalesOrders', $orderId);

      if (! $orderBean->number) {
          continue;
      }

      $db->query("UPDATE aos_invoices_cstm SET aos_invoices_cstm.order_number_c = '{$orderBean->number}' WHERE aos_invoices_cstm.id_c = '$invoiceBean->id'");
    }

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}
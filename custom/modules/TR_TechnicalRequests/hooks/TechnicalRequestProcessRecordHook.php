<?php
  require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

  class TechnicalRequestProcessRecordHook
  {
    public function processCustomColumnStyle($bean, $event, $arguments)
    {
      global $app_list_strings, $log;

      $is_export_to_excl = $this->isExportToExcel();

      //Colormatch #313
      if(isset($_REQUEST['module']) && $_REQUEST['module'] == 'Home'){
        $opportunity = BeanFactory::getBean('Opportunities', $bean->opportunity_id_c);
        $bean->load_relationship('tr_technicalrequests_opportunities');
        $opportunities = $bean->tr_technicalrequests_opportunities->getBeans();
        if(count($opportunities) > 0){
          $opportunity = array_values($opportunities)[0];
          $bean->opportunity_c = $opportunity->name;
          $bean->technical_request_update = $this->getTRUpdatesHTML($bean); //Colormatch #314
        }
      }
      else{
        $bean->technicalrequests_number_c = (!$is_export_to_excl) ? "<div style='padding-left: 10px'>{$bean->technicalrequests_number_c}</div>" : $bean->technicalrequests_number_c;
      }

      $bean->version_c = (!$is_export_to_excl) ? "<div style='padding-left: 25px'>{$bean->version_c}</div>" : $bean->version_c;
      $bean->status = $bean->approval_stage && $bean->status ? TechnicalRequestHelper::get_status($bean->approval_stage)[$bean->status] : '';
      
      if(!$is_export_to_excl){
      $bean->product_master_non_db = isset($bean->product_master_id_non_db)
        ? "<div><a href='index.php?module=AOS_Products&action=DetailView&record={$bean->product_master_id_non_db}'>{$bean->product_master_non_db}</a></div>"
        : $bean->product_master_non_db;
      }
      
      // $technicalRequestProductMasterBeanList = $bean->get_linked_beans(
      //     'tr_technicalrequests_aos_products_1',
      //     'AOS_Products',
      //     array(),
      //     0,
      //     -1,
      //     0,
      //     "tr_technicalrequests_aos_products_1_c.tr_technicalrequests_aos_products_1tr_technicalrequests_ida = '{$bean->id}'"
      // );

      // if ($technicalRequestProductMasterBeanList != null && count($technicalRequestProductMasterBeanList) > 0) {
      //   $productMasterBean = $technicalRequestProductMasterBeanList[0];

      //   if ($productMasterBean && $productMasterBean->id) {
      //     // $bean->product_master_non_db = "<div><a href='index.php?module=AOS_Products&action=DetailView&record={$productMasterBean->id}'>{$productMasterBean->product_number_c}</a></div>";
      //   }
      // }
    }

    private function getTRUpdatesHTML($bean){
      $result = '';

      if(!empty($bean->technical_request_update)){
        $updates = substr($bean->technical_request_update, 0, 10);
        $result = $updates;
        $moreLink = '';
        if(strlen($bean->technical_request_update) > 10){
          $moreLink = '&nbsp;<a href="#" onclick="return false;" data-toggle="modal" data-target="#exampleModalCenter"> (...)</a>
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">'. $bean->name .'</h5>
                              </div>
                              <div class="modal-body">
                                '. $bean->technical_request_update.'
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>';
        }

        $result .= $moreLink;
      }

      return $result;
    }

    //OnTrack #1451 - checkin if is export to excel
    private function isExportToExcel(){
      $result = false;

      if(isset($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == 'TR_TechnicalRequestsExportXLSRegistry'){
        $result = true;
      }

      return $result;
    }
  }
?>
<?php
  require_once('custom/include/Carbon/src/Carbon/Carbon.php');

	use Carbon\Carbon;

  class TechnicalRequestItemsProcessRecordHook
  {
    public function handleCustomColumnValues(&$bean, $event, $arguments)
    {
      global $app_list_strings, $log;

      if (! in_array($_REQUEST['action'], ['Save', 'Save2'])) {
        $trItembean = BeanFactory::getBean('TRI_TechnicalRequestItems', $bean->id);
        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trItembean->tri_techni0387equests_ida);

        $bean->name = $app_list_strings['distro_item_list'][$bean->name];

        if ($trBean && $trBean->id) {
          if(! $trBean->load_relationship('tr_technicalrequests_aos_products_2')) {
            return;
          }

          $productMasterIds = $trBean->tr_technicalrequests_aos_products_2->get();

          if (count($productMasterIds) > 0) {
            $productMasterBean = BeanFactory::getBean('AOS_Products', $productMasterIds[0]);
            
            $bean->product_number = "<div><a href='index.php?module=AOS_Products&action=DetailView&record={$productMasterBean->id}'>
              {$bean->product_number}
            </a></div>";

            $bean->technical_request_product_name_non_db = $productMasterBean->name;
          }
          
          $bean->technical_request_number_non_db = "<div style='padding-left: 10px'><a href='index.php?module=TR_TechnicalRequests&action=DetailView&record={$trBean->id}'>
            {$trBean->technicalrequests_number_c}
          </a></div>";

          $bean->technical_request_version_non_db = "<div style='padding-left: 25px'>{$trBean->version_c}</div>";

          $technicalRequestAccountBeanList = $trBean->get_linked_beans(
            'tr_technicalrequests_accounts',
            'Accounts',
            array(),
            0,
            -1,
            0,
            "tr_technicalrequests_accounts_c.tr_technicalrequests_accountstr_technicalrequests_idb = '{$trBean->id}'"
          );
          
          if ($technicalRequestAccountBeanList != null && count($technicalRequestAccountBeanList) > 0) {
            $bean->technical_request_account_name_non_db = $technicalRequestAccountBeanList[0]->name;
          }

          $technicalRequestOpportunityBeanList = $trBean->get_linked_beans(
            'tr_technicalrequests_opportunities',
            'Opportunities',
            array(),
            0,
            -1,
            0,
            "tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiestr_technicalrequests_idb = '{$trBean->id}'"
          );
          
          if ($technicalRequestOpportunityBeanList != null && count($technicalRequestOpportunityBeanList) > 0) {
            $bean->technical_request_opportunity_number_non_db = "<span style='padding-left: 15px;'>{$technicalRequestOpportunityBeanList[0]->oppid_c}</span>";
          }
        }
      }
    }

    public function handleSubpanelColumns(&$bean, $event, $arguments)
    {
      global $log;
      
      if ($_REQUEST['module'] == 'TR_TechnicalRequests' && $_REQUEST['action'] == 'DetailView') {
        //OnTrack #1412 - SUBPANELS NOT SHOWING FOR TECHNICAL REQUESTS AND TECH REQ ITEMS
        $date_arr = explode(' ', $bean->date_entered);

        if(!empty($date_arr) && !empty($date_arr[0])){
            $bean->date_entered = $date_arr[0];
        }

        if (!empty($bean->completed_date_c)) {
          $completed_date_arr = explode(' ', $bean->completed_date_c);
          if(!empty($completed_date_arr) && !empty($completed_date_arr[0])){
            $bean->completed_date_c = $completed_date_arr[0];
          }
        }
      }
    }
  }

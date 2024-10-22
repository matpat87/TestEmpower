<?php

   if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

   require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');

   class DSBTN_DistributionProcessRecordHook
   {
      function process_record($bean, $event, $arguments)
      {
         if (! in_array($_REQUEST['action'], ['Save', 'Save2'])) {
            // $bean->contact_c = "<a href='index.php?module=DSBTN_Distribution&action=DetailView&record={$bean->id}'>{$bean->contact_c}</a>";

            if ($bean->custom_opportunity_number_non_db) {
               $bean->custom_opportunity_number_non_db = "<span style='padding-left: 15px;'>{$bean->custom_opportunity_number_non_db}</span>";
            }

            if ($bean->custom_technical_request_number_non_db && $bean->custom_technical_request_version_non_db) {
               $bean->custom_technical_request_number_non_db = "<span style='padding-left: 5px;'>{$bean->custom_technical_request_number_non_db}.{$bean->custom_technical_request_version_non_db}</span>";
            }

            $bean->distro_item_non_db = $bean->distro_item_non_db ? DistributionHelper::GetDistributionItemLabel($bean->distro_item_non_db) : '';

            $bean->distro_item_delivery_method_non_db = $bean->distro_item_delivery_method_non_db ? DistributionHelper::GetShippingMethodLabel($bean->distro_item_delivery_method_non_db) : '';

            $bean->distro_item_status_non_db = $bean->distro_item_status_non_db ? DistributionHelper::GetStatusLabel($bean->distro_item_status_non_db) : '';

            $distributionBean = BeanFactory::getBean('DSBTN_Distribution', $bean->id);
            $trBean = BeanFactory::getBean('TR_TechnicalRequests', $distributionBean->tr_technicalrequests_id_c);

            if ($trBean && (! ((in_array($trBean->approval_stage, ['understanding_requirements', 'development'])) && (in_array($trBean->status, ['new', 'more_information', 'approved']))) )) {
               // echo "<style> #edit-{$distributionBean->id} { visibility: hidden; }</style>";
            }
         }
      }
   }

?>
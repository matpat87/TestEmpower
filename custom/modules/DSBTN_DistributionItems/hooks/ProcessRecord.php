<?php
    if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');

    class ProcessRecord{
        public function process_record($bean, $event, $arguments)
        {
            global $app, $log;
            
            if(in_array($app->controller->bean->module_name, ["TR_TechnicalRequests", "Users"]) && (! in_array($_REQUEST['action'], ['Save', 'Save2']))) {
                if (in_array($_REQUEST['action'], ['check_if_distro_and_tr_lab_items_completed'])) return true;

                $bean->custom_uom_c = DistributionHelper::GetUOM($bean->distribution_item_c);
                $bean->distribution_item_c = DistributionHelper::GetDistributionItemLabel($bean->distribution_item_c);
                $bean->shipping_method_c = DistributionHelper::GetShippingMethodLabel($bean->shipping_method_c);
            }
        }

        public function handle_date_completed($bean, $event, $arguments)
        {
            global $log;

            if (in_array($_REQUEST['module'], ['TR_TechnicalRequests', 'Users']) && $_REQUEST['action'] == 'DetailView') {
                $date_arr = explode(' ', $bean->date_completed_c);

                if(!empty($date_arr) && !empty($date_arr[0])){
                    $bean->date_completed_c = $date_arr[0];
                }
            }
        }
    }

?>
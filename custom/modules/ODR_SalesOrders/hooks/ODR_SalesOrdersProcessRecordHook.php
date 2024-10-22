<?php

    class ODR_SalesOrdersProcessRecordHook{

        //OnTrack #859 - Order and Customer Product relationship
        public function process_records(&$bean, $event, $arguments){
            global $log;

            $module = !empty($_GET['module']) ? $_GET['module'] : '';
           
            if(in_array($module, ['CI_CustomerItems', 'Accounts'])) {
                $bean->number = '<a href="index.php?module=ODR_SalesOrders&action=DetailView&record='. $bean->id .'">' . $bean->number . '</a>';
            }

            //OnTrack #970 - NEW FIELD - ADDITIONAL DETAILS
            $custom_req_ship_date_reason_code = !empty($bean->custom_req_ship_date_reason_code) ? "'" . $bean->custom_req_ship_date_reason_code . "'" : "''";
            $custom_req_ship_date_orig = !empty($bean->custom_req_ship_date_orig) ? "'" . $bean->custom_req_ship_date_orig . "'" : "''";
            $id = $bean->id;
            if(!empty($bean->custom_req_ship_date_reason_code)){
                $bean->custom_additional_info = <<<EOD
                <span id="adspan_{$id}" onclick="showAdditionalInfo('adspan_{$id}', {$custom_req_ship_date_reason_code}, {$custom_req_ship_date_orig})" style="position: relative;"><!--not_in_theme!--><span class="suitepicon suitepicon-action-info" title="Additional Details"></span></span>
EOD;
            }
        }
    }

?>
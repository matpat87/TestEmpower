<?php

    class AOS_InvoicesProcessRecordHook
    {

        public function process_records(&$bean, $event, $arguments){
            global $log;

            $module = !empty($_GET['module']) ? $_GET['module'] : '';
            
            if(in_array($module, ['Accounts'])) {
                $bean->number = '<a href="index.php?module=AOS_Invoices&action=DetailView&record='. $bean->id .'">' . $bean->number . '</a>';
            }

        }
    }

?>
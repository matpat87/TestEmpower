<?php
    class ProcessRecord
    {
        public function customNameColume($bean, $event, $arguments)
        {
            global $log, $app_list_strings;
            $displayName = $app_list_strings['industry_dom'][$bean->name];
            
            // $log->fatal(print_r($_REQUEST, true));
            if ($_REQUEST['action'] == 'index') {
                $bean->industry_non_db = "
                    <a href='index.php?module=MKT_Markets&action=DetailView&record={$bean->id}'>
                        <span class='sugar_field'>{$displayName}</span>
                    </a>";

            }
            
        }
    }
?>
<?php
    require_once('custom/include/PHP_XLSXWriter/xlsxwriter.class.php');

    class OppExpCSVEntryPoint{
        const ALL = 'All';
        const FILE_TYPE = 'xlsx';
        const FILE_NAME = 'Opportunity';
        const LBL_AUTHOR = 'Chroma Colors';

        private function get_data()
        {
            $whereQuery = '';

            // If Checkbox are manually ticked or Select This Page is chosen
            if(! empty($_REQUEST['uid'])) {
                $explodedUIDs = explode(',', $_REQUEST['uid']);
                $whereInFormattedIds = handleArrayToWhereInFormatAll(array_combine($explodedUIDs, $explodedUIDs));
                $whereQuery = "opportunities.id IN ({$whereInFormattedIds})";
            }
            
            // If Select All is chosen
            if (! empty($_REQUEST['current_post'])) {
                $whereQuery = $_SESSION['OpportunityQueryWhere'];
            }

            return $whereQuery;
        }

        private function prepare()
        {
            $whereQuery = $this->get_data();
            $result = $this->get_opportunities($whereQuery);
            return $result;
        }

        public function export(){
            global $current_user, $log;

            $opp_list = self::prepare();        

            $writer = new XLSXWriter();
            $writer->setAuthor(LBL_AUTHOR);

            $current_user_index = $current_user->user_name . '_PREFERENCES';
            $str_to_explode = (!empty($_SESSION[$current_user_index]['global']) 
                && !empty($_SESSION[$current_user_index]['global']['OpportunitiesQ'])
                && !empty($_SESSION[$current_user_index]['global']['OpportunitiesQ']['displayColumns'])) 
                ? $_SESSION[$current_user_index]['global']['OpportunitiesQ']['displayColumns'] : '';

            $export_header = $this->map_header($str_to_explode);

            $export_data = array();
            foreach($opp_list as $opp){
                $account = $this->get_account($opp->id);

                $export_data[] = $this->map_fields($str_to_explode, $opp, $account);
            }

            $writer->writeSheet($export_data, self::FILE_NAME, $export_header);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $cls_date = new DateTime();
            $now = $cls_date->format('d-m-Y');
            $file_name = self::FILE_NAME .' ' . $now . '.' . self::FILE_TYPE;
            header('Content-Disposition: attachment;filename="'. $file_name .'"');
            header('Cache-Control: max-age=0');
            $writer->writeToStdOut();
        }

        public static function get_opportunities($whereQuery)
        {
            $result = array();
            $orderByQuery = $_SESSION['OpportunityQueryOrderBy'] ?? 'name';

            $oppBean = BeanFactory::getBean('Opportunities');
            $oppBeanList = $oppBean->get_full_list($orderByQuery, $whereQuery);
            
            if (! empty($oppBeanList) && count($oppBeanList) > 0) {
                $result = $oppBeanList;
            }

            return $result;
        }

        public static function get_account($opp_id)
        {
            global $db;
            $result = '';

            $data = $db->query("select ao.account_id,
                    a.name
                from accounts_opportunities ao
                inner join accounts a
                    on a.id = ao.account_id 
                        and a.deleted = 0
                where ao.deleted = 0 
                    and ao.opportunity_id = '{$opp_id}' ");
            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null)
            {
                $result = $rowData;
            }

            return $result;
        } 

        private function map_header($str_to_explode){
            require('custom/modules/Opportunities/metadata/listviewdefs.php');

            $result = array();

            if(!empty($str_to_explode)){
                $exploded_arr = explode('|', $str_to_explode);

                foreach($exploded_arr as $str_field){

                    foreach($listViewDefs['Opportunities'] as $field_key => $field ){

                        if($field_key == $str_field){
                            $lower_str_field = strtolower($str_field);
                            $result[translate($field['label'],'Opportunities')] = 'string';
                        }
                    }
                }
            }
            else{
                $result = array(
                    translate('LBL_OPPID', 'Opportunities') => 'string',
                    translate('LBL_OPPORTUNITY_NAME', 'Opportunities') => 'string',
                    translate('LBL_ACCOUNT', 'Opportunities') => 'string',
                    'Sales Stage' => 'string',
                    translate('LBL_STATUS', 'Opportunities') => 'string',
                    translate('LBL_AMOUNT', 'Opportunities') => 'string',
                    translate('LBL_LIST_DATE_CLOSED', 'Opportunities') => 'string',
                    'User' => 'string',
                    'Created Date' => 'string',
                    translate('LBL_LAST_ACTIVITY_DATE', 'Opportunities') => 'string',
                );
            }

            return $result;
        }

        private function map_fields($str_to_explode, $opp_bean, $account){
            require('custom/modules/Opportunities/metadata/listviewdefs.php');

            global $app_list_strings;

            $result = array();

            if(!empty($str_to_explode)){
                $exploded_arr = explode('|', $str_to_explode);

                foreach($exploded_arr as $str_field){

                    foreach($listViewDefs['Opportunities'] as $field_key => $field ){

                        if($field_key == $str_field){
                            if($str_field == 'ACCOUNT_NAME'){
                                $result[] = $account['name'];
                            }
                            else{
                                $lower_str_field = strtolower($str_field);
                                $result[] = $opp_bean->$lower_str_field;
                            }
                        }
                    }
                }
            }
            else{
                $status = !empty($app_list_strings['tr_technicalrequests_status_list'][$opp_bean->status_c]) ? 
                    $app_list_strings['tr_technicalrequests_status_list'][$opp_bean->status_c] : '';
                $sales_stage = !empty($app_list_strings['sales_stage_dom'][$opp_bean->sales_stage]) ? 
                    $app_list_strings['sales_stage_dom'][$opp_bean->sales_stage] : '';

                $result = array(
                    $opp_bean->oppid_c, 
                    $opp_bean->name,
                    $account['name'],
                    $sales_stage,
                    $status,
                    $opp_bean->amount,
                    $opp_bean->date_closed,
                    $opp_bean->assigned_user_name,
                    $opp_bean->date_entered,
                    $opp_bean->last_activity_date_c,
                );
            }

            return $result;
        }
    }

    $oppExpCSVEntryPoint = new OppExpCSVEntryPoint();
    $oppExpCSVEntryPoint->export();
?>
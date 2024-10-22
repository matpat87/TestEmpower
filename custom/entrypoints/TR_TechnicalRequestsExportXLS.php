<?php

    require_once('custom/include/PHP_XLSXWriter/xlsxwriter.class.php');

    class TR_TechnicalRequestsExportXLS{
        const ALL = 'All';
        const FILE_TYPE = 'xlsx';
        const FILE_NAME = 'Technical Request';
        const LBL_AUTHOR = 'Chroma Colors';

        private function get_data(){
            $result = array();

            if(!empty($_REQUEST['uid'])){
                $result = explode(',', $_REQUEST['uid']);
            }
            
            if(!empty($_REQUEST['current_post'])){
                if(!isset($_REQUEST['uid'])){
                    $result[] = self::ALL;
                }
            }

            return $result;
        }

        private function prepare(){
            $data = $this->get_data();
            $result = array();

            if(!empty($data)){
                $tr_bean = BeanFactory::getBean('TR_TechnicalRequests');
                $where_query = "";

                if(in_array(self::ALL, $data)){
                    $where_query = $_SESSION['TR_TechnicalRequestsExportXLSQuery'];
                }
                else{
                    $where_data = '';

                    foreach($data as $record){
                        $where_data .= "'{$record}', ";
                    }
    
                    $where_data = substr($where_data, 0, strlen($where_data) - 2);
                    $where_query = "tr_technicalrequests.id in ({$where_data})";
                }

                $result = $tr_bean->get_full_list(
                    'name', $where_query
                );
            }

            return $result;
        }

        public function export(){
            global $current_user;

            $tr_bean_list = self::prepare();           
            $writer = new XLSXWriter();
            $writer->setAuthor(LBL_AUTHOR);

            $current_user_index = $current_user->user_name . '_PREFERENCES';
            $str_to_explode = (!empty($_SESSION[$current_user_index]['global']) 
                && !empty($_SESSION[$current_user_index]['global']['TR_TechnicalRequestsQ'])
                && !empty($_SESSION[$current_user_index]['global']['TR_TechnicalRequestsQ']['displayColumns'])) ? $_SESSION[$current_user_index]['global']['TR_TechnicalRequestsQ']['displayColumns'] : '';

            $export_header = $this->map_header($str_to_explode);

            

            $export_data = array();
            foreach($tr_bean_list as $tr_bean){
                $tr_bean->load_relationship('tr_technicalrequests_accounts');
                $account_list = $tr_bean->tr_technicalrequests_accounts->getBeans();

                $account = null;
                if(!empty($account_list)){
                    $account = array_values($account_list)[0];
                }

                $export_data_arr = $this->map_fields($str_to_explode, $tr_bean, $account);

                $export_data[] = $export_data_arr;
            }

            $writer->writeSheet($export_data, self::FILE_NAME, $export_header);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $cls_date = new DateTime();
            $now = $cls_date->format('m-d-Y');
            $file_name = self::FILE_NAME .' ' . $now . '.' . self::FILE_TYPE;
            header('Content-Disposition: attachment;filename="'. $file_name .'"');
            header('Cache-Control: max-age=0');
            $writer->writeToStdOut();
        }

        private function map_header($str_to_explode){
            require('custom/modules/TR_TechnicalRequests/metadata/listviewdefs.php');

            $result = array();

            if(!empty($str_to_explode)){

                $exploded_arr = explode('|', $str_to_explode);

                foreach($exploded_arr as $str_field){
                    if($str_field == 'CUSTOM_ADDITIONAL_INFO'){
                        continue;
                    }

                    foreach($listViewDefs[$module_name] as $field_key => $field ){

                        if($field_key == $str_field){
                            $lower_str_field = strtolower($str_field);
                            $result[translate($field['label'],'TR_TechnicalRequests')] = 'string';
                        }
                    }
                }
            }
            else{

                foreach($listViewDefs[$module_name] as $field_key => $field ){
                    if($field_key == 'CUSTOM_ADDITIONAL_INFO'){
                        continue;
                    }

                    if($field['default']){
                        $result[translate($field['label'],'TR_TechnicalRequests')] = 'string';
                    }
                }
            }

            return $result;
        }

        private function map_fields($str_to_explode, $tr_bean, $account){
            require('custom/modules/TR_TechnicalRequests/metadata/listviewdefs.php');

            global $log;
            $result = array();

            if(!empty($str_to_explode)){
                $exploded_arr = explode('|', $str_to_explode);

                foreach($exploded_arr as $str_field){
                    if($str_field == 'CUSTOM_ADDITIONAL_INFO'){
                        continue;
                    }

                    foreach($listViewDefs[$module_name] as $field_key => $field ){

                        if($field_key == $str_field){
                            if($str_field == 'ACCOUNTS_ODR_SALESORDERS_1_NAME'){
                                $result[] = $account->name;
                            }
                            else if($str_field == 'CUSTOM_CUST_NUM'){
                                $result[] = $account->cust_num_c;
                            }
                            else{
                                $lower_str_field = strtolower($str_field);
                                $result[] = $tr_bean->$lower_str_field;
                            }
                        }
                    }
                }
            }
            else{
                foreach($listViewDefs[$module_name] as $field_key => $field ){
                    if($field_key == 'CUSTOM_ADDITIONAL_INFO'){
                        continue;
                    }
                    else if($field_key == 'ACCOUNTS_ODR_SALESORDERS_1_NAME'){
                        $result[] = $account->name;
                    }
                    else if($field_key == 'CUSTOM_CUST_NUM'){
                        $result[] = $account->cust_num_c;
                    }
                    else{
                        $lower_str_field = strtolower($field_key);
                        $result[] = $tr_bean->$lower_str_field;
                    }
                }
            }

            return $result;
        }
    }


    $tr_TechnicalRequestsExportXLS = new TR_TechnicalRequestsExportXLS();
    $tr_TechnicalRequestsExportXLS->export();
?>
<?php

    class InvoiceHelper{
        public static function is_id_exists($id)
        {
            global $db;
            $result = false;

            $data = $db->query("select id 
                from aos_invoices 
                where id = '{$id}'");
            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null && !empty($rowData['id']))
            {
                $result = true;
            }

            return $result;
        }

        /**
         * Triggered via core code class: lib/Search/SearchResults.php
         * Custom function that handles (custom) non-db field data display in global (elastic) search display table/list view
         * @param SugarBean $bean, Array $fieldDefs
         * @return SugarBean $bean
         */
        public static function handleElasticSearchNonDbFieldData(&$bean, $fieldDefs)
        {
            global $log;
            require_once("include/MVC/View/views/view.list.php");
            $listViewDefs = [];

            $linkedFieldRelationshipMap = [
                'custom_item_number' => [
                    'link' => 'aos_products_quotes',
                    'custom_column' => 'item_number_c' // aos_products_quotes.item_number_c
                ],
                'custom_shipped_date' => [
                    'link' => 'aos_products_quotes',
                    'custom_column' => 'shipped_date_c' // aos_products_quotes.shipped_date_c
                ],
                'custom_customer_number' => [
                    'link' => 'accounts',
                    'custom_column' => 'cust_num_c' // accounts_cstm.cust_num_c
                ],
                // Added custom field and actual column defintion here
            ];


            
            $viewList = new ViewList();
            $viewList->type = 'list';
            $viewList->module = 'AOS_Invoices';
            
            $bean->load_relationships();
            
            $metaDataFile = $viewList->getMetaDataFile(); // load current list view fields
            require($metaDataFile);
           
            foreach($listViewDefs['AOS_Invoices'] as $field_name => $def) {

                $field_name = strtolower($field_name);

                if ($fieldDefs[$field_name]['source'] == 'non-db' && in_array($field_name, array_keys($linkedFieldRelationshipMap))) {
                    
                    $linkedBeansArr = $bean->{$linkedFieldRelationshipMap[$field_name]['link']}->getBeans(); // array
                    $linkedBean = reset($linkedBeansArr) ?? null; // get the only object from array without key 
                    
                    if (!empty($linkedBean)) {
                        $bean->{$field_name} = $linkedBean->{$linkedFieldRelationshipMap[$field_name]['custom_column']};
                    }
                   
                }
                
            }
            
            return $bean;
        }
    }
?>
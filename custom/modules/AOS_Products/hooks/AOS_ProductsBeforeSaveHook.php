<?php
    require_once('custom/modules/AOS_Products/helper/ProductHelper.php');

    class AOS_ProductsBeforeSaveHook{

        public function form_before_save(&$bean, $event, $arguments)
        {
            global $log;

            $bean->custom_is_edit_non_db = 'true';
            $_SESSION['custom_is_edit_non_db'] = 'true';

            // Bug in the core where it becomes an object if Edit is clicked from TR -> Product Master Subpanel then Save is triggered
            $trID = (is_object($bean->tr_technicalrequests_aos_products_2tr_technicalrequests_ida)) 
            ? $_REQUEST['tr_technicalrequests_aos_products_2tr_technicalrequests_ida'] 
            : $bean->tr_technicalrequests_aos_products_2tr_technicalrequests_ida;

            $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trID);

            if((!ProductHelper::is_id_exists($bean->id) //if not yet in database, assign Product Number
                || ($bean->type == 'development' && (! in_array($bean->status_c, ['in_process', 'complete', 'rejected'])) && ($bean->resin_type_c != $bean->fetched_row['resin_type_c'] || $bean->product_category_c != $bean->fetched_row['product_category_c'] || $bean->geometry_c != $bean->fetched_row['geometry_c'] || $bean->fda_eu_food_contract_c != $bean->fetched_row['fda_eu_food_contract_c'])) //allow change during Development only
                || (!empty($_POST['isDuplicate']) && $_POST['isDuplicate'] == 'true')) //allow change during Rematch
                && (($trBean && $trBean->id) && ($trBean->type <> 'rematch' || ($trBean->type == 'rematch' && $trBean->colormatch_type_c == 'product_master'))) // Only execute sequencer if TR Type is not Production Rematch or if Production Rematch but Rematch Type is New Product Number (product_master)
                && (((isset($bean->base_resin_c) && $bean->base_resin_c == 0) || !empty($bean->base_resin_c)) && !empty($bean->color_c) && !empty($bean->geometry_c) && ((isset($bean->resin_type_c) && $bean->resin_type_c == 0) || !empty($bean->resin_type_c)) && !empty($bean->fda_eu_food_contract_c))    
            )
            {
                $product_category_bean = BeanFactory::getBean('AOS_Product_Categories', $bean->product_category_c);
                $isNewRecord = (! $bean->fetched_row['id']) ? true: false;

                //$is_rematch_version = (!empty($bean->custom_rematch_type) && $bean->custom_rematch_type == 'rematch_version');
                $bean->product_number_c = ProductHelper::generate_number_sequence_v2($isNewRecord, $this->get_resin_value($bean->base_resin_c), $bean->color_c,
                    $bean->geometry_c, $this->get_resin_value($bean->resin_type_c), $bean->fda_eu_food_contract_c, $bean->fetched_row['id'], $product_category_bean->pcatid_c);
                
                //$bean->custom_is_edit_non_db = 'false';

                if($this->is_product_number_exist($bean->product_number_c)){
                    $tr_id = !empty($_POST['tr_technicalrequests_aos_products_2tr_technicalrequests_ida']) ? $_POST['tr_technicalrequests_aos_products_2tr_technicalrequests_ida'] : '';
                    $this->send_duplicate_notif($bean, $tr_id, 'SKosovich@Chromacolors.com');
                }
            }

            if(!empty($bean->import_product_number_c))
            {
                $bean->product_number_c = $bean->import_product_number_c;
            }

            $this->assign_account_rel($bean, $bean->account_id_c);
            $this->manage_rematch($bean);
            $this->manage_audit_fields($bean);
        }

        private function assign_account_rel($pm_bean, $account_id)
        {
            if(!empty($account_id))
            {
                $account_bean = BeanFactory::getBean('Accounts', $account_id);
                $pm_bean->load_relationship('aos_products_accounts_1');
                $pm_bean->aos_products_accounts_1->delete($pm->id, $account_id);
                $pm_bean->aos_products_accounts_1->add($account_bean);
            }
        }

        private function get_resin_value($resin)
        {
            $result = $resin;

            if(strpos($resin, '_') !== false)
            {
                $result = substr($resin, 0, (strpos($resin, '_')));
            }

            return $result;
        }

        //For Rematch
        private function manage_rematch($bean)
        {
            $version = 1;

            if(isset($bean->custom_rematch_type) && !empty($bean->custom_rematch_type)) {
                $product_bean = BeanFactory::getBean('AOS_Products', $bean->custom_related_product_id);

                if($bean->custom_rematch_type == 'rematch_version' || $bean->custom_rematch_type == 'rematch_rejected')
                {
                    $version = ProductHelper::get_version($product_bean->product_number_c);
                    $bean->product_number_c = $product_bean->product_number_c;
                }

                $version = str_pad($version, 2, '0', STR_PAD_LEFT);
                $bean->version_c = $version;
                $bean->system_version_c = $bean->product_number_c . "." . $version;
            }
        }

        private function manage_audit_fields($bean)
        {
            //Colormatch #236
            if(!empty($bean->tr_technicalrequests_aos_products_2_name))
            {
                $bean->technical_request_name_c = $bean->tr_technicalrequests_aos_products_2_name;
            }

            if(!empty($bean->product_category_c))
            {
                $resin_data = get_product_categories();
                $bean->product_category_name_c = $resin_data[$bean->product_category_c];
            }
        }

        //OnTrack #1344 - duplicate product master START
        private function is_product_number_exist($product_number){
            global $db;
            $result = false;
            
            $sql = "
                select ap.id
                from aos_products ap
                left join aos_products_cstm apc
                    on apc.id_c = ap.id
                where apc.product_number_c = '{$product_number}' AND  ap.deleted = 0";
                
            $data = $db->query($sql);
            $row = $db->fetchByAssoc($data);

            if(!empty($row) && !empty($row['id'])){
                $result = true;
            }

            return $result;
        }

        private function send_duplicate_notif($aos_product_bean, $tr_id, $email){
            global $log, $sugar_config;

            $log->fatal('id: ' . $aos_product_bean->id);
            $log->fatal('email: ' . $email);

            if( !empty($aos_product_bean->id) 
                    && !empty($email)){
                $tr_name = '';
                $date_entered = date("Y-m-d H:i:s");
                $created_by_bean = BeanFactory::getBean('Users', $aos_product_bean->created_by);
                $created_by_name = $created_by_bean != null ? $created_by_bean->first_name . ' ' . $created_by_bean->last_name : '';

                if(!empty($tr_id)){
                    $tr_bean = BeanFactory::getBean('TR_TechnicalRequests', $tr_id);
                    $tr_id = $tr_bean->id;
                    $tr_name = $tr_bean->name;
                }

                $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
                
                $email_template = <<<EOD
                    {$customQABanner}
                    
                    Hi,
                    <br/>
                    <br/>
                    Product Number is duplicate. Please see details below. <br/>
                    Stage: {$aos_product_bean->type} <br/>
                    Status: {$aos_product_bean->status_c} <br/>
                    Product #: {$aos_product_bean->product_number_c} <br/>
                    TR ID: {$tr_id} <br/>
                    TR Name: {$tr_name} <br/>
                    Version: {$aos_product_bean->version_c} <br/>
                    Name: {$aos_product_bean->name} <br/>
                    Site: {$aos_product_bean->site_c} <br/>
                    Site Contact ID: {$aos_product_bean->user_id_c} <br/>
                    Site Contact Name: {$aos_product_bean->user_lab_manager_c} <br/>
                    Product Category: {$aos_product_bean->product_category_c} <br/>
                    Base Resin: {$aos_product_bean->base_resin_c} <br/>
                    Color: {$aos_product_bean->color_c} <br/>
                    Geometry: {$aos_product_bean->geometry_c} <br/>
                    TR FDA/EU Food Contact: {$aos_product_bean->fda_eu_food_contract_c} <br/>
                    Carrier Resin: {$aos_product_bean->resin_type_c} <br/>
                    Created By ID: {$aos_product_bean->created_by} <br/>
                    Created By Name: {$created_by_name} <br/>
                    Date Entered: {$date_entered} <br/>
                    Assigned User ID: {$aos_product_bean->assigned_user_id} <br/>
                    Assigned User Name: {$aos_product_bean->assigned_user_name} <br/>
EOD;

                sendEmail('EmpowerCRM Duplicate Product Master', $email_template, [ $email ]);

                $log->fatal('AOS_ProductsBeforeSaveHook.send_duplicate_notif: Not an error - email sent');
            }
            else{
                $log->fatal('AOS_ProductsBeforeSaveHook.send_duplicate_notif: Email not sent');
            }

        }
        //OnTrack #1344 - duplicate product master END
    }

?>
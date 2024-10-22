<?php
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');
    use Carbon\Carbon;

    class TechnicalRequestItemsBeforeSaveHook{

        public function TechnicalRequestItemsBeforeSave(&$bean, $event, $arguments){
            if ($bean->fetched_row['status'] != $bean->status) {
                $bean->completed_date_c = ($bean->status != 'complete') ? '' : Carbon::now()->format('Y-m-d H:i:s');
            }
        }

        private function audit_completed_date($parent_id, $old_val, $new_val){
            global $db, $current_user, $log;
            $result = false;

            $id = create_guid();
            $date_created = date("Y-m-d H:i:s");
            $label_val = translate('LBL_COMPLETED_DATE', 'TRI_TechnicalRequestItems');
            $query = "insert into tri_technicalrequestitems_audit
                        values ('{$id}', '{$parent_id}', '{$date_created}', '{$current_user->id}', '{$label_val}', 'datetimecombo', '{$old_val}', '{$new_val}', '{$old_val}', '{$new_val}')";
            $result = $db->query($query);

            return $result;
        }

        // Deprecated as behavior is similar to DistributionBeforeSaveHook - before_save
        // public function handleTRChipsOrQuoteApprovedWorkflow(&$bean, $event, $arguments)
        // {
        //   // If new TR item OR TR Item quantity has been updated
        //   // If TR ID exists (Triggered from TR - technical_request_id or from Distro - tr_technicalrequests_id_c)
        //   if ((! $bean->fetched_row['id'] || ($bean->fetched_row['qty'] != $bean->qty)) && (isset($_REQUEST['technical_request_id']) || isset($_REQUEST['tr_technicalrequests_id_c'])) ) {
        //     $trId = $_REQUEST['technical_request_id'] ?? $_REQUEST['tr_technicalrequests_id_c'];
        //     $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trId);
        //     $returnModule = $_REQUEST['return_module'];
        //     $returnId = $_REQUEST['return_id'];
            
        //     if ($trBean && $trBean->id && $trBean->approval_stage == 'quoting_or_proposing') {
        //       $trBean->approval_stage = 'development';
        //       $trBean->status = 'new';
            
        //       if ($returnModule != 'TR_TechnicalRequests' && $returnId) {
        //         $trBean->save();
                
        //         $params = [
        //           'module'=> $returnModule,
        //           'action'=>'DetailView', 
        //           'record' => $returnId
        //         ];

        //         // To prevent logic hook from proceeding and creating the record, redirect to the return module's detailview page
        //         // This is to prevent duplicate TR items from being created since TR bean is saved which triggers the TR Items workflow process
        //         SugarApplication::redirect('index.php?' . http_build_query($params));
        //       }
        //     }
        //   }
        // }
    }
?>
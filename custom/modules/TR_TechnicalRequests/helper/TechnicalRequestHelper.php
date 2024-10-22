<?php
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');
    use Carbon\Carbon;
    
    class TechnicalRequestHelper{

        public static function assign_technicalrequests_number($technical_request_id = '')
        {
            global $db;
            $result = 0;
            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $technical_request_id);
    
            if(!empty($technical_request_bean->technicalrequests_number_c)){
                $result = $technical_request_bean->technicalrequests_number_c;
            }
            else{
                $data = $db->query("select technicalrequests_number_c 
                    from tr_technicalrequests_cstm
                    order by technicalrequests_number_c desc
                    limit 1");
                $rowData = $db->fetchByAssoc($data);
        
                if($rowData != null)
                {
                    $result = $rowData['technicalrequests_number_c'];
                }
                
                $result += 1;
            }
    
            return $result;
        }

        public static function handle_stage_status_routing($stage, $status, $type = '')
        {
            global $app_list_strings, $current_user;

            $options = '<select name="approval_stage" id="approval_stage" title="">';

            if (! $current_user->is_admin) {
                switch ($stage) {
                    case '':
                        $options .= "<option label='{$app_list_strings['approval_stage_list']['understanding_requirements']}' value='understanding_requirements' selected>{$app_list_strings['approval_stage_list']['understanding_requirements']}</option>";
                        break;
                    case 'understanding_requirements':
                        $options .= "<option label='{$app_list_strings['approval_stage_list']['understanding_requirements']}' value='understanding_requirements' selected>{$app_list_strings['approval_stage_list']['understanding_requirements']}</option>";
                        $options .= "<option label='{$app_list_strings['approval_stage_list']['closed_rejected']}' value='closed_rejected'>{$app_list_strings['approval_stage_list']['closed_rejected']}</option>";
                        break;
                    case 'development':
                        switch ($status) {
                            case 'new':
                            case 'awaiting_target_resin':
                            case 'in_process':
                            case 'more_information':
                                $options .= "<option label='{$app_list_strings['approval_stage_list']['development']}' value='development' selected>{$app_list_strings['approval_stage_list']['development']}</option>";
                                $options .= "<option label='{$app_list_strings['approval_stage_list']['closed_rejected']}' value='closed_rejected'>{$app_list_strings['approval_stage_list']['closed_rejected']}</option>";
                                break;
                            case 'approved':
                                $options .= "<option label='{$app_list_strings['approval_stage_list']['development']}' value='development' selected>{$app_list_strings['approval_stage_list']['development']}</option>";
                                break;
                            default:
                                # code...
                                break;
                        }
                        break;
                    case 'quoting_or_proposing':
                    case 'sampling':
                    case 'production_trial':
                    case 'award_eminent':
                    case 'closed_lost':
                        $stages = $app_list_strings['approval_stage_list'];
                        unset($stages['understanding_requirements']);
                        unset($stages['development']);
                        unset($stages['closed']);
                        unset($stages['closed_rejected']);
                        
                        // OnTrack 1895 - If stage = 'Award Imminent' and TR Type is a Production Rematch or Colormatch
                        // Do not display 'Closed - Won'
                        if (in_array($type, ['rematch', 'color_match'])) {
                            unset($stages['closed_won']);
                        }
    
                        foreach ($stages as $key => $value) {
                            if ($stage == $key) {
                                $options .= "<option label='{$value}' value='{$key}' selected>{$value}</option>";
                            } else {
                                $options .= "<option label='{$value}' value='{$key}'>{$value}</option>";
                            }
                        }
                        break;
                    case 'closed_won':
                        $stages = $app_list_strings['approval_stage_list'];
                        unset($stages['understanding_requirements']);
                        unset($stages['development']);
                        unset($stages['closed']);
                        unset($stages['closed_rejected']);
    
                        foreach ($stages as $key => $value) {
                            if ($stage == $key) {
                                $options .= "<option label='{$value}' value='{$key}' selected>{$value}</option>";
                            } else {
                                $options .= "<option label='{$value}' value='{$key}'>{$value}</option>";
                            }
                        }
                        break;
                    case 'closed':
                        $options .= "<option label='{$app_list_strings['approval_stage_list']['closed']}' value='closed' selected>{$app_list_strings['approval_stage_list']['closed']}</option>";
                        break;
                    case 'closed_rejected':
                        switch ($status) {
                            case 'created_in_error':
                                $options .= "<option label='{$app_list_strings['approval_stage_list']['understanding_requirements']}' value='understanding_requirements'>{$app_list_strings['approval_stage_list']['understanding_requirements']}</option>";
                                $options .= "<option label='{$app_list_strings['approval_stage_list']['development']}' value='development'>{$app_list_strings['approval_stage_list']['development']}</option>";
                                $options .= "<option label='{$app_list_strings['approval_stage_list']['closed_rejected']}' value='closed_rejected' selected>{$app_list_strings['approval_stage_list']['closed_rejected']}</option>";
                                break;
                            default:
                                $options .= "<option label='{$app_list_strings['approval_stage_list']['development']}' value='development'>{$app_list_strings['approval_stage_list']['development']}</option>";
                                $options .= "<option label='{$app_list_strings['approval_stage_list']['closed_rejected']}' value='closed_rejected' selected>{$app_list_strings['approval_stage_list']['closed_rejected']}</option>";
                                break;
                        }
                        break;
                    default:
                        foreach ($app_list_strings['approval_stage_list'] as $key => $value) {
                            if ($stage == $key) {
                                $options .= "<option label='{$value}' value='{$key}' selected>{$value}</option>";
                            } else {
                                $options .= "<option label='{$value}' value='{$key}'>{$value}</option>";
                            }
                        }
                        break;
                }
            } else {
                foreach ($app_list_strings['approval_stage_list'] as $key => $value) {
                    if ($stage == $key) {
                        $options .= "<option label='{$value}' value='{$key}' selected>{$value}</option>";
                    } else {
                        $options .= "<option label='{$value}' value='{$key}'>{$value}</option>";
                    }
                }
            }

            $options .= '</select>';

            return $options;
        }

        public static function get_version($technicalrequests_number_c)
        {
            global $db;
            $result = 0;
            $version = 0;

            $query = "select version_c 
            from tr_technicalrequests as t
            inner join tr_technicalrequests_cstm as tc
                on tc.id_c = t.id
            where t.deleted = 0
                and tc.technicalrequests_number_c = '{$technicalrequests_number_c}'
                and tc.technicalrequests_number_c <> 'TBD'
            order by tc.version_c desc
            limit 1";
            $data = $db->query($query);

            //var_dump($query);
            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null)
            {
                $version = intVal($rowData['version_c']) + 1;
            }
            else
            {
                $version = 1;
            }

            $result = str_pad($version, 2, '0', STR_PAD_LEFT);

    
            return $result;
        } 

        public static function is_id_exists($id)
        {
            global $db;
            $result = false;

            $data = $db->query("select id 
                from tr_technicalrequests 
                where tr_technicalrequests.id = '{$id}'");
            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null && !empty($rowData['id']))
            {
                $result = true;
            }

            return $result;
        } 

        public static function get_opportunity_details($id)
        {
            global $db;
            $result = null;
            $query = "select id,
                        name,
                        date_modified
                    from opportunities 
                    where id = '{$id}';";
            $data = $db->query($query);
            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null)
            {
                $result = $rowData;
            }

            return $result;
        } 

        public static function get_stages_with_status_data()
        {
            global $app_list_strings;
            $result = array(
                'understanding_requirements' => array(
                    'sortIndex' => 0,
                    'status_data' => array(
                        'in_process' => array(
                            'sortIndex' => 0,
                            'label' => 'Draft'
                        ),
                        'more_information' => array(
                            'sortIndex' => 1,
                            'label' => 'More Information Required'
                        ),
                    ),
                ),
                'development' => array(
                    'sortIndex' => 1,
                    'status_data' => array(
                        'new' => array( //OnTrack #700
                            'sortIndex' => 0,
                            'label' => '0 - New'
                        ),
                        'approved' => array(
                            'sortIndex' => 1,
                            'label' => '1 - Approved ready for Development'
                        ),
                        'in_process' => array(
                            'sortIndex' => 2,
                            'label' => '2 - In Process'
                        ),
                        'development_complete' => array(
                            'sortIndex' => 3,
                            'label' => '3 - Development Complete'
                        ),
                        'awaiting_target_resin' => array(
                            'sortIndex' => 4,
                            'label' => 'Awaiting Target/Resin'
                        ),
                        'more_information' => array(
                            'sortIndex' => 5,
                            'label' => 'More Information Required'
                        ),
                    )
                ),
                'quoting_or_proposing' => array(
                    'sortIndex' => 2,
                    'status_data' => array(
                        'new' => array(
                            'sortIndex' => 0,
                            'label' => '0 - New'
                        ),
                        'chips_submitted_for_customer_approval' => array(
                            'sortIndex' => 1,
                            'label' => '1 - Chips Submitted for Customer Approval'
                        ),
                        'chips_approved' => array(
                            'sortIndex' => 2,
                            'label' => '2 - Chips Approved'
                        ),
                        'quote_available' => array(
                            'sortIndex' => 3,
                            'label' => '3 - Quote Available'
                        ),
                        'quote_submitted_for_customer_approval' => array(
                            'sortIndex' => 4,
                            'label' => '4 - Quote Submitted for Customer Approval'
                        ),
                        'quote_approved' => array(
                            'sortIndex' => 5,
                            'label' => '5 - Quote Approved'
                        ),
                    )
                ),
                'sampling' => array(
                    'sortIndex' => 3,
                    'status_data' => array(
                        'new' => array(
                            'sortIndex' => 0,
                            'label' => '0 - New'
                        ),
                        'sample_submitted_for_customer_approval' => array(
                            'sortIndex' => 1,
                            'label' => '1 - Sample Submitted for Customer Approval'
                        ),
                        'sample_approved' => array(
                            'sortIndex' => 2,
                            'label' => '2 - Sample Approved'
                        ),
                    )
                ),
                'production_trial' => array(
                    'sortIndex' => 4,
                    'status_data' => array(
                        'new' => array(
                            'sortIndex' => 0,
                            'label' => '0 - New'
                        ),
                        'first_order_submitted_for_customer_approval' => array(
                            'sortIndex' => 1,
                            'label' => '1 - First order Submitted for Customer Approval'
                        ),
                        'approved' => array(
                            'sortIndex' => 2,
                            'label' => '2 - Approved'
                        ),
                    )
                ),
                'award_eminent' => array(
                    'sortIndex' => 5,
                    'status_data' => array(
                        'awaiting_award' => array(
                            'sortIndex' => 0,
                            'label' => '1 - Awaiting Award'
                        ),
                    )
                ),
                'closed_won' => array(
                    'sortIndex' => 6,
                    'status_data' => array(
                        'order_received' => array(
                            'sortIndex' => 0,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['order_received']
                        ),
                        'qualified_source' => array(
                            'sortIndex' => 1,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['qualified_source']
                        ),
                    )
                ),
                'closed' => array(
                    'sortIndex' => 7,
                    'status_data' => array(
                        'chip_sample_complete' => array(
                            'sortIndex' => 0,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['chip_sample_complete']
                        ),
                    ),
                ),
                'closed_lost' => array(
                    'sortIndex' => 8,
                    'status_data' => array(
                        '' => array(
                            'sortIndex' => 0,
                            'label' => ''
                        ),
                        'color' => array(
                            'sortIndex' => 1,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['color']
                        ),
                        'price' => array(
                            'sortIndex' => 2,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['price']
                        ),
                        'performance'=> array(
                            'sortIndex' => 3,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['performance']
                        ),
                        'service'=> array(
                            'sortIndex' => 4,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['service']
                        ),
                        'competition'=> array(
                            'sortIndex' => 5,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['competition']
                        ),
                        'cancelled'=> array(
                            'sortIndex' => 6,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['cancelled']
                        ),
                    )
                ),
                'closed_rejected' => array(
                    'sortIndex' => 9,
                    'status_data' => array(
                        '' => array(
                            'sortIndex' => 0,
                            'label' => ''
                        ),
                        'capability' => array(
                            'sortIndex' => 1,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['capability']
                        ),
                        'capacity' => array(
                            'sortIndex' => 2,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['capacity']
                        ),
                        'credit_risk' => array(
                            'sortIndex' => 3,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['credit_risk']
                        ),
                        'created_in_error' => array(
                            'sortIndex' => 4,
                            'label' => $app_list_strings['tr_technicalrequests_status_list']['created_in_error']
                        ),
                    )
                ),
                '' => array(
                    'sortIndex' => -1, 
                    'status_data' => array(
                        '' => array(
                            'sortIndex' => 0,
                            'label' => ''
                        ),
                    )
                ),
            );

            return $result;
        }

        public static function get_lowest_status($tr_related_beans, $lowest_sales_stage)
        {
            $result = '';
            $status_sortIndex = -1;
            $stages_with_status_data = TechnicalRequestHelper::get_stages_with_status_data();

            if(!empty($tr_related_beans))
            {
                $lowest_sales_stage_statuses = $stages_with_status_data[$lowest_sales_stage];
                //$result = 

                foreach($tr_related_beans as $tr_related_bean)
                {
                    //filter Stages based on lowest Sales Stage
                    if($tr_related_bean->approval_stage == $lowest_sales_stage)
                    {
                        $tr_status_arr = $stages_with_status_data[$tr_related_bean->approval_stage]['status_data'][$tr_related_bean->status];

                        //if status is null (to initialize) or tr status is lesser than current status index
                        if(empty($result) || $tr_status_arr['sortIndex'] < $status_sortIndex)
                        {
                            $result = TechnicalRequestHelper::get_status_key($tr_related_bean->approval_stage, $tr_status_arr['sortIndex']);
                            $status_sortIndex = $tr_status_arr['sortIndex'];
                        }
                    }
                }
            }

            return $result;
        }

        public static function get_status_key($sales_stage_key, $sortIndex)
        {
            $result = '';
            $stages_with_status_data = TechnicalRequestHelper::get_stages_with_status_data();

            if(!empty($sales_stage_key)){
                $status_data = $stages_with_status_data[$sales_stage_key]['status_data'];
                
                foreach($status_data as $status_key => $status_arr)
                {
                    if($status_arr['sortIndex'] == $sortIndex)
                    {
                        $result = $status_key;
                        break;
                    }
                }
            }

            return $result;
        }

        public static function get_lowest_sales_stage($tr_related_beans)
        {
            $result = '';
            $stages_with_status_data = TechnicalRequestHelper::get_stages_with_status_data();

            $i = 0;
            if(!empty($tr_related_beans))
            {
                // $current_sales_stage_arr = $stages_with_status_data[$tr_related_beans[0]->approval_stage];
                // $result = $tr_related_beans[0]->approval_stage;

                $tr_related_bean = reset($tr_related_beans); // targets the first TR element in the array
                $current_sales_stage_arr = $stages_with_status_data[$tr_related_bean->approval_stage];
                $result = $tr_related_bean->approval_stage;

                foreach($tr_related_beans as $tr_related_bean)
                {
                    $sales_stage_arr = $stages_with_status_data[$tr_related_bean->approval_stage];

                    if(0 < $i && $sales_stage_arr['sortIndex'] < $current_sales_stage_arr['sortIndex'])
                    {
                        $current_sales_stage_arr = $sales_stage_arr;
                        $result = $tr_related_bean->approval_stage;
                    }

                    $i++;
                }
            }

            return $result;
        }

        public static function get_status($stage, $currentStage = '', $currentStatus = '', $isSubmitToDev = false, $isByPass = false)
        {
            global $current_user, $log;

            $result = array();
            $stages_with_status_data = TechnicalRequestHelper::get_stages_with_status_data();

            foreach($stages_with_status_data as $stage_key => $stage_with_status) {
                if($stage_key == $stage) {
                    foreach($stage_with_status['status_data'] as $status_key => $status) {
                        $result[$status_key] = $status['label'];
                    }
                }
            }
            
            if (! $current_user->is_admin && !$isByPass) {
                switch ($stage) {
                    case 'understanding_requirements':
                        
                        $result = array_intersect_key(
                            $result, 
                            ['in_process' => 1]
                        );

                        // OnTrack #1909: For Cases when TR is from stage = 'Development' and status = '<Any status under stage development>'
                        // and is changed to status = 'More Information Required' and system changes stage to 'Understanding Requirements'
                        // Status will only be 'More information Required' and unset the Draft, since TR cannot be reverted back
                        // to 'Draft' at this point of the workflow
                        if ($currentStatus == 'more_information') {
                            $result['more_information'] = 'More Information Required';
                            unset($result['in_process']);
                        }
                        // END of OnTrack #1909 Customisation

                        
                        break;
                    case 'development':
                        if ($currentStatus && ! array_key_exists($currentStatus, $result)) {
                            $result = array();
                            $result['new'] = $stages_with_status_data[$stage]['status_data']['new']['label'];
                        } else {
                            switch ($currentStatus) {
                                case 'new':
                                    $result = array_intersect_key(
                                        $result, 
                                        ['new' => 1, 'approved' => 2, 'awaiting_target_resin' => 3, 'more_information' => 4]
                                    );
                                    break;
                                case 'approved':
                                    $result = array_intersect_key(
                                        $result, 
                                        ['approved' => 1, 'in_process' => 2]
                                    );
                                    break;
                                case 'awaiting_target_resin':
                                    $result = array_intersect_key(
                                        $result, 
                                        ['new' => 1, 'awaiting_target_resin' => 2, 'more_information' => 3]
                                    );
                                    break;
                                case 'in_process':
                                    if ($isSubmitToDev) {
                                        $result = array_intersect_key(
                                            $result, 
                                            ['new' => 1]
                                        );
                                    } else {
                                        $result = array_intersect_key(
                                            $result, 
                                            ['in_process' => 1, 'development_complete' => 2, 'awaiting_target_resin' => 3, 'more_information' => 4]
                                        );
                                    }
                                    break;
                                case 'more_information':
                                    $result = array_intersect_key(
                                        $result, 
                                        ['new' => 1, 'awaiting_target_resin' => 2, 'more_information' => 3]
                                    );
                                    break;
                                default:
                                    break;
                            }
                        }
                        break;
                    case 'closed_won':
                        // For non-admin users, remove ability to set status = order_received as this needs to be done via system integration or admins only
                        // Need to add order_received in $result if it is the current value to not cause issues where on Edit it gets set to qualified_source as it is the only available option
                        if (isset($currentStatus) && $currentStatus) {
                            if ($currentStatus == 'order_received') {
                                $result = array_intersect_key(
                                    $result, 
                                    ['order_received' => 1, 'qualified_source' => 2]
                                );
                            } else {
                                $result = array_intersect_key(
                                    $result, 
                                    ['qualified_source' => 1]
                                );
                            }
                        }
                        break;
                    case 'closed_rejected':
                        if ($currentStage == 'understanding_requirements') {
                            $result = array_intersect_key(
                                $result, 
                                ['created_in_error' => 1]
                            );
                            break;
                        }
                        break;
                    default:
                        break;
                }
            }

            // OnTrack #1909: For Cases when TR is from stage = 'Development' and status = '<Any status under stage development>'
            // and is changed to status = 'More Information Required' and system changes stage to 'Understanding Requirements'
            // Status will only be 'More information Required' and unset the Draft, since TR cannot be reverted back
            // to 'Draft' at this point of the workflow
            if ($current_user->is_admin && $stage == 'understanding_requirements') {
                if ($currentStatus == 'more_information') {
                    $result['more_information'] = 'More Information Required';
                    unset($result['in_process']);
                }
            }
            // END of OnTrack #1909 Customisation

            return $result;
        }

        private static function get_first_versions_only($tr_related_beans)
        {
            $result = array();

            if(!empty($tr_related_beans))
            {
                foreach($tr_related_beans as $tr_related_bean)
                {
                    if($tr_related_bean->version_c == '01')
                    {
                        $result[] = $tr_related_bean;
                    }
                }
            }

            return $result;
        }

        private static function get_non_rejected_only($tr_related_beans)
        {
            $result = array();

            if(!empty($tr_related_beans))
            {
                foreach($tr_related_beans as $tr_related_bean)
                {
                    if(! in_array($tr_related_bean->approval_stage, ['closed', 'closed_rejected']))
                    {
                        $result[] = $tr_related_bean;
                    }
                }
            }

            return $result;
        }

        public static function opportunity_calculate_probability($opportunity_id, $opportunity_bean_obj = null, $deleted_tr_id = '')
        {
            global $log, $app_list_strings;
            $total_opportunity_amount  = 0;
            $opportunity_probability = 0;
            $opportunity_amount_weighted = 0;
            $opportunity_total_volume = 0;
            $opportunity_sales_stage = 'IdentifyingOpportunity';
            $tr_related_count = 0;
            $opportunity_bean = null;
            $tr_related_beans = array();
            $first_tr_status_c = '';
            $now = new DateTime('now');

            if(!empty($opportunity_id))
            {
                //calculate for Opportunity Amount and Probability %
                if($opportunity_bean_obj == null){
                    $opportunity_bean = BeanFactory::getBean('Opportunities', $opportunity_id);
                    $tr_related_beans = TechnicalRequestHelper::get_opportunity_trs($opportunity_id);
                }
                else
                {
                    $opportunity_bean = $opportunity_bean_obj;

                    $tr_related_beans = ($opportunity_bean_obj->tr_technicalrequests_opportunities != null) ? $opportunity_bean_obj->tr_technicalrequests_opportunities->getBeans() : [];
                }
                // $tr_related_beans = TechnicalRequestHelper::get_first_versions_only($tr_related_beans); -- Deprected function as fix in OnTrack #1418
                $previous_opportunity_tr_stage_conversion = TechnicalRequestHelper::get_opportunity_tr_stage_conversion('');
                $tr_related_count = count($tr_related_beans);
                $opportunity_tr_stage_conversion = array();
                $trs_closed = array();

                // If there are more than one TR related to an Opportunity, retrieve non rejected technical requests and set as new counter value
                if ($tr_related_count > 1) {
                    $tr_related_beans_non_rejected = TechnicalRequestHelper::get_non_rejected_only($tr_related_beans);
                    $tr_related_count = count($tr_related_beans_non_rejected);
                }
                
                if($tr_related_count > 0){
                    $minus_tr_related_count = (!empty($deleted_tr_id)) ? 1 : 0;
                    for($i = 0; $i < ($tr_related_count - $minus_tr_related_count); $i++)
                    {
                        $trs_closed[$i] = '0';
                    }
                    $tr_related_count = $tr_related_count - $minus_tr_related_count;

                    $i = 0;
                    $opportunity_sales_stage = 'IdentifyingOpportunity';
                    foreach($tr_related_beans as $tr_related_bean)
                    {
                        if($deleted_tr_id != $tr_related_bean->id){

                            $probability_percentage = $tr_related_bean->probability_c;
                            // $log->fatal('$tr_related_bean->id: ' . $tr_related_bean->id);
                            // $log->fatal('$tr_related_bean->name: ' . $tr_related_bean->name);
                            // $log->fatal('$tr_related_bean->approval_stage: ' . $tr_related_bean->approval_stage);
                            // $log->fatal('$probability_percentage: ' . $probability_percentage);

                            if($probability_percentage > 0)
                            {
                                $skipProbabilityAndWeightedCalculation = false;

                                // Skip if Closed or Closed - Rejected and there are more than 1 TR related to an Opportunity
                                if ((in_array($tr_related_bean->approval_stage, ['closed', 'closed_rejected'])) && count($tr_related_beans) > 1) {
                                    $skipProbabilityAndWeightedCalculation = true;
                                }

                                if (! $skipProbabilityAndWeightedCalculation) {
                                    //for Opportunity Probability
                                    $tr_probability_calculated = $probability_percentage / $tr_related_count;
                                    // $log->fatal('$tr_probability_calculated: ' . $tr_probability_calculated);
                                    $opportunity_probability += $tr_probability_calculated;
                                    // $log->fatal('$opportunity_probability: ' . $opportunity_probability);
                                    

                                    //for Opportunity Amount Weighted
                                    $tr_annual_amount_weighted = TechnicalRequestHelper::get_tr_annual_amount_weighted($tr_related_bean->annual_amount_c, $probability_percentage);
                                    $opportunity_amount_weighted += $tr_annual_amount_weighted;

                                    //for Opportunity Total Amount
                                    $total_opportunity_amount +=  $tr_related_bean->annual_amount_c;
                                    
                                    //for Opportunity Total Volume
                                    $opportunity_total_volume += $tr_related_bean->annual_volume_c;
                                }
                            }

                            $opportunity_tr_stage_conversion = TechnicalRequestHelper::get_opportunity_tr_stage_conversion($tr_related_bean->approval_stage);
                            $trs_closed[$i] = ($opportunity_tr_stage_conversion['key'] == 'Closed') ? '1' : '0';

                            //this will go up to Solution Development
                            if($opportunity_tr_stage_conversion['value']['index'] > $previous_opportunity_tr_stage_conversion['value']['index'] && !$trs_closed[$i])
                            {
                                $opportunity_sales_stage = $opportunity_tr_stage_conversion['key'];
                                $previous_opportunity_tr_stage_conversion = $opportunity_tr_stage_conversion;
                            }
                        }

                        // if(strpos($tr_bean->version_c, '1') !== false)
                        // {
                        //     $first_tr_status_c = $tr_bean->status;
                        // }

                        $i++;
                    }
                
                    $opportunity_probability = round($opportunity_probability);
                    //sets Closed to Opportunity Sales Stage once all of the TR is Closed
                    // if(!in_array('0', $trs_closed))
                    // {
                    //     $opportunity_sales_stage = 'Closed';
                    // }
                }

                $opportunity_total_volume = ($opportunity_total_volume > 0) ? $opportunity_total_volume : 0;
                $annual_avg_sell_price = ($total_opportunity_amount > 0 && $opportunity_total_volume > 0) ? $total_opportunity_amount / $opportunity_total_volume : 0;
                $sales_stage = TechnicalRequestHelper::get_lowest_sales_stage($tr_related_beans);
                $status = TechnicalRequestHelper::get_lowest_status($tr_related_beans, $sales_stage);
                $sales_stage = TechnicalRequestHelper::get_opportunity_status($sales_stage);
                $closed_date = TechnicalRequestHelper::get_latest_closed_date($tr_related_beans);
                // var_dump('$sales_stage');
                // var_dump(TechnicalRequestHelper::get_opportunity_status($sales_stage));
                // var_dump('$status');
                // var_dump($status);
                //TODO: Create a function conversion for Sales Stage. Then, use it for Opportunity Sales Stage
                //die();
                
                if($opportunity_bean_obj != null){
                    $opportunity_bean_obj->probability_prcnt_c = $opportunity_probability;
                    $opportunity_bean_obj->amount_weighted_c = $opportunity_amount_weighted;
                    $opportunity_bean_obj->amount = $total_opportunity_amount;
                    $opportunity_bean_obj->annual_volume_lbs_c = $opportunity_total_volume;
                    $opportunity_bean_obj->avg_sell_price_c = $annual_avg_sell_price;
                    $opportunity_bean_obj->sales_stage = $sales_stage;
                    $opportunity_bean_obj->date_modified = $now->format('Y-m-d H:i:s');
                    $opportunity_bean_obj->status_c = $status;
                }

                if($opportunity_bean_obj == null)
                {
                    $date_str = $now->format('Y-m-d H:i:s');
                    $closed_date = (! $closed_date) ? date('Y-m-d') : $closed_date;
                    
                    if (in_array($sales_stage, ['Closed', 'ClosedWon', 'ClosedLost', 'ClosedRejected'])) {
                        $newClosedDate = (! $opportunity_bean_obj->closed_date_c) ? "{$closed_date}" : "{$opportunity_bean_obj->closed_date_c}";
                    } else {
                        $newClosedDate = 'NULL';
                    }

                    $formattedNewClosedDate = (isset($newClosedDate) && $newClosedDate <> 'NULL') ? "'{$newClosedDate}'" : $newClosedDate;
                    $closed_date_query = " oc.closed_date_c = {$formattedNewClosedDate}, ";

                    TechnicalRequestHelper::_update_opportunity($opportunity_id, $opportunity_probability, $opportunity_amount_weighted, 
                        $total_opportunity_amount, $opportunity_total_volume, $annual_avg_sell_price, 
                        $sales_stage, $date_str, $status, $newClosedDate, $closed_date_query);
                }
            }
        }

        private function _update_opportunity($id, $probability_prcnt_c, $amount_weighted_c, 
            $amount, $annual_volume_lbs_c, $avg_sell_price_c, 
            $sales_stage, $date_str, $status, $closed_date, $closed_date_query)
        {
            global $db, $log;

            $query = "update opportunities o
                      join opportunities_cstm oc
                        on oc.id_c = o.id
                      set oc.probability_prcnt_c = $probability_prcnt_c,
                        oc.amount_weighted_c = $amount_weighted_c,
                        o.amount = $amount,
                        o.amount_usdollar = $amount,
                        oc.annual_volume_lbs_c = $annual_volume_lbs_c,
                        oc.avg_sell_price_c = $avg_sell_price_c,
                        o.sales_stage = '{$sales_stage}',
                        o.date_modified = '{$date_str}',
                        {$closed_date_query}
                        oc.status_c = '{$status}'
                      where o.deleted = 0 
                        and o.id = '$id' ";

            $result = $db->query($query);

            // Handle audit log changes as directly updating via DB does not trigger insert to audit logs
            // Audit -- START
            $opportunityBean = BeanFactory::getBean('Opportunities', $id);

            if ($opportunityBean && $opportunityBean->id) {
                $formattedClosedDate = (isset($closed_date) && $closed_date && $closed_date <> 'NULL') 
                    ? Carbon::parse($closed_date)->format('Y-m-d') 
                    : '';
                    
                // Just set the bean values without triggering save to "trick" the core codes that there are bean changes and call auditBean(true)
                // auditBean is from SugarBean.php which checks if audit is enabled and changes are visible from bean vs. bean->fetched_row comparison
                // If changes are visible, field changes are inserted to the audit table
                $opportunityBean->probability_prcnt_c = $probability_prcnt_c ?? $opportunityBean->fetched_row['probability_prcnt_c'];
                $opportunityBean->amount_weighted_c = $amount_weighted_c ?? $opportunityBean->fetched_row['amount_weighted_c'];
                $opportunityBean->amount = $amount ?? $opportunityBean->fetched_row['amount'];
                $opportunityBean->amount_usdollar = $amount ?? $opportunityBean->fetched_row['amount_usdollar'];
                $opportunityBean->annual_volume_lbs_c = $annual_volume_lbs_c ?? $opportunityBean->fetched_row['annual_volume_lbs_c'];
                $opportunityBean->avg_sell_price_c = $avg_sell_price_c ?? $opportunityBean->fetched_row['avg_sell_price_c'];
                $opportunityBean->sales_stage = $sales_stage ?? $opportunityBean->fetched_row['avg_sell_price_c'];
                $opportunityBean->closed_date_c = $formattedClosedDate ?? $opportunityBean->fetched_row['closed_date_c'];
                $opportunityBean->status_c = $status ?? $opportunityBean->fetched_row['status_c'];

                // Need to add this here as it keeps inserting in the audit log
                // It's seeing it as a change due to how the frontend value differs from the one in the DB in terms of format
                // Old Value: 2022-12-23
                // New Value: 12/23/2022
                $opportunityBean->date_closed = ($opportunityBean->date_closed)
                    ? Carbon::parse($opportunityBean->date_closed)->format('Y-m-d')
                    : $opportunityBean->fetched_row['date_closed'];

                // Need to add this here as it double inserts in the audit log for account name changes
                $opportunityBean->account_name = ($opportunityBean->account_name)
                    ? explode(" (", $opportunityBean->account_name)[0]
                    : $opportunityBean->fetched_row['account_name'];
                $opportunityBean->auditBean(true);
            }
            // Audit -- END

            return $result;
        }

        private static function get_opportunity_status($tr_sales_stage)
        {
            $result = '';

            $sales_stages = array(
                'UnderstandingRequirements' => array('understanding_requirements'), 
                'SolutionDevelopment' => array('development'),
                'Closed' => array ('closed'),
                'QuotingProposing' => array('quoting_or_proposing'),
                'Sampling' => array('sampling'),
                'ProductionTrialOrder' => array('production_trial'),
                'AwardEminent' => array('award_eminent'),
                'ClosedWon' => array('closed_won'),
                'ClosedLost' => array('closed_lost'),
                'ClosedRejected' => array('closed_rejected'),
            );

            foreach($sales_stages as $sales_stage_key => $sales_stage_arr)
            {
                //var_dump($tr_sales_stage);

                if(in_array($tr_sales_stage, $sales_stage_arr))
                {
                    $result = $sales_stage_key;
                    break;
                }
            }

            return $result;
        }

        private static function get_opportunity_tr_stage_conversion($tr_sales_stage)
        {
            $sales_stage_list_data = array(
                'IdentifyingOpportunity' => array(
                    'index' => 1,
                    'trs' => array()
                ),
                'UnderstandingRequirements' => array(
                    'index' => 2,
                    'trs' => array('understanding_requirements')
                ),
                'SolutionDevelopment' => array(
                    'index' => 2,
                    'trs' => array('development', 'quoting_or_proposing', 'sampling', 'production_trial', 'award_eminent')
                ),
                'Closed' => array(
                    'index' => 2,
                    'trs' => array('closed', 'closed_won', 'closed_lost', 'closed_rejected')
                ),
            );

            $result = $sales_stage_list_data['IdentifyingOpportunity'];

            if(!empty($tr_sales_stage)){
                foreach($sales_stage_list_data as $sales_stage_key => $sales_stage_value)
                {
                    if(in_array($tr_sales_stage, $sales_stage_value['trs']))
                    {
                        $result = array( 'key' => $sales_stage_key, 'value' => $sales_stage_value);
                        break;
                    }
                }
            }
            else
            {
                $result = array('key', 'value' => $sales_stage_list_data['IdentifyingOpportunity']);
            }

            return $result;
        } 

        public static function get_opportunity_trs($opportunity_id)
        {
            global $log;

            $result = array();

            if(!empty($opportunity_id))
            {
                $opportunity_bean = BeanFactory::getBean('Opportunities', $opportunity_id);
                if ($opportunity_bean) {

                    $opportunity_bean->load_relationship('tr_technicalrequests_opportunities');
                    $result = (isset($opportunity_bean->tr_technicalrequests_opportunities)) 
                        ? $opportunity_bean->tr_technicalrequests_opportunities->getBeans()
                        : array();
                }
            }

            return $result;
        }

        public static function get_opportunity_ids($tr_id)
        {
            $result = array();

            if(!empty($tr_id))
            {
                $tr_bean = BeanFactory::getBean('TR_TechnicalRequests', $tr_id);
                $tr_bean->load_relationship('tr_technicalrequests_opportunities');
                $opportunies = $tr_bean->tr_technicalrequests_opportunities->getBeans();

                $i = 0;
                foreach($opportunies as $opportunity)
                {
                    $result[$i] = $opportunity->id;
                    $i++;
                }
            }

            return $result;
        }

        public static function get_tr_annual_amount_weighted($annual_amount, $tr_probability_percentage)
        {
            $result = 0;

            if($annual_amount > 0 && $tr_probability_percentage > 0)
            {
                $result = $annual_amount * ($tr_probability_percentage / 100);
            }

            return $result;
        }

        public static function get_tr_probability_percentage($stage_id)
        {
            $result = 0;

            $stage_percentages = array(
                'understanding_requirements' => 1,
                'development' => 5,
                'quoting_or_proposing' => 10,
                'sampling' => 25,
                'production_trial' => 50,
                'award_eminent' => 75,
                'closed_won' => 100,
                'closed' => 100,
            );

            foreach($stage_percentages as $stage_percentage_id => $stage_percentage)
            {
                if($stage_percentage_id == $stage_id)
                {
                    $result = $stage_percentage;
                    break;
                }
            }
            
            return $result;
        }

        public static function get_related_tr_name($related_tr_bean)
        {
            global $log;
            $result = '';

            if(isset($related_tr_bean))
            {
                $pmString = "";
                if ($related_tr_bean->load_relationship('tr_technicalrequests_aos_products_2') && count($related_tr_bean->tr_technicalrequests_aos_products_2->getBeans()) > 0) {
                    $relatedProductMaster = reset($related_tr_bean->tr_technicalrequests_aos_products_2->getBeans());
                    $pmString .= " (PM {$relatedProductMaster->product_number_c}.{$relatedProductMaster->version_c})";
                }
                $version = (!empty($related_tr_bean->version_c)) ? (intval($related_tr_bean->version_c) + 1) : '1';
                $version = str_pad($version, 2, '0', STR_PAD_LEFT);
                $result = $related_tr_bean->technicalrequests_number_c . ' - ' . $related_tr_bean->name . $pmString;// . '.' . $version;
            }

            return $result;
        }

        public static function get_opp_trs_with_distros($opportunity_id)
        {
            $result = array();

            $opportunity_bean = BeanFactory::getBean('Opportunities', $opportunity_id);
            
            if (! empty($opportunity_bean->id)) {
                $opportunity_bean->load_relationship('tr_technicalrequests_opportunities');
                $opp_trs = $opportunity_bean->tr_technicalrequests_opportunities->getBeans();

                if (isset($opp_trs) && count($opp_trs) > 0) {
                    foreach($opp_trs as $tr_bean) {
                        $result[$tr_bean->id] = "TR {$tr_bean->technicalrequests_number_c}.{$tr_bean->version_c} - {$tr_bean->name}";
                    }

                    asort($result);
                    array_unshift($result, '');
                }
            }

            return $result;
        }

        //Colormatch #313 - My TR Dashlet
        public static function manipulateDisplay($sourceHTML, $th_list_width = null){
            global $log;

            $doc = new DOMDocument();
            $doc->loadHTML($sourceHTML);
            $xpath = new DOMXpath($doc);

            $trHTMLObj = $xpath->query("//table/thead/tr")->item(0);

            if (! $trHTMLObj) {
                return $sourceHTML;
            }

            //set width of thead
            $i = 0;

            if ($trHTMLObj) {
                foreach($trHTMLObj->getElementsByTagName('th') as $th) {
                    $width_in_percent = (!empty($th_list_width) && is_array($th_list_width) && !empty($th_list_width[$i])) 
                        ? $th_list_width[$i] : 10;
                    $th->setAttribute('style', "width: {$width_in_percent}%;");
                    $i++;
                }
            }
            
            $result = $doc->saveHTML($doc->getElementsByTagName('table')->item(0));
            return $result;
        }

        public static function tbdMarketEmailNotificationBody($trBean)
        {
            global $app_list_strings, $log, $sugar_config;

            if ($trBean) {
                $recordURL = $sugar_config['site_url'] . '/index.php?module=TR_TechnicalRequests&action=DetailView&record=' . $trBean->id;
                $emailObj = new Email();
                $defaults = $emailObj->getSystemDefaultEmail();
                $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
                
                $body = "
                    {$customQABanner}
                    
                    <p>Hi,</p>
                    <p>Please review the below for a new market request.</p>
                    <p>Module: Technical Requests <br/>
                    TR #: {$trBean->technicalrequests_number_c} <br/>
                    Type: {$app_list_strings['tr_technicalrequests_type_dom'][$trBean->type]} <br/>
                    Opportunity: {$trBean->tr_technicalrequests_opportunities_name}<br/>
                    Status: ".$app_list_strings['tr_technicalrequests_status_list'][$trBean->status]."<br>
                    Stage: {$app_list_strings['approval_stage_list'][$trBean->approval_stage]} <br/>
                    Account: {$trBean->tr_technicalrequests_accounts_name} <br/>
                    Markets: {$trBean->market_c}
                    </p>
                    <p>Click here to access the record: <a href='{$recordURL}'>{$recordURL}</a></p>
                    Thanks,
                    <br>
                    {$defaults['name']}
                    <br>
                ";

                return $body;

            }

            return '';

        }

        public function get_latest_closed_date($tr_related_beans)
        {
            $result = '';
            
            if (! empty($tr_related_beans)) {
                $trActualClosedDates = array();
                
                foreach ($tr_related_beans as $tr_related_bean) {
                    if (in_array($tr_related_bean->approval_stage, ['closed', 'closed_won', 'closed_lost', 'closed_rejected']) && $tr_related_bean->actual_close_date_c) {
                        $trActualClosedDates[] = date('Y-m-d', strtotime($tr_related_bean->actual_close_date_c));
                    }
                }

                $result = (count($trActualClosedDates) > 0) ? max($trActualClosedDates) : '';
            }

            return $result;
        }

        public static function closeIncompleteDistroAndTRItems($trBean)
        {
            // Distro Items
            $distroBean = BeanFactory::getBean('DSBTN_Distribution');
            $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$trBean->id}'", false, 0);

            if ($distroBeanList != null && count($distroBeanList) > 0) {
                foreach ($distroBeanList as $distroBean) {
                    $distroItemBean = BeanFactory::newBean('DSBTN_DistributionItems');
                    $distroItemBeanList = $distroItemBean->get_full_list('', "dsbtn_distribution_id_c = '{$distroBean->id}' AND status_c NOT IN ('complete', 'rejected')", false, 0);

                    if (isset($distroItemBeanList) && count($distroItemBeanList) > 0) {
                        foreach ($distroItemBeanList as $distroItemBean) {
                            $distroItemBean->status_c = 'rejected';
                            $distroItemBean->save();
                        }
                    }
                }
            }

            // TR Items
            $trBean->load_relationship('tri_technicalrequestitems_tr_technicalrequests');
            $trItemIds = $trBean->tri_technicalrequestitems_tr_technicalrequests->get();

            $trItemArray = [];

            foreach ($trItemIds as $trItemId) {
                array_push($trItemArray, "'{$trItemId}'");
            }

            $trItemIdsWhereIn = implode(', ', $trItemArray) ?? null;

            $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems');
            $trItemBeanFilterQuery = $trItemIdsWhereIn ? "tri_technicalrequestitems.id IN ({$trItemIdsWhereIn}) AND tri_technicalrequestitems.status NOT IN ('complete', 'rejected')" : "1=0";
            $trItemBeanList = $trItemBean->get_full_list('name', $trItemBeanFilterQuery, false, 0);

            if ($trItemBeanList != null && count($trItemBeanList) > 0) {
                foreach ($trItemBeanList as $trItemBean) {
                    $trItemBean->status = 'rejected';
                    $trItemBean->save();
                }
            }
        }

        public static function showOrHideTRPrintoutActionButton($trBean)
        {
            $showActionButton = false;

            if ($trBean->approval_stage == 'development' && in_array($trBean->status, ['approved', 'in_process', 'awaiting_target_resin'])) {
                $showActionButton = true;
            }
    
            return $showActionButton;
        }
        /***
         * Returns all (String) fields that are audited true
         */
        public static function getAuditedFields($trBean)
        {
            global $log;
            
            $auditedFields = [];

            foreach($trBean->field_defs as $key => $value) {

                if (array_key_exists('audited', $value) && $value['audited'] === true) {
                    if ($value['type'] == 'relate' && $value['source'] == 'non-db') {
                        $auditedFields[$value['id_name']] = $trBean->field_defs[$value['id_name']]; 
                    } else {
                        $auditedFields[$key] = $value;
                    }
                }
            }

            return array_keys($auditedFields);
        }

        /**
         * Helper function to iterate thru the TR audited = 1 fields and check if before and after values are changed
         * @param Bean Technical Request
         * @return Array of boolean value(s)
         */
        public static function beanFieldValueChangeChecker($trBean)
        {
            if ($trBean && $trBean->id) {
                $valueIsUpdated = []; // array of boolean values supplied when auditable field values are updated
                $beanAuditableFields = self::getAuditedFields($trBean); // retrieves TR fields that are audited => 1
                
                if (isset($trBean->rel_fields_before_value) && is_array($trBean->rel_fields_before_value) && count($trBean->rel_fields_before_value) > 0) {
                    if (isset($beanAuditableFields) && is_array($beanAuditableFields) && count($beanAuditableFields) > 0) {
                        foreach ($beanAuditableFields as $field){
                            if (array_key_exists($field, $trBean->rel_fields_before_value) && $trBean->{$field} != $trBean->rel_fields_before_value[$field]) {
                                // if it's a relate field, compare the before id values and the after id values
                                $valueIsUpdated[$field]= true;
                                continue;
                            } else if (!array_key_exists($field, $trBean->rel_fields_before_value) && $trBean->fetched_row[$field] != $trBean->{$field}) {
                                // if a regular or custom field that is NOT  in the rel_fields_before_value AND value has been updated
                                $valueIsUpdated[$field]= true;
                                continue;
                            } else {
                                $valueIsUpdated[$field]= false;
                            }
                        }

                        return $valueIsUpdated;
                    }
                }
            }
            
            return [false]; // return array with one value: FALSE; indicating bean has no audited = true field defs
        }

        public static function customTRItemsDistroItemsStatusAudit($parentIds = [], $beforeValueStr, $afterValueStr, $auditTable = null, $field_name = 'status')
        {
            global $current_user, $log, $db, $timedate;

            if (count($parentIds) == 0 || empty($parentIds)) {
                return false;
            }
            
            if (!isset($beforeValueStr) || empty($beforeValueStr)) {
                return false;
            }

            if (!isset($afterValueStr) || empty($afterValueStr)) {
                return false;
            }

            if ($beforeValueStr != $afterValueStr) {
                
                // Manual insert on calls_audit table
                $timeDateNow = $timedate->getNow()->asDb();

                foreach ($parentIds as $index => $parent_id) {
                    $newId = create_guid();
                    $query = "
                        INSERT INTO {$auditTable} (
                            `id`,
                            `parent_id`,
                            `date_created`,
                            `created_by`,
                            `field_name`,
                            `data_type`,
                            `before_value_string`,
                            `after_value_string`) 
                            
                            VALUES (
                                '{$newId}',
                                '{$parent_id}',
                                '{$timeDateNow}',
                                '{$current_user->id}',
                                '{$field_name}',
                                'enum',
                                '{$beforeValueStr}',
                                '{$afterValueStr}' );
                    ";
                    // $log->fatal($query);
                    $result = $db->query($query);
                } // end of foreach
            }



        }

        public static function handleCoverLetterPdfUploadOnGenerate($tcpdfObject, $trBean)
        {
            global $current_user, $log, $sugar_config, $db;
            
            $tmpFileName = "{$trBean->id}_tr_cover_letter";
            $docName = "TR-{$trBean->technicalrequests_number_c}-Cover-Letter.pdf";            
            $docRevision = new DocumentRevision();

            if (! file_exists($sugar_config['upload_dir'] . $tmpFileName)) {
                $tcpdfObject->Output("upload://$tmpFileName", 'F');

                // New Bean Document
                $docBean = BeanFactory::newBean('Documents');
                $docBean->status_id = 'Active';
                $docBean->doc_type = 'Sugar';
                $docBean->document_name = $docName;
                $docBean->assigned_user_id = $current_user->id;
                $docBean->assigned_user_name = $current_user->name;
                $docBean->parent_type = 'TR_TechnicalRequests';
                $docBean->parent_id = $trBean->id;
                $docBean->upload_source_id = $trBean->id;// Used by Document.php to properly rename file based on upload source id
                $docBean->save(false);
                
                if ($docBean->load_relationship('tr_technicalrequests_documents')) {				
                    $docBean->tr_technicalrequests_documents->add($trBean->id); // Link document and the selected module
                }

                $docRevision->revision = 1;
                $docRevision->document_id = $docBean->id;
            } else {
                $documentQuery = $db->query("SELECT id FROM documents WHERE parent_type = 'TR_TechnicalRequests' AND parent_id = '{$trBean->id}' AND document_name LIKE 'TR-{$trBean->technicalrequests_number_c}-Cover-Letter%' AND deleted = 0");
                
                if ($documentQuery->num_rows == 1) {
                    $rowData = $db->fetchByAssoc($documentQuery); // array key == 'id'
                    
                    $docRevisionQuery = $db->query("SELECT document_name, revision, document_revision_id FROM documents, document_revisions where documents.id = '".$rowData['id']."' AND document_revisions.id = documents.document_revision_id order by revision desc limit 1");
                    
                    if ($docRevisionQuery->num_rows == 1) {
                        $docRevisionResult = $db->fetchByAssoc($docRevisionQuery);
                        $docRevision->revision = $docRevisionResult['revision'] + 1;
                        $docRevision->document_id = $rowData['id'];
                        
                        $tcpdfObject->Output("upload://$tmpFileName", 'F'); // Need to regenerate temp file to reflect changes
                    }
                }
            }

            $docRevision->filename = $docName;
            $docRevision->file_ext = 'pdf';
            $docRevision->file_mime_type = 'application/pdf';
            $docRevision->save(false);

            $file = $sugar_config['upload_dir'] . $trBean->id . '_tr_cover_letter';
            $newfile =  $sugar_config['upload_dir'] . $docRevision->id;

            if (! copy($file, $newfile)) {
                $log->fatal('failed to copy' . $trBean->id . '_tr_cover_letter');
            }

            return;
        }
    } // end of class

    

?>
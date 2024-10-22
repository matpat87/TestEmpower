<?php

    class DistributionHelper{

        public static $distro_items = array (
            'Documentation' => array (
                array(
                    'name' => 'Customer Required Documentation',
                    'value' => 'customer_required_documentation',
                    'description' => 'ea',
                    'category' => 'product_documentation',
                ),
                array(
                    'name' => 'Tech Data Sheet',
                    'value' => 'tech_data_sheet',
                    'description' => 'ea',
                    'category' => 'product_documentation',
                ),
                array(
                    'name' => 'Safety Data Sheet',
                    'value' => 'safety_data_sheet',
                    'description' => 'ea',
                    'category' => 'product_documentation',
                ),
                array(
                    'name' => 'CONEG/HMF',
                    'value' => 'coneg_hmf',
                    'description' => 'ea',
                    'category' => 'regulatory_documents',
                ),
                array(
                    'name' => 'FDA Letter',
                    'value' => 'fda_letter',
                    'description' => 'ea',
                    'category' => 'regulatory_documents',
                ),
                array(
                    'name' => 'Other Regulatory Docs',
                    'value' => 'other_regulatory_docs',
                    'description' => 'ea',
                    'category' => 'regulatory_documents',
                ),
                array(
                    'name' => 'REACH/ROHS',
                    'value' => 'reach_rohs',
                    'description' => 'ea',
                    'category' => 'regulatory_documents',
                ),
                array(
                    'name' => 'Prop 65',
                    'value' => 'prop_65',
                    'description' => 'ea',
                    'category' => 'regulatory_documents',
                ),
                array(
                    'name' => 'UL',
                    'value' => 'ul',
                    'description' => 'ea',
                    'category' => 'regulatory_documents',
                ),
                array(
                    'name' => 'COA',
                    'value' => 'coa',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'COC',
                    'value' => 'coc',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Spectral Data',
                    'value' => 'spectral_data',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Quote',
                    'value' => 'quote',
                    'description' => 'ea',
                    'category' => 'quote',
                ),
            ),
            'Lab Items' => array (
                array(
                    'name' => '3D Mold - Part',
                    'value' => '3d_mold_part',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => '3D Mold - Flask',
                    'value' => '3d_mold_flask',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Auto Plaque',
                    'value' => 'auto_plaque',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Blown Film',
                    'value' => 'blown_film',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Cast Film',
                    'value' => 'cast_film',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Customer Specified Mold',
                    'value' => 'customer_specified_mold',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Deodorant Cap',
                    'value' => 'deodorant_cap', 
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Flat Chips',
                    'value' => 'flat_chips',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Laser Marked Chips',
                    'value' => 'laser_marked_chips',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Press Outs',
                    'value' => 'press_outs',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Roto Cubes',
                    'value' => 'roto_cubes',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Sample Concentrate',
                    'value' => 'sample_concentrate',
                    'description' => 'lbs',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Sample Dry Color',
                    'value' => 'sample_dry_color',
                    'description' => 'g',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Step Chips',
                    'value' => 'step_chips',
                    'description' => 'ea',
                    'category' => 'lab',
                ),
                array(
                    'name' => 'Colormatch',
                    'value' => 'colormatch_task',
                    'description' => 'ea',
                    'category' => 'lab',
                    'tr_item_only' => true,
                ),
                /*  Ontrack #1662: Reverted logic on generating a SDS task; SDS is now separated from the Sample;
                    array(
                        'name' => 'SDS',
                        'value' => 'sds_task',
                        'description' => 'ea',
                        'category' => 'lab',
                        'tr_item_only' => true,
                    ), 
                */
            ),
        );

        public static $shipping_methods = array(
            array( 'name' => '', 'value' => '' ),
            array( 'name' => 'USPS', 'value' => 'usps' ),
            array( 'name' => 'FedEx', 'value' => 'fedex' ),
            array( 'name' => 'UPS', 'value' => 'ups' ),
            array( 'name' => 'DHL', 'value' => 'dhl' ),
            array( 'name' => 'Email', 'value' => 'email' ),
            array( 'name' => 'Customer Pickup', 'value' => 'customer_pickup' ),
            array( 'name' => 'Salesperson', 'value' => 'salesperson' ),
            array( 'name' => 'Other', 'value' => 'other' ),
        );

        public static $statuses = array(
            array( 'name' => '', 'value' => '' ),
            array( 'name' => '1 - New', 'value' => 'new' ),
            array( 'name' => '2 - Ready', 'value' => 'ready' ),
            array( 'name' => '3 - Complete', 'value' => 'complete' ),
            array( 'name' => 'Rejected', 'value' => 'rejected' ),
            array( 'name' => 'On Hold', 'value' => 'onHold' ),
        );

        public static function is_id_exists($id)
        {
            global $db;
            $result = false;

            $data = $db->query("select id 
                from dsbtn_distribution 
                where dsbtn_distribution.id = '{$id}'");
            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null && !empty($rowData['id']))
            {
                $result = true;
            }

            return $result;
        } 

        public static function assign_distribution_number($distribution_id = '')
        {
            global $db;
            $result = 0;
            
            $distribution_bean = BeanFactory::getBean('DSBTN_Distribution');
            $distribution_list = $distribution_bean->get_full_list('id', "dsbtn_distribution.id = '{$distribution_id}'", false, 0);

            if(!empty($distribution_list) && count($distribution_list) > 0)
            {
                $result = $distribution_list[0]->distribution_number_c;
            }
            else
            {
                $data = $db->query("select distribution_number_c 
                    from dsbtn_distribution_cstm 
                    order by distribution_number_c desc
                    limit 1");
                $rowData = $db->fetchByAssoc($data);
        
                if($rowData != null)
                {
                    $result = $rowData['distribution_number_c'];
                }
                
                $result += 1;
            }
    
            return $result;
        }

        public static function GetDistributionItemsDetailView($module, $bean_id)
        {
            global $app;

            $distribution_items_bean = BeanFactory::newBean('DSBTN_DistributionItems');

            if ($module == 'DSBTN_Distribution') {
                $distribution_data = $distribution_items_bean->get_full_list('row_order_c', "dsbtn_distribution_id_c = '$bean_id'", false, 0);
            }
            
            if ($module == 'Contacts') {
                $distribution_data = $distribution_items_bean->get_full_list('row_order_c', "contact_id_c = '$bean_id'", false, 0);
            }

            $tr_html = '';
    
            if(!empty($distribution_data)){
                foreach($distribution_data as $distribution_item)
                {
                    $assignedToBean = BeanFactory::getBean('Users', $distribution_item->assigned_user_id);

                    $tr_html .= '<tr>';
                    $tr_html .= '<td class="text-center">'. DistributionHelper::GetDistributionItemLabel($distribution_item->distribution_item_c) .'</td>';
                    $tr_html .= '<td class="text-center">'. $distribution_item->qty_c .'</td>';
                    $tr_html .= '<td class="text-center"> <label class="label">'.  DistributionHelper::GetUOM($distribution_item->distribution_item_c) .'</label> </td>';
                    $tr_html .= '<td class="text-center">'. DistributionHelper::GetShippingMethodLabel($distribution_item->shipping_method_c) .'</td>';
                    $tr_html .= '<td class="text-center">'. $distribution_item->account_information_c .'</td>';

                    if ($module == 'DSBTN_Distribution') {
                        $tr_html .= '<td class="text-center">'. DistributionHelper::GetStatusLabel($distribution_item->status_c) .'</td>';
                        $tr_html .= '<td class="text-center">'. $assignedToBean->name .'</td>';
                    }
                    
                    $tr_html .= '</tr>';
                }
            }

            return $tr_html;
        }

        public static function GetDistributionItemsEditView($module, $bean_id, $trId = '')
        {
            $distribution_items_bean = BeanFactory::newBean('DSBTN_DistributionItems');
            $siteColormatchCoordinatorBean = BeanFactory::newBean('Users');

            if ($module == 'DSBTN_Distribution') {
                $distribution_data = $distribution_items_bean->get_full_list('row_order_c', "dsbtn_distribution_id_c = '$bean_id'", false, 0);
                $distributionBean = BeanFactory::getBean('DSBTN_Distribution', $bean_id);
                $contactBean = BeanFactory::getBean('Contacts', $distributionBean->contact_id_c);

                if (! $distributionBean->tr_technicalrequests_id_c) {
                    $trBean = BeanFactory::getBean('TR_TechnicalRequests', $_REQUEST['parent_id']);
                } else {
                    $trBean = BeanFactory::getBean('TR_TechnicalRequests', $distributionBean->tr_technicalrequests_id_c);
                }

                if ($trBean->id && $trBean->site) {
                    $workGroupColormatchCoordinatorList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatchCoordinator' AND trwg_trworkinggroup.parent_type = 'Users'");
                    $siteColormatchCoordinatorBean = (!empty($workGroupColormatchCoordinatorList) && count($workGroupColormatchCoordinatorList) > 0) ? BeanFactory::getBean('Users', $workGroupColormatchCoordinatorList[0]->parent_id) : null;
                }
            }
            
            if ($module == 'Contacts' || $module == 'DistributionContact') {
                $distribution_data = $distribution_items_bean->get_full_list('row_order_c', "contact_id_c = '$bean_id'", false, 0);
                $contactBean = BeanFactory::getBean('Contacts', $bean_id);
            }            
            
            $tr_html = '';

            if(empty($bean_id) || ((! $distribution_data) || is_array($distribution_data) && count($distribution_data) < 1))
            {
                $tr_html .= '<tr>';
                
                
                $tr_html .= '<td>'. DistributionHelper::GetDistributionDropdown('') .'</td>';
                $tr_html .= '<td> <input type="text" name="qty[]" class="qty" /> </td>';
                $tr_html .= '<td class="text-center"> <label class="label uom"></label> <input type="hidden" name="uom[]" id="uom[]" class="uomHidden" /> </td>';
                $tr_html .= '<td>'. DistributionHelper::GetShippingMethodDropdown('') .'</td>';
                $tr_html .= '<td> <input type="text" name="account_information[]" class="account_information" /> </td>';

                if ($module == 'DSBTN_Distribution' || $module == 'DistributionContact') {
                    $tr_html .= '<td>'. DistributionHelper::GetStatusDropdown('new') .'</td>';
                    
                    $tr_html .= 
                        '<td style="padding-right: 20px;">' .
                            '<div>' .
                                '<input style="margin-top: 4px;" class="sqsEnabled sqsNoAutofill distro_item_assigned_user_name" autocomplete="off" type="text" name="distro_item_assigned_user_name[0]" id="distro_item_assigned_user_name_0" maxlength="50" value="'.$siteColormatchCoordinatorBean->name.'" placeholder="ColorMatch Coordinator">' .
                            
                                '<input type="hidden" name="distro_item_assigned_user_id[0]" id="distro_item_assigned_user_id_0"  maxlength="50" value="'.$siteColormatchCoordinatorBean->id.'">' .

                                '<button style="position: absolute; margin-top: 4px; margin-bottom: 2px; height: 32px; width: 32px; padding: 0px; padding-top: 5px;" title="Select User" accessKey="T" type="button" tabindex="116" class="button distro_item_assigned_user_name_button" value="Select" name="btn1" index="0"><span class="suitepicon suitepicon-action-select" style="color: inherit; font-size: 13px;"></span></button>' .
                            '</div>' .
                        '</td>';
                }
                        
                $tr_html .= "<td class=\"text-center\" style=\"display: flex; padding-left: 20px; margin-top: 6px; justify-content: center\">" .
                                 "<span style=\"margin-right: 10px;\" class=\"btn btn-info distribution-add glyphicon glyphicon-plus\" aria-hidden=\"true\" title=\"Add More\"></span>" .
                                 "<span class=\"btn btn-info distribution-remove glyphicon glyphicon-minus\" aria-hidden=\"true\" title=\"Remove\"></span>" .
                             "</td>";
                $tr_html .= '</tr>';
            }
            else
            {
                if(!empty($distribution_data))
                {
                    foreach($distribution_data as $key => $distribution_item)
                    {
                        $tr_html .= '<tr>';


                        $tr_html .= '<td>'. DistributionHelper::GetDistributionDropdown($distribution_item->distribution_item_c) .'</td>';
                        $tr_html .= '<td> <input type="text" name="qty[]" class="qty" value="'. $distribution_item->qty_c .'" /> </td>';
                        $tr_html .= '<td class="text-center"> <label class="label uom">'.  DistributionHelper::GetUOM($distribution_item->distribution_item_c) .'</label> <input type="hidden" name="uom[]" id="uom[]" class="uomHidden" value="'. DistributionHelper::GetUOM($distribution_item->distribution_item_c) .'" /> </td>';
                        $tr_html .= '<td>'. DistributionHelper::GetShippingMethodDropdown($distribution_item->shipping_method_c) .'</td>';
                        $tr_html .= '<td> <input type="text" name="account_information[]" class="account_information" value="'. $distribution_item->account_information_c .'" /> </td>';

                        if ($module == 'DSBTN_Distribution' || $module == 'DistributionContact') {
                            
                            // On page load, retrieve Distro items with existing assigned users, but if contact is changed, retrieve distro items but set assigned user value(s) to site coordinator
                            if ($module == 'DSBTN_Distribution') {
                                $assignedToBean = (! $distribution_item->assigned_user_id) ? $siteColormatchCoordinatorBean : BeanFactory::getBean('Users', $distribution_item->assigned_user_id);
                                $tr_html .= (! $distribution_item->status_c) ? '<td>'. DistributionHelper::GetStatusDropdown('new') .'</td>' : '<td>'. DistributionHelper::GetStatusDropdown($distribution_item->status_c) .'</td>';
                            } else {
                                $assignedToBean = $siteColormatchCoordinatorBean;
                                $tr_html .= '<td>'. DistributionHelper::GetStatusDropdown('new') .'</td>';
                            }
                            
                            $tr_html .= 
                                '<td style="padding-right: 20px;">' .
                                    '<div>' .
                                        '<input style="margin-top: 4px;" class="sqsEnabled sqsNoAutofill distro_item_assigned_user_name" autocomplete="off" type="text" name="distro_item_assigned_user_name['.$key.']" id="distro_item_assigned_user_name_'.$key.'" maxlength="50" value="'.$assignedToBean->name.'" placeholder="ColorMatch Coordinator">' .
                                    
                                        '<input type="hidden" name="distro_item_assigned_user_id['.$key.']" id="distro_item_assigned_user_id_'.$key.'"  maxlength="50" value="'.$assignedToBean->id.'">' .

                                        '<button style="position: absolute; margin-top: 4px; margin-bottom: 2px; height: 32px; width: 32px; padding: 0px; padding-top: 5px;" title="Select User" accessKey="T" type="button" tabindex="116" class="button distro_item_assigned_user_name_button" value="Select" name="btn1" index="'.$key.'"><span class="suitepicon suitepicon-action-select" style="color: inherit; font-size: 13px;"></span></button>' .
                                    '</div>' .
                                '</td>';
                        }
                        
                        $tr_html .= "<td class=\"text-center\" style=\"display: flex; padding-left: 20px; margin-top: 6px; justify-content: center\">" .
                                        "<span style=\"margin-right: 10px;\" class=\"btn btn-info distribution-add glyphicon glyphicon-plus\" aria-hidden=\"true\" title=\"Add More\"></span>" .
                                        "<span class=\"btn btn-info distribution-remove glyphicon glyphicon-minus\" aria-hidden=\"true\" title=\"Remove\"></span>" .
                                    "</td>";
                        $tr_html .= '</tr>';
                    }
                }
            }
            
            if ($contactBean->id) {
                $contactEmail = $contactBean->emailAddress->getPrimaryAddress($contactBean);
                $tr_html .= "<input type=\"hidden\" id=\"hidden-contact-email\" value=\"{$contactEmail}\" />";
            }
            
            return $tr_html;
        }

        private static function GetDistributionDropdown($selected)
        {
            global $log;
            
            $result = '<select name="distribution_item[]" class="distribution_item form-control">';
            
            // Filter Distribution items - Ontrack 1696
            $filteredDistroItemsArr = self::filterDistributionDropdown($selected);

            // array_sort_by_column(DistributionHelper::$distro_items['Documentation'], 'name');
            // array_sort_by_column(DistributionHelper::$distro_items['Lab Items'], 'name');

            array_sort_by_column($filteredDistroItemsArr['Documentation'], 'name');
            array_sort_by_column($filteredDistroItemsArr['Lab Items'], 'name');

            $result .= '<option value="" data-description=""></option>';

            foreach ($filteredDistroItemsArr as $distro_item_opt_group_keys => $distro_item_opt_groups) {
                $result .= '<optgroup label="'.$distro_item_opt_group_keys.'">';
                
                foreach ($distro_item_opt_groups as $distro_item) {
                    if (! $distro_item['tr_item_only']) {
                        $result .= '<option value="'. $distro_item['value'] .'" data-description="'. $distro_item['description'] .'"';

                        if(!empty($selected) && $distro_item['value'] == $selected) {
                            $result .= ' selected="selected"';
                        }

                        $result .= '> '. $distro_item['name'] .' </option>';
                    }
                }

                $result .= '</optgroup>';
            }

            $result .= '</select>';

            return $result;
        }

        /**
            * @author Glai Obido
            * Ontrack #1696
            * Handle filtering Distro Items dropdown list based on parent TR Type
            * 
        */
        public static function filterDistributionDropdown($selected = '')
        {
            global $log;
            
            // On Create Distro
            if (!empty($_REQUEST['parent_id']) && !empty($_REQUEST['parent_module']) && $_REQUEST['parent_module'] == 'TR_TechnicalRequests') {
                $parentTrBean = BeanFactory::getBean('TR_TechnicalRequests', $_REQUEST['parent_id']); 
                
            } elseif (!empty($selected) && $_REQUEST['module'] == 'DSBTN_Distribution' && !empty($_REQUEST['record'])) { 
                // On Edit Distro
                $dsbtnBean = BeanFactory::getBean('DSBTN_Distribution', $_REQUEST['record']);
                $parentTrBean = BeanFactory::getBean('TR_TechnicalRequests', $dsbtnBean->tr_technicalrequests_id_c);
                
            } elseif($_REQUEST['module'] == 'DSBTN_Distribution' && $_REQUEST['action'] == 'retrieve_contact_distribution_items' && !empty($_REQUEST['contact_id']) && !empty($_REQUEST['tr_id'])) {
                // On ajax triggered event for changing the distribution contact_id
                $parentTrBean = BeanFactory::getBean('TR_TechnicalRequests', $_REQUEST['tr_id']);

                
            } elseif ($_REQUEST['module'] == 'DSBTN_Distribution' && $_REQUEST['action'] == 'retrieve_dsbtn_items_dropdown_list' && !empty($_REQUEST['tr_id'])) {
                // On create Distro but pre populated TR is updated: triggered from an ajax request on change tr_id
                $parentTrBean = BeanFactory::getBean('TR_TechnicalRequests', ($_REQUEST['tr_id']));
            } else {
                // Safety Net
                return DistributionHelper::$distro_items;
            }

            $filteredItemsArray['Documentation'] = array_filter(DistributionHelper::$distro_items['Documentation'], function($itemArray) use ($parentTrBean, $selected) {
                switch ($parentTrBean->type) {
                    case 'lab_items':
                        return in_array($itemArray['value'], ['', 'spectral_data', $selected]);
                    default:
                        return $itemArray;
                } // end of switch-case

            });  // end of array_filter

            $filteredItemsArray['Lab Items'] = array_filter(DistributionHelper::$distro_items['Lab Items'], function($itemArray) use ($parentTrBean, $selected) {
                switch ($parentTrBean->type) {
                    case 'lab_items':
                        return !in_array($itemArray['value'], ['', 'sample_concentrate', 'sample_dry_color']);
                    default:
                        return $itemArray;
                } // end of switch-case

            });  // end of array_filter

            

            return $filteredItemsArray;
        }

        private static function GetShippingMethodDropdown($selected)
        {
            $result = '<select name="shipping_method[]" class="shipping_method form-control">';

            // array_sort_by_column(DistributionHelper::$shipping_methods, 'name');
            foreach(DistributionHelper::$shipping_methods as $shipping_method)
            {
                $result .= '<option value="'. $shipping_method['value'] .'"';

                if(!empty($selected) && $shipping_method['value'] == $selected)
                {
                    $result .= ' selected="selected"';
                }

                $result .= '> '. $shipping_method['name'] .' </option>';
            }

            $result .= '</select>';

            return $result;
        }

        private static function GetStatusDropdown($selected)
        {
            $result = '<select name="status[]" class="status form-control">';

            foreach(DistributionHelper::$statuses as $status)
            {
                $result .= '<option value="'. $status['value'] .'"';

                if(!empty($selected) && $status['value'] == $selected)
                {
                    $result .= ' selected="selected"';
                }

                $result .= '> '. $status['name'] .' </option>';
            }

            $result .= '</select>';

            return $result;
        }

        public static function GetUOM($distribution_item_val)
        {
            $result = '';

            foreach(DistributionHelper::$distro_items as $distro_item_opt_groups) {
                foreach($distro_item_opt_groups as $distro_item) {
                    if ($distro_item['value'] == $distribution_item_val) {
                        $result = $distro_item['description'];
                    }
                }
            }

            return $result;
        }

        public static function GetDistributionItemLabel($distribution_item_val)
        {
            $result = '';

            foreach(DistributionHelper::$distro_items as $distro_item_opt_groups) {
                foreach ($distro_item_opt_groups as $distro_item) {
                    if($distro_item['value'] == $distribution_item_val) {
                        $result = $distro_item['name'];
                    }
                }
            }

            return $result;
        }
        
        public static function GetShippingMethodLabel($shipping_method_val)
        {
            $result = '';

            foreach(DistributionHelper::$shipping_methods as $shipping_method)
            {
                if($shipping_method['value'] == $shipping_method_val)
                {
                    $result = $shipping_method['name'];
                }
            }

            return $result;
        }

        public static function GetStatusLabel($status_val)
        {
            $result = '';

            foreach(DistributionHelper::$statuses as $status)
            {
                if($status['value'] == $status_val)
                {
                    $result = $status['name'];
                }
            }

            return $result;
        }

        public static function GetDistroItemKeyEquivalentBeans($bean)
        {
            foreach (DistributionHelper::$distro_items['Documentation'] as $distro_item) {
                if ($bean->fetched_row['distribution_item_c'] === $distro_item['name']) {
                    $bean->fetched_row['distribution_item_c'] = $distro_item['value'];
                }
            }

            foreach (DistributionHelper::$distro_items['Lab Items'] as $distro_item) {
                if ($bean->fetched_row['distribution_item_c'] === $distro_item['name']) {
                    $bean->fetched_row['distribution_item_c'] = $distro_item['value'];
                }
            }

            foreach(DistributionHelper::$shipping_methods as $shipping_method)
            {
                if($bean->fetched_row['shipping_method_c'] === $shipping_method['name'])
                {
                    $bean->fetched_row['shipping_method_c'] = $shipping_method['value'];
                }
            }

            foreach(DistributionHelper::$statuses as $status)
            {
                if($bean->fetched_row['status_c'] === $status['name'])
                {
                    $bean->fetched_row['status_c'] = $status['value'];
                }
            }

            return $bean;
        }

        public static function handleColormatchCoordinatorDistroItemsReassignment($trBean, $prevColormatchCoordinator)
        {
            if ($trBean->id && $trBean->site) {
                $workGroupColormatchCoordinatorList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatchCoordinator' AND trwg_trworkinggroup.parent_type = 'Users'");
                $siteColormatchCoordinatorBean = (!empty($workGroupColormatchCoordinatorList) && count($workGroupColormatchCoordinatorList) > 0) ? BeanFactory::getBean('Users', $workGroupColormatchCoordinatorList[0]->parent_id) : null;

                if ($siteColormatchCoordinatorBean && $siteColormatchCoordinatorBean->id) {
                    $distroBean = BeanFactory::getBean('DSBTN_Distribution');
                    $distroBeanList = $distroBean->get_full_list('', "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$trBean->id}'", false, 0);
                    $distroBeanArray = [];

                    if ($distroBeanList != null && count($distroBeanList) > 0) {
                        foreach ($distroBeanList as $distroBean) {
                            $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems');
                            $distroItemBeanList = $distroItemBean->get_full_list('dsbtn_distributionitems_cstm.distribution_item_c', "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}' AND dsbtn_distributionitems_cstm.status_c NOT IN ('complete', 'rejected') AND dsbtn_distributionitems.assigned_user_id = '{$prevColormatchCoordinator->id}' ", false, 0);

                            if (isset($distroItemBeanList) && count($distroItemBeanList) > 0) {
                                foreach ($distroItemBeanList as $distroItemBean) {
                                    if ((! $distroItemBean->assigned_user_id) || ($distroItemBean->assigned_user_id != $siteColormatchCoordinatorBean->id)) {
                                        $distroItemBean->assigned_user_id = $siteColormatchCoordinatorBean->id;
                                        $distroItemBean->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

?>
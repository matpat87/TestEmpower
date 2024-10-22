<?php

    class ProductHelper{
        
        public static function is_id_exists($id)
        {
            global $db;
            $result = false;

            $data = $db->query("select id 
                from aos_products 
                where aos_products.id = '{$id}'");
            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null && !empty($rowData['id']))
            {
                $result = true;
            }

            return $result;
        } 

        public static function get_version($product_number_c)
        {
            global $db;
            $result = 0;
            $version = 0;

            $query = "select version_c 
            from aos_products as a
            inner join aos_products_cstm as ac
                on ac.id_c = a.id
            where a.deleted = 0
                and ac.product_number_c = '{$product_number_c}'
                and ac.product_number_c <> 'TBD'
            order by ac.version_c desc
            limit 1";
            $data = $db->query($query);

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

        public static function get_statuses($typeParam)
        {
            global $app_list_strings, $log;
            $status_defaults = $app_list_strings['aos_products_status_list'];
            $result = array();
            
            $data = array(
                'development' => array(
                    'new', 'in_process', 'complete', 'rejected'
                ),
                'production' => array(
                    'active', 'inactive'
                )
            );

            foreach($data as $status_key => $statuses)
            {
                if($status_key == $typeParam)
                {
                    foreach($statuses as $status)
                    {
                        $result[$status] = $status_defaults[$status];
                    }
                }
            }

            return $result;
        }

        public static function generate_number_sequence($isNewRecord, $base_resin, $color, $cm_product_form, 
            $carrier_resin, $fda_eu_food_contract, $product_id = '', $category_code = '')
        {
            global $log;

            $result = '';
            $productBean = $product_id ? BeanFactory::getBean('AOS_Products', $product_id) : null;
            $productCategoryBean = BeanFactory::getBean('AOS_Product_Categories', $productBean->product_category_c);

            if(((isset($base_resin) && $base_resin == 0) || !empty($base_resin)) && !empty($color))
            {
                $sequence = '';
                $carrier_resin_edited = (empty($carrier_resin)) ? 'XXX' : $carrier_resin;
                $fda_eu_food_contract = (empty($fda_eu_food_contract) || $fda_eu_food_contract != 'yes') ? '' : '-F';
                $base_resin_and_color = $base_resin . $color;
                $sequences = ProductHelper::get_number_sequencer($base_resin_and_color);
                $sequences_count = count($sequences);
                
                if ($isNewRecord) {
                    $sequence = ($sequences_count > 0) ? str_pad(($sequences_count + 1), 4, '0', STR_PAD_LEFT) : '0001';
                } else {
                    // Check if alphabet exists on substr for prod num, if true, modify substr to take 1 step backward to properly retrieve the sequence number
                    if (preg_match("/[a-z]/i", substr($productBean->product_number_c, 4, 4))) {
                        $sequence = substr($productBean->product_number_c, 3, 4);
                    } else {
                        $sequence = substr($productBean->product_number_c, 4, 4); 
                    }
                }

                $result = $base_resin . $color . $sequence . $cm_product_form . $carrier_resin . $category_code . $fda_eu_food_contract;
            }
            else
            {
                $result = $productBean->product_number_c;
            }

            return $result;
        }

        public static function generate_number_sequence_v2($isNewRecord, $base_resin, $color, $cm_product_form, 
            $carrier_resin, $fda_eu_food_contract, $product_id = '', $category_code = '')
        {
            global $log;

            $result = '';
            $productBean = $product_id ? BeanFactory::getBean('AOS_Products', $product_id) : null;
            $productCategoryBean = BeanFactory::getBean('AOS_Product_Categories', $productBean->product_category_c);

            if(((isset($base_resin) && $base_resin == 0) || !empty($base_resin)) && !empty($color))
            {
                $sequence = '';
                $carrier_resin_edited = (empty($carrier_resin)) ? 'XXX' : $carrier_resin;
                $fda_eu_food_contract = (empty($fda_eu_food_contract) || $fda_eu_food_contract != 'yes') ? '' : '-F';
                $base_resin_and_color = $base_resin . $color;
                $sequences_count = (int) ProductHelper::get_number_sequencer_v3($base_resin_and_color);
                
                if ($isNewRecord) {
                    $sequence = (!empty($sequences_count)) ? str_pad(($sequences_count + 1), 4, '0', STR_PAD_LEFT) : '0001';
                } else {
                    // Check if alphabet exists on substr for prod num, if true, modify substr to take 1 step backward to properly retrieve the sequence number
                    if (preg_match("/[a-z]/i", substr($productBean->product_number_c, 4, 4))) {
                        $sequence = substr($productBean->product_number_c, 3, 4);
                    } else {
                        $sequence = substr($productBean->product_number_c, 4, 4); 
                    }
                }

                $result = $base_resin . $color . $sequence . $cm_product_form . $carrier_resin . $category_code . $fda_eu_food_contract;
            }
            else
            {
                $result = $productBean->product_number_c;
            }

            return $result;
        }

        public static function get_number_sequencer($base_resin_and_color)
        {
            global $log, $db;
            $result = array();

            $query = "select p.id, pc.product_number_c
                    from aos_products as p
                    inner join aos_products_cstm pc
                        on pc.id_c = p.id
                    where pc.product_number_c like '{$base_resin_and_color}%'
                    and p.deleted = 0 ";
            $data = $db->query($query);

            while($rowData = $db->fetchByAssoc($data))
            {
                $result[$rowData['id']] = $rowData['product_number_c'];
            }

            return $result;
        }

        public static function get_number_sequencer_v2($base_resin_and_color)
        {
            global $log, $db;

            $query = "select p.id, pc.product_number_c
                    from aos_products as p
                    inner join aos_products_cstm pc
                        on pc.id_c = p.id
                    where pc.product_number_c like '{$base_resin_and_color}%'
                        and p.deleted = 0
                    order by pc.product_number_c desc
                    limit 1 ";
            $data = $db->query($query);
            $rowData = $db->fetchByAssoc($data);

            $sequence = '';
            if(!empty($rowData['product_number_c'])){
                // if (preg_match("/[a-z]/i", substr($rowData['product_number_c'], 4, 4))) {
                //     $sequence = substr($rowData['product_number_c'], 3, 4);
                // } else {
                    $sequence = substr($rowData['product_number_c'], 4, 4); 
                //}
            }

            return $sequence;
        }

        public static function get_number_sequencer_list($base_resin_and_color)
        {
            global $log, $db;
            $result = array();

            $query = "select p.id, pc.product_number_c
                    from aos_products as p
                    inner join aos_products_cstm pc
                        on pc.id_c = p.id
                    where pc.product_number_c like '{$base_resin_and_color}%'
                        and p.deleted = 0 ";

            $data = $db->query($query);

            while($rowData = $db->fetchByAssoc($data)){
                $result[] = $rowData;
            }

            return $result;
        }

        public static function get_number_sequencer_v3($base_resin_and_color){
            global $log, $db;
            $result = 0;

            $sequence_list = ProductHelper::get_number_sequencer_list($base_resin_and_color);
            $sequence = '';
            $intSequence = 0;

            if(count($sequence_list) > 0){

                foreach($sequence_list as $sequence){
                    $sequence = substr($sequence['product_number_c'], 4, 4); 
                    $intSequence = (int) $sequence;

                    //echo "${sequence} ${intSequence} == ${result} <br/>";

                    if($intSequence > $result){
                        $result = $intSequence;
                    }
                }
            }

            return $result;
        }

        public static function get_site_by_id($tr_site_id)
        {
            $result = '';
            $data = array(1 => 'Salisbury', 2 => 'Delaware', 3 => 'Lambertville', 4 => 'Leominster', 5 => 'Niles');

            foreach($data as $key => $item)
            {
                if($key == $tr_site_id)
                {
                    $result = $item;
                }
            }

            return $result;
        }
        
        public static function get_product_num_with_version($product_bean, $is_link = false)
        {
            $result = '';

            if($product_bean != null)
            {
                $result = $product_bean->product_number_c . '.' . $product_bean->version_c;

                if($is_link)
                {
                    $result = '<a href="index.php?module=AOS_Products&action=DetailView&record='. $product_bean->id .'">'. $result .'</a>';
                }
            }

            return $result;
        }

        public static function get_product_bean_db($product_id)
        {
            global $log;
            $result = null;

            if(!empty($product_id))
            {
                $product_bean = BeanFactory::getBean('AOS_Products');
                $products_data = $product_bean->get_full_list('name', "aos_products.id='{$product_id}'", false, 0);

                if(isset($products_data)){
                    $result = $products_data[0];
                }
            }

            return $result;
        }

        //Colormatch #227
        public static function get_site_coordinator($site)
        {
            $result = array('success' => false, 'data' => array());
            
            $aclRolesBean = BeanFactory::getBean('ACLRoles')->retrieve_by_string_fields(
                ['name' => 'Colormatch Coordinator'],
                false,
                true
            );

            if ($aclRolesBean && $site) {
                $userBeanList = $aclRolesBean->get_linked_beans(
                    'users', 'Users', array(), 0, -1, 0,
                    "(users_cstm.site_c LIKE '%^{$site}^%' OR users_cstm.site_c LIKE '%{$site}%') AND users.status = 'Active'"
                );

                if(!empty($userBeanList) && count($userBeanList) > 0) {
                    $result['success'] = true;
            
                    foreach($userBeanList as $userBean) {
                        array_push($result['data'], array('id' => $userBean->id, 'name' => $userBean->name ));
                    }
                }
            }

            return $result;
        }

        public static function get_resin_value($resin)
        {
            $result = $resin;

            if(strpos($resin, '_') !== false)
            {
                $result = substr($resin, 0, (strpos($resin, '_')));
            }

            return $result;
        }
    }

?>
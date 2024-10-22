<?php

    function get_product_categories($id = '')
    {
        global $db;

        $result = array('' => '');

        $query = "SELECT
                aos_product_categories.id, aos_product_categories.name
            FROM
                aos_product_categories
                    LEFT JOIN
                aos_product_categories_cstm ON aos_product_categories.id = aos_product_categories_cstm.id_c
            WHERE
                aos_product_categories.deleted = 0
                    AND aos_product_categories_cstm.status_c = 'Active'
            ORDER BY name ASC";

        $data_result = $db->query($query);

        while($row = $db->fetchByAssoc($data_result))
        {
            $result[$row['id']] = $row['name'];
        }

        return $result;
    }

    function get_resin_data()
    {
        global $log, $app_list_strings;
        $result = array();

        foreach($app_list_strings['resin_type_list'] as $key => $val)
        {
            if(!empty($val) && strpos($val, '-') !== false){
                $val_arr = explode('-', $val);

                //Colormatch #294
                $label = $val_arr[1];
                if(count($val_arr) > 2)
                {
                    $label = substr($val, (strpos($val, '-') + 1));
                }

                $result[$key] = trim($label) . ' - (' . trim($val_arr[0]) . ')';
            }
            else{
                $result[$key] = $val;
            }
        }

        asort($result);

        return $result;
    }

    function get_sub_industry($industry = '')
    {
        global $log, $db;

        $result = array('' => '');


        $filter = (!is_object($industry) && $industry != '') ? " AND mkt_markets.name = '{$industry}' " : "";

        $query = "SELECT 
                    mkt_markets.id,
                    mkt_markets.name,
                    mkt_markets_cstm.sub_industry_c AS sub_industry
                FROM
                    mkt_markets
                        LEFT JOIN
                    mkt_markets_cstm ON mkt_markets.id = mkt_markets_cstm.id_c
                WHERE
                    mkt_markets.deleted = 0
                    {$filter}
                ORDER BY mkt_markets_cstm.sub_industry_c ASC";
        
        $data_result = $db->query($query);

        while($row = $db->fetchByAssoc($data_result))
        {
            $result[$row['id']] = $row['sub_industry'];
        }

        return $result;
    }

    // For OnTrack 1507 Implementation: customized Sub-Industry Dropdowns where Sub-Industry is selected first for filtering 
    // Industry Dropdown
    function get_sub_industry_dropdown($industry = '')
    {
        global $log, $db;

        $result = array('' => '');


        $filter = (!is_object($industry) && $industry != '') ? " AND mkt_markets.name = '{$industry}' " : "";

        $query = "SELECT 
                    mkt_markets_cstm.sub_industry_c AS sub_industry
                FROM
                    mkt_markets
                        LEFT JOIN
                    mkt_markets_cstm ON mkt_markets.id = mkt_markets_cstm.id_c
                WHERE
                    mkt_markets.deleted = 0
                   
                GROUP BY mkt_markets_cstm.sub_industry_c
                ORDER BY mkt_markets_cstm.sub_industry_c ASC";
        
        $data_result = $db->query($query);

        while($row = $db->fetchByAssoc($data_result))
        {
            $result[$row['sub_industry']] = $row['sub_industry'];
        }

        return $result;
    }

    // Custom markets dropdown value options from MKT_NewMarkets module
    function get_markets_dropdown()
    {
        global $log, $db;

        $result = array('' => '');

        $query = "SELECT 
                    mkt_newmarkets.id,
                    mkt_newmarkets.name
                FROM
                    mkt_newmarkets
                WHERE
                    mkt_newmarkets.deleted = 0
                ORDER BY mkt_newmarkets.name ASC";
        
        $data_result = $db->query($query);

        $otherRowArray = array();

        while($row = $db->fetchByAssoc($data_result))
        {
            if ($row['name'] == 'Other') {
                $otherRowArray = (count($otherRowArray) > 0) ? $otherRowArray : ['id' => $row['id'], 'name' => $row['name']];
            } else {
                $result[$row['id']] = $row['name'];
            }
            
        }

        if ($otherRowArray) {
            $result[$otherRowArray['id']] = $otherRowArray['name'];
        }

        return $result;
    }

    // Custom industries dropdown value options from MKT_Markets module
    function get_industries_dropdown()
    {
        global $log, $db, $app_list_strings;

        $result = array('' => '');

        $query = "SELECT 
                    mkt_markets.id,
                    mkt_markets.name
                FROM
                    mkt_markets
                WHERE
                    mkt_markets.deleted = 0
                ORDER BY mkt_markets.name ASC";
        
        $data_result = $db->query($query);

        while($row = $db->fetchByAssoc($data_result))
        {
            $result[$row['name']] = $app_list_strings['industry_dom'][$row['name']] ?? $row['name'];
        }

        return $result;
    }
    
    // Custom Competition dropdown value options from COMP_Competitor module
    function get_competition_dropdown()
    {
        global $log, $db, $app_list_strings;

        $result = array('' => '');

        $query = "SELECT 
                        id, name
                    FROM
                        comp_competition
                    WHERE
                        deleted = 0
                    ORDER BY name ASC";
        
        $data_result = $db->query($query);

        while($row = $db->fetchByAssoc($data_result))
        {
            $result[$row['id']] = $row['name'];
        }

        return $result;
    }

    // Custom site_list dropdown function: to filter sites
    // based on parameter
    function get_site_list_dropdown($object, $field_name = '', $current_value = '', $view='')
    {
        global $app_list_strings, $log;
        $excludedList = $object->field_name_map[$field_name]['function']['params']['excluded_list'] ?? $app_list_strings['excluded_site_list'];
        
        // Special case for TR_TechnicalRequests and Product Master module: apply remove site filter on these modules only: Ontrack 1995
        $excludedList = in_array($object->module_dir, ['TR_TechnicalRequests', 'AOS_Products']) ? $excludedList : [];

        $siteList = array_filter($app_list_strings['site_list'], function($val, $key) use ($excludedList, $current_value) {
            return !in_array($key, $excludedList) || $key == $current_value;
        },ARRAY_FILTER_USE_BOTH);
        
        return $siteList;

    }
?>
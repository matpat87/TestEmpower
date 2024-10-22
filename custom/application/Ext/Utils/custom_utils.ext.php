<?php 
 //WARNING: The contents of this file are auto-generated



    function get_product_categories($id = '')
    {
        global $db;

        $result = array('' => '');

        $query = "select id,
                    name
                from aos_product_categories
                where deleted = 0
                order by name asc";

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
            $result[$row['name']] = $app_list_strings['industry_dom'][$row['name']];
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


/**
 * User: Shad Mickelberry
 * Company: Jackal Software
 * Date: 2019-04-29
 * File Name: dropdown_functions.php
 */

function jcklAppendGetDashboards()
{

    require_once 'modules/jacka_DashboardAppend/jacka_DashboardAppend.php';
    $append = new jacka_DashboardAppend();

    $dropdown = $append->retrieveDashboardsEnum();

    return $dropdown;
}

?>
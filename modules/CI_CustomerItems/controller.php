<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class CI_CustomerItemsController extends SugarController
{
    public function action_retrieve_product_master()
    {
        $result = array('success' => true, 'data' => array());

        if (isset($_REQUEST['product_master_id']) && $_REQUEST['product_master_id']) {
            $productMasterBean = BeanFactory::getBean('AOS_Products', $_REQUEST['product_master_id']);

            $result['data'] = array (
                'product_master_non_db' => "{$productMasterBean->product_number_c}.{$productMasterBean->version_c}",
                'product_number_c' => $productMasterBean->product_number_c,
                'version_c' => $productMasterBean->version_c,
                'name' => $productMasterBean->name,
                'related_product_c' => $productMasterBean->related_product_c,
            );
        }

        echo json_encode($result);
    }

    public function action_retrieve_market_industry()
    {
        $result = array('success' => true, 'data' => array());
        $result['data']['industry'] = '';

        if (isset($_REQUEST['market_id']) && $_REQUEST['market_id']) {
            $marketBean = BeanFactory::getBean('MKT_Markets', $_REQUEST['market_id']);
            $result['data']['industry'] = $marketBean->industry;
        }

        echo json_encode($result);
    }

    public function action_update_case_account_id_session()
    {
        $_SESSION['case_account_id'] = $_REQUEST['case_account_id'];
        echo json_encode(true);
    }

    // Retrieves Sub Industry values via Ajax request
    public function action_get_sub_industry_dropdown()
    {
        global $log, $db;
        $customerProductId = $_GET['customer_product_id'];
        
        $subIndustries = get_sub_industry($_GET['industry']);

        if (isset($customerProductId)) {
            $opportunity = BeanFactory::getBean('CI_CustomerItems', $customerProductId);
            $subIndustry = $opportunity->sub_industry_c ?? '';
        }

        $result = array(
            'current_value' => ($subIndustry) ? $subIndustry : '',
            'dropdown_list' => $subIndustries
         );

        echo json_encode($result);
    }

    public function action_get_industry_dropdown()
    {
        global $log, $db, $app_list_strings;
            
        $customerProductID = $_GET['customer_product_id'];
        $subIndustry = $_GET['sub_industry'];
        $subIndustries = get_sub_industry_dropdown($_GET['industry']);
        $filterStr = '';
        
        if (isset($customerProductID)) {
            $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $customerProductID);
            $industry = $customerProductBean->sub_industry_c ?? ''; // set the selected value to the Industry ID instead of the industry_dom value
        }

        if (isset($subIndustry) && $subIndustry != '') {
            $filterStr = " AND mkt_markets_cstm.sub_industry_c = '{$subIndustry}'";
        }
        
        $industryBean = BeanFactory::getBean('MKT_Markets');
        $industryBeanList = $industryBean->get_full_list(
            'name',
            "mkt_markets.id IS NOT NULL {$filterStr}"
            );
        
        $filteredIndustryDom = array_map(function($industryItem) use ($app_list_strings){
            return $app_list_strings['industry_dom'][$industryItem];
        }, array_column($industryBeanList, 'name', 'id'));
        
        $filteredIndustryDom = array('' => '' ) + $filteredIndustryDom; // blank option at the beginning of an array
        
        $result = array(
            'current_value' => ($industry) ? $industry : '',
            'dropdown_list' => ($filterStr != '') ? $filteredIndustryDom: []
        );

        echo json_encode($result);
    }
} // end of class
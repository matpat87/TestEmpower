<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    $post = $_POST;
    $queryParams = array(
        'module' => 'Home',
        'action' => 'index',    
    );

    if(isset($post['parent_product_id']))
    {
        $product_new_bean = BeanFactory::newBean('AOS_Products');
        $product_new_bean->fetched_row['id'] = '';
        $product_new_bean->id = create_guid();
        $product_new_bean->new_with_id = true;
        $product_new_bean->status_c = 'Active';
        $product_new_bean->type = 'sample';

        $fields_to_copy = array('name', 'site_c', 'description', 
            'material_cost_type_c', 'tr_technicalrequests_aos_products_2_name', 'tr_technicalrequests_aos_products_2tr_technicalrequests_ida',
            'aos_product_category_name', 'aos_product_category_id', 'account_c',
            'account_id_c', 'aos_products_id_c', 'cas_c', 
            'unit_measure_c', 'oem_account_c',
            'account_id1_c', 'user_id_c', 'related_product_c');

        $source_product_bean = BeanFactory::getBean('AOS_Products', $post['parent_product_id']);
        $source_product_bean->aos_products_id_c = $post['parent_product_id'];
        $source_product_bean->status_c = 'Rejected';
        
        foreach (get_object_vars($source_product_bean) as $key => $value) {
            if(in_array($key, $fields_to_copy))
            {
                $product_new_bean->$key = $value;
            }
        }

        $product_new_bean->save();
        $source_product_bean->save();

        $queryParams = array(
            'module' => 'AOS_Products',
            'action' => 'DetailView',
            'record' => $product_new_bean->id,
        );
    }

    SugarApplication::redirect('index.php?' . http_build_query($queryParams));

?>
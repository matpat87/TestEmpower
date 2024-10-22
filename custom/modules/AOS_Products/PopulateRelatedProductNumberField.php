<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=AOS_Products&action=PopulateRelatedProductNumberField
populateRelatedProductNumberField();

function populateRelatedProductNumberField() 
{
    global $log, $db;

    $aosProductsBean = BeanFactory::getBean("AOS_Products");
    $aosProductsBeanList = $aosProductsBean->get_full_list(
        "id", 
        "(aos_products_cstm.aos_products_id_c != '' AND aos_products_cstm.aos_products_id_c IS NOT NULL)", 
        false, 
        0
    );

    if (count($aosProductsBeanList) > 0) {
        foreach ($aosProductsBeanList as $bean) {
            $relatedProductMasterBean = BeanFactory::getBean('AOS_Products', $bean->aos_products_id_c);

            if (! $relatedProductMasterBean->id) {
                continue;
            }

            // Stores Related Product # with format: <product_number>.<version_number>
            // Purpose is if in the event the related product masters are deleted and re-inserted, we can re-link based on the related product number and version
            $relatedProductNumber =  ($relatedProductMasterBean->product_number_c && $relatedProductMasterBean->version_c)
                ? "{$relatedProductMasterBean->product_number_c}.{$relatedProductMasterBean->version_c}"
                : "";
            
            if ($relatedProductNumber) {
                $updateQuery = "UPDATE aos_products 
                                LEFT JOIN aos_products_cstm 
                                ON aos_products.id = aos_products_cstm.id_c 
                                SET aos_products_cstm.related_product_number_c = '{$relatedProductNumber}'
                                WHERE aos_products.id = '{$bean->id}'";

                echo "<pre>";
                    print_r($updateQuery);
                echo "</pre></br>";

                $db->query($updateQuery);
            }
        }
    }
}
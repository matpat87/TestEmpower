<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=AOS_Products&action=UpdateProductNumberUltraPetStr
updateProductNumberUltraPetStr();

function updateProductNumberUltraPetStr() 
{
    global $log, $db;

    $aosProductsBean = BeanFactory::getBean('AOS_Products');
    $beanList = $aosProductsBean->get_full_list('id', "aos_products_cstm.product_number_c LIKE '%UltraPET%' AND aos_products.type='development'", false, 0);

    if (count($beanList) > 0) {
        foreach ($beanList as $productMaster) {
            $replaceStr = str_replace('UltraPET', "UP", $productMaster->product_number_c);
            
            $sql = "
                UPDATE aos_products
                    LEFT JOIN
                aos_products_cstm ON aos_products_cstm.id_c = aos_products.id
                    AND aos_products.deleted = 0 
                SET aos_products_cstm.product_number_c = '{$replaceStr}'
                WHERE aos_products.id = '{$productMaster->id}'
            ";

            $res = $db->query($sql);
        }
    }
}
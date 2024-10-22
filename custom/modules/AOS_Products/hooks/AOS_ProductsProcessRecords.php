<?php
    class AOS_ProductsProcessRecords{

        public function process_records($bean, $event, $arguments)
        {
            global $log;

            $productMasterBean = BeanFactory::getBean('AOS_Products', $bean->id);
            $bean->product_name_non_db = $productMasterBean->name;

            if(!empty($bean->product_category_c))
            {
                $product_category_bean = $account_bean = BeanFactory::getBean('AOS_Product_Categories', $bean->product_category_c);
                $bean->product_category_c = $product_category_bean->name;
            }

            $bean->version_c = "<div style='padding-left: 25px'>{$bean->version_c}</div>";
        }
    }

?>
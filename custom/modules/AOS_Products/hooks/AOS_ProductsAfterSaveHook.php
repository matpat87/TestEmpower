<?php
    require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');

    class AOS_ProductsAfterSaveHook{

        public function handleTRItemProductNumberUpdate(&$bean, $event, $arguments)
        {
            // If Product Number is updated, loop through TR Items and update their product numbers as well
            if ($bean->fetched_row['id'] && $bean->fetched_row['product_number_c'] != $bean->product_number_c) {
                // Bug in the core where it becomes an object if Edit is clicked from TR -> Product Master Subpanel then Save is triggered
                $trID = (is_object($bean->tr_technicalrequests_aos_products_2tr_technicalrequests_ida)) 
                    ? $_REQUEST['tr_technicalrequests_aos_products_2tr_technicalrequests_ida'] 
                    : $bean->tr_technicalrequests_aos_products_2tr_technicalrequests_ida;

                $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trID);

                if ($trBean && $trBean->id) {
                    $trItemBeanList = $trBean->get_linked_beans(
                        'tri_technicalrequestitems_tr_technicalrequests',
                        'TRI_TechnicalRequestItems',
                        array(),
                        0,
                        -1,
                        0,
                        ""
                    );
        
                    if (!empty($trItemBeanList) && count($trItemBeanList) > 0) {
                        foreach($trItemBeanList as $trItemBean) {
                            $trItemBean->product_number = $bean->product_number_c;
                            $trItemBean->save();
                        }
                    }
                }
            }
        }
    }

?>
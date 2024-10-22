<?php

    class CustomerItemsHelper
    {

        public static function tbdMarketEmailNotificationBody($customerItemBean)
        {
            global $app_list_strings, $log, $sugar_config;

            if ($customerItemBean) {
                $recordURL = $sugar_config['site_url'] . '/index.php?module=CI_CustomerItems&action=DetailView&record=' . $customerItemBean->id;
                $emailObj = new Email();
                $defaults = $emailObj->getSystemDefaultEmail();
                $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
                
                $body = "
                    {$customQABanner}
                    
                    <p>Hi,</p>
                    <p>Please review the below for a new market request.</p>
                    <p>Module: Customer Products <br/>
                    Product #: {$customerItemBean->product_number_c} <br/>
                    Product Name: {$customerItemBean->name}<br/>
                    Status: ".$app_list_strings['customer_products_status_list'][$customerItemBean->status]."<br>
                    Account: {$customerItemBean->ci_customeritems_accounts_name} <br/>
                    Markets: {$customerItemBean->mkt_markets_ci_customeritems_1_name}
                    </p>

                    <p>Click here to access the record: <a href='{$recordURL}'>{$recordURL}</a></p>
                    Thanks,
                    <br>
                    {$defaults['name']}
                    <br>
                ";

                return $body;

            }

            return '';

        }
    }

?>
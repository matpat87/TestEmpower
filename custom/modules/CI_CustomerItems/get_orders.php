<?php 
    function get_orders($args){
        $args = func_get_args();
        $customer_product_id = $_GET['record'];

        $return_array = "select odr_salesorders.id,
                            odr_salesorders.number,
                            aos_products_quotes.requested_date_c as due_date,
                            accounts.id as accounts_odr_salesorders_1accounts_ida,
	                        accounts.name as accounts_odr_salesorders_1_name,
                            odr_salesorders.status,
                            odr_salesorders.total_amount,
                            odr_salesorders.date_entered,
                            odr_salesorders.date_modified
                        from odr_salesorders
                        left join odr_salesorders_cstm os
                            on os.id_c = odr_salesorders.id
                        inner join aos_products_quotes
                            on aos_products_quotes.parent_id = odr_salesorders.id
                        inner join ci_customeritems_aos_products_quotes_c 
                            on ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesaos_products_quotes_idb = aos_products_quotes.id
                                and ci_customeritems_aos_products_quotes_c.deleted = 0
                                and ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesci_customeritems_ida = '{$customer_product_id}' 
                        left join ci_customeritems_accounts_c 
                            on ci_customeritems_accounts_c.ci_customeritems_accountsci_customeritems_idb = ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesci_customeritems_ida
                        left join accounts 
                            on accounts.id = ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida
                        where odr_salesorders.deleted = 0 ";

        return $return_array;
    }
?>
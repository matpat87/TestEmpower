<?php

function get_invoices($args){
    $args = func_get_args();
    $customer_product_id = $_GET['record'];

    $return_array = "select aos_invoices.id,
                        aos_invoices.number,
                        aos_products_quotes.requested_date_c as due_date,
                        accounts.id as billing_account_id,
                        accounts.name as billing_account,
                        aos_invoices.status,
                        aos_invoices.total_amt,
                        aos_invoices.date_entered,
                        aos_invoices.date_modified,
                        aos_invoices_cstm.requested_date_c
                    from aos_invoices
                    left join aos_invoices_cstm
                        on aos_invoices_cstm.id_c = aos_invoices.id
                    inner join aos_products_quotes
                        on aos_products_quotes.parent_id = aos_invoices.id
                    inner join ci_customeritems_aos_products_quotes_c 
                        on ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesaos_products_quotes_idb = aos_products_quotes.id
                            and ci_customeritems_aos_products_quotes_c.deleted = 0
                            and ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesci_customeritems_ida = '{$customer_product_id}' 
                    left join ci_customeritems_accounts_c 
                        on ci_customeritems_accounts_c.ci_customeritems_accountsci_customeritems_idb = ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesci_customeritems_ida
                    left join accounts 
                        on accounts.id = ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida
                    where aos_invoices.deleted = 0 ";

    return $return_array;
}

?>
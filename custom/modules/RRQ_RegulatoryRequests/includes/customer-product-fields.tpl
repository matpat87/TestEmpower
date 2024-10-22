<table id="tbl_customer_products" class="list view table-responsive" data-rows='{$CUSTOMER_PRODUCTS_DATA}'>
    <input tabindex="0"  type="hidden" id="site_colormatch_coordinator_id" value="">
    <input tabindex="0"  type="hidden" id="site_colormatch_coordinator_name" value="">
    <thead>
        <tr>
            <th scope="col" style="width: 20%; text-align: center;">Product #</th>
            <th scope="col" style="width: 20%; text-align: center;">Product Name</th>
            <th scope="col" style="width: 20%; text-align: center;">Application</th>
            <th scope="col" style="width: 20%; text-align: center;">OEM Account</th>
            <th scope="col" style="width: 20%; text-align: center;">Industry Name</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {* {$CUSTOMER_PRODUCTS_ROWS_HTML} *}
    </tbody>
</table>
{$CUSTOMER_PRODUCTS_MODAL_TEMPLATE_HTML}

<div style="display: none" id="cust_product_row_template">
	<table id="tbl_cust_product_row_template">
		<tbody>{$CUSTOMER_PRODUCTS_ROWS_TEMPLATE_HTML}</tbody>
	</table>
</div>
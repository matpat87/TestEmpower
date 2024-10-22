var sugar_mod_fields ={};sugar_mod_fields['Accounts'] = {"$ADDbilling":{"type":"none","req":false,"label":"","source":"non-db"},"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"billing_address_street":{"type":"varchar","req":false,"label":"LBL_BILLING_ADDRESS_STREET","inline_edit":false,"source":""},"billing_address_city":{"type":"varchar","req":false,"label":"LBL_BILLING_ADDRESS_CITY","inline_edit":false,"source":""},"billing_address_state":{"type":"enum","req":false,"label":"LBL_BILLING_ADDRESS_STATE","inline_edit":false,"options":"states_list","source":""},"billing_address_postalcode":{"type":"varchar","req":false,"label":"LBL_BILLING_ADDRESS_POSTALCODE","inline_edit":false,"source":""},"billing_address_country":{"type":"enum","req":false,"label":"LBL_BILLING_ADDRESS_COUNTRY","def":"US","inline_edit":false,"options":"countries_list","source":""},"phone_office":{"type":"phone","req":false,"label":"LBL_PHONE_OFFICE","source":""},"website":{"type":"url","req":false,"label":"LBL_WEBSITE","source":"","gen":0},"shipping_address_street":{"type":"varchar","req":false,"label":"LBL_SHIPPING_ADDRESS_STREET","inline_edit":false,"source":""},"shipping_address_city":{"type":"varchar","req":false,"label":"LBL_SHIPPING_ADDRESS_CITY","source":""},"shipping_address_state":{"type":"enum","req":false,"label":"LBL_SHIPPING_ADDRESS_STATE","options":"states_list","source":""},"shipping_address_postalcode":{"type":"varchar","req":false,"label":"LBL_SHIPPING_ADDRESS_POSTALCODE","source":""},"email1":{"type":"email","req":false,"label":"LBL_EMAIL"}};sugar_mod_fields['Contacts'] = {"$ADDprimary":{"type":"none","req":false,"label":"","source":"non-db"},"name":{"type":"name","req":false,"label":"LBL_NAME","source":"non-db"},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"first_name":{"type":"varchar","req":false,"label":"LBL_FIRST_NAME","source":""},"last_name":{"type":"varchar","req":true,"label":"LBL_LAST_NAME","source":""},"title":{"type":"varchar","req":false,"label":"LBL_TITLE","source":""},"phone_mobile":{"type":"phone","req":false,"label":"LBL_MOBILE_PHONE","source":""},"phone_work":{"type":"phone","req":false,"label":"LBL_OFFICE_PHONE","source":""},"email1":{"type":"email","req":false,"label":"LBL_EMAIL_ADDRESS"},"primary_address_street":{"type":"varchar","req":true,"label":"LBL_PRIMARY_ADDRESS_STREET","source":""},"primary_address_city":{"type":"varchar","req":true,"label":"LBL_PRIMARY_ADDRESS_CITY","source":""},"primary_address_state":{"type":"enum","req":true,"label":"LBL_PRIMARY_ADDRESS_STATE","inline_edit":false,"options":"states_list","source":""},"primary_address_postalcode":{"type":"varchar","req":true,"label":"LBL_PRIMARY_ADDRESS_POSTALCODE","source":""},"primary_address_country":{"type":"enum","req":true,"label":"LBL_PRIMARY_ADDRESS_COUNTRY","def":"US","inline_edit":false,"options":"countries_list","source":""},"account_name":{"type":"relate","req":true,"label":"LBL_ACCOUNT_NAME","module":"Accounts","id_name":"account_id","search":"non-db"}};sugar_mod_fields['Opportunities'] = {"name":{"type":"name","req":true,"label":"LBL_OPPORTUNITY_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"account_name":{"type":"relate","req":true,"label":"LBL_ACCOUNT_NAME","module":"Accounts","id_name":"account_id","search":"non-db"},"amount":{"type":"currency","req":false,"label":"LBL_AMOUNT","inline_edit":false,"options":"numeric_range_search_dom","source":""},"amount_usdollar":{"type":"currency","req":false,"label":"LBL_AMOUNT_USDOLLAR","source":""},"date_closed":{"type":"date","req":true,"label":"LBL_DATE_CLOSED","options":"date_range_search_dom","source":""},"sales_stage":{"type":"enum","req":true,"label":"LBL_SALES_STAGE","options":"sales_stage_dom","source":""}};sugar_mod_fields['Leads'] = {"$ADDprimary":{"type":"none","req":false,"label":"","source":"non-db"},"name":{"type":"name","req":false,"label":"LBL_NAME","source":"non-db"},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"first_name":{"type":"varchar","req":false,"label":"LBL_FIRST_NAME","source":""},"last_name":{"type":"varchar","req":false,"label":"LBL_LAST_NAME","source":""},"title":{"type":"varchar","req":false,"label":"LBL_TITLE","source":""},"phone_mobile":{"type":"phone","req":false,"label":"LBL_MOBILE_PHONE","source":""},"phone_work":{"type":"phone","req":false,"label":"LBL_OFFICE_PHONE","source":""},"email1":{"type":"email","req":false,"label":"LBL_EMAIL_ADDRESS"},"primary_address_street":{"type":"varchar","req":false,"label":"LBL_PRIMARY_ADDRESS_STREET","source":""},"primary_address_city":{"type":"varchar","req":false,"label":"LBL_PRIMARY_ADDRESS_CITY","source":""},"primary_address_state":{"type":"varchar","req":false,"label":"LBL_PRIMARY_ADDRESS_STATE","source":""},"primary_address_postalcode":{"type":"varchar","req":false,"label":"LBL_PRIMARY_ADDRESS_POSTALCODE","source":""},"primary_address_country":{"type":"varchar","req":false,"label":"LBL_PRIMARY_ADDRESS_COUNTRY","source":""},"converted":{"type":"bool","req":false,"label":"LBL_CONVERTED","source":""},"status":{"type":"enum","req":false,"label":"LBL_STATUS","options":"lead_status_dom","source":""},"account_name":{"type":"varchar","req":false,"label":"LBL_ACCOUNT_NAME","source":""}};sugar_mod_fields['Calls'] = {"name":{"type":"name","req":true,"label":"LBL_SUBJECT","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"duration_hours":{"type":"int","req":true,"label":"LBL_DURATION_HOURS","source":""},"duration_minutes":{"type":"int","req":false,"label":"LBL_DURATION_MINUTES","source":""},"date_start":{"type":"datetime","req":true,"label":"LBL_DATE","options":"date_range_search_dom","source":""},"date_end":{"type":"datetime","req":false,"label":"LBL_DATE_END","options":"date_range_search_dom","source":""},"parent_name":{"type":"parent","req":true,"label":"LBL_LIST_RELATED_TO","options":"parent_type_display","id_name":"parent_id","id_type":"parent_type"},"status":{"type":"enum","req":true,"label":"LBL_STATUS","def":"Planned","options":"call_status_dom","source":""},"direction":{"type":"enum","req":false,"label":"LBL_DIRECTION","options":"call_direction_dom","source":""},"reminder_checked":{"type":"bool","req":false,"label":"LBL_REMINDER","source":"non-db"},"reminder_time":{"type":"enum","req":false,"label":"LBL_REMINDER_TIME","def":"-1","options":"reminder_time_options","source":""},"repeat_type":{"type":"enum","req":false,"label":"LBL_REPEAT_TYPE","options":"repeat_type_dom","source":""},"repeat_interval":{"type":"int","req":false,"label":"LBL_REPEAT_INTERVAL","def":"1","source":""},"repeat_dow":{"type":"varchar","req":false,"label":"LBL_REPEAT_DOW","source":""},"repeat_until":{"type":"date","req":false,"label":"LBL_REPEAT_UNTIL","source":""},"repeat_count":{"type":"int","req":false,"label":"LBL_REPEAT_COUNT","source":""},"repeat_parent_id":{"type":"id","req":false,"label":"LBL_REPEAT_PARENT_ID","source":""},"recurring_source":{"type":"varchar","req":false,"label":"LBL_RECURRING_SOURCE","source":""}};sugar_mod_fields['Meetings'] = {"name":{"type":"name","req":true,"label":"LBL_SUBJECT","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"duration_hours":{"type":"int","req":true,"label":"LBL_DURATION_HOURS","source":""},"duration_minutes":{"type":"int","req":false,"label":"LBL_DURATION_MINUTES","source":""},"date_start":{"type":"datetime","req":true,"label":"LBL_DATE","options":"date_range_search_dom","source":""},"date_end":{"type":"datetime","req":false,"label":"LBL_DATE_END","options":"date_range_search_dom","source":""},"status":{"type":"enum","req":false,"label":"LBL_STATUS","def":"Planned","options":"meeting_status_dom","source":""},"reminder_checked":{"type":"bool","req":false,"label":"LBL_REMINDER","source":"non-db"},"reminder_time":{"type":"enum","req":false,"label":"LBL_REMINDER_TIME","def":"-1","options":"reminder_time_options","source":""},"parent_name":{"type":"parent","req":true,"label":"LBL_LIST_RELATED_TO","options":"parent_type_display","id_name":"parent_id","id_type":"parent_type"},"repeat_type":{"type":"enum","req":false,"label":"LBL_REPEAT_TYPE","options":"repeat_type_dom","source":""},"repeat_interval":{"type":"int","req":false,"label":"LBL_REPEAT_INTERVAL","def":"1","source":""},"repeat_dow":{"type":"varchar","req":false,"label":"LBL_REPEAT_DOW","source":""},"repeat_until":{"type":"date","req":false,"label":"LBL_REPEAT_UNTIL","source":""},"repeat_count":{"type":"int","req":false,"label":"LBL_REPEAT_COUNT","source":""},"repeat_parent_id":{"type":"id","req":false,"label":"LBL_REPEAT_PARENT_ID","source":""},"recurring_source":{"type":"varchar","req":false,"label":"LBL_RECURRING_SOURCE","source":""},"duration":{"type":"enum","req":false,"label":"LBL_DURATION","options":"duration_dom","source":"non-db"}};sugar_mod_fields['Tasks'] = {"name":{"type":"name","req":true,"label":"LBL_SUBJECT","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"status":{"type":"enum","req":true,"label":"LBL_STATUS","def":"Not Started","options":"task_status_dom","source":""},"date_due":{"type":"datetime","req":false,"label":"LBL_DUE_DATE","options":"date_range_search_dom","source":""},"date_start":{"type":"datetime","req":false,"label":"LBL_START_DATE","options":"date_range_search_dom","source":""},"parent_name":{"type":"parent","req":true,"label":"LBL_LIST_RELATED_TO","options":"parent_type_display","id_name":"parent_id","id_type":"parent_type"},"contact_name":{"type":"relate","req":false,"label":"LBL_CONTACT_NAME","module":"Contacts","id_name":"contact_id"},"priority":{"type":"enum","req":true,"label":"LBL_PRIORITY","options":"task_priority_dom","source":""}};sugar_mod_fields['Cases'] = {"name":{"type":"name","req":true,"label":"LBL_SUBJECT","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"case_number":{"type":"int","req":false,"label":"LBL_NUMBER","inline_edit":false,"readonly":true,"source":"","disable_num_format":true},"status":{"type":"enum","req":false,"label":"LBL_STATUS","def":"Draft","options":"status_list","source":""},"priority":{"type":"enum","req":true,"label":"LBL_PRIORITY","options":"ci_severity_list","source":""},"account_name":{"type":"relate","req":true,"label":"LBL_ACCOUNT_NAME","module":"Accounts","id_name":"account_id"},"state":{"type":"enum","req":false,"label":"LBL_STATE","def":"Open","options":"case_state_dom","source":""},"update_text":{"type":"text","req":false,"label":"LBL_UPDATE_TEXT","source":"non-db","html":true},"internal":{"type":"bool","req":false,"label":"LBL_INTERNAL","source":"non-db"},"aop_case_updates_threaded":{"type":"function","req":false,"label":"LBL_AOP_CASE_UPDATES_THREADED","inline_edit":false,"source":"non-db"}};sugar_mod_fields['Project'] = {"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","options":"date_range_search_dom","source":""},"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"status":{"type":"enum","req":false,"label":"LBL_STATUS","options":"project_status_dom","source":""},"priority":{"type":"enum","req":false,"label":"LBL_PRIORITY","options":"projects_priority_options","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_USER_NAME","module":"Users","id_name":"assigned_user_id"}};sugar_mod_fields['Notes'] = {"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","source":""},"name":{"type":"name","req":true,"label":"LBL_NOTE_SUBJECT","source":""},"filename":{"type":"file","req":false,"label":"LBL_FILENAME","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"parent_name":{"type":"parent","req":true,"label":"LBL_RELATED_TO","options":"record_type_display_notes","id_name":"parent_id","id_type":"parent_type"}};sugar_mod_fields['Documents'] = {"name":{"type":"varchar","req":false,"label":"LBL_NAME","source":"non-db"},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"document_name":{"type":"varchar","req":true,"label":"LBL_NAME","source":""},"doc_type":{"type":"enum","req":false,"label":"LBL_DOC_TYPE","def":"Sugar","options":"eapm_list","source":""},"filename":{"type":"file","req":true,"label":"LBL_FILENAME","source":"non-db"},"category_id":{"type":"enum","req":false,"label":"LBL_SF_CATEGORY","options":"document_category_dom","source":""},"status_id":{"type":"enum","req":false,"label":"LBL_DOC_STATUS","options":"document_status_dom","source":""},"revision":{"type":"varchar","req":true,"label":"LBL_DOC_VERSION","def":"1","source":"non-db"},"last_rev_mime_type":{"type":"varchar","req":false,"label":"LBL_LAST_REV_MIME_TYPE","source":"non-db"}};sugar_mod_fields['AOS_Quotes'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"billing_account":{"type":"relate","req":false,"label":"LBL_BILLING_ACCOUNT","module":"Accounts","id_name":"billing_account_id"},"billing_contact":{"type":"relate","req":false,"label":"LBL_BILLING_CONTACT","module":"Contacts","id_name":"billing_contact_id"},"expiration":{"type":"date","req":true,"label":"LBL_EXPIRATION","options":"date_range_search_dom","source":""},"number":{"type":"int","req":true,"label":"LBL_QUOTE_NUMBER","source":"","disable_num_format":true},"line_items":{"type":"function","req":false,"label":"LBL_LINE_ITEMS","inline_edit":false,"source":"non-db"},"total_amt":{"type":"currency","req":false,"label":"LBL_TOTAL_AMT","source":""},"subtotal_amount":{"type":"currency","req":false,"label":"LBL_SUBTOTAL_AMOUNT","source":""},"discount_amount":{"type":"currency","req":false,"label":"LBL_DISCOUNT_AMOUNT","source":""},"tax_amount":{"type":"currency","req":false,"label":"LBL_TAX_AMOUNT","source":""},"shipping_amount":{"type":"currency","req":false,"label":"LBL_SHIPPING_AMOUNT","source":""},"shipping_tax":{"type":"enum","req":false,"label":"LBL_SHIPPING_TAX","options":"vat_list","source":""},"shipping_tax_amt":{"type":"currency","req":false,"label":"LBL_SHIPPING_TAX_AMT","source":""},"total_amount":{"type":"currency","req":false,"label":"LBL_GRAND_TOTAL","options":"numeric_range_search_dom","source":""},"stage":{"type":"enum","req":true,"label":"LBL_STAGE","def":"Draft","options":"quote_stage_dom","source":""},"subtotal_tax_amount":{"type":"currency","req":false,"label":"LBL_SUBTOTAL_TAX_AMOUNT","source":""}};sugar_mod_fields['AOS_Invoices'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"billing_account":{"type":"relate","req":false,"label":"LBL_BILLING_ACCOUNT","module":"Accounts","id_name":"billing_account_id"},"billing_contact":{"type":"relate","req":false,"label":"LBL_BILLING_CONTACT","module":"Contacts","id_name":"billing_contact_id"},"number":{"type":"varchar","req":true,"label":"LBL_INVOICE_NUMBER","source":""},"line_items":{"type":"function","req":false,"label":"LBL_LINE_ITEMS","inline_edit":false,"source":"non-db"},"total_amt":{"type":"currency","req":false,"label":"LBL_TOTAL_AMT","source":""},"subtotal_amount":{"type":"currency","req":false,"label":"LBL_SUBTOTAL_AMOUNT","source":""},"discount_amount":{"type":"currency","req":false,"label":"LBL_DISCOUNT_AMOUNT","source":""},"tax_amount":{"type":"currency","req":false,"label":"LBL_TAX_AMOUNT","source":""},"shipping_amount":{"type":"currency","req":false,"label":"LBL_SHIPPING_AMOUNT","inline_edit":false,"source":""},"shipping_tax":{"type":"enum","req":false,"label":"LBL_SHIPPING_TAX","options":"vat_list","source":""},"shipping_tax_amt":{"type":"currency","req":false,"label":"LBL_SHIPPING_TAX_AMT","source":""},"total_amount":{"type":"currency","req":false,"label":"LBL_GRAND_TOTAL","options":"numeric_range_search_dom","source":""},"invoice_date":{"type":"date","req":false,"label":"LBL_INVOICE_DATE","options":"date_range_search_dom","source":""},"status":{"type":"enum","req":false,"label":"LBL_STATUS","options":"invoice_status_dom","source":""},"subtotal_tax_amount":{"type":"currency","req":false,"label":"LBL_SUBTOTAL_TAX_AMOUNT","source":""}};sugar_mod_fields['AOS_Contracts'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"reference_code":{"type":"varchar","req":false,"label":"LBL_REFERENCE_CODE ","source":""},"start_date":{"type":"date","req":false,"label":"LBL_START_DATE","options":"date_range_search_dom","source":""},"end_date":{"type":"date","req":false,"label":"LBL_END_DATE","options":"date_range_search_dom","source":""},"status":{"type":"enum","req":true,"label":"LBL_STATUS","def":"Not Started","options":"contract_status_list","source":""},"contract_account":{"type":"relate","req":true,"label":"LBL_CONTRACT_ACCOUNT","module":"Accounts","id_name":"contract_account_id"},"contact":{"type":"relate","req":false,"label":"LBL_CONTACT","module":"Contacts","id_name":"contact_id"},"line_items":{"type":"function","req":false,"label":"LBL_LINE_ITEMS","source":"non-db"},"total_amt":{"type":"currency","req":false,"label":"LBL_TOTAL_AMT","source":""},"subtotal_amount":{"type":"currency","req":false,"label":"LBL_SUBTOTAL_AMOUNT","source":""},"discount_amount":{"type":"currency","req":false,"label":"LBL_DISCOUNT_AMOUNT","source":""},"tax_amount":{"type":"currency","req":false,"label":"LBL_TAX_AMOUNT","source":""},"shipping_amount":{"type":"currency","req":false,"label":"LBL_SHIPPING_AMOUNT","source":""},"shipping_tax":{"type":"enum","req":false,"label":"LBL_SHIPPING_TAX","options":"vat_list","source":""},"shipping_tax_amt":{"type":"currency","req":false,"label":"LBL_SHIPPING_TAX_AMT","source":""},"total_amount":{"type":"currency","req":false,"label":"LBL_GRAND_TOTAL","options":"numeric_range_search_dom","source":""}};sugar_mod_fields['AOS_Products'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"part_number":{"type":"varchar","req":true,"label":"LBL_PART_NUMBER","source":""},"price":{"type":"currency","req":true,"label":"LBL_PRICE","options":"numeric_range_search_dom","source":""},"aos_product_category_name":{"type":"relate","req":true,"label":"LBL_AOS_PRODUCT_CATEGORYS_NAME","module":"AOS_Product_Categories","id_name":"aos_product_category_id"}};sugar_mod_fields['AOS_Product_Categories'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"}};sugar_mod_fields['Users'] = {"user_name":{"type":"user_name","req":true,"label":"LBL_USER_NAME","source":""},"first_name":{"type":"name","req":false,"label":"LBL_FIRST_NAME","source":""},"last_name":{"type":"name","req":true,"label":"LBL_LAST_NAME","source":""},"full_name":{"type":"name","req":false,"label":"LBL_NAME","source":"non-db"},"name":{"type":"varchar","req":false,"label":"LBL_NAME","source":"non-db"},"department":{"type":"enum","req":true,"label":"LBL_DEPARTMENT","options":"department_list","source":""},"phone_mobile":{"type":"phone","req":false,"label":"LBL_MOBILE_PHONE","source":""},"email1":{"type":"email","req":true,"label":"LBL_EMAIL"}};sugar_mod_fields['Currencies'] = {"name":{"type":"varchar","req":true,"label":"LBL_LIST_NAME","source":""},"date_entered":{"type":"datetime","req":true,"label":"LBL_DATE_ENTERED","source":""},"date_modified":{"type":"datetime","req":true,"label":"LBL_DATE_MODIFIED","source":""}};sugar_mod_fields['AOS_PDF_Templates'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"}};sugar_mod_fields['AOS_Products_Quotes'] = {"name":{"type":"text","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"part_number":{"type":"varchar","req":false,"label":"LBL_PART_NUMBER","source":""},"number":{"type":"int","req":false,"label":"LBL_LIST_NUM","source":""},"product_qty":{"type":"decimal","req":false,"label":"LBL_PRODUCT_QTY","source":"","precision":4},"product_list_price":{"type":"currency","req":false,"label":"LBL_PRODUCT_LIST_PRICE","source":""},"product_discount":{"type":"currency","req":false,"label":"LBL_PRODUCT_DISCOUNT","source":""},"product_discount_amount":{"type":"currency","req":false,"label":"LBL_PRODUCT_DISCOUNT_AMOUNT","source":""},"discount":{"type":"enum","req":false,"label":"LBL_DISCOUNT","def":"Percentage","options":"discount_list","source":""},"product_unit_price":{"type":"currency","req":true,"label":"LBL_PRODUCT_UNIT_PRICE","source":""},"vat_amt":{"type":"currency","req":true,"label":"LBL_VAT_AMT","source":""},"product_total_price":{"type":"currency","req":true,"label":"LBL_PRODUCT_TOTAL_PRICE","source":""},"vat":{"type":"enum","req":false,"label":"LBL_VAT","def":"5.0","options":"vat_list","source":""},"parent_name":{"type":"parent","req":false,"label":"LBL_FLEX_RELATE","options":"product_quote_parent_type_dom","id_name":"parent_id","id_type":"parent_type"},"product_id":{"type":"id","req":false,"label":"LBL_PRODUCT_ID","source":""},"group_name":{"type":"relate","req":false,"label":"LBL_GROUP_NAME","module":"AOS_Line_Item_Groups","id_name":"group_id"},"group_id":{"type":"id","req":false,"label":"","source":""}};sugar_mod_fields['Emails'] = {"name":{"type":"name","req":false,"label":"LBL_SUBJECT","inline_edit":false,"source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"from_addr_name":{"type":"varchar","label":"LBL_FROM","tagType":"email","source":""},"to_addrs_names":{"type":"varchar","label":"LBL_TO","tagType":"email","source":"","req":true},"cc_addrs_names":{"type":"varchar","label":"LBL_CC","tagType":"email","source":""},"bcc_addrs_names":{"type":"varchar","label":"LBL_BCC","tagType":"email","source":""},"description_html":{"type":"text","label":"LBL_HTML_BODY","html":"True","source":""},"date_sent":{"type":"datetime","req":false,"label":"LBL_DATE_SENT","inline_edit":false,"source":""},"type":{"type":"enum","req":false,"label":"LBL_LIST_TYPE","inline_edit":false,"options":"dom_email_types","source":""},"parent_name":{"type":"parent","label":"LBL_EMAIL_RELATE","id_name":"parent_id","id_type":"parent_type","options":"record_type_display","source":""}};sugar_mod_fields['EmailTemplates'] = {"date_entered":{"type":"datetime","req":true,"label":"LBL_DATE_ENTERED","inline_edit":false,"source":""},"date_modified":{"type":"datetime","req":true,"label":"LBL_DATE_MODIFIED","inline_edit":false,"source":""},"name":{"type":"varchar","req":true,"label":"LBL_NAME","source":""},"subject":{"type":"varchar","req":false,"label":"LBL_SUBJECT","source":""},"body_html":{"type":"longtext","req":false,"label":"LBL_PLAIN_TEXT","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"type":{"type":"enum","req":false,"label":"LBL_TYPE","options":"emailTemplates_type_list","source":""}};sugar_mod_fields['QCRM_SavedSearch'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"fields":{"type":"text","req":false,"label":"LBL_FIELDS","source":""},"shared":{"type":"bool","req":false,"label":"LBL_SHARED","source":""}};sugar_mod_fields['QCRM_Homepage'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"description":{"type":"text","req":false,"label":"LBL_DESCRIPTION","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"dashlets":{"type":"text","req":false,"label":"LBL_DASHLETS","source":""},"charts":{"type":"text","req":false,"label":"LBL_CHARTS","source":""},"icons":{"type":"text","req":false,"label":"LBL_ICONS","source":""},"hidden":{"type":"text","req":false,"label":"LBL_HIDDEN","source":""},"creates":{"type":"text","req":false,"label":"LBL_CREATES","source":""},"shared":{"type":"bool","req":false,"label":"LBL_SHARED","source":""}};sugar_mod_fields['QCRM_Tracker'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"jjwg_maps_address_c":{"type":"varchar","req":false,"label":"LBL_JJWG_MAPS_ADDRESS","help":"Address","source":"_cstm"},"jjwg_maps_geocode_status_c":{"type":"varchar","req":false,"label":"LBL_JJWG_MAPS_GEOCODE_STATUS","help":"Geocode Status","source":"_cstm"},"jjwg_maps_lat_c":{"type":"float","req":false,"label":"LBL_JJWG_MAPS_LAT","def":"0.00000000","help":"Latitude","source":"_cstm","precision":8},"jjwg_maps_lng_c":{"type":"float","req":false,"label":"LBL_JJWG_MAPS_LNG","def":"0.00000000","help":"Longitude","source":"_cstm","precision":8}};sugar_mod_fields['Favorites'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"}};sugar_mod_fields['Calls_Reschedule'] = {"name":{"type":"name","req":true,"label":"LBL_NAME","source":""},"date_entered":{"type":"datetime","req":false,"label":"LBL_DATE_ENTERED","inline_edit":false,"options":"date_range_search_dom","source":""},"date_modified":{"type":"datetime","req":false,"label":"LBL_DATE_MODIFIED","inline_edit":false,"options":"date_range_search_dom","source":""},"assigned_user_name":{"type":"relate","req":false,"label":"LBL_ASSIGNED_TO_NAME","module":"Users","id_name":"assigned_user_id"},"reason":{"type":"enum","req":false,"label":"LBL_REASON","options":"call_reschedule_dom","source":""},"call_name":{"type":"relate","req":false,"label":"LBL_CALLS","module":"Calls","id_name":"call_id"}};
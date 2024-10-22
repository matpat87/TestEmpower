<?php
    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    /**
     * usage: http://localhost:8888/empower/index.php?entryPoint=CustomFields
     * **/
    class CustomFields{
        public function process()
        {
            global $log;
            $log->fatal('NOT AN ERROR - CustomFields.process: Start');
            $query_for_execution = "";
            $module_fields = array(
                array(
                    'module_name' => 'TR_TechnicalRequests',
                    'fields' => array(
                        'contact_id1_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data 
                                (id,name,vname,comments,help,custom_module,
                                type,len,required,default_value,date_modified,
                                deleted,audited,massupdate,duplicate_merge,reportable,
                                importable,ext1,ext2,ext3,ext4) VALUES ('TR_TechnicalRequestscontact_id1_c','contact_id1_c','LBL_CONTACT_CONTACT_ID','','','TR_TechnicalRequests','id',36,0,NULL,'2020-10-15 13:17:20',0,0,0,0,0,'true','','','',''); ",
                        ),
                        'contact_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('TR_TechnicalRequestscontact_c','contact_c','LBL_CONTACT','','','TR_TechnicalRequests','relate',255,1,NULL,'2020-10-15 13:17:20',0,1,0,0,1,'true','','Contacts','contact_id1_c','');",
                        ),
                    ),
                ),
                array(
                    'module_name' => 'CI_CustomerItems',
                    'fields' => array(
                        'account_id_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data 
                                (id,name,vname,comments,help,custom_module,
                                type,len,required,default_value,date_modified,
                                deleted,audited,massupdate,duplicate_merge,reportable,
                                importable,ext1,ext2,ext3,ext4) VALUES ('CI_CustomerItemsaccount_id_c','account_id_c','LBL_OEM_ACCOUNT_ACCOUNT_ID','','','CI_CustomerItems','id',36,0,NULL,'2020-12-23 00:00:00',0,0,0,0,0,'true','','','',''); ",
                        ),
                        'oem_account_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CI_CustomerItemsoem_account_c','oem_account_c','LBL_OEM_ACCOUNT','','','CI_CustomerItems','relate',255,0,NULL,'2020-12-23 00:00:00',0,1,0,0,1,'true','','Accounts','account_id_c','');",
                        ),
                        'ci_customeritems_id_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data 
                                (id,name,vname,comments,help,custom_module,
                                type,len,required,default_value,date_modified,
                                deleted,audited,massupdate,duplicate_merge,reportable,
                                importable,ext1,ext2,ext3,ext4) VALUES ('CI_CustomerItemsci_customeritems_id_c','ci_customeritems_id_c','LBL_RELATED_PRODUCT_CI_CUSTOMERITEMS_ID','','','CI_CustomerItems','id',36,0,NULL,'2020-12-23 00:00:00',0,0,0,0,0,'true','','','',''); ",
                        ),
                        'related_product_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CI_CustomerItemsrelated_product_c','related_product_c','LBL_RELATED_PRODUCT','','','CI_CustomerItems','relate',255,0,NULL,'2020-12-23 00:00:00',0,1,0,0,1,'true','','CI_CustomerItems','ci_customeritems_id_c','');",
                        ),
                    ),
                ),
                array(
                    'module_name' => 'AOS_Invoices',
                    'fields' => array(
                        'billing_address_street2_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesbilling_address_street2_c','billing_address_street2_c','LBL_BILLING_ADDRESS_STREET2','','','AOS_Invoices','varchar',255,0,'','2021-01-31 11:24:58',0,0,0,0,1,'true','','','',''); ",
                        ),
                        'company_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicescompany_c','company_c','LBL_COMPANY','','','AOS_Invoices','varchar',255,0,'','2021-01-31 10:06:53',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'csr_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicescsr_c','csr_c','LBL_CSR','','','AOS_Invoices','varchar',255,0,'','2021-01-31 09:50:53',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'freight_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesfreight_c','freight_c','LBL_FREIGHT','','','AOS_Invoices','currency',26,0,'','2021-01-31 10:18:16',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'misc_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesmisc_c','misc_c','LBL_MISC',NULL,NULL,'AOS_Invoices','currency',26,0,'0','2021-01-31 12:02:31',0,1,0,0,1,'true',NULL,NULL,NULL,NULL); ",
                        ),
                        'odr_salesorders_id_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesodr_salesorders_id_c','odr_salesorders_id_c','LBL_ORDER_NUMBER_ODR_SALESORDERS_ID','','','AOS_Invoices','id',36,0,NULL,'2021-01-29 14:19:28',0,0,0,0,0,'true','','','',''); ",
                        ),
                        'order_date_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesorder_date_c','order_date_c','LBL_ORDER_DATE','','','AOS_Invoices','date',NULL,0,'','2021-01-31 09:53:38',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'order_number_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesorder_number_c','order_number_c','LBL_ORDER_NUMBER','','','AOS_Invoices','relate',255,0,NULL,'2021-01-29 14:19:28',0,1,0,0,1,'true','','ODR_SalesOrders','odr_salesorders_id_c',''); ",
                        ),
                        'order_type_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesorder_type_c','order_type_c','LBL_ORDER_TYPE','','','AOS_Invoices','enum',100,0,NULL,'2021-01-29 14:25:29',0,0,0,0,1,'true','inv_order_type_list','','',''); ",
                        ),
                        'po_number_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicespo_number_c','po_number_c','LBL_PO_NUMBER','','','AOS_Invoices','varchar',255,0,'','2021-01-31 09:47:29',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'requested_date_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesrequested_date_c','requested_date_c','LBL_REQUESTED_DATE','','','AOS_Invoices','date',NULL,0,'','2021-01-31 09:57:41',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'sales_person_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicessales_person_c','sales_person_c','LBL_SALES_PERSON','','','AOS_Invoices','varchar',255,0,'','2021-01-31 09:48:29',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'shipping_address_street2_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesshipping_address_street2_c','shipping_address_street2_c','LBL_SHIPPING_ADDRESS_STREET2','','','AOS_Invoices','varchar',255,0,'','2021-01-31 11:34:24',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'ship_via_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesship_via_c','ship_via_c','LBL_SHIP_VIA','','','AOS_Invoices','varchar',255,0,'','2021-01-31 10:08:03',0,0,0,0,1,'true','','','',''); ",
                        ),
                        'site_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicessite_c','site_c','LBL_SITE',NULL,NULL,'AOS_Invoices','enum',100,1,NULL,'2021-01-31 10:02:48',0,1,0,0,1,'true','site_list',NULL,NULL,NULL); ",
                        ),
                        'total_discount_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicestotal_discount_c','total_discount_c','LBL_TOTAL_DISCOUNT','','','AOS_Invoices','decimal',18,0,'','2021-01-31 10:13:41',0,1,0,0,1,'true','2','','',''); ",
                        ),
                        'bill_to_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('AOS_Invoicesbill_to_c','bill_to_c','LBL_BILL_TO','','','AOS_Invoices','varchar',255,0,'','2021-01-31 00:00:00',0,1,0,0,1,'true','','','',''); ",
                        ),
                    ),
                ),
                array(
                    'module_name' => 'ODR_SalesOrders',
                    'fields' => array(
                        'user_id_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data 
                                (id,name,vname,comments,help,custom_module,
                                type,len,required,default_value,date_modified,
                                deleted,audited,massupdate,duplicate_merge,reportable,
                                importable,ext1,ext2,ext3,ext4) VALUES ('ODR_SalesOrdersuser_id_c','user_id_c','LBL_SALESPERSON_USER_ID','','','ODR_SalesOrders','id',36,0,NULL,'2020-12-23 00:00:00',0,0,0,0,0,'true','','','',''); ",
                        ),
                        'salesperson_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('ODR_SalesOrderssalesperson_c','salesperson_c','LBL_SALESPERSON','','','ODR_SalesOrders','relate',255,0,NULL,'2020-12-23 00:00:00',0,1,0,0,1,'true','','Users','user_id_c','');",
                        ),
                        'user_id1_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data 
                                (id,name,vname,comments,help,custom_module,
                                type,len,required,default_value,date_modified,
                                deleted,audited,massupdate,duplicate_merge,reportable,
                                importable,ext1,ext2,ext3,ext4) VALUES ('ODR_SalesOrdersuser_id1_c','user_id1_c','LBL_CSR_USER_ID','','','ODR_SalesOrders','id',36,0,NULL,'2020-12-23 00:00:00',0,0,0,0,0,'true','','','',''); ",
                        ),
                        'csr_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('ODR_SalesOrderscsr_c','csr_c','LBL_CSR','','','ODR_SalesOrders','relate',255,0,NULL,'2020-12-23 00:00:00',0,1,0,0,1,'true','','Users','user_id1_c','');",
                        ),
                        'bill_to_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ODR_SalesOrdersbill_to_c','bill_to_c','LBL_BILL_TO','','','ODR_SalesOrders','varchar',1000,0,'','2021-03-12 00:00:00',0,0,0,0,1,'true','','','',''); ",
                        ),
                        'req_ship_date_reason_code_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ODR_SalesOrdersreq_ship_date_reason_code_c','req_ship_date_reason_code_c','LBL_REQUIRED_SHIP_DATE_REASON_CODE','','','ODR_SalesOrders','varchar',256,0,'','2021-06-08 00:00:00',0,0,0,0,1,'true','','','',''); ",
                        ),
                    ),
                ),
                array(
                    'module_name' => 'VEND_Vendors',
                    'fields' => array(
                        'vendor_number_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VEND_Vendorsvendor_number_c','vendor_number_c','LBL_VENDOR_NUMBER','','','VEND_Vendors','varchar',256,0,'','2021-06-04 00:00:00',0,0,0,0,1,'true','','','',''); ",
                        ),
                    ),
                ),
                array(
                    'module_name' => 'OTW_OTWorkingGroups',
                    'fields' => array(
                        'first_name_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('OTW_OTWorkingGroupsfirst_name_c','first_name_c','LBL_FIRST_NAME','','','OTW_OTWorkingGroups','varchar',255,0,'','2021-07-27 14:43:47',0,0,0,0,1,'true','','','','');"
                        ),
                        'last_name_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('OTW_OTWorkingGroupslast_name_c','last_name_c','LBL_LAST_NAME','','','OTW_OTWorkingGroups','varchar',255,0,'','2021-07-27 14:44:24',0,0,0,0,1,'true','','','','');"
                        ),
                        'ot_role_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('OTW_OTWorkingGroupsot_role_c','ot_role_c','LBL_OT_ROLE','','','OTW_OTWorkingGroups','enum',100,1,'','2021-07-27 14:39:22',0,0,0,0,1,'true','tr_roles_list','','','');"
                        ),
                        'parent_id' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('OTW_OTWorkingGroupsparent_id','parent_id','LBL_PARENT_ID',NULL,NULL,'OTW_OTWorkingGroups','id',36,0,NULL,'2021-07-26 14:27:36',0,0,0,0,1,'true',NULL,NULL,NULL,NULL);"
                        ),
                        'parent_name' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('OTW_OTWorkingGroupsparent_name','parent_name','LBL_FLEX_RELATE',NULL,NULL,'OTW_OTWorkingGroups','parent',100,0,NULL,'2021-07-26 14:27:36',0,0,0,0,1,'true','parent_type_display',NULL,NULL,NULL);"
                        ),
                        'parent_type' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('OTW_OTWorkingGroupsparent_type','parent_type','LBL_PARENT_TYPE',NULL,NULL,'OTW_OTWorkingGroups','parent_type',255,0,NULL,'2021-07-26 14:27:36',0,0,0,0,1,'true',NULL,NULL,NULL,NULL);"
                        ),
                    ),
                ),
                array(
                    'module_name' => 'CHL_Challenges',
                    'fields' => array(
                        'commercialized_to_others_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengescommercialized_to_others_c','commercialized_to_others_c','LBL_COMMERCIALIZED_TO_OTHERS','','','CHL_Challenges','enum',100,1,'','2021-08-12 14:13:55',0,0,0,0,1,'true','commercialized_by_others_list','','','');"
                        ),
                        'issue_in_the_market_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengesissue_in_the_market_c','issue_in_the_market_c','LBL_ISSUE_IN_THE_MARKET',NULL,NULL,'CHL_Challenges','enum',100,1,NULL,'2021-08-12 14:19:03',0,0,0,0,1,'true','issue_in_the_market_list',NULL,NULL,NULL);"
                        ),
                        'possible_solutions_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengespossible_solutions_c','possible_solutions_c','LBL_POSSIBLE_SOLUTIONS',NULL,NULL,'CHL_Challenges','text',NULL,0,NULL,'2021-08-12 13:54:42',0,0,0,0,1,'true',NULL,'6','80',NULL);"
                        ),
                        'priority_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengespriority_c','priority_c','LBL_PRIORITY','','','CHL_Challenges','enum',100,1,'','2021-08-15 13:17:43',0,0,0,0,1,'true','chl_priority','','','');"
                        ),
                        'related_to_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengesrelated_to_c','related_to_c','LBL_RELATED_TO',NULL,NULL,'CHL_Challenges','enum',100,1,NULL,'2021-08-15 13:23:10',0,0,0,0,1,'true','chl_related_to',NULL,NULL,NULL);"
                        ),
                        'status_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengesstatus_c','status_c','LBL_STATUS',NULL,NULL,'CHL_Challenges','enum',100,1,NULL,'2021-08-15 13:52:49',0,0,0,0,1,'true','chl_status',NULL,NULL,NULL);"
                        ),
                        'subject_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengessubject_c','subject_c','LBL_SUBJECT','','','CHL_Challenges','varchar',255,1,'','2021-08-12 13:17:31',0,1,0,0,1,'true','','','','');"
                        ),
                        'type_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengestype_c','type_c','LBL_TYPE','','','CHL_Challenges','enum',100,1,'','2021-08-12 14:28:32',0,0,0,0,1,'true','chl_type_list','','','');"
                        ),
                        'used_by_others_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengesused_by_others_c','used_by_others_c','LBL_USED_BY_OTHERS','','','CHL_Challenges','enum',100,1,'','2021-08-12 14:08:37',0,0,0,0,1,'true','used_by_others_list','','','');"
                        ),
                        'used_by_others_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengesused_by_others_c','used_by_others_c','LBL_USED_BY_OTHERS','','','CHL_Challenges','enum',100,1,'','2021-08-12 14:08:37',0,0,0,0,1,'true','used_by_others_list','','','');"
                        ),
                        'value_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('CHL_Challengesvalue_c','value_c','LBL_VALUE','','','CHL_Challenges','decimal',18,0,'','2021-08-15 15:20:11',0,0,0,0,1,'true','2','','','');"
                        ),
                        'division_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('CHL_Challengesdivision_c','division_c','LBL_DIVISION','','','CHL_Challenges','enum',100,0,'','2021-09-08 12:57:58',0,0,0,0,1,'true','user_division_list','','','');"
                        ),
                    ),
                ),
                array(
                    'module_name' => 'ProjectTask',
                    'fields' => array(
                        'prj_document_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_document_c','prj_document_c','LBL_PRJ_DOCUMENT','','','ProjectTask','Cstmfile',255,0,NULL,'2021-08-23 13:17:26',0,0,0,0,1,'true','','','','');"
                        ),
                        'prj_status_update_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_status_update_c','prj_status_update_c','LBL_PRJ_STATUS_UPDATE',NULL,NULL,'ProjectTask','text',NULL,0,NULL,'2021-08-23 13:16:39',0,0,0,0,1,'true',NULL,'6','80',NULL);"
                        ),
                        'prj_division_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_division_c','prj_division_c','LBL_PRJ_DIVISION','','','ProjectTask','enum',100,1,'','2021-08-23 13:12:39',0,1,1,0,1,'true','user_division_list','','','');"
                        ),
                        'prj_priority_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_priority_c','prj_priority_c','LBL_PRJ_PRIORITY','','','ProjectTask','int',2,0,'','2021-08-23 13:03:31',0,1,0,0,1,'true','1','99','','');"
                        ),
                        'prj_severity_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_severity_c','prj_severity_c','LBL_PRJ_SEVERITY','','','ProjectTask','enum',100,1,'1','2021-08-23 13:02:10',0,1,1,0,1,'true','severity_list','','','');"
                        ),
                        'prj_type_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_type_c','prj_type_c','LBL_PRJ_TYPE','','','ProjectTask','enum',100,1,'','2021-08-23 13:00:43',0,1,1,0,1,'true','bug_type_dom','','','');"
                        ),
                        'prj_module_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_module_c','prj_module_c','LBL_PRJ_MODULE','','','ProjectTask','enum',100,0,'','2021-08-23 12:59:40',0,1,1,0,1,'true','module_dropdown_list','','','');"
                        ),
                        'prj_phase_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_phase_c','prj_phase_c','LBL_PRJ_PHASE','','','ProjectTask','enum',100,1,'1','2021-08-23 12:58:29',0,1,1,0,1,'true','phase_list','','','');"
                        ),
                        'prj_application_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_application_c','prj_application_c','LBL_PRJ_APPLICATION','','','ProjectTask','enum',100,1,NULL,'2021-08-23 12:57:15',0,1,0,0,1,'true','application_list','','','');"
                        ),
                        'prj_status_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_status_c','prj_status_c','LBL_PRJ_STATUS',NULL,NULL,'ProjectTask','enum',100,1,NULL,'2021-08-23 12:55:36',0,1,0,0,1,'true','bug_status_dom',NULL,NULL,NULL);"
                        ),
                        'prj_number_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('ProjectTaskprj_number_c','prj_number_c','LBL_PRJ_NUMBER','','','ProjectTask','int',255,0,'','2021-08-23 12:50:22',0,1,0,0,1,'true','','','','');"
                        ),
                    ),
                ),
                array(
                    'module_name' => 'Users',
                    'fields' => array(
                        'is_reset_password_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('Usersis_reset_password_c','is_reset_password_c','LBL_IS_RESET_PASSWORD','','','Users','bool',255,0,'0','2021-09-19 13:23:56',0,0,0,0,1,'true','','','','');",
                        )
                    )
                ),
                array(
                    'module_name' => 'MDM_ModuleManagement',
                    'fields' => array(
                        'module_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('MDM_ModuleManagementmodule_c','module_c','LBL_MODULE','','','MDM_ModuleManagement','enum',100,1,NULL,'2021-09-27 13:57:21',0,0,0,0,1,'true','moduleList','','','');"
                        ),
                    ),
                ),
                array(
                    'module_name' => 'AOS_Products',
                    'fields' => array(
                        'account_id1_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data 
                                (id,name,vname,comments,help,custom_module,
                                type,len,required,default_value,date_modified,
                                deleted,audited,massupdate,duplicate_merge,reportable,
                                importable,ext1,ext2,ext3,ext4) VALUES ('AOS_Productsaccount_id1_c','account_id1_c','LBL_OEM_ACCOUNT_ACCOUNT_ID','','','AOS_Products','id',36,0,NULL,'2022-02-18 00:00:00',0,0,0,0,0,'true','','','',''); ",
                        ),
                    ),
                ),
                array(
                    'module_name' => 'Opportunities',
                    'fields' => array(
                        //OnTrack #1240
                        'last_activity_date_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('Opportunitieslast_activity_date_c','last_activity_date_c','LBL_LAST_ACTIVITY_DATE','','','Opportunities','datetimecombo',NULL,0,'','2022-01-16 15:17:35',0,0,0,0,1,'true','','','','');"
                        ),
                    ),
                ),
                array(
                    'module_name' => 'TRI_TechnicalRequestItems',
                    'fields' => array(
                        //OnTrack #1389 - Completed Date
                        'completed_date_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('TRI_TechnicalRequestItemscompleted_date_c','completed_date_c','LBL_COMPLETED_DATE','','','TRI_TechnicalRequestItems','datetimecombo',NULL,0,'','2022-04-07 00:00:00',0,0,0,0,1,'true','','','','');"
                        ),
                    ),
                ),
                array(
                    'module_name' => 'Contacts',
                    'fields' => array(
                        //OnTrack #563 - Alternate Email
                        'alternate_email_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('Contactsalternate_email_c','alternate_email_c','LBL_ALTERNATE_EMAIL','','','Contacts','varchar',NULL,0,'','2022-05-30 00:00:00',0,0,0,0,1,'true','','','','');"
                        ),
                    ),
                ),
                array(
                    'module_name' => 'RRQ_RegulatoryRequests',
                    'fields' => array(
                        //OnTrack #1480 - Regulatory Requests
                        'id_num_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('RRQ_RegulatoryRequestsid_num_c','id_num_c','LBL_ID_NUM','','','RRQ_RegulatoryRequests','varchar',255,0,'','2022-09-16 07:29:35',0,0,0,0,1,'true','','','','');",
                        ),
                        'status_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('RRQ_RegulatoryRequestsstatus_c','status_c','LBL_STATUS','','','RRQ_RegulatoryRequests','enum',100,1,'','2022-09-16 07:44:29',0,1,0,0,1,'true','reg_req_statuses','','','');",
                        ),
                        'req_date_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('RRQ_RegulatoryRequestsreq_date_c','req_date_c','LBL_REQ_DATE','','','RRQ_RegulatoryRequests','date',NULL,0,'','2022-09-17 07:25:46',0,1,0,0,1,'true','','','','');",
                        ),
                        'req_by_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('RRQ_RegulatoryRequestsreq_by_c','req_by_c','LBL_REQ_BY','','','RRQ_RegulatoryRequests','relate',255,0,NULL,'2022-09-17 07:26:34',0,1,0,0,1,'true','','Users','user_id_c','');",
                        ),
                        'user_id_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('RRQ_RegulatoryRequestsuser_id_c','user_id_c','LBL_REQ_BY_USER_ID','','','RRQ_RegulatoryRequests','id',36,0,NULL,'2022-09-17 07:26:34',0,0,0,0,0,'true','','','','');",
                        ),
                        'user_id1_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('RRQ_RegulatoryRequestsuser_id1_c','user_id1_c','LBL_SUBMIT_BY_USER_ID','','','RRQ_RegulatoryRequests','id',36,0,NULL,'2022-09-17 07:27:16',0,0,0,0,0,'true','','','','');",
                        ),
                        'submit_by_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('RRQ_RegulatoryRequestssubmit_by_c','submit_by_c','LBL_SUBMIT_BY','','','RRQ_RegulatoryRequests','relate',255,0,NULL,'2022-09-17 07:27:16',0,1,0,0,1,'true','','Users','user_id1_c','');",
                        ),
                        'req_type_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('RRQ_RegulatoryRequestsreq_type_c','req_type_c','LBL_REQ_TYPE',NULL,NULL,'RRQ_RegulatoryRequests','enum',100,1,NULL,'2022-09-17 08:37:39',0,0,0,0,1,'true','reg_req_request_type',NULL,NULL,NULL);",
                        ),
                    ),
                ),
                array(
                    'module_name' => 'VI_VendorIssues',
                    'fields' => array(
                        'site_c' => array(
                            'add_query' => "INSERT INTO `fields_meta_data` (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuessite_c','site_c','LBL_SITE','','','VI_VendorIssues','enum',100,0,'','2022-12-28 00:00:00',0,0,0,0,1,'true','site_list','','','');"
                        ),
                        'purchase_order_num_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuespurchase_order_num_c','purchase_order_num_c','LBL_PURCHASE_ORDER_NUM','','','VI_VendorIssues','varchar',255,0,'','2022-12-28 00:00:00',0,0,0,0,1,'true','','','',''); ",
                        ),
                        'raw_material_num_id_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data 
                                (id,name,vname,comments,help,custom_module,
                                type,len,required,default_value,date_modified,
                                deleted,audited,massupdate,duplicate_merge,reportable,
                                importable,ext1,ext2,ext3,ext4) VALUES ('VI_VendorIssuesraw_material_num_id_c','raw_material_num_id_c','LBL_RAW_MATERIAL_ID_NUM','','','VI_VendorIssues','id',36,0,NULL,'2022-12-28 00:00:00',0,0,0,0,0,'true','','','',''); ",
                        ),
                        'raw_material_num_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('VI_VendorIssuesraw_material_num_c','raw_material_num_c','LBL_RAW_MATERIAL_NUM','','','VI_VendorIssues','relate',255,1,NULL,'2022-12-28 00:00:00',0,1,0,0,1,'true','','RMM_RawMaterialMaster','raw_material_num_id_c','');",
                        ),
                        'vendor_id_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data 
                                (id,name,vname,comments,help,custom_module,
                                type,len,required,default_value,date_modified,
                                deleted,audited,massupdate,duplicate_merge,reportable,
                                importable,ext1,ext2,ext3,ext4) VALUES ('VI_VendorIssuesvendor_id_c','vendor_id_c','LBL_VENDOR_ID','','','VI_VendorIssues','id',36,0,NULL,'2022-12-28 00:00:00',0,0,0,0,0,'true','','','',''); ",
                        ),
                        'vendor_name_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('VI_VendorIssuesvendor_name_c','vendor_name_c','LBL_VENDOR_NAME','','','VI_VendorIssues','relate',255,1,NULL,'2022-12-28 00:00:00',0,1,0,0,1,'true','','VEND_Vendors','vendor_id_c','');",
                        ),
                        // 'vendor_name_c' => array(
                        //     'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuesvendor_name_c','vendor_name_c','LBL_VENDOR_NAME','','','VI_VendorIssues','varchar',255,0,'','2022-12-28 00:00:00',0,0,0,0,1,'true','','','',''); ",
                        // ),
                        'po_value_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuespo_value_c','po_value_c','LBL_PO_VALUE','','','VI_VendorIssues','currency',26,0,'','2022-12-28 00:00:00',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'po_date_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuespo_date_c','po_date_c','LBL_PO_DATE','','','VI_VendorIssues','date',NULL,0,'','2022-12-28 00:00:00',0,1,0,0,1,'true','','','',''); ",
                        ),
                        'po_vendor_lot_num_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuespo_vendor_lot_num_c','po_vendor_lot_num_c','LBL_VENDOR_LOT_NUM','','','VI_VendorIssues','varchar',255,0,'','2022-12-28 00:00:00',0,0,0,0,1,'true','','','',''); ",
                        ),
                        'po_quantity_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuespo_quantity_c','po_quantity_c','LBL_PO_QUANTITY','','','VI_VendorIssues','varchar',255,0,'','2022-12-28 00:00:00',0,0,0,0,1,'true','','','',''); ",
                        ),
                        'product_details_gallery_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuesproduct_details_gallery_c','product_details_gallery_c','LBL_PRODUCT_DETAILS_GALLERY','','','VI_VendorIssues','Imagegallery',255,0,NULL,'2022-12-30 15:51:00',0,0,0,0,1,'true','','','','');",
                        ),
                        'contact_id_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data 
                                (id,name,vname,comments,help,custom_module,
                                type,len,required,default_value,date_modified,
                                deleted,audited,massupdate,duplicate_merge,reportable,
                                importable,ext1,ext2,ext3,ext4) VALUES ('VI_VendorIssuescontact_id_c','contact_id_c','LBL_CONTACT_ID','','','VI_VendorIssues','id',36,0,NULL,'2022-12-28 00:00:00',0,0,0,0,0,'true','','','',''); ",
                        ),
                        'contact_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (id,name,vname,comments,help,custom_module,type,len,required,default_value,date_modified,deleted,audited,massupdate,duplicate_merge,reportable,importable,ext1,ext2,ext3,ext4) VALUES ('VI_VendorIssuescontact_c','contact_c','LBL_CONTACT','','','VI_VendorIssues','relate',255,1,NULL,'2022-12-28 00:00:00',0,1,0,0,1,'true','','Contacts','contact_id_c','');",
                        ),
                        'severity_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuesseverity_c','severity_c','LBL_SEVERITY','','','VI_VendorIssues','enum',100,1,'','2022-12-28 00:00:00',0,1,1,0,1,'true','vendor_severity_dom','','','');"
                        ),
                        'return_authorization_num_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuesreturn_authorization_num_c','return_authorization_num_c','LBL_RETURN_AUTHORIZATION_NUM','','','VI_VendorIssues','varchar',255,0,'','2022-12-28 00:00:00',0,0,0,0,1,'true','','','',''); ",
                        ),
                        'investigation_results_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuesinvestigation_results_c','investigation_results_c','LBL_INVESTIGATION_RESULTS','','','VI_VendorIssues','text',NULL,0,'','2022-12-31 09:11:54',0,0,0,0,1,'true','','4','20',''); ",
                        ),
                        'root_cause_type_c' => array(
                            'add_query' => "INSERT INTO `fields_meta_data` (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuesroot_cause_type_c','root_cause_type_c','LBL_ROOT_CAUSE_TYPE','','','VI_VendorIssues','enum',100,0,'','2022-12-28 00:00:00',0,0,0,0,1,'true','vi_root_cause_type_dom','','','');"
                        ),
                        'corrective_action_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuescorrective_action_c','corrective_action_c','LBL_CORRECTIVE_ACTION','','','VI_VendorIssues','text',NULL,0,'','2022-12-31 09:11:54',0,0,0,0,1,'true','','4','20',''); ",
                        ),
                        'resolution_details_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuesresolution_details_c','resolution_details_c','LBL_RESOLUTION_DETAILS','','','VI_VendorIssues','text',NULL,0,'','2022-12-31 09:11:54',0,0,0,0,1,'true','','4','20',''); ",
                        ),
                        'closed_date_c' => array(
                            'add_query' => "INSERT INTO fields_meta_data (`id`,`name`,`vname`,`comments`,`help`,`custom_module`,`type`,`len`,`required`,`default_value`,`date_modified`,`deleted`,`audited`,`massupdate`,`duplicate_merge`,`reportable`,`importable`,`ext1`,`ext2`,`ext3`,`ext4`) VALUES ('VI_VendorIssuesclosed_date_c','closed_date_c','LBL_CLOSED_DATE','','','VI_VendorIssues','date',NULL,0,'','2022-12-28 00:00:00',0,1,0,0,1,'true','','','',''); ",
                        ),
                    ),
                )
            );

            foreach($module_fields as $module_field){
                foreach($module_field['fields'] as $field_name => $field)
                {
                    if(!$this->is_exist($field_name, $module_field['module_name']))
                    {
                        //$query_for_execution .= $field['add_query'];
                        $log->fatal('NOT AN ERROR - CustomFields.process query for exection: ' . $field['add_query']);
                        
                        $this->execute($field['add_query']);
                        echo 'CustomFields.process query for exection: ' . $field['add_query'] . '<br/><br/>';
                    }
                }
            }
            

            /*
            if(!empty($query_for_execution))
            {
                $log->fatal('NOT AN ERROR - CustomFields.process query for exection: ' . $query_for_execution);
                $this->execute($query_for_execution);
            }
            */

            $log->fatal('NOT AN ERROR - CustomFields.process: End');
        }

        private function is_exist($field_name, $module_name)
        {
            global $db;
            $result = false;

            $query = "SELECT * 
                FROM fields_meta_data
                where name = '{$field_name}'
                    and custom_module = '{$module_name}' ";

            $data = $db->query($query);

            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null && !empty($rowData['id']))
            {
                $result = true;
            }

            return $result;
        }

        private function execute($query_for_execution)
        {
            global $db;
            $result = false;

            if(!empty($query_for_execution))
            {
                $data = $db->query($query_for_execution);
                $result = true;
            }

            return $result;
        }
    }

    $customFields = new CustomFields();
	$customFields->process();
    
?>
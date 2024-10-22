<?php
	require_once('custom/include/TCPDF/tcpdf.php');
	require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');
	require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');
	require_once('custom/modules/AOS_Products/helper/ProductHelper.php');
    require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');

	//if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

	class TRPrintout{
		
		public $tr_bean;
        public $tr_related_name;
        public $technical_request_id;
		public $product_id;
		
		public $pdf_data = array(
            'opportunity_detail' => array(
                'opp_id' => array(
					'is_ui_added' => false, 'label' => 'ID', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'opp_name' => array(
					'is_ui_added' => false, 'label' => 'Name', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'acc_name' => array(
					'is_ui_added' => false, 'label' => 'Account Name', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'sales_stage' => array(
					'is_ui_added' => false, 'label' => 'Sales Stage', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'status' => array(
					'is_ui_added' => false, 'label' => 'Status', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'account_prio' => array(
					'is_ui_added' => false, 'label' => 'Account Priority', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'opp_amount' => array(
					'is_ui_added' => false, 'label' => 'Amount', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'expected_date_closed' => array(
					'is_ui_added' => false, 'label' => 'Exp. Close', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'user' => array(
					'is_ui_added' => false, 'label' => 'User', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'created_date' => array(
					'is_ui_added' => false, 'label' => 'Created Date', 'value' => '', 
					'style' => '', 'class' => '',
				),
            ),
			'header' => array(
				'company_name' => array(
					'is_ui_added' => false, 'label' => 'Company Name', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'contact_name' => array(
					'is_ui_added' => false, 'label' => 'Contact', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'contact_email' => array(
					'is_ui_added' => false, 'label' => 'Email', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'contact_phone' => array(
					'is_ui_added' => false, 'label' => 'Office Phone', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'contact_address_info' => array(
					'is_ui_added' => false, 'label' => 'Address Info', 'value' => '', 
					'style' => '', 'class' => '',
				),
			),
			'general' => array(
				'technicalrequests_number_c' => array(
					'is_ui_added' => false, 'label' => 'TR #', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'version_c' => array(
					'is_ui_added' => false, 'label' => 'Version #', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'name' => array(
					'is_ui_added' => false, 'label' => 'Product Name', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'type' => array(
					'is_ui_added' => false, 'label' => 'Type', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'tr_technicalrequests_type_dom',
				),
                'colormatch_type_c' => array(
					'is_ui_added' => false, 'label' => 'Colormatch Type', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'colormatch_type_list',
				),
				'approval_stage' => array(
					'is_ui_added' => false, 'label' => 'Stage', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'approval_stage_list',
				),
				'status' => array(
					'is_ui_added' => false, 'label' => 'Status', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'tr_technicalrequests_status_list'
				),
				'opportunity_name' => array(
					'is_ui_added' => false, 'label' => 'Opportunity', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'account_name' => array(
					'is_ui_added' => false, 'label' => 'Account', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'market_name' => array(
					'is_ui_added' => false, 'label' => 'Market', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'avg_sell_price_c' => array(
					'is_ui_added' => false, 'label' => 'ASP', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'annual_volume_c' => array(
					'is_ui_added' => false, 'label' => 'Annual Volume', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'annual_amount_c' => array(
					'is_ui_added' => false, 'label' => 'Annual Amount', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'probability_c' => array(
					'is_ui_added' => false, 'label' => 'Probability %', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'annual_amount_weighted_c' => array(
					'is_ui_added' => false, 'label' => 'Annual Amount Weighted', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'site' => array(
					'is_ui_added' => false, 'label' => 'Site', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'order_cycle_c' => array(
					'is_ui_added' => false, 'label' => 'Order Cycle', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'order_cycle_list',
				),
				'req_completion_date_c' => array(
					'is_ui_added' => false, 'label' => 'Req Completion Date', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'actual_close_date_c' => array(
					'is_ui_added' => false, 'label' => 'Actual Close Date', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'production_start_date_c' => array(
					'is_ui_added' => false, 'label' => 'Prod Start Date', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'production_end_date_c' => array(
					'is_ui_added' => false, 'label' => 'Prod End Date', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'special_instructions_c' => array(
					'is_ui_added' => false, 'label' => 'Special Instructions', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'updates' => array(
					'is_ui_added' => false, 'label' => 'Technical Request Update', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'distro_type_c' => array(
					'is_ui_added' => false, 'label' => 'Distro Type', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'distro_type_list',
				),
				'tr_related_name' => array(
					'is_ui_added' => false, 'label' => 'Related', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'created_by_name' => array(
					'is_ui_added' => false, 'label' => 'Submitted By', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'assigned_user_name' => array(
					'is_ui_added' => false, 'label' => 'Assigned To', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'date_entered' => array(
					'is_ui_added' => false, 'label' => 'Submitted Date', 'value' => '', 
					'style' => '', 'class' => '',
				),
			),
			'tr_prod_info' => array(
				'cm_product_form_c' => array(
					'is_ui_added' => false, 'label' => 'Geometry', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'cm_product_form_list',
				),
				'target_letdown_c' => array(
					'is_ui_added' => false, 'label' => 'Target Letdown', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'product_category_c' => array(
					'is_ui_added' => false, 'label' => 'Product Category', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'is_improve_letdown_c' => array(
					'is_ui_added' => false, 'label' => 'Improve Letdown', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'cm_customer_process_c' => array(
					'is_ui_added' => false, 'label' => 'Customer Process', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'cm_customer_process_list',
				),
				'application_c' => array(
					'is_ui_added' => false, 'label' => 'Application', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'cm_customer_number_c' => array(
					'is_ui_added' => false, 'label' => 'Customer Part #', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'customer_part_name_c' => array(
					'is_ui_added' => false, 'label' => 'Customer Part Name', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'color_c' => array(
					'is_ui_added' => false, 'label' => 'Color', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'pi_color_list',
				),
				'industry_spec_c' => array(
					'is_ui_added' => false, 'label' => 'Match Target', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'industry_spec_list',
				),
				'is_return_customer_part_c' => array(
					'is_ui_added' => false, 'label' => 'Return Target', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'is_return_customer_part_c_list',
				),
				'special_effects_c' => array(
					'is_ui_added' => false, 'label' => 'Special Effects', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'special_effects_list',
				),
				'industry_note_c' => array(
					'is_ui_added' => false, 'label' => 'Match Target Note', 'value' => '', 
					'style' => '', 'class' => '',
				),
			),
			'tr_competitor_info' => array(
				'competitor_c' => array(
					'is_ui_added' => false, 'label' => 'Competitor', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'ci_competitor_c' => array(
					'is_ui_added' => false, 'label' => 'Competitor Concentrate LD', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'match_article_c' => array(
					'is_ui_added' => false, 'label' => 'Match Article', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'ci_product_form_c' => array(
					'is_ui_added' => false, 'label' => 'Geometry', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'ci_product_form_list',
				),
				'price_c' => array(
					'is_ui_added' => false, 'label' => 'Price ($/Lb)', 'value' => '', 
					'style' => '', 'class' => '',
				),
			),
			'tr_customer_base' => array(
				'match_in_customers_resin_c' => array(
					'is_ui_added' => false, 'label' => 'Match in Customers Resin', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'match_in_customer_resin_list',
				),
				'resin_compound_type_c' => array(
					'is_ui_added' => false, 'label' => 'Resin / Compound type', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'resin_type_list'
				),
				'mfg_c' => array(
					'is_ui_added' => false, 'label' => 'MFG', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'grade_id_number_c' => array(
					'is_ui_added' => false, 'label' => 'Grade / ID #', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'melt_index_c' => array(
					'is_ui_added' => false, 'label' => 'Melt Index', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'mfg_c' => array(
					'is_ui_added' => false, 'label' => 'Manufacturer', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'customer_provided_c' => array(
					'is_ui_added' => false, 'label' => 'Customer Provided', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'customer_provided_list',
				),
                'technical_data_sheet_c' => array(
					'is_ui_added' => false, 'label' => 'Technical Data Sheet', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'safety_data_sheet_new_c' => array(
					'is_ui_added' => false, 'label' => 'Safety Data Sheet', 'value' => '', 
					'style' => '', 'class' => '',
				),
			),
			'tr_stability' => array(
				'light_c' => array(
					'is_ui_added' => false, 'label' => 'Light', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'light_list'
				),
				'stability_comments_c' => array(
					'is_ui_added' => false, 'label' => 'Comments', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'heat_in_f_c' => array(
					'is_ui_added' => false, 'label' => 'Heat (Fº)', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'heat_in_f_list',
				),
			),
			'tr_opacity_texture' => array(
				'opacity_level_c' => array(
					'is_ui_added' => false, 'label' => 'Opacity Level', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'opacity_level_list',
				),
				'ot_comments_c' => array(
					'is_ui_added' => false, 'label' => 'Comments', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'thickness_c' => array(
					'is_ui_added' => false, 'label' => 'Thickness', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'finished_part_texture_c' => array(
					'is_ui_added' => false, 'label' => 'Fin Part Texture', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'finished_part_texture_list'
				),
			),
			'tr_tolerance' => array(
				'visual_match_c' => array(
					'is_ui_added' => false, 'label' => 'Visual Match', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'visual_type_c' => array(
					'is_ui_added' => false, 'label' => 'Visual Match Type', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'visual_type_list',
				),
				'instrumental_match_c' => array(
					'is_ui_added' => false, 'label' => 'Instrumental Match', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'de_max_c' => array(
					'is_ui_added' => false, 'label' => 'DE Max', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'de_max_list',
				),
				'lab_or_cmc_c' => array(
					'is_ui_added' => false, 'label' => 'LAB or CMC', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'delta_l_a_b_max_c' => array(
					'is_ui_added' => false, 'label' => 'Delta L, a, b max', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'light_source_c' => array(
					'is_ui_added' => false, 'label' => 'Light Source', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'light_source_list',
				),
			),
			'tr_additives' => array(
				'ad_type_1_c' => array(
					'is_ui_added' => false, 'label' => 'Type', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'ad_type_list',
				),
				'ad_percent_1_c' => array(
					'is_ui_added' => false, 'label' => '%', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'ad_type_2_c' => array(
					'is_ui_added' => false, 'label' => 'Type', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'ad_type_list',
				),
				'ad_percent_2_c' => array(
					'is_ui_added' => false, 'label' => '%', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'ad_type_3_c' => array(
					'is_ui_added' => false, 'label' => 'Type', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'ad_type_list',
				),
				'ad_percent_3_c' => array(
					'is_ui_added' => false, 'label' => '%', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'ad_comment_c' => array(
					'is_ui_added' => false, 'label' => 'Comment', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'part_decoration_c' => array(
					'is_ui_added' => false, 'label' => 'Part Decoration', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'part_decoration_list',
				),
			),
			'tr_regulatory' => array(
				'fda_food_contact_c' => array(
					'is_ui_added' => false, 'label' => 'Food Contact', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'fda_food_contact_list',
				),
				'fda_eu_article_type_c' => array(
					'is_ui_added' => false, 'label' => 'Article Type', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'fda_eu_food_type_c' => array(
					'is_ui_added' => false, 'label' => 'Food Type', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'temperature_and_conditions_c' => array(
					'is_ui_added' => false, 'label' => 'T&C of use', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'is_rohs_c' => array(
					'is_ui_added' => false, 'label' => 'ROHS', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'rohs_list',
				),
				'mmp_medical_c' => array(
					'is_ui_added' => false, 'label' => 'Medical Classification', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'mmp_medical_list',
				),
				'prop_65_c' => array(
					'is_ui_added' => false, 'label' => 'Prop 65', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'prop65_list',
				),
				'is_toys_c' => array(
					'is_ui_added' => false, 'label' => 'Toys', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'reach_svhc_c' => array(
					'is_ui_added' => false, 'label' => 'Reach SVHC', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'reach_svhc_list',
				),
				'is_housewares_c' => array(
					'is_ui_added' => false, 'label' => 'Housewares', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'is_coneg_tip_c' => array(
					'is_ui_added' => false, 'label' => 'CONEG / TIP', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'is_acid_resistant_pigment_c' => array(
					'is_ui_added' => false, 'label' => 'Acid Pigment', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'usp_class_c' => array(
					'is_ui_added' => false, 'label' => 'USP Class', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'ups_class_list',
				),
                'is_iron_oxide_pigment_ok_c' => array(
					'is_ui_added' => false, 'label' => 'Iron Oxide Free', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'is_cpsia_c' => array(
					'is_ui_added' => false, 'label' => 'CPSIA', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'is_heavy_metal_free_c' => array(
					'is_ui_added' => false, 'label' => 'H Metal Free', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'ul_cert_c' => array(
					'is_ui_added' => false, 'label' => 'UL Cert', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'ul_cert_list',
				),
				'is_diarylide_free_c' => array(
					'is_ui_added' => false, 'label' => 'Diarylide Free', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'ul_cert_list',
				),
				'nsf_cert_c' => array(
					'is_ui_added' => false, 'label' => 'NSF Cert', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'nsf_cert_list',
				),
				'other_material_restriction_c' => array(
					'is_ui_added' => false, 'label' => 'Oth Mat Rest', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'r_other_cert_c' => array(
					'is_ui_added' => false, 'label' => 'Other Cert', 'value' => '', 
					'style' => '', 'class' => '',
				),
			),
			'product' => array(
				'type' => array(
					'is_ui_added' => false, 'label' => 'Type', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'product_type_list',
				),
				'status_c' => array(
					'is_ui_added' => false, 'label' => 'Status', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'aos_products_status_list',
				),
				'product_number_c' => array(
					'is_ui_added' => false, 'label' => 'Prod #', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'name' => array(
					'is_ui_added' => false, 'label' => 'Prod Name', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'product_category_c' => array(
					'is_ui_added' => false, 'label' => 'Prod Category', 'value' => '', 
					'style' => '', 'class' => '',
				),
				/* //no need, unless SK wants it
				'technical_request' => array( //TODO: To populate it's value in database
					'is_ui_added' => false, 'label' => 'TR', 'value' => '', 
					'style' => '', 'class' => '',
				),
				*/
				'site_c' => array(
					'is_ui_added' => false, 'label' => 'Site', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'lab_site_list',
				),
				'user_id_c' => array(
					'is_ui_added' => false, 'label' => 'Site Contact', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'cost' => array(
					'is_ui_added' => false, 'label' => 'Cost', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'scheduling_code_c' => array(
					'is_ui_added' => false, 'label' => 'Sched Code', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'priority_level_c' => array(
					'is_ui_added' => false, 'label' => 'Prio Level', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'priority_level_c' => array(
					'is_ui_added' => false, 'label' => 'Prio Level', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'priority_level_list',
				),
				'complexity_c' => array(
					'is_ui_added' => false, 'label' => 'Complexity', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'complexity_list',
				),
				'description' => array(
					'is_ui_added' => false, 'label' => 'Description', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'complexity_list',
				),
				'product_image_pic_c_file' => array( //TODO: To populate it's value in database 
					'is_ui_added' => false, 'label' => 'Product Image', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'number_of_attempts_c' => array(
					'is_ui_added' => false, 'label' => '# of Attempts', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'number_of_hours_c' => array(
					'is_ui_added' => false, 'label' => '# of Hours', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'assigned_user_name' => array(
					'is_ui_added' => false, 'label' => 'Assigned To', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'created_by_name' => array(
					'is_ui_added' => false, 'label' => 'Created By', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'date_entered' => array( 
					'is_ui_added' => false, 'label' => 'Date Entered', 'value' => '', 
					'style' => '', 'class' => '',
				),
			),
			'product_info' => array(
				'base_resin_c' => array( 
					'is_ui_added' => false, 'label' => 'Base Resin', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'resin_type_list',
				),
				'color_c' => array( 
					'is_ui_added' => false, 'label' => 'Color', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'pi_color_list',
				),
				'geometry_c' => array( 
					'is_ui_added' => false, 'label' => 'Geometry', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'cm_product_form_list',
				),
				'fda_eu_food_contract_c' => array( 
					'is_ui_added' => false, 'label' => 'Food Contact', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'fda_food_contact_list',
				),
				'resin_type_c' => array( 
					'is_ui_added' => false, 'label' => 'Carrier Resin', 'value' => '', 
					'style' => '', 'class' => '',
				),
				'comments_c' => array( 
					'is_ui_added' => false, 'label' => 'Comments', 'value' => '', 
					'style' => '', 'class' => '',
				),
			),
			'distributions' => array(),
		);		

		function __construct(){}

		public function process()
		{
			global $log, $app_list_strings, $db, $current_user;

			if(TechnicalRequestHelper::is_id_exists($this->technical_request_id)){
				$this->tr_bean = BeanFactory::getBean('TR_TechnicalRequests', $this->technical_request_id);
				$tr_indexes = array('general', 'tr_prod_info', 'tr_competitor_info', 'tr_customer_base',
					'tr_stability', 'tr_opacity_texture', 'tr_tolerance', 
					'tr_additives', 'tr_regulatory');

				foreach($tr_indexes as $tr_index){
					foreach($this->pdf_data[$tr_index] as $pdf_var => &$pdf)
					{
						foreach (get_object_vars($this->tr_bean) as $key => $value) {
							if($pdf_var == $key)
							{
								$pdf['value'] = trim($value);

								if(isset($pdf['option_name']) && !empty($pdf['option_name']))
								{
									$pdf['value'] = $app_list_strings[$pdf['option_name']][$value];
								}
							}
						}
					}
				}

				if(!empty($this->tr_bean->tr_technicalrequests_accountsaccounts_ida))
				{
					$account = BeanFactory::getBean('Accounts', $this->tr_bean->tr_technicalrequests_accountsaccounts_ida);
					$this->pdf_data['header']['company_name']['value'] = $account->name;
				}

                if(!empty($this->tr_bean->product_category_c))
                {
                    $product_category = BeanFactory::getBean('AOS_Product_Categories', $this->tr_bean->product_category_c);
                    $this->pdf_data['tr_prod_info']['product_category_c']['value'] = $product_category->name;
				}

				if (! empty($this->tr_bean->updates)) {
					$this->tr_bean->updates = html_entity_decode($this->tr_bean->updates);;
					$this->tr_bean->updates = str_replace('font-size:8pt;', 'font-size:5pt;', $this->tr_bean->updates);
					$this->tr_bean->updates = str_replace('font-size:12pt;', '', $this->tr_bean->updates);
					$this->tr_bean->updates = str_replace('<br />', '', $this->tr_bean->updates);
					$this->pdf_data['general']['updates']['value'] = $this->tr_bean->updates;
				}
				
				//TR Money
				$this->pdf_data['general']['avg_sell_price_c']['value'] = convert_to_money($this->pdf_data['general']['avg_sell_price_c']['value']);
				$this->pdf_data['general']['annual_amount_c']['value'] = convert_to_money($this->pdf_data['general']['annual_amount_c']['value']);
				$this->pdf_data['general']['annual_amount_weighted_c']['value'] = convert_to_money($this->pdf_data['general']['annual_amount_weighted_c']['value']);
				$this->pdf_data['tr_competitor_info']['price_c']['value'] = convert_to_money($this->pdf_data['tr_competitor_info']['price_c']['value']);
				
				//TR - Market
				if(!empty($this->tr_bean->mkt_markets_id_c))
				{
					$market = BeanFactory::getBean('MKT_Markets', $this->tr_bean->mkt_markets_id_c);
                    $this->pdf_data['general']['market_name']['value'] = $market->name;
				}
                
				//TR - Accounts
                $this->tr_bean->load_relationship('tr_technicalrequests_accounts');
                $accounts = $this->tr_bean->tr_technicalrequests_accounts->getBeans();
                if(!empty($accounts) && count($accounts) > 0)
                {
                    $account = array_values($accounts)[0];
				    $this->pdf_data['general']['account_name']['value'] = $account->name;

                    //OnTrack #1436 - Account Prio in Opportunity
                    $account_class_c = $account->account_class_c;
                    if(empty($account->account_class_c)){
                        $account_class_c = '-';
                    }

                    $this->pdf_data['opportunity_detail']['account_prio']['value'] = $account_class_c;
				}
				
				//TR - Opportunity
				$this->tr_bean->load_relationship('tr_technicalrequests_opportunities');
				$opportunities = $this->tr_bean->tr_technicalrequests_opportunities->getBeans();
				if($opportunities)
				{
					$opportunity = array_values($opportunities)[0];
					$this->pdf_data['general']['opportunity_name']['value'] = $opportunity->name;


                    //OnTrack #1226 - Opportunity Details
                    $this->pdf_data['opportunity_detail']['opp_id']['value'] = $opportunity->oppid_c;
                    $this->pdf_data['opportunity_detail']['opp_name']['value'] = $opportunity->name;
                    $this->pdf_data['opportunity_detail']['acc_name']['value'] = $opportunity->account_name;
                    $this->pdf_data['opportunity_detail']['sales_stage']['value'] = (!empty($app_list_strings['sales_stage_dom'])) ? 
                        $app_list_strings['sales_stage_dom'][$opportunity->sales_stage] : '';
                    $this->pdf_data['opportunity_detail']['status']['value'] = (!empty($app_list_strings['tr_technicalrequests_status_list'])) ?
                        $app_list_strings['tr_technicalrequests_status_list'][$opportunity->status_c]: '';
                    $this->pdf_data['opportunity_detail']['opp_amount']['value'] = convert_to_money($opportunity->amount);
                    $this->pdf_data['opportunity_detail']['expected_date_closed']['value'] = $opportunity->date_closed;
                    $this->pdf_data['opportunity_detail']['user']['value'] = $opportunity->assigned_user_name;
                    $this->pdf_data['opportunity_detail']['created_date']['value'] = $opportunity->date_entered;
				}

				//TR - Distros
				$distroBean = BeanFactory::getBean('DSBTN_Distribution');
				$distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$this->tr_bean->id}'", false, 0);

				if($distroBeanList != null && count($distroBeanList) > 0)
				{
					$distro_data = array();
					foreach($distroBeanList as $distroBean)
					{
                        $contact = BeanFactory::getBean('Contacts', $distroBean->contact_id_c);
                        $account = BeanFactory::getBean('Accounts', $distroBean->account_id_c);
						$distro_item_bean = BeanFactory::getBean('DSBTN_DistributionItems');
						$distro_items = $distro_item_bean->get_full_list("", "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}' AND dsbtn_distributionitems_cstm.status_c NOT IN ('complete', 'rejected') ", false, 0);

						if(isset($distro_items) && !empty($distro_items)){
							foreach($distro_items as $distro_item)
							{
								$distroItemAssignedUserBean = BeanFactory::getBean("Users", $distro_item->assigned_user_id);
								$status = $app_list_strings['distribution_item_status_list'][$distro_item->status_c];

								$this->pdf_data['distributions'][] = array(
									'distro_num' => $distroBean->distribution_number_c,
                                    'account_name' => $account->name,
                                    'contact_name' => trim($contact->first_name . ' ' . $contact->last_name),
									'distribution_item_c' => DistributionHelper::GetDistributionItemLabel($distro_item->distribution_item_c),
									'qty_c' => $distro_item->qty_c,
                                    'uom_c' => $distro_item->uom_c,
									'shipping_method' => DistributionHelper::GetShippingMethodLabel($distro_item->shipping_method_c),
									'assigned_to' => $distroItemAssignedUserBean->name ?? '',
									'status' => $status,
                                    'account_information_c' => $distro_item->account_information_c,
								);
							}
						}
					}
				}

				//TR - Contacts                
                $contact = BeanFactory::getBean('Contacts', $this->tr_bean->contact_id1_c);
				if($contact != null && !empty($contact->last_name))
				{
                    $name = trim($contact->first_name . ' ' . $contact->last_name);
					$this->pdf_data['header']['contact_name']['value'] = $name;
					//$log->fatal(print_r($contact, true));
					if(!empty($contact->email1)){
						$this->pdf_data['header']['contact_email']['value'] = $contact->email1;
					}

                    $distro_bean = null;
                    if($distroBeanList != null && count($distroBeanList) > 0){
                        $distro_bean = $distroBeanList[0];
                    }

                    // var_dump($distro_bean->primary_address_street);
                    // var_dump($distro_bean->primary_address_city);
                    // var_dump($distro_bean->primary_address_state);
                    // var_dump($distro_bean->primary_address_postalcode);
                    // var_dump($distro_bean->primary_address_country);
                    // die();

					$this->pdf_data['header']['contact_phone']['value'] = $contact->phone_work;
					$address = $distro_bean->primary_address_street . ', ' . $distro_bean->primary_address_city . ', '  .
								$distro_bean->primary_address_state . ', ' . $distro_bean->primary_address_postalcode . ', '  .
								$distro_bean->primary_address_country;
				    $this->pdf_data['header']['contact_address_info']['value'] = $address;
				}

				//TR - Related TR
				if(!empty($this->tr_bean->tr_technicalrequests_id_c)){
					$tr_related_bean = BeanFactory::getBean('TR_TechnicalRequests', $this->tr_bean->tr_technicalrequests_id_c);
					$this->pdf_data['general']['tr_related_name']['value'] = TechnicalRequestHelper::get_related_tr_name($tr_related_bean);
                }

				//TR - TR Items
				$retrieveTRItemsQuery = "SELECT tri_technicalrequestitems.* 
					FROM tri_technicalrequestitems
					LEFT JOIN tri_technicalrequestitems_tr_technicalrequests_c
						ON tri_technicalrequestitems.id = tri_technicalrequestitems_tr_technicalrequests_c.tri_technif81bstitems_idb
					LEFT JOIN tr_technicalrequests
						ON tr_technicalrequests.id = tri_technicalrequestitems_tr_technicalrequests_c.tri_techni0387equests_ida
					LEFT JOIN tr_technicalrequests_cstm
						ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c
					LEFT JOIN securitygroups_records 
						ON securitygroups_records.record_id = tri_technicalrequestitems.id
						AND securitygroups_records.deleted = 0
					LEFT JOIN securitygroups 
						ON securitygroups.id = securitygroups_records.securitygroup_id
						AND securitygroups.deleted = 0
					LEFT JOIN securitygroups_cstm 
						ON securitygroups.id = securitygroups_cstm.id_c
					LEFT JOIN securitygroups_users 
						ON securitygroups.id = securitygroups_users.securitygroup_id
						AND securitygroups_users.deleted = 0
					WHERE tri_technicalrequestitems.deleted = 0
						AND tr_technicalrequests.id = '{$this->technical_request_id}'
						AND tri_technicalrequestitems.status NOT IN ('complete', 'rejected')";

				if (! $current_user->is_admin) {
					// Retrieve records where user is part of the security group or is the assigned user for the TR Item
					$retrieveTRItemsQuery .= "
						AND (securitygroups_users.user_id = '{$current_user->id}' OR tri_technicalrequestitems.assigned_user_id = '{$current_user->id}')
					";
				}
				
				$retrieveTRItemsQuery .= " GROUP BY tri_technicalrequestitems.id";

				$trItemResult = $db->query($retrieveTRItemsQuery);

				while ($row = $db->fetchByAssoc($trItemResult)) {
					$trItemAssignedUserBean = BeanFactory::getBean("Users", $row['assigned_user_id']);

					$this->pdf_data['tr_items'][] = array(
						'tr_item' => $app_list_strings['distro_item_list'][$row['name']],
						'qty' => $row['qty'],
						'uom' => $row['uom'],
						'due_date' => $row['due_date'],
						'assigned_to' => $trItemAssignedUserBean->name ?? '',
						'status' => $app_list_strings['technical_request_items_status_list'][$row['status']]
					);
				}

				//TR - Radio Buttons
				$this->pdf_data['tr_regulatory']['is_toys_c']['value'] = 
					($this->pdf_data['tr_regulatory']['is_toys_c']['value'] == 1) ? 'Yes' : 'No' ;
				$this->pdf_data['tr_regulatory']['is_housewares_c']['value'] = 
					($this->pdf_data['tr_regulatory']['is_housewares_c']['value'] == 1) ? 'Yes' : 'No' ;
				$this->pdf_data['tr_regulatory']['is_coneg_tip_c']['value'] = 
					($this->pdf_data['tr_regulatory']['is_coneg_tip_c']['value'] == 1) ? 'Yes' : 'No' ;
				$this->pdf_data['tr_regulatory']['is_acid_resistant_pigment_c']['value'] = 
					($this->pdf_data['tr_regulatory']['is_acid_resistant_pigment_c']['value'] == 1) ? 'Yes' : 'No' ;
                $this->pdf_data['tr_regulatory']['is_iron_oxide_pigment_ok_c']['value'] = 
					($this->pdf_data['tr_regulatory']['is_iron_oxide_pigment_ok_c']['value'] == 1) ? 'Yes' : 'No' ;
				$this->pdf_data['tr_regulatory']['is_cpsia_c']['value'] = 
					($this->pdf_data['tr_regulatory']['is_cpsia_c']['value'] == 1) ? 'Yes' : 'No' ;
				$this->pdf_data['tr_regulatory']['is_heavy_metal_free_c']['value'] = 
					($this->pdf_data['tr_regulatory']['is_heavy_metal_free_c']['value'] == 1) ? 'Yes' : 'No' ;

				//Product
				$product = BeanFactory::getBean('AOS_Products');

				if ($this->tr_bean->type) {
					if (! in_array($this->tr_bean->type, ['color_match', 'rematch', 'cost_analysis', 'ld_optimization'])) {
						$this->pdf_data['general']['name']['label'] = 'Product #';

						$product = BeanFactory::getBean('AOS_Products')->retrieve_by_string_fields(
							array(
								"product_number_c" => $this->tr_bean->name,
							), false, true
						);
					} else {
						$this->pdf_data['general']['name']['label'] = 'Product Name';
						
						if (! $this->product_id) {
							$technicalRequestProductMasterBeanList = $this->tr_bean->get_linked_beans(
								'tr_technicalrequests_aos_products_2',
								'AOS_Products',
								'date_entered ASC',
								0,
								-1,
								0,
								"tr_technicalrequests_aos_products_2_c.tr_technicalrequests_aos_products_2tr_technicalrequests_ida = '{$this->technical_request_id}'"
							);
							
							if ($technicalRequestProductMasterBeanList != null && count($technicalRequestProductMasterBeanList) > 0) {
								
								foreach ($technicalRequestProductMasterBeanList as $productMasterBean) {
									// OnTrack #1614 fix: Removed condition for not displaying Product Master IF Type !== 'development'
									// PM should be displayed when stage is Production
									if($productMasterBean->type == 'development' && (in_array($productMasterBean->status_c, ['complete', 'rejected']))) {
										continue;
									}
									$product = $productMasterBean;

								}
							}
						} else {
							$product = BeanFactory::getBean('AOS_Products', $this->product_id);
						}

						
					}
				}
				
				$product_indexes = array('product', 'product_info');

				foreach($product_indexes as $product_index){
					foreach($this->pdf_data[$product_index] as $pdf_var => &$pdf)
					{
						foreach (get_object_vars($product) as $key => $value) {
							if($pdf_var == $key)
							{
								$pdf['value'] = $value;

								if(isset($pdf['option_name']) && !empty($pdf['option_name']))
								{
									$pdf['value'] = $app_list_strings[$pdf['option_name']][$value];
								}
							}
						}
					}
				}

				if(!empty($product->product_category_c))
				{
					$product_categories = get_product_categories();
					if(!empty($product_categories)){
						$this->pdf_data['product']['product_category_c']['value'] = $product_categories[$product->product_category_c];
					}
				}

				$site_coordinators = ProductHelper::get_site_coordinator($product->site_c);
				if(!empty($site_coordinators) && !empty($site_coordinators['data']))
				{
					$this->pdf_data['product']['user_id_c']['value'] = array_values($site_coordinators['data'])[0]['name'];
				}
			}
			else{
				die('Something went wrong while processing your request');
			}
		}

		public function printPDF()
		{
			global $app_list_strings, $log;
			if(1 == 1)
			{
				define ('CUSTOM_PDF_MARGIN_TOP', 20);
				define ('CUSTOM_PDF_PAGE_ORIENTATION', 'P');

				$pdf = new TCPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);


				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Empower');
				$pdf->SetTitle('Technical Request Printout');
				$pdf->SetSubject('Technical Request Printout');
				//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

				// set default header data
				$pdf->SetHeaderData('', 0, 'Technical Request Printout', '');

				// set header and footer fonts
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
				//var_dump(PDF_MARGIN_LEFT);
				$pdf->SetMargins(3, CUSTOM_PDF_MARGIN_TOP, 3);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				// set font
				$pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);

				// get the current page break margin.
				//$bMargin = $pdf->getBreakMargin();

				// get current auto-page-break mode.
				//$auto_page_break = $pdf->getAutoPageBreak();

				// enable auto page break.
				//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);

				// add a page
				$pdf->AddPage();
				//$log->fatal('y 1: ' . $pdf->getY());
				//$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(255, 0, 0)));
			}

			$style = '<style>
						.break{
							line-height: 5px;
						}

						.tdLabel{
							margin-left: 5px;
						}

						.tdValue{
							
						}

						.td-title{
							width: 200px;
							border: 1px solid black;
							padding: 0px;
							background-color: #C8C8C8;
							font-weight: bold;
						}

						.subTitle{
							border: 1px solid black;
							text-align: center;
							background-color: #C8C8C8;
							font-weight: bold;
						}

						.opacityTexture{
							border: 1px solid black;
						}

						
					</style>
				<table>';

			//start of First Row
			if(1 == 1){
                $html .= '<tr>';
					$html .= '<td>';
						$html .= '<table cellspacing="0" cellpadding="0" border="1">';
                        $html .= '<tr>';

                        $html .= '<td colspan="2">';
                            $html .= '<table cellspacing="0" cellpadding="0" border="0">';

                                $totalColumnsHasValue = $this->getTotalColumnsHasValue('opportunity_detail');
                                $rowCtr = 0;
                                $cellIndex = 0;

                                $html .= '<tr><td class="subTitle" colspan="2">Opportunity</td></tr>';
                                foreach($this->pdf_data['opportunity_detail'] as $pdf_var => $pdf_val)
                                {
                                    if(!empty($pdf_val['value'])){
                                        if($rowCtr == 0)
                                        {
                                            $html .= '<tr>';
                                        }
                                        
                                        $html .= '<td>' . $this->getHTMLDataV2('opportunity_detail', $pdf_var) . '</td>';
                                    
                                        $rowCtr++;

                                        if($rowCtr == 2){
                                            $html .= '</tr>';
                                            $rowCtr = 0;
                                        }

                                        $cellIndex++;
                                    }
                                }

                                if($cellIndex == $totalColumnsHasValue && $rowCtr < 2 && $rowCtr > 0)
                                {
                                    $html .= '</tr>';
                                }
        
                            $html .= '</table>';
                        $html .= '</td>';

                        $html .= '</tr>';
						$html .= '</table>';
					$html .= '</td>';
				$html .= '</tr>';

				
			}
			//end of First Row

			$html .= '<tr><td class="break"></td></tr>';

            //start of 2nd Row
            if(2 == 2){
                $html .= '<table class="main">';
				$html .= '<tr>';
					$html .= '<td>';
						$html .= '<table border="1">';
							$html .= '<tr>';
								//start of Header
								$html .= $this->getSectionHTML('header', 'Contact');
								//end of Header

								//start of TR - General
								$html .= '<td colspan="2">';
									$html .= '<table cellspacing="0" cellpadding="0" border="0">';

										$totalColumnsHasValue = $this->getTotalColumnsHasValue('general');
										$rowCtr = 0;
										$cellIndex = 0;

										$html .= '<tr><td class="subTitle" colspan="2">General</td></tr>';
										foreach($this->pdf_data['general'] as $pdf_var => $pdf_val)
										{
											
											if(!empty($pdf_val['value'])){
												if($rowCtr == 0)
												{
													$html .= '<tr>';
												}
												
												$html .= '<td>' . $this->getHTMLDataV2('general', $pdf_var) . '</td>';
											
												$rowCtr++;

												if($rowCtr == 2){
													$html .= '</tr>';
													$rowCtr = 0;
												}

												$cellIndex++;
											}
										}

										if($cellIndex == $totalColumnsHasValue && $rowCtr < 2 && $rowCtr > 0)
										{
											$html .= '</tr>';
										}
				
									$html .= '</table>';
								$html .= '</td>';
								//end of TR - General

							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</td>';
				$html .= '</tr>';
				//end of First TR - General
            }
            //start of 2nd Row

            $html .= '<tr><td class="break"></td></tr>';

			//start of 3rd Row
			if(3 == 3){
				$html .= '<tr>';
					$html .= '<td>';
						$html .= '<table cellspacing="0" cellpadding="0" border="1">';

							$cellIndex = 0;
							$html .= '<tr>';
								//start of TR Prod Info
								$html .= $this->getSectionHTML('tr_prod_info', 'Prod Info');
								//end of TR Prod Info

								//start of Competitor Information
								$html .= $this->getSectionHTML('tr_competitor_info', 'Competitor Information');
								//end of Competitor Information

								//start of Customer Base
								$html .= $this->getSectionHTML('tr_customer_base', 'Customer Base');
								//end of Customer Base
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</td>';
				$html .= '</tr>';
			}

			$html .= '<tr><td class="break"></td></tr>';

			//start pf 4th row
			if(true){
                $html .= '<tr>';
                    $html .= '<td>';
                        $html .= '<table border="1">';
                            $html .= '<tr>';
                                //start of Stability
                                $html .= $this->getSectionHTML('tr_stability', 'Stability');
                                //end of Stability

                                //start of Opacity & Texture - tr_opacity_texture
                                $html .= $this->getSectionHTML('tr_opacity_texture', 'Opacity & Texture');
                                //end of Opacity & Texture

                                //start of Tolerance - tr_tolerance
                                $html .= $this->getSectionHTML('tr_tolerance', 'Tolerance');
                                //end of Tolerance

                            $html .= '</tr>';
                        $html .= '</table>';
                    $html .= '</td>';

                    // $html .= '</table>';
                    // $html .= '</td>';
                $html .= '</tr>';
			}
			//end of 4th row

			$html .= '<tr><td class="break"></td></tr>';

			//start of 5th row
			if(true){
				$html .= '<tr>';
					$html .= '<td>';
						$html .= '<table border="1">';
							$html .= '<tr>';
								//start of Additives
								$html .= $this->getSectionHTML('tr_additives', 'Additives');
								/*
								$html .= '<td>';
									$html .= '<table cellspacing="0" cellpadding="0" border="0">';

										$totalColumnsHasValue = $this->getTotalColumnsHasValue('tr_additives');
										$rowCtr = 0;
										$cellIndex = 0;

										$html .= '<tr><td class="subTitle" colspan="2">Additives</td></tr>';
										foreach($this->pdf_data['tr_additives'] as $pdf_var => $pdf_val)
										{
											
											if(!empty($pdf_val['value'])){
												if($rowCtr == 0)
												{
													$html .= '<tr>';
												}
												
												$html .= '<td>' . $this->getHTMLDataV2('tr_additives', $pdf_var) . '</td>';
											
												$rowCtr++;

												if($rowCtr == 2){
													$html .= '</tr>';
													$rowCtr = 0;
												}

												$cellIndex++;
											}
										}

										if($cellIndex == $totalColumnsHasValue && $rowCtr < 2 && $rowCtr > 0)
										{
											$html .= '</tr>';
										}

									$html .= '</table>';
								$html .= '</td>';
								*/
								//end of Additives

								//start of Regulatory
								$html .= '<td colspan="2">';
									$html .= '<table cellspacing="0" cellpadding="0" border="0">';

										$totalColumnsHasValue = $this->getTotalColumnsHasValue('tr_regulatory');
										$rowCtr = 0;
										$cellIndex = 0;

										$html .= '<tr><td class="subTitle" colspan="3">Regulatory</td></tr>';
										foreach($this->pdf_data['tr_regulatory'] as $pdf_var => $pdf_val)
										{
											
											if(!empty($pdf_val['value'])){
												if($rowCtr == 0)
												{
													$html .= '<tr>';
												}
												
												$html .= '<td>' . $this->getHTMLDataV2('tr_regulatory', $pdf_var) . '</td>';
											
												$rowCtr++;

												if($rowCtr == 3){
													$html .= '</tr>';
													$rowCtr = 0;
												}

												$cellIndex++;
											}
										}

										if($cellIndex == $totalColumnsHasValue && $rowCtr < 3 && $rowCtr > 0)
										{
											$html .= '</tr>';
										}

									$html .= '</table>';
								$html .= '</td>';
								//$html .= $this->getSectionHTML('tr_regulatory', 'Regulatory');
								//end of Regulatory
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</td>';
				$html .= '</tr>';
			}
			//end of 5th row
			
			// start of 6th row
			if (count($this->pdf_data['tr_items']) > 0) {
				$html .= '<tr><td class="break"></td></tr>';
				$html .= '<tr><td class="break"></td></tr>';

				$html .= '<tr>';
					//start of Resin Information
					$html .= '<td>';
						$html .= '<table border="1">';
							$html .= '<tr>';
								//start of TR Items
								$html .= '<td>';
									$html .= '<table border="1">';
										$html .= '<tr><td colspan="8" class="subTitle">Technical Request Items</td></tr>';
										$html .= '<tr>';
											$html .= '<td style="text-align: center; width: 20%">TR Item</td>';
											$html .= '<td style="text-align: center; width: 20%">Qty</td>';
											$html .= '<td style="text-align: center; width: 20%">UOM</td>';
											$html .= '<td style="text-align: center; width: 20%">Assigned To</td>';
											$html .= '<td style="text-align: center; width: 20%">Status</td>';
										$html .= '</tr>';
										foreach ($this->pdf_data['tr_items'] as $trItem) {
											$html .= '<tr>';
												$html .= '<td style="text-align: center;">'. $this->getHTMLDataV3($trItem['tr_item']) .'</td>';
												$html .= '<td style="text-align: center;">'. $this->getHTMLDataV3($trItem['qty']) .'</td>';
												$html .= '<td style="text-align: center;">'. $this->getHTMLDataV3($trItem['uom']) .'</td>';
												$html .= '<td style="text-align: center;">'. $this->getHTMLDataV3($trItem['assigned_to']) .'</td>';
												$html .= '<td style="text-align: center;">'. $this->getHTMLDataV3($trItem['status']) .'</td>';
											$html .= '</tr>';
										}

									$html .= '</table>';
								$html .= '</td>';
								//end of TR Items
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</td>';
					//end of Resin Information
				$html .= '</tr>';
			}
			// end of 6th row

			// start of 7th row

			if (count($this->pdf_data['distributions']) > 0) {
				$html .= '<tr><td class="break"></td></tr>';
				$html .= '<tr><td class="break"></td></tr>';
                $font_size = "font-size: 9px;";
				
				$html .= '<tr>';
					//start of Resin Information
					$html .= '<td>';
						$html .= '<table border="1">';
							$html .= '<tr>';
								//start of Distributions
								$html .= '<td>';
									$html .= '<table border="1">';
										$html .= '<tr><td colspan="9" class="subTitle">Distribution Items</td></tr>';

										$html .= '<tr>';
											$html .= '<td style="text-align: center; width: 5%; '. $font_size .'">Distro #</td>';
											$html .= '<td style="text-align: center; width: 10%; '. $font_size .'">Account</td>';
											$html .= '<td style="text-align: center; width: 15%; '. $font_size .'">Name</td>';
											$html .= '<td style="text-align: center; width: 15%; '. $font_size .'">Disto Item</td>';
											$html .= '<td style="text-align: center; width: 5%; '. $font_size .'">Qty</td>';
											$html .= '<td style="text-align: center; width: 5%; '. $font_size .'">UOM</td>';
											$html .= '<td style="text-align: center; width: 10%; '. $font_size .'">Del Method</td>';
                                            $html .= '<td style="text-align: center; width: 15%; '. $font_size .'">'. "Add'l Info" . "</td>";
											$html .= '<td style="text-align: center; width: 10%; '. $font_size .'">Assigned To</td>';
											$html .= '<td style="text-align: center; width: 10%; '. $font_size .'">Status</td>';
										$html .= '</tr>';

										foreach($this->pdf_data['distributions'] as $distribution){
											$html .= '<tr>';
												$html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['distro_num']) .'</td>';
												$html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['account_name']) .'</td>';
												$html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['contact_name']) .'</td>';
												$html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['distribution_item_c']) .'</td>';
												$html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['qty_c']) .'</td>';
												$html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['uom_c']) .'</td>';
												$html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['shipping_method']) .'</td>';
                                                $html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['account_information_c']) .'</td>';
												$html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['assigned_to']) .'</td>';
												$html .= '<td style="text-align: center; '. $font_size .'">'. $this->getHTMLDataV3($distribution['status']) .'</td>';
											$html .= '</tr>';
										}

									$html .= '</table>';
								$html .= '</td>';
								//end of Distributions
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</td>';
					//end of Resin Information
				$html .= '</tr>';
			}
			// end of 7th row

			$html .= '</table>';
			//end of main table

			//var_dump($html);
			//echo $html;
			//$log->fatal($html);

			// output the HTML content
			$pdf->writeHTML($style . $html, true, false, false, false, '');

			//$log->fatal('y 2: ' . $pdf->getY());

			// add a page
			$pdf->AddPage();
			
			/** */
			$next_html = '<table>';

			$next_html .= '<tr>';
				$next_html .= '<td>';
					$next_html .= '<table border="1">';
						$next_html .= '<tr>';
						//start of Product Master
						$next_html .= '<td colspan="2">';
							$next_html .= '<table cellspacing="0" cellpadding="0" border="0">';

								$totalColumnsHasValue = $this->getTotalColumnsHasValue('product');
								$rowCtr = 0;
								$cellIndex = 0;

								$next_html .= '<tr><td class="subTitle" colspan="2">Product Master</td></tr>';
								foreach($this->pdf_data['product'] as $pdf_var => $pdf_val)
								{
									
									if(!empty($pdf_val['value'])){
										if($rowCtr == 0)
										{
											$next_html .= '<tr>';
										}
										
										$next_html .= '<td>' . $this->getHTMLDataV2('product', $pdf_var) . '</td>';
									
										$rowCtr++;

										if($rowCtr == 2){
											$next_html .= '</tr>';
											$rowCtr = 0;
										}

										$cellIndex++;
									}
								}

								if($cellIndex == $totalColumnsHasValue && $rowCtr < 2 && $rowCtr > 0)
								{
									$next_html .= '</tr>';
								}

							$next_html .= '</table>';
						$next_html .= '</td>';
						//end of Product Master

						//start of Product Info
						$next_html .= $this->getSectionHTML('product_info', 'Product Info');
						/*
						$next_html .= '<td>';
							$next_html .= '<table cellspacing="0" cellpadding="0" border="0">';
								
								$totalColumnsHasValue = $this->getTotalColumnsHasValue('product_info');
								$rowCtr = 0;
								$cellIndex = 0;

								$next_html .= '<tr><td class="subTitle" colspan="2">Product Info</td></tr>';
								foreach($this->pdf_data['product_info'] as $pdf_var => $pdf_val)
								{
									
									if(!empty($pdf_val['value'])){
										if($rowCtr == 0)
										{
											$next_html .= '<tr>';
										}
										
										$next_html .= '<td>' . $this->getHTMLDataV2('product_info', $pdf_var) . '</td>';
									
										$rowCtr++;

										if($rowCtr == 2){
											$next_html .= '</tr>';
											$rowCtr = 0;
										}

										$cellIndex++;
									}
								}

								if($cellIndex == $totalColumnsHasValue && $rowCtr < 2 && $rowCtr > 0)
								{
									$next_html .= '</tr>';
								}

							$next_html .= '</table>';
						$next_html .= '</td>';
						*/
						//end of Product Info

						$next_html .= '</tr>';

					$next_html .= '</table>';
				$next_html .= '</td>';
			$next_html .= '</tr>';

			$next_html .= '<tr><td class="break"></td></tr>';

			if(6 == 6)
			{
				//start of static form
				$next_html .= '<tr>';
					$next_html .= '<td>';
						$next_html .= '<table border="1">';
							$next_html .= '<tr>';
								$next_html .= '<td colspan="13" style="font-weight: bold;"> LAB USE ONLY</td>';
							$next_html .= '</tr>';
							$next_html .= '<tr>';
								$next_html .= '<td colspan="5" style="width: 36%"> Color Name:</td>';
								$next_html .= '<td colspan="4" style="width: 32%"> Color Number:</td>';
								$next_html .= '<td colspan="4" style="width: 32%"> Match Resin:</td>';
							$next_html .= '</tr>';
							$next_html .= '<tr>';
								$next_html .= '<td colspan="3" style="width: 20%"> % LDR</td>';
								$next_html .= '<td colspan="2" style="width: 16%"> Use Ration</td>';
								$next_html .= '<td style="width: 8%"></td>';
								$next_html .= '<td style="width: 8%"></td>';
								$next_html .= '<td style="width: 8%"></td>';
								$next_html .= '<td style="width: 8%"></td>';
								$next_html .= '<td style="width: 8%"></td>';
								$next_html .= '<td style="width: 8%"></td>';
								$next_html .= '<td style="width: 8%"></td>';
								$next_html .= '<td style="width: 8%"></td>';
							$next_html .= '</tr>';
							$next_html .= '<tr>';
								$next_html .= '<td style="width: 11.5%; text-align: center;">Item ID</td>';
                                $next_html .= '<td style="width: 11.5%; text-align: center;">Item Description</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">RM Qty</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Shot 1</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Shot 2</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Shot 3</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Shot 4</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Shot 5</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Shot 6</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Shot 7</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Shot 8</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Shot 9</td>';
								$next_html .= '<td style="width: 7%; text-align: center;">Final Formula</td>';
							$next_html .= '</tr>';

							for($i = 0; $i < 12; $i++){
								$next_html .= '<tr>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
									$next_html .= '<td></td>';
                                    $next_html .= '<td></td>';
								$next_html .= '</tr>';
							}

							$next_html .= '<tr>';
								$next_html .= '<td colspan="7" style="font-weight: bold;"> Color Matcher Initials:</td>';
								$next_html .= '<td colspan="6" style="font-weight: bold;"> Manager Initials:</td>';
							$next_html .= '</tr>';
						$next_html .= '</table>';
					$next_html .= '</td>';
				$next_html .= '</tr>';
				//end of static form
			}

			$next_html .= '<tr><td class="break"></td></tr>';

			if(7 == 7)
			{
				//start of static form
				$next_html .= '<tr>';
					$next_html .= '<td>';
						$next_html .= '<table border="1">';
							$next_html .= '<tr>';
								$next_html .= '<td style="font-weight: bold;"> Production Mixing Instructions:</td>';
								$next_html .= '<td> Grind Spec:</td>';
							$next_html .= '</tr>';
							$next_html .= '<tr>';
								$next_html .= '<td> Masterbatch</td>';
								$next_html .= '<td> Standard Roto 35 Mesh <input type="checkbox" name="box" value="1" /></td>';
							$next_html .= '</tr>';
							$next_html .= '<tr>';
								$next_html .= '<td> Feedstock:</td>';
								$next_html .= '<td> Granite Mesh 12 <input type="checkbox" name="box" value="1" /> 16 <input type="checkbox" name="box" value="1" /> 20 <input type="checkbox" name="box" value="1" /> 35 <input type="checkbox" name="box" value="1" /></td>';
							$next_html .= '</tr>';
							$next_html .= '<tr>';
								$next_html .= '<td> Drycolor:</td>';
								$next_html .= '<td> Pulverized Powder Mesh 16 <input type="checkbox" name="box" value="1" /> 20 <input type="checkbox" name="box" value="1" /> 30 <input type="checkbox" name="box" value="1" /> 35 <input type="checkbox" name="box" value="1" /> Other</td>';
							$next_html .= '</tr>';
							$next_html .= '<tr>';
								$next_html .= '<td></td>';
								$next_html .= '<td></td>';
							$next_html .= '</tr>';
							$next_html .= '<tr>';
								$next_html .= '<td colspan="2"> Comments:</td>';
							$next_html .= '</tr>';
							$next_html .= '<tr>';
								$next_html .= '<td colspan="2"></td>';
							$next_html .= '</tr>';
						$next_html .= '</table>';
					$next_html .= '</td>';
				$next_html .= '</tr>';
				//end of static form 2
			}

			
			$next_html .= '</table>';

			$pdf->writeHTML($style . $next_html, true, false, false, false, '');
			

			//$log->fatal('y 3: ' . $pdf->getY());

			// reset pointer to the last page
			$pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$pdf->Output('TR Printout-' . date('Y-m-d') . strtotime(date('h:i:s')) . '.pdf', 'D');
		}

		private function getSectionHTML($pdf_index, $title)
		{
			$html = '';
			$html .= '<td>';
				$html .= '<table>';
				$html .= '<tr><td colspan="3" class="subTitle">'. $title .'</td></tr>';
					$html .= '<tr>';
						$html .= '<td style="width: 2%"></td>';
						$html .= '<td style="width: 96%">';
							$html .= '<table>';
								foreach($this->pdf_data[$pdf_index] as $pdf_var => $pdf_val)
								{
									if(!empty($pdf_val['value'])){
										$html .= '<tr><td>' . $this->getHTMLDataV2($pdf_index, $pdf_var) . '</td></tr>';
										
									}
								}
							$html .= '</table>';
						$html .= '</td>';
						$html .= '<td style="width: 2%"></td>';
					$html .= '</tr>';
				$html .= '</table>';
			$html .= '</td>';

			return $html;
		}
		
		private function getHTMLDataV3($pdf_value){
			$result = '';

			if(!empty($pdf_value))
			{
				$result .= '<table style="width: 100%;">';
				$result .= '<tr>';
				$result .= '<td style="width: 2%;"></td>';
				$result .= '<td style="width:96%">' . $pdf_value . '</td>';
				$result .= '<td style="width: 2%;"></td>';
				$result .= '</tr>';
				$result .= '</table>';
			}

			return $result;
		}

		private function getHTMLDataV2($pdf_index, $pdf_var){
			$result = '';
			$pdf = $this->pdf_data[$pdf_index][$pdf_var];

			if(!$pdf['is_ui_added'])
			{
				$pdf['is_ui_added'] = true;
				$result .= '<table>';
					$result .= '<tr>';
						$result .= '<td style="width: 2%;"></td>';
						$result .= '<td style="width: 96%;">';
							$result .= '<table>';
								$result .= '<tr>';
									$result .= '<td class="tdLabel">' . $pdf['label'] . ':</td>';
									$result .= '<td style="'. $pdf['style'] .'" class="tdValue '. 
										$pdf['class'] .'" >' . $pdf['value'] . '</td>';
								$result .= '</tr>';
							$result .= '</table>';
						$result .= '</td>';
						$result .= '<td style="width: 2%;"></td>';
					$result .= '</tr>';
				$result .= '</table>';
			}

			return $result;
		}

		private function getTotalColumnsHasValue($pdf_index)
		{
			$result = 0;

			if(!empty($pdf_index)){
				foreach($this->pdf_data[$pdf_index] as $pdf_var => $pdf)
				{
					if(!empty($pdf['value'])){
						$result++;
					}
				}
			}

			return $result;
		}

		private function getHTMLData($labelName, $tdData)
		{
			$result = '';

			if(!empty($tdData))
			{
				$result .= '<tr><td class="tdLabel" style="height: 10px;">'. $labelName .'</td> <td class="tdValue">'. $tdData .'</td></tr>';
			}

			return $result;
		}
	}
?>
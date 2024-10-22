<?php
    require_once('custom/include/TCPDF/tcpdf.php');
    require_once('custom/entrypoints/helpers/PDFHelper.php');
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');
	use Carbon\Carbon;

    class OppSumReport{

        private $pdf_data = array(
            //Opportunity ID#, Opportunity name, Type, Stage, Status, Account, Contact (primary), Opportunity Amount, Avg Sell Price, Annual Volume, Expected Close date, Description, Sales Rep (Account Assigned To), Created Date,
            'opp_section' => array(
                'oppid_c' => array(
					'is_ui_added' => false, 'label' => 'Opp ID#', 'value' => '', 
					'style' => '', 'class' => '',
				),
                'name' => array(
                    'is_ui_added' => false, 'label' => 'Name', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'opportunity_type' => array(
                    'is_ui_added' => false, 'label' => 'Type', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'sales_stage' => array(
                    'is_ui_added' => false, 'label' => 'Stage', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'status_c' => array(
                    'is_ui_added' => false, 'label' => 'Status', 'value' => '', 
					'style' => '', 'class' => '', 'option_name' => 'tr_technicalrequests_status_list',
                ),
                'account_name' => array(
                    'is_ui_added' => false, 'label' => 'Account', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'contact_name' => array(
                    'is_ui_added' => false, 'label' => 'Contact', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'amount' => array(
                    'is_ui_added' => false, 'label' => 'Amount', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'avg_sell_price_c' => array(
                    'is_ui_added' => false, 'label' => 'Avg Sell Price', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'avg_sell_price' => array(
                    'is_ui_added' => false, 'label' => 'Avg Sell Price', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'annual_volume_lbs_c' => array(
                    'is_ui_added' => false, 'label' => 'Annual Volume (Lbs.)', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'date_closed' => array(
                    'is_ui_added' => false, 'label' => 'Expected Close Date', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'description' => array(
                    'is_ui_added' => false, 'label' => 'Description', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                //Account Assigned To
                'sales_rep' => array(
                    'is_ui_added' => false, 'label' => 'Sales Rep', 'value' => '', 
					'style' => '', 'class' => '',
                ),
                'created_date' => array(
                    'is_ui_added' => false, 'label' => 'Created Date', 'value' => '', 
					'style' => '', 'class' => '',
                ),
            ),
            'tr_list_section' => array(),
            'contact_section' => array(),
        );

        public function process($opp_id){
            if(empty($opp_id)){
                die('No Opp ID');
            }

            $this->manage_data($opp_id);
        }

        public function printPDF(){
            define ('CUSTOM_PDF_MARGIN_TOP', 20);
            define ('CUSTOM_PDF_PAGE_ORIENTATION', 'P');

            $pdf = new TCPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);


            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Empower');
            $pdf->SetTitle('Opportunity Summary Report');
            $pdf->SetSubject('Opportunity Summary Report');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            // set default header data
            $pdf->SetHeaderData('', 0, 'Opportunity Summary Report', '');

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

            $style = $this->get_css();

            //start of main table
            $html = '<table>';

            if(1 == 1){
                $html .= '<table class="main">';
                $html .= '<tr>';
                    $html .= '<td>';
                        $html .= '<table border="1">';
                            $html .= '<tr>';
                                //start of TR - Opportunity 
                                $html .= '<td colspan="2">';
                                    $html .= '<table cellspacing="0" cellpadding="1" border="0">';

                                        $totalColumnsHasValue = PDFHelper::getTotalColumnsHasValue('opp_section', $this->pdf_data);
                                        $rowCtr = 0;
                                        $cellIndex = 0;

                                        $html .= '<tr><td class="subTitle" colspan="2">Opportunity</td></tr>';
                                        foreach($this->pdf_data['opp_section'] as $pdf_var => $pdf_val)
                                        {
                                            
                                            if(!empty($pdf_val['value'])){
                                                if($rowCtr == 0)
                                                {
                                                    $html .= '<tr>';
                                                }
                                                
                                                $html .= '<td>' . PDFHelper::getHTMLDataV2('opp_section', $pdf_var, $this->pdf_data) . '</td>';
                                            
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
                                //end of TR - Opportunity

                            $html .= '</tr>';
                        $html .= '</table>';
                    $html .= '</td>';
                $html .= '</tr>';
                //end of First TR - Opportunity
            }
            //end of 1st Row

            $html .= '<tr><td class="break"></td></tr>';

            if(2 == 2){
                $html .= '<tr>';
					//start of TR Information
					$html .= '<td>';
						$html .= '<table border="0" cellpadding="1">';
							$html .= '<tr>';
								//start of TR
								$html .= '<td>';
									$html .= '<table border="1" cellpadding="1">';
										$html .= '<tr><td colspan="5" class="subTitle">Technical Requests</td></tr>';

										$html .= '<tr>';
                                            $html .= '<td style="text-align: center; width: 10%; font-weight: bold;">TR #</td>';
                                            $html .= '<td style="text-align: center; width: 15%; font-weight: bold;">Type</td>';
                                            $html .= '<td style="text-align: center; width: 15%; font-weight: bold;">Stage</td>';
                                            $html .= '<td style="text-align: center; width: 13%; font-weight: bold;">Status</td>';
                                            $html .= '<td style="text-align: center; width: 15%; font-weight: bold;">Product #</td>';
                                            $html .= '<td style="text-align: center; width: 20%; font-weight: bold;">Product Name</td>';
                                            $html .= '<td style="text-align: center; width: 12%; font-weight: bold;">Req Comp Date</td>';
										$html .= '</tr>';

										foreach($this->pdf_data['tr_list_section'] as $tr_section){
                                            $html .= '<tr>';
                                            $html .= '<td class="trSubTitle" style="text-align: center;">'. PDFHelper::getHTMLDataV3($tr_section['header']['tr_num']['value']) .'</td>';
                                            $html .= '<td class="trSubTitle" style="text-align: center;">'. PDFHelper::getHTMLDataV3($tr_section['header']['type']['value']) .'</td>';
                                            $html .= '<td class="trSubTitle" style="text-align: center;">'. PDFHelper::getHTMLDataV3($tr_section['header']['approval_stage']['value']) .'</td>';
                                            $html .= '<td class="trSubTitle" style="text-align: center;">'. PDFHelper::getHTMLDataV3($tr_section['header']['status']['value']) .'</td>';
                                            $html .= '<td class="trSubTitle" style="text-align: center;">'. PDFHelper::getHTMLDataV3($tr_section['header']['prod_num']['value']) .'</td>';
                                            $html .= '<td class="trSubTitle" style="text-align: center;">'. PDFHelper::getHTMLDataV3($tr_section['header']['prod_name']['value']) .'</td>';
                                            $html .= '<td class="trSubTitle" style="text-align: center;">'. PDFHelper::getHTMLDataV3($tr_section['header']['req_comp_date']['value']) .'</td>';
                                            $html .= '</tr>';

                                            if(!empty($tr_section['details'])){
                                                $html .= '<tr>';
                                                $html .= '<td colspan="6" align="center">';
                                                    $html .= '<table border="0">'; //start of margin
                                                    $html .= '<tr style="line-height: 50%"><td></td></tr>'; //top margin
                                                    $html .= '<tr>';
                                                    $html .= '<td width="10%"></td>'; //left margin
                                                    

                                                    $html .= '<td width="85%">';
                                                    $html .= '<table border="1" cellpadding="1">';
                                                    $html .= '<thead>';
                                                    $html .= '<tr>';
                                                    $html .= '<th style="font-weight: bold; width: 32%;">TR Item</th>';
                                                    $html .= '<th style="font-weight: bold; width: 10%;">Qty</th>';
                                                    $html .= '<th style="font-weight: bold; width: 10%">UOM</th>';
                                                    $html .= '<th style="font-weight: bold; width: 15%;">Due Date</th>';
                                                    $html .= '<th style="font-weight: bold; width: 15%;">Completed Date</th>';
                                                    $html .= '<th style="font-weight: bold; width: 20%;">Assigned To</th>';
                                                    $html .= '</tr>';
                                                    $html .= '</thead>';

                                                    foreach($tr_section['details'] as $detail){
                                                        $html .= '<tr>';
                                                        $html .= '<td>' . PDFHelper::getHTMLDataV3($detail['tr_item']['value']) . '</td>';
                                                        $html .= '<td>' . PDFHelper::getHTMLDataV3($detail['qty']['value']) . '</td>';
                                                        $html .= '<td>' . PDFHelper::getHTMLDataV3($detail['uom']['value']) . '</td>';
                                                        $html .= '<td>' . PDFHelper::getHTMLDataV3($detail['due_date']['value']) . '</td>';
                                                        $html .= '<td>' . PDFHelper::getHTMLDataV3($detail['completed_date_c']['value']) . '</td>';
                                                        $html .= '<td>' . PDFHelper::getHTMLDataV3($detail['assgined_to']['value']) . '</td>';
                                                        $html .= '</tr>';
                                                    }
                                                    $html .= '</table>';
                                                    $html .= '</td>';

                                                    $html .= '<td width="1%"></td>'; //right margin
                                                    $html .= '</tr>';
                                                    $html .= '<tr style="line-height: 50%"><td></td></tr>'; //bottom margin
                                                    $html .= '</table>'; //end of margin
                                                
                                                $html .= '</td>';
                                                $html .= '</tr>';
                                            }
										}

									$html .= '</table>';
								$html .= '</td>';
                                //end of TR
							$html .= '</tr>'; 
						$html .= '</table>';
					$html .= '</td>';
					//end of TR Information
				$html .= '</tr>';
            }
            //end of 2nd Row

            $html .= '<tr><td class="break"></td></tr>';

            if(3 == 3){
                $html .= '<tr>';
                //start of TR Information
                $html .= '<td>';
                    $html .= '<table border="1">';
                        $html .= '<tr>';
                            //start of Contact
                            $html .= '<td>';
                            $html .= '<table border="1" cellpadding="1">';
                            $html .= '<tr><td colspan="6" class="subTitle">Contacts</td></tr>';

                            $html .= '<tr>';
                                $html .= '<td style="text-align: center; width: 15%; font-weight: bold;">Name</td>';
                                $html .= '<td style="text-align: center; width: 23%; font-weight: bold;">Email</td>';
                                $html .= '<td style="text-align: center; width: 15%; font-weight: bold;">Office Phone</td>';
                                $html .= '<td style="text-align: center; width: 7%; font-weight: bold;">Ext</td>';
                                $html .= '<td style="text-align: center; width: 15%; font-weight: bold;">Mobile Phone</td>';
                                $html .= '<td style="text-align: center; width: 25%; font-weight: bold;">Primary Address Info</td>';
                            $html .= '</tr>';

                            foreach($this->pdf_data['contact_section'] as $contact_section){
                                $html .= '<tr>';
                                $html .= '<td style="text-align: center;">'. PDFHelper::getHTMLDataV3($contact_section['contact_name']['value']) .'</td>';
                                $html .= '<td style="text-align: center;">'. PDFHelper::getHTMLDataV3($contact_section['email']['value']) .'</td>';
                                $html .= '<td style="text-align: center;">'. PDFHelper::getHTMLDataV3($contact_section['phone_work']['value']) .'</td>';
                                $html .= '<td style="text-align: center;">'. PDFHelper::getHTMLDataV3($contact_section['ext_c']['value']) .'</td>';
                                $html .= '<td style="text-align: center;">'. PDFHelper::getHTMLDataV3($contact_section['phone_mobile']['value']) .'</td>';
                                $html .= '<td style="text-align: left;">'. PDFHelper::getHTMLDataV3($contact_section['address']['value']) .'</td>';
                                $html .= '</tr>';

                            }

                            $html .= '</table>';

                            $html .= '</td>';
							//end of Contact
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</td>';
					//end of TR Information
				$html .= '</tr>';
            }

            $html .= '</table>';
            //end of main table

            $pdf->writeHTML($style . $html, true, false, false, false, '');
			

			//$log->fatal('y 3: ' . $pdf->getY());

			// reset pointer to the last page
			$pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
            $file_name = "Opportunity Summary {$this->pdf_data['opp_section']['oppid_c']['value']}";
			$pdf->Output($file_name . '.pdf', 'I');
        }

        private function manage_data($opp_id){
            global $app_list_strings;

            $opp_bean = BeanFactory::getBean('Opportunities', $opp_id);
            $opp_indexes = array('opp_section');

            if(!empty($opp_bean->id)){
                $opp_bean->amount = convert_to_money($opp_bean->amount);
                $opp_bean->avg_sell_price_c = convert_to_money($opp_bean->avg_sell_price_c);

                foreach($opp_indexes as $tr_index){
					foreach($this->pdf_data[$tr_index] as $pdf_var => &$pdf)
					{
						foreach (get_object_vars($opp_bean) as $key => $value) {
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

                //TR#, Product # (Prod master), Product name, Req Completion Date
                $this->pdf_data['tr_list_section'] = $this->get_related_tr($opp_bean);
                $this->pdf_data['contact_section'] = $this->get_related_contacts($opp_bean);
            }

            // echo '<pre>';
            // print_r($this->pdf_data);
            // echo '</pre>';
        }

        private function get_related_tr($opp_bean){
            global $app_list_strings;

            $result = array();
            $opp_bean->load_relationship('tr_technicalrequests_opportunities');
            $rel_tr_bean_list = $opp_bean->tr_technicalrequests_opportunities->getBeans();

            foreach($rel_tr_bean_list as $rel_tr_bean){
                $rel_tr_bean->load_relationship('tri_technicalrequestitems_tr_technicalrequests');
                $tr_item_list = array();
                $tr_item_list = $rel_tr_bean->tri_technicalrequestitems_tr_technicalrequests->getBeans();
                $type_name = !empty($app_list_strings['tr_technicalrequests_type_dom'][$rel_tr_bean->type]) ? $app_list_strings['tr_technicalrequests_type_dom'][$rel_tr_bean->type] : '';
                $stage_name = !empty($app_list_strings['approval_stage_list'][$rel_tr_bean->approval_stage]) ?  $app_list_strings['approval_stage_list'][$rel_tr_bean->approval_stage] : '';
                $status_name = !empty($app_list_strings['tr_technicalrequests_status_list'][$rel_tr_bean->status]) ?  $app_list_strings['tr_technicalrequests_status_list'][$rel_tr_bean->status] : '';

                $tr_record = array();
                $tr_record['header'] = array(
                    'tr_num' => array(
                        'is_ui_added' => false, 'label' => 'TR #', 'value' => $rel_tr_bean->technicalrequests_number_c. '.'.$rel_tr_bean-> version_c, 
                        'style' => '', 'class' => '',
                    ),
                    'type' => array(
                        'is_ui_added' => false, 'label' => 'Type', 'value' => $type_name, 
                        'style' => '', 'class' => '',
                    ),
                    'prod_num' => array(
                        'is_ui_added' => false, 'label' => 'Prod #', 'value' => $this->get_prod_num($rel_tr_bean), 
                        'style' => 'text-align: right;', 'class' => '',
                    ),
                    'prod_name' => array(
                        'is_ui_added' => false, 'label' => 'Prod Name', 'value' => $rel_tr_bean->name, 
                        'style' => '', 'class' => '',
                    ),
                    'req_comp_date' => array(
                        'is_ui_added' => false, 'label' => 'Req Completion Date', 'value' => $rel_tr_bean->req_completion_date_c, 
                        'style' => '', 'class' => '',
                    ),
                    'approval_stage' => array(
                        'is_ui_added' => false, 'label' => 'Stage', 'value' => $stage_name, 
                        'style' => '', 'class' => '',
                    ),
                    'status' => array(
                        'is_ui_added' => false, 'label' => 'Status', 'value' => $status_name, 
                        'style' => '', 'class' => '',
                    ),
                );

                foreach($tr_item_list as $tr_item_bean){
                    $tr_item_name = !empty($app_list_strings['distro_item_list'][$tr_item_bean->name]) ?  $app_list_strings['distro_item_list'][$tr_item_bean->name] : '';
                    $tri_completed_date = !empty($tr_item_bean->completed_date_c) 
                        ? Carbon::parse($tr_item_bean->completed_date_c)->format('m/d/Y')
                        : "";

                    $tr_record['details'][] = array(
                        'tr_item' => array(
                            'is_ui_added' => false, 'label' => 'TR Item', 'value' => $tr_item_name, 
                            'style' => '', 'class' => '',
                        ),
                        'qty' => array(
                            'is_ui_added' => false, 'label' => 'Qty', 'value' => $tr_item_bean->qty, 
                            'style' => '', 'class' => '',
                        ),
                        'uom' => array(
                            'is_ui_added' => false, 'label' => 'UOM', 'value' => $tr_item_bean->uom, 
                            'style' => '', 'class' => '',
                        ),
                        'due_date' => array(
                            'is_ui_added' => false, 'label' => 'Due Date', 'value' => $tr_item_bean->due_date, 
                            'style' => '', 'class' => '',
                        ),
                        'completed_date_c' => array(
                            'is_ui_added' => false, 'label' => 'Completed Date', 'value' => $tri_completed_date, 
                            'style' => '', 'class' => '',
                        ),
                        'assgined_to' => array(
                            'is_ui_added' => false, 'label' => 'Assigned To', 'value' => $tr_item_bean->assigned_user_name, 
                            'style' => '', 'class' => '',
                        ),
                    );
                }

                

                $result[] = $tr_record;
            }

            return $result;
        }

        //OnTrack #1265
        private function get_prod_num($tr_bean){
            $result = '';
            $tr_bean->load_relationship('tr_technicalrequests_aos_products_2');
            $prod_list = $tr_bean->tr_technicalrequests_aos_products_2->getBeans();

            if(!empty($prod_list)){
                foreach($prod_list as $prod_bean){
                    $result .= $prod_bean->product_number_c . ', ';
                }

                if(!empty($result)){
                    $result = substr($result, 0, (strlen($result) - 2));
                }
            }

            return $result;
        }

        private function get_related_contacts($opp_bean){
            $result = array();
            $rel_contact_list = $this->get_related_contact_data($opp_bean->id);

            if(!empty($rel_contact_list)){
                foreach($rel_contact_list as $contact_bean){

                    $contact_name = $contact_bean->first_name . ' ' . $contact_bean->last_name;
                    $address = $this->get_contact_address($contact_bean);;
                    $result[] = array(
                        'contact_name' => array(
                            'is_ui_added' => false, 'label' => 'Name', 'value' => $contact_name, 
                            'style' => '', 'class' => '',
                        ),
                        'email' => array(
                            'is_ui_added' => false, 'label' => 'Email', 'value' => $contact_bean->email1, 
                            'style' => '', 'class' => '',
                        ),
                        'phone_work' => array(
                            'is_ui_added' => false, 'label' => 'Office Phone', 'value' => $contact_bean->phone_work, 
                            'style' => '', 'class' => '',
                        ),
                        'ext_c' => array(
                            'is_ui_added' => false, 'label' => 'Office Ext', 'value' => $contact_bean->ext_c, 
                            'style' => '', 'class' => '',
                        ),
                        'phone_mobile' => array(
                            'is_ui_added' => false, 'label' => 'Office Ext', 'value' => $contact_bean->phone_mobile, 
                            'style' => '', 'class' => '',
                        ),
                        'address' => array(
                            'is_ui_added' => false, 'label' => 'Office Ext', 'value' => $address, 
                            'style' => '', 'class' => '',
                        ),
                    );
                }
            }

            return $result;
        }

        private function get_contact_address($contact_bean){
            $address = '';

            if(!empty($contact_bean)){
                if(!empty($contact_bean->primary_address_street)){
                    $address .= $contact_bean->primary_address_street;
                    $address .= '<br/>';
                }

                if(!empty($contact_bean->primary_address_city)){
                    $address .= ' ' . $contact_bean->primary_address_city;
                }

                if(!empty($contact_bean->primary_address_state)){
                    $address .= ' ' . $contact_bean->primary_address_state;
                }

                if(!empty($contact_bean->primary_address_postalcode)){
                    $address .= ' ' . $contact_bean->primary_address_postalcode;
                }

                if(!empty($contact_bean->primary_address_country)){
                    $address .= ' ' . $contact_bean->primary_address_country;
                }
            }

            return $address;
        }

        private function get_tr_product_names($tr_id){
            global $db;
            $result = '';
            $result_data = array();

            $sql = "select ap.name
                    from tr_technicalrequests_aos_products_2_c tap
                    inner join aos_products ap
                        on ap.id = tap.tr_technicalrequests_aos_products_2aos_products_idb
                            and ap.deleted = 0
                    where tap.deleted = 0
                        and tap.tr_technicalrequests_aos_products_2tr_technicalrequests_ida = '{$tr_id}'";
            $data = $db->query($sql);
            
            while($row = $db->fetchByAssoc($data)){
                $result_data[] = $row['name'];
            }

            if(!empty($result_data)){
                $result = implode(', ', $result_data);
            }

            return $result;
        }

        private function get_related_contact_data($opp_id){
            global $db;
            $result = array();

            $sql = "select contact_id
                    from opportunities_contacts
                    where deleted = 0
                        and opportunity_id = '{$opp_id}'";
            $data = $db->query($sql);
            
            while($row = $db->fetchByAssoc($data)){
                $result[] = BeanFactory::getBean('Contacts', $row['contact_id']);
            }

            return $result;
        }
        
        private function get_css(){
            $result = "<style>
                        .break{
                            line-height: 5px;
                        }

                        .tdLabel{
                            margin-left: 5px;
                            width: 30%;
                        }

                        .tdValue{
                            width: 70%;
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
                            background-color: #7F7F7F;
                            font-weight: bold;
                        }

                        .opacityTexture{
                            border: 1px solid black;
                        }

                        .trSubTitle{
                            background-color: #C3C3C3;
                        }
                    </style>";

            return $result;
        }
    }

?>
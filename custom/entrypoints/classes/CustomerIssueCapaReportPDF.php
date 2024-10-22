<?php
    require_once('custom/include/TCPDF/tcpdf.php');
    require_once('custom/modules/Cases/helpers/CustomerIssuesHelper.php');
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');

	use Carbon\Carbon;

    class CustomerIssueCapaReportPDF
    {

        public $customer_issue_bean;
        public $capa_department_manager_user;
        public $customer_issue_id;
        public $customer_issue_account;
        public $user_on_closed_issue; // the user who closed the issue
        public $return_authorization_by_user;
        public $user_on_verified_issue;
        public $date_verified;
        public $customer_issue_lot_line_items_bean_list;

        
        function __construct($customer_issue_id) 
        {
            global $log, $app_list_strings;

            $this->user_on_verified_issue = null;
            $this->date_verified = null;
            $this->customer_issue_id = $customer_issue_id;

            $this->customer_issue_bean = BeanFactory::getBean('Cases', $this->customer_issue_id);
            $this->customer_issue_account = BeanFactory::getBean('Accounts', $this->customer_issue_bean->account_id);
            $this->customer_issue_contact = BeanFactory::getBean('Contacts', $this->customer_issue_bean->contact_created_by_id);

            // Retrieve the CAPA WORKGROUP USER of role = 'DepartmentManager'
            $departmentManagers = CustomerIssuesHelper::getWorkgroupUsers($this->customer_issue_bean, 'DepartmentManager'); // array result
            $this->capa_department_manager_user = count($departmentManagers) > 0 ? $departmentManagers[0] : "";

            // Retrieve Customer Product #
            $customerItemBean = BeanFactory::getBean('CI_CustomerItems', $this->customer_issue_bean->ci_customeritems_cases_1ci_customeritems_ida);
            $this->customer_issue_bean->ci_customeritems_cases_1_name = $customerItemBean->product_number_c;

            // Retrieve User for closing an Issue
            $userOnClosedIssue = CustomerIssuesHelper::getUserForClosingIssue($this->customer_issue_bean->id);
            $this->user_on_closed_issue =  ($userOnClosedIssue) ? $userOnClosedIssue : null;

            // Retrieve Return Authorization By User
            $returnAuthorizationByUserBean = BeanFactory::getBean('Users', $this->customer_issue_bean->return_authorization_number_c);
            $this->return_authorization_by_user = ($returnAuthorizationByUserBean && $returnAuthorizationByUserBean->id) ? $returnAuthorizationByUserBean->full_name : '';

            // Retrieve User & date for verifying issue
            $qryVerificationAuditData= CustomerIssuesHelper::getRecentVerificationAuditDetails($this->customer_issue_bean);

            if ($this->customer_issue_bean->verified_status_c && $qryVerificationAuditData) {
                $this->user_on_verified_issue = $qryVerificationAuditData['user_details']->full_name;
                $this->date_verified = Carbon::parse($qryVerificationAuditData['audit_details']->date_created)->format('m/d/Y');
            }

            //OnTrack #1386
            $this->customer_issue_bean->description = $this->replace_carriage_return($this->customer_issue_bean->description);
            $this->customer_issue_bean->status_update_c = $this->replace_carriage_return($this->customer_issue_bean->status_update_c);
            $this->customer_issue_bean->credit_notes_c = $this->replace_carriage_return($this->customer_issue_bean->credit_notes_c);
            $this->customer_issue_bean->material_notes_c = $this->replace_carriage_return($this->customer_issue_bean->material_notes_c);
            $this->customer_issue_bean->investigation_results_c = $this->replace_carriage_return($this->customer_issue_bean->investigation_results_c);
            $this->customer_issue_bean->root_cause_c = $this->replace_carriage_return($this->customer_issue_bean->root_cause_c);
            $this->customer_issue_bean->immediate_action_c = $this->replace_carriage_return($this->customer_issue_bean->immediate_action_c);
            $this->customer_issue_bean->preventative_action_plan_c = $this->replace_carriage_return($this->customer_issue_bean->preventative_action_plan_c);
            $this->customer_issue_bean->internal_audit_results_c = $this->replace_carriage_return($this->customer_issue_bean->internal_audit_results_c);

            $this->customer_issue_lot_line_items_bean_list = $this->customer_issue_bean->get_linked_beans('aos_products_quotes', $this->customer_issue_bean->object_name);
        }

        public function generatePDF()
        {

            define ('CUSTOM_PDF_MARGIN_TOP', 20);
            define ('CUSTOM_PDF_PAGE_ORIENTATION', 'P');
            ob_end_clean();
            $pdf = new TCPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
            

            // set document information
            $pdf->SetCreator('Empower');
            $pdf->SetAuthor('Empower');
            // $pdf->SetTitle('Corrective and Preventive Action Report');
            // $pdf->SetSubject('Corrective and Preventive Action Report');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            // set default header data
            // $pdf->SetHeaderData('', 0, 'Corrective and Preventive Action Report', '');
            // $pdf->SetHeaderData('chroma-color-logo.jpg', PDF_HEADER_LOGO_WIDTH, 'Corrective and Preventive Action Report', '');

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            //var_dump(PDF_MARGIN_LEFT);
            $pdf->SetMargins(4, CUSTOM_PDF_MARGIN_TOP, 4);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set font
            $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
            
            // First Page
            $pdf->AddPage();
            $html = $this->formatHTML();
            $pdf->writeHTML($html, true, false, false, false, '');

            $pdf->Ln();

            // Second Page
            $pdf->AddPage();
            $nextPageHtml = $this->formatHTML(2);
            $pdf->writeHTML($nextPageHtml, true, false, false, false, '');

            // reset pointer to the last page
            $pdf->lastPage();

            
            $pdf->Output('CAPA REPORT.pdf', 'D');

        }

        public function formatHTML($page = 1) 
        {
            global $app_list_strings, $log;
            
            $mainTable = '';
            $result = '';
            // Updated logic in #1260:if Type = Quality issue Complaint Justified = Yes, else No
            // Updated logic in #1572: if Status is NOT Issue Invalid (Rejected), Complaint Justified = Yes, else No
            switch ($this->customer_issue_bean->ci_type_c) {
                case 'QualityIssue':
                    $complainJustified = ($this->customer_issue_bean->status <> 'Rejected') 
                        ? 'Yes'
                        : 'No'; 
                    break;
                case 'AuditFindings':
                    $complainJustified = ''; 
                    break;
                default:
                    $complainJustified = 'No'; 
                    break;
            }

            $style = <<<EOD
                <style>
                    table {
                        width: 100%;
                    }
                    
                    td, th {
                        text-align: left;
                        padding: 10px;
                    }

                    .label {
                        background-color: #f5f5f5;
                    }

                    .table-margin {
                        margin-top: 20px;
                    }

                    .form-title {
                        margin: 0 auto
                        
                    }

                    .logo {
                        display: inline-block;
                        width: 50%
                    }

                </style>

EOD;
            
            
            if ($page == 1 ) {

                $mainTable = <<<EOD
                    <table cellspacing="0" cellpadding="5">
                        <tr>
                            <th colspan="2"><img src="custom/include/images/chroma-color-logo.jpg" border="0" height="50" width="100" /></th>
                            <th colspan="2"><span style="font-size: 16px; font-weight: bold; text-align: right;"><br>Corrective and Preventive Action Report</span></th>
                        </tr>
                    </table>

                    <table cellspacing="0" cellpadding="5" border="1">
                        <tr>
                            <th colspan="2">Date: {$this->customer_issue_bean->create_date_c}</th>
                            <th colspan="2">Issue Number: {$this->customer_issue_bean->case_number}</th>
                            
                        </tr>
                        <tr>
                            <th colspan="2"><span class="form-label">Customer Name and Address:</span> 
                                <br/> {$this->customer_issue_account->name} 
                                <br/><br/>
                                {$this->customer_issue_account->billing_address_country} <br/> {$this->customer_issue_account->billing_address_street} <br/>{$this->customer_issue_account->billing_address_city}, {$this->customer_issue_account->billing_address_state}
                            </th>
                            <th colspan="2">CSR/Sales Rep: 
                                <br/>
                                {$this->customer_issue_account->assigned_user_name}
                            </th>
                        </tr>
                        
                        <tr>
                            <th colspan="4">Contact: {$this->customer_issue_contact->first_name} {$this->customer_issue_contact->last_name} </th>
                        </tr>
                        
                    
                    </table>

                    <div></div>

                    <table class="table-margin" cellspacing="0" cellpadding="5" border="1">
                        <tr>
                            <th>Potential Return: {$this->customer_issue_bean->potential_return_c}</th>
                            <th>Potential Claim: {$this->customer_issue_bean->potential_claim_c}</th>
                        </tr>
                    </table>

                    <div></div>
                    
                    {$this->lineItemsTable()}
                    <div></div>
                    
                    <table class="table-margin" cellspacing="0" cellpadding="5" border="1">
                        <tr>
                            <th class="label">Complaint/Concern: <br/><br/> {$this->customer_issue_bean->name}</th>
                        </tr>
                        
                        <tr>
                            <th>Description: <br/> <br/> {$this->customer_issue_bean->description}</th>
                        </tr>
                        
                    </table>
                    
                    <div></div>

                    <table class="table-margin" cellspacing="0" cellpadding="5" border="1">
                        <tr>
                            <th  colspan="3" rowspan="2" class="label">Results of Investigation: <br/><br/> {$this->customer_issue_bean->investigation_results_c}</th>
                            <th>Type: <br/>
                            {$app_list_strings['ci_type_list'][$this->customer_issue_bean->ci_type_c]}
                            </th>
                        </tr>
                        <tr>
                            <th>Complaint Justified: <br/>
                                {$complainJustified}
                            </th>
                        </tr>
                        <tr>
                            <th>Assigned Investigator:</th>
                            <td colspan="3">{$this->capa_department_manager_user->full_name}</td>
                        </tr>
                        <tr>
                            <th>Expected Date of Completion:</th>
                            <td colspan="3">{$this->customer_issue_bean->due_date_c}</td>
                        </tr>
                        <tr>
                            <th>Date of Completion:</th>
                            <td colspan="3">{$this->customer_issue_bean->close_date_c}</td>
                        </tr>
                        
                    </table>
EOD;

                $result = $style .''. $mainTable;
            }

            if ($page == 2 ) {
                $secondPageTbl = <<<EOD
                    <table class="table-margin" cellspacing="0" cellpadding="5" border="1">
                        <tr>
                            <th colspan="1">Root Cause:</th>
                            <th colspan="3">{$this->customer_issue_bean->root_cause_c}</th>
                            
                            
                        </tr>
                        <tr>
                            <th colspan="1">Corrective Action: </th>
                            <th colspan="3">{$this->customer_issue_bean->immediate_action_c}</th>
                            
                            
                        </tr>
                        <tr>
                            <th colspan="1">Preventive Action: </th>
                            <th colspan="3">{$this->customer_issue_bean->preventative_action_plan_c}</th>
                            
                        </tr>
                        <tr>
                            <th colspan="1">Verification Notes: </th>
                            <th colspan="3">{$this->customer_issue_bean->internal_audit_results_c}</th>
                            
                        </tr>
                        
                    </table>

                    <div></div>
                    
                    <table class="table-margin" cellspacing="0" cellpadding="5" border="1">
                        <tr>
                            <td rowspan="2">Disposition of Material: <br/> 
                            {$app_list_strings['customer_material_dispo_list'][$this->customer_issue_bean->customer_material_dispo_c]}</td>
                            <td rowspan="2">Return Authorization By: <br/> {$this->return_authorization_by_user}</td>
                            
                        </tr>
                    </table>

                    <div></div>

                    <table class="table-margin" cellspacing="0" cellpadding="5" border="1">
                        <tr>
                            <td>Verified By: <br/> {$this->user_on_verified_issue}</td>
                            <td>Date Verified: <br/>  {$this->date_verified}</td>
                            
                        </tr>
                      
                        <tr>
                            <td>Closed By: <br/> {$this->user_on_closed_issue->full_name}</td>
                            <td>Date Closed: <br/> {$this->customer_issue_bean->close_date_c}</td>
                            
                        </tr>
                        
                    </table>
EOD;

                $result = $style .''. $secondPageTbl;
            }
            
            return $result;
        }

        private function lineItemsTable()
        {
            $table = "";

            if (isset($this->customer_issue_lot_line_items_bean_list) && count($this->customer_issue_lot_line_items_bean_list) > 0) {
                $table = "
                    <table class=\"table-margin\" cellspacing=\"0\" cellpadding=\"5\" border=\"1\">
                    <tr>
                        <th class=\"label\">Product #</th>
                        <th class=\"label\">Product Amount (Lbs)</th>
                        <th class=\"label\">Lot #</th>
                    </tr>
                ";

                foreach($this->customer_issue_lot_line_items_bean_list as $lineItem) {
                    $table .= "
                        <tr>
                            <td>{$lineItem->customer_product_number}</td>
                            <td>{$lineItem->customer_product_amount_lbs}</td>
                            <td>{$lineItem->lot_name}</td>
                        </tr>
                    ";
                }

                $table .=  "</table>";
            }

            return $table;
        }

        private function replace_carriage_return($str){
            $result = $str;

            $result = nl2br($result);

            return $result;
        }

    }
?>  
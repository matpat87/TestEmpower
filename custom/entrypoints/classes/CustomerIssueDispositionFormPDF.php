<?php
    require_once('custom/include/TCPDF/tcpdf.php');
    require_once('custom/modules/Cases/helpers/CustomerIssuesHelper.php');
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');

	use Carbon\Carbon;

    // Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF {
        
        // Page footer
        public function Footer() 
        {
            global $log;
            $line_width = (0.85 / $this->k);
            $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
            // Position at 10 mm from bottom
            $this->SetY(-10);
            // Set font
            $this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);

            $w_page = isset($this->l['w_page']) ? $this->l['w_page'].' ' : '';
            if (empty($this->pagegroups)) {
                $pagenumtxt = $w_page.$this->getAliasNumPage().' / '.$this->getAliasNbPages();
            } else {
                $pagenumtxt = $w_page.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();
            }

            $customFooterText = 'C:Empower\Form024\Disposition\Jan2024rev0';
            

            $this->Cell(0, 0, $customFooterText, 'T', 0, 'L');
            $this->Cell(0, 0, $pagenumtxt, 0, 0, 'R');
        }
    }

    class CustomerIssueDispositionFormPDF
    {

        public $pdf;
        public $customer_issue_bean;
        public $customer_issue_id;
        public $customer_issue_account;
        public $authorized_by_user = '';
        public $product_number = '';
        public $customer_issue_lot_line_items_bean_list;

        
        function __construct($customer_issue_id) 
        {
            global $log, $app_list_strings;

            $this->user_on_verified_issue = null;
            $this->date_verified = null;
            $this->customer_issue_id = $customer_issue_id;

            $this->customer_issue_bean = BeanFactory::getBean('Cases', $this->customer_issue_id);
            $this->customer_issue_account = BeanFactory::getBean('Accounts', $this->customer_issue_bean->account_id);

            if (!empty($this->customer_issue_bean->return_authorization_number_c)) {
                $userBean = BeanFactory::getBean('Users', $this->customer_issue_bean->return_authorization_number_c);
                $this->authorized_by_user = ($userBean->id) ? $userBean->full_name : '';
            }

            if (!empty($this->customer_issue_bean->ci_customeritems_cases_1ci_customeritems_ida)) {
                $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $this->customer_issue_bean->ci_customeritems_cases_1ci_customeritems_ida);
                $this->product_number = ($customerProductBean->id) ? $customerProductBean->product_number_c : '';
            }

            $this->customer_issue_lot_line_items_bean_list = $this->customer_issue_bean->get_linked_beans('aos_products_quotes', $this->customer_issue_bean->object_name);
        }

        public function generatePDF()
        {

            define ('CUSTOM_PDF_MARGIN_TOP', 10);
            define ('CUSTOM_PDF_PAGE_ORIENTATION', 'P');
            ob_end_clean();
            $this->pdf = new MYPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
            

            // set document information
            $this->pdf->SetCreator('Empower');
            $this->pdf->SetAuthor('Empower');


            // set header and footer fonts
            $this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            $this->pdf->setPrintHeader(false);

            // set default monospaced font
            $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $this->pdf->SetMargins(4, CUSTOM_PDF_MARGIN_TOP, 4);
            $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set font
            $this->pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
            
            // First Page
            $this->pdf->AddPage();
            $html = $this->formatHTML();
            $this->pdf->writeHTML($html, true, false, false, false, '');


            // reset pointer to the last page
            $this->pdf->lastPage();

            
            $this->pdf->Output('Disposition Form.pdf', 'D');

        }

        public function formatHTML() 
        {
            global $app_list_strings, $log;
            
            $style = '
                <style>
                    table {
                        width: 100%;
                    }
                    
                    td {
                        font-size: 11px;
                        text-align: left;
                        padding: 10px;
                        border: none;
                    }

                    th, .label {
                        font-weight: bold;
                    }
                    
                    .divider {
                        width: 100%;
                        margin-top: 10px;
                        border-bottom: 1px solid #aea9a8;
                    }

                </style>';

            $mainTable = '';
            $result = '';
            
            // Page title (Header)
            $mainTable .= '
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <th colspan="1" style="margin-top: 0px; text-align:center;">
                            <div><img src="custom/include/images/chroma-color-logo.jpg" border="0" height="60" width="125" /></div>
                        </th>
                        <th colspan="1" style="text-align:center;">
                            <p style="font-size: 16px; font-weight: bold;">Material Review and Disposition Form</p><br>
                        </th>
                        <th><p style="font-size: 10px; text-align: center; word-wrap: break-word"></p></th>
                    </tr>
                </table>
                <div class="divider"></div>
            ';

            $mainTable .= '
                <table cellspacing="1" cellpadding="5">
                    <tr>
                        <td colspan="2"><span class="label">Date:</span> '.$this->customer_issue_bean->create_date_c.'</td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="label">Distribution:</span> CAPA Coordinator, Receiving, Customer Service, Inventory Control</td>
                    </tr>
                    <tr>
                        <td><span class="label">Customer:</span> '.$this->customer_issue_bean->account_name.'</td>
                        <td><span class="label">Authorization By:</span> '. $this->authorized_by_user .'</td>
                    </tr>
                    <tr>
                        <td><span class="label">CI #/ RA #:</span> '.$this->customer_issue_bean->case_number.'</td>
                        <td><span class="label">Reason:</span> '.$this->customer_issue_bean->name .'</td>
                    </tr>
                    <tr>
                        <td><span class="label">Disposition:</span> '.$app_list_strings['internal_material_dispo_list'][$this->customer_issue_bean->internal_material_dispo_c].'</td>
                        <td></td>
                    </tr>
                    
                </table>
            ';

            $mainTable .= "
                <div></div>
                {$this->lineItemsTable()}
            ";
            
            $mainTable .= '
                <div></div>
                <table cellspacing="0" cellpadding="5" border="1">
                    <tr>
                        <td colspan="2" rowspan="3"><span class="label">Material Notes:</span><br/><br/>'.$this->customer_issue_bean->material_notes_c.'</td>
                    </tr>
                    
                </table>
            ';
            
            $mainTable .= '
                <div>
                    <h3>Receiving Department Information</h3>
                    <table cellspacing="0" cellpadding="5">
                        <tr>
                            <td rowspan="3"><span class="label">Date Received:</span>
                            <br/><br />
                                <span class="label">Received By:</span>
                                <br/><br />
                                <span class="label">Warehouse Location:</span>
                                <br/><br />
                                <span class="label">Comments:</span><br/>
                            </td>
                            <td rowspan="3" colspan="2">'. $this->innerTable() .'</td>
                            
                        </tr>
                    </table>
                </div>
            ';
            $mainTable .= '
                <div class="divider"></div>
                <div>
                    <table cellspacing="0" cellpadding="5" border="0">
                        <tr>
                            <td><span class="label">Date Disposition Completed:</span></td>
                            <td><span class="label">Rework Lot #:</span></td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="label">By:</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="2"><span class="label">Note(s):</span></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    
                    </table>
                </div>
               
            ';



            
            
            $result = $style . $mainTable;
            
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
                            <td>$lineItem->customer_product_number</td>
                            <td>$lineItem->customer_product_amount_lbs</td>
                            <td>$lineItem->lot_name</td>
                        </tr>
                    ";
                }

                $table .=  "</table>";
            }

            return $table;
        }

        private function innerTable()
        {
            
            $table = '';

            $radioOptions = '<span><input type="radio" name="box" value="0" />&nbsp;Sm Box</span><br/><span><input type="radio" name="box" value="0" />&nbsp;Drum</span><br><span><input type="radio" name="box" value="0" />&nbsp;Gaylord</span>
            ';

            $table .= '
                <table cellspacing="0" cellpadding="5" border="1">
                    <tr>
                        <th>Container Type</th>
                        <th>Total No. of Container</th>
                        <th>Net Weight of Container</th>
                    </tr>
                    <tr>
                        <td>'.$radioOptions.'</td>
                        <td></td>
                        <td></td>
                    
                    </tr>
                    <tr>
                        <td>'.$radioOptions.'</td>
                        <td></td>
                        <td></td>
                    
                    </tr>
                    <tr>
                        <td>'.$radioOptions.'</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3"><span class="label">Total Pounds Received:</span></td>
                    </tr>
                </table>
            ';

            return $table;
        }

    }
?>  
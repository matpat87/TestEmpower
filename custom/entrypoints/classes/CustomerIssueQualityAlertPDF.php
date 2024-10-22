<?php
    require_once('custom/include/TCPDF/tcpdf.php');
    require_once('custom/modules/Cases/helpers/CustomerIssuesHelper.php');
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');

	use Carbon\Carbon;
   

// crea
    class CustomerIssueQualityAlertPDF
    {

        public $pdf;
        public $customer_issue_bean;
        public $customer_issue_id;
        public $customer_issue_account;
        public $created_by_user = '';
        public $product_number = '';
        public $product_description = '';
        public $images = '';
        public $imagesLoc = '';
        public $customer_issue_lot_line_items_bean_list;

        
        function __construct($customer_issue_id) 
        {
            global $log, $app_list_strings;

            $this->user_on_verified_issue = null;
            $this->date_verified = null;
            $this->customer_issue_id = $customer_issue_id;

            $this->customer_issue_bean = BeanFactory::getBean('Cases', $this->customer_issue_id);
            $this->customer_issue_account = BeanFactory::getBean('Accounts', $this->customer_issue_bean->account_id);

            if (!empty($this->customer_issue_bean->created_by)) {
                $userBean = BeanFactory::getBean('Users', $this->customer_issue_bean->created_by);
                $this->created_by_user = ($userBean->id) ? $userBean->full_name : '';
            }

            if (!empty($this->customer_issue_bean->ci_customeritems_cases_1ci_customeritems_ida)) {
                $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $this->customer_issue_bean->ci_customeritems_cases_1ci_customeritems_ida);
                $this->product_number = ($customerProductBean->id) ? $customerProductBean->product_number_c : '';
                $this->product_description = ($customerProductBean->id) ? $customerProductBean->name : '';
            }

            $this->customer_issue_lot_line_items_bean_list = $this->customer_issue_bean->get_linked_beans('aos_products_quotes', $this->customer_issue_bean->object_name);
            $this->images = json_decode(html_entity_decode($this->customer_issue_bean->images_c));
        }

        public function generatePDF()
        {

            define ('CUSTOM_PDF_MARGIN_TOP', 10);
            define ('CUSTOM_PDF_MARGIN_BOTTOM', 6);
            define ('CUSTOM_PDF_PAGE_ORIENTATION', 'P');
            ob_end_clean();
            $this->pdf = new TCPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
            

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
            $this->pdf->SetFooterMargin(CUSTOM_PDF_MARGIN_BOTTOM);

            // set auto page breaks
            // $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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

            
            $this->pdf->Output('Quality Alert.pdf', 'D');

        }

        public function formatHTML() 
        {
            global $app_list_strings, $log;

            $upload_dir = $GLOBALS['sugar_config']['upload_dir'];
            $this->imagesLoc = "{$upload_dir}/Cases/{$this->customer_issue_bean->id}/images_c/";
            
            $style = '
                <style>
                    table {
                        width: 100%;
                    }
                    
                    td {
                        font-size: 13px;
                        text-align: left;
                        padding: 20px;
                        border: none;
                    }

                    th, .label {
                        font-weight: bold;
                    }

                    .table-header {
                        font-size: 23px;
                        font-weight: bold;
                        color: white;
                        background-color: red;
                        
                    }
                    
                    .divider {
                        width: 100%;
                        margin: 10px;
                        border-bottom: 1px solid #aea9a8;
                    }
                    
                    .issue-samples {
                        height: 670px;
                    }

                    .issue-styling {
                        font-size: 16px;
                        font-weight: bold;
                    }
                

                </style>';

            $mainTable = '';
            $result = '';
            
            // Page title (Header)
            $mainTable .= '
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <th colspan="1" style="margin-top: 0px; text-align:left;">
                            <div><img src="custom/include/images/chroma-color-logo.jpg" border="0" height="60" width="125" /></div>
                        </th>
                        <th colspan="1" style="text-align:center;"></th>
                        <th></th>
                    </tr>
                </table>
               
            ';
            $mainTable .= '
                <table cellspacing="1" cellpadding="5" border="1">
                    <tr>
                        <th class="table-header" colspan="2" style="text-align:center;">
                           Quality Alert
                        </th>
                        
                    </tr>
                    <tr>
                        <td><span class="label">Date:</span> '.$this->customer_issue_bean->create_date_c.'</td>
                        <td><span class="label">Submitted by:</span>&nbsp;'.$this->created_by_user.'</td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="label">Customer:</span>&nbsp;'.$this->customer_issue_account->name.'</td>
                    </tr>
                   
                </table>
            ';

            $mainTable .= "
                <div></div>
                {$this->lineItemsTable()}
            ";
            
           $mainTable .= '
                <div>
                </div>
                <table cellspacing="1" cellpadding="6" border="1">
                    <tr>
                        <th border="0" class="table-header" colspan="2" style="text-align:center;">
                        Reason for Alert
                        </th>
                        
                    </tr>
                    <tr>
                        <td colspan="2" border="0"><span class="issue-styling">Issue:&nbsp;'.$this->customer_issue_bean->name.'</span></td>
                    </tr>
                    
                </table>
           ';
            $mainTable .= '
                <div></div>
                <table cellspacing="0" cellpadding="4" border="2">
                    <tr>
                        <td colspan="3"><span class="label">Issue Images/Samples:</span></td>
                    </tr>'.$this->handleImagesArea().'
                    
                </table>
            ';
      
            
            $result = $style . $mainTable;
            
            return $result;
        }

        private function lineItemsTable()
        {
            $table = "";

            if (isset($this->customer_issue_lot_line_items_bean_list) && count($this->customer_issue_lot_line_items_bean_list) > 0) {
                $table = "
                    <table cellspacing=\"1\" cellpadding=\"5\" border=\"1\">
                    <tr>
                        <td class=\"label\">Product #</td>
                        <td class=\"label\">Product Amount (Lbs)</td>
                        <td class=\"label\">Lot #</td>
                    </tr>
                ";

                foreach($this->customer_issue_lot_line_items_bean_list as $lineItem) {
                    $table .= "
                        <tr>
                            <td class=\"label\">$lineItem->customer_product_number</td>
                            <td class=\"label\">$lineItem->customer_product_amount_lbs</td>
                            <td class=\"label\">$lineItem->lot_name</td>
                        </tr>
                    ";
                }

                $table .=  "</table>";
            }

            return $table;
        }

        private function handleImagesArea()
        {
            global $log;

            if (!empty($this->images)) {
                $row = '<tr>';
                foreach ($this->images as $index => $image) {
                    $index += 1;
                    $row .= '<td border="0" text-align="center"><img src="'.$this->imagesLoc.$image->file_name.'" alt="Front View" height="170" width="auto"></td>';
                    
                    if ($index % 3 == 0) {
                        $row .=  (count($this->images) == $index) ? '</tr>' : '</tr><tr>';
                    } 

                    if ($index % 3 != 0) {
                        $row .=  (count($this->images) == $index) ? '<td border="0"></td></tr>' : '';
                    }
                    
                }

               
              
                return $row;

            }

            return '';
        }

    }
?>  
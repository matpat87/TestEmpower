<?php
    require_once('custom/include/TCPDF/tcpdf.php');
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');
    require_once('custom/modules/Accounts/helpers/AccountProfileReportHelper.php');

	use Carbon\Carbon;


    // Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF {

        //Page header
        public function Header() {
           
            $headerdata = $this->getHeaderData(); 
            $cell_height = $this->getCellHeight($headerfont[2] / $this->k);
            $cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1);
            $this->Cell(0, 15, $headerdata['string'], array( 'B' => array('width' => 0)), false, 'R', 0, '', 0, false, 'M', 'B');

        }
    }

    class GenerateAccountProfile
    {
        public $account_bean;
        public $account_id;
        public $account_opportunities;
        public $account_customer_issues;
        public $pdf_sections_html_array = [];

        function __construct($account_id) 
        {
            global $log, $app_list_strings;
            
            $this->account_id = $account_id;
            $this->account_bean = BeanFactory::getBean('Accounts', $account_id);
            
        }

        public function generatePDF()
        {

            define ('CUSTOM_PDF_MARGIN_TOP', 20);
            define ('CUSTOM_PDF_PAGE_ORIENTATION', 'P');
            ob_end_clean();
            
            $date = Carbon::today()->toFormattedDateString();

            $formattedDateHeader = "Date Printed: {$date}";

            $pdf = new MYPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
            

            // set document information
            $pdf->SetCreator('Empower');
            $pdf->SetAuthor('Empower');
            // $pdf->SetTitle('Corrective and Preventive Action Report');
            // $pdf->SetSubject('Corrective and Preventive Action Report');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            // set default header data
            $pdf->SetHeaderData('', 0, '', $formattedDateHeader, array(0,0,0), array(0,0,0));
            // $pdf->SetHeaderData('chroma-color-logo.jpg', PDF_HEADER_LOGO_WIDTH, 'Corrective and Preventive Action Report', '');
            // set default header data
            

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_DATA));
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

            // $pdf->Ln();
            
            // reset pointer to the last page
            $pdf->lastPage();

            
            $pdf->Output('ACCOUNT PROFILE REPORT.pdf', 'I'); // Change 2nd param to 'D' if on click, PDF should force download

        }

        public function formatHTML($page = 1) 
        {
            global $app_list_strings, $log;
            
            $style = '
                <style>
                    table {
                        width: 100%;
                    }
                    
                    td {
                        font-size: 12px;
                        text-align: left;
                        padding: 10px;
                        border: none;
                    }

                    th {
                        font-weight: bold;
                    }

                    tr.even-row {
                        background-color: #aed6f1;
                    }
                    
                    tr.table-header, tr.odd-row {
                        background-color: #f1f2f4;
                    }
                    
                    .th-font-sm {
                        font-size: 9px;
                    }
                    .table-title {
                        background-color: #2d7fc2;
                        color: #fff;
                        text-align: center;
                        border: 0.5px solid #dcdad9;
                        
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

                    .inline-label {
                        font-weight: bold;
                    }

                    .row-label {
                        color: red;
                    }

                </style>';

                $mainTable = '
                <table cellspacing="1" cellpadding="8">
                    <tr>
                        <th colspan="1"><img src="custom/include/images/chroma-color-logo.jpg" border="0" height="60" width="130" /></th>
                        <th rowspan="4" colspan="1" style="text-align:center;">
                            <span style="font-size: 14px; font-weight: bold;">Account Profile Report</span><br>
                            <span style="font-size: 8px; word-wrap: break-word">
                                <span style="font-weight: bold;">'
                                .$this->account_bean->name.'</span><br>'
                                .$this->account_bean->billing_address_country.'<br>'
                                .$this->account_bean->billing_address_street.'<br>'
                                .$this->account_bean->billing_address_city.' '
                                .$this->account_bean->billing_address_state.' '
                                .$this->account_bean->billing_address_postalcode
                                .'</span>
                        </th>
                        <th><p style="font-size: 10px; text-align: center; word-wrap: break-word"></p></th>
                    </tr>
                  
                </table>
                <div></div>';

                $mainTable .= $this->formatTableData();
                $content = $style . $mainTable;

            
            return $content;
        } // end of formatHTML

        private function formatTableData()
        {
            global $log;

            
            $tableOne =  AccountProfileReportHelper::getRevenueAndBudget($this->account_bean);
            $tableTwo =  AccountProfileReportHelper::getAccountContacts($this->account_bean);
            $tableThree =  AccountProfileReportHelper::getAccountSalesObjectives($this->account_bean);
            $tableFour =  AccountProfileReportHelper::getAccountChallenges($this->account_bean);
            $tableFive =  AccountProfileReportHelper::getAccountCompetitors($this->account_bean);
            $tableSix =  AccountProfileReportHelper::getAccountCustomerIssues($this->account_bean);
            $tableSeven =  AccountProfileReportHelper::getAccountOpportunities($this->account_bean);
            $tableEight =  AccountProfileReportHelper::getChildAccountLocations($this->account_bean);
            
            $section = $this->generateTable($tableOne);
            $section .= '<div></div>';
            $section .= $this->generateTable($tableTwo);
            $section .= '<div></div>';
            $section .= $this->generateTable($tableFour);
            $section .= '<div></div>';
            $section .= $this->generateTable($tableFive);
            $section .= '<div></div>';
            $section .= $this->generateTable($tableSix);
            $section .= '<div></div>';
            $section .= $this->generateTable($tableSeven);
            $section .= '<div></div>';
            $section .= $this->generateTable($tableEight);
           
            return $section;

        }

        private function generateTable($dataArray = [])
        {   
            $section = '';
            if (count($dataArray) > 0) {
    
                $section .= '<table cellspacing="0" cellpadding="4" border="0" nobr="true">';
                
                
                if (array_key_exists('tableHeader', $dataArray)) {
                    $fontSize = (count($dataArray['tableHeader']) > 6) ? "th-font-sm" : "";

                    $colspan = count($dataArray['tableHeader']);
                    $section .= '<tr><th class="table-title" colspan="'.$colspan.'">'.$dataArray['tableTitle'].'</th></tr>';
                    $section .= '<tr class="table-header">';
                    foreach ($dataArray['tableHeader'] as $header) {
                        $section .= '<th class="'.$fontSize.'">'.$header.'</th>';
                    }
                    $section .= '</tr>';
                } else {
                    $colspan = count($dataArray['tableData'][0]) > 0 ? count($dataArray['tableData'][0]) : 1;
                    $section .= '<tr><th class="table-title" colspan="'.$colspan.'">'.$dataArray['tableTitle'].'</th></tr>';
                }

                $counter = 0;
                foreach ($dataArray['tableData'] as $table_row_index => $table_row) {
                    // if index is string - means index is the data ID and has multiple rows for the same Data
                    if (is_string($table_row_index)) {
                        foreach ($table_row as $key => $rowData) {
                            $rowClass = ($counter % 2 == 0) ? "even-row" : "odd-row"; // for alternate row colors
                            $section .= '<tr class="'.$rowClass.'">';
                            $section .= $this->generateColumns($rowData);
                            $section .= '</tr>';
                            
                        }
                        $counter++;

                    } else {
                        $rowClass = ($table_row_index % 2 == 0) ? "even-row" : "odd-row"; // for alternate row colors
                        $section .= '<tr class="'.$rowClass.'">';
                        $section .= $this->generateColumns($table_row);
                        $section .= '</tr>';
                    }
                }
    
                $section .= '</table>';
                
            }
            return $section;
        }

        private function generateColumns($rowData = []) 
        {
            global $log;
            
            $section = '';

            foreach ($rowData as $table_data_index => $table_data) {
                            
                $class = array_key_exists('class', $table_data) 
                        ? $table_data['class']
                        :'';
                $colspan = array_key_exists('colspan', $table_data) 
                        ? 'colspan="'.$table_data['colspan'].'"'
                        :'';
                $rowspan = array_key_exists('rowspan', $table_data) 
                        ? 'colspan="'.$table_data['rowspan'].'"'
                        :'';

                $section .= '<td class="'.$class.'" '.$colspan.' '.$rowspan.'>';
                
                $section .= $table_data['label'];
                $section .= $table_data['data'];
                $section .= '</td>';
            }

            return $section;
        }
        

    }

  

?>  
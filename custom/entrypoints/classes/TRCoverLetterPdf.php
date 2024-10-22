<?php
    require_once('custom/include/TCPDF/tcpdf.php');
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');
    require_once('custom/modules/TRWG_TRWorkingGroup/helpers/TRWorkingGroupHelper.php');
    require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');


	use Carbon\Carbon;

    class MYPDF extends TCPDF {
    
        // Page footer
        public function Footer() {
            $footerText = 'Important Disclaimer: The information provided is accurate to the best of Chroma’s knowledge as of the date issued. Chroma may have relied on information provided by third parties (including its suppliers).  Information provided relates only to the products described and may not be valid where the products are used in combination with other materials or in any process. The information is for guidance only, and the buyer must make its own determination of product suitability and fitness for purpose, including conducting testing in buyer’s application.  NO WARRANTY, EXPRESS OR IMPLIED, IS MADE OF FITNESS FOR A PARTICULAR PURPOSE, MERCHANTABILITY, OR ANY OTHER WARRANTY REGARDING THE PRODUCTS OR THE INFORMATION PROVIDED. Disclosure is not a license to nor an inducement to use a product in a manner that might infringe any patent.';

            // Position at 15 mm from bottom
            $this->SetY(-25);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->MultiCell(0, 10, $footerText, 0, 'L');
        }
    }


    class TRCoverLetterPdf
    {
        public $technical_request_id;
        public $tr_bean;
        public $related_account_bean;
        public $product_master;
        public $customer_product;
        public $rdManagerInfo;
        

        function __construct($tr_id) 
        {
            global $log, $app_list_strings;
            
            $this->technical_request_id = $tr_id;
            $this->tr_bean = BeanFactory::getBean('TR_TechnicalRequests', $this->technical_request_id);

            // Get related Account Bean
            $accountBean = BeanFactory::getBean('Accounts', $this->tr_bean->tr_technicalrequests_accountsaccounts_ida);
            if (!empty($accountBean->id)) {
                $this->related_account_bean = $accountBean;
            }

            // Product Category
            $productCategory = BeanFactory::getBean('AOS_Product_Categories', $this->tr_bean->product_category_c);
            $this->tr_bean->product_category_name_cstm = !empty($productCategory->id) ? $productCategory->name : '';

            // Product Master
            if ($this->tr_bean->load_relationship('tr_technicalrequests_aos_products_2')) {
                $productMasterIds = $this->tr_bean->tr_technicalrequests_aos_products_2->get(); // array
                // temp assuming TRs only have one related Product Master
                if (count($productMasterIds) == 1) {
                    $productMasterId= $productMasterIds[0];
                    $this->product_master = BeanFactory::getBean('AOS_Products', $productMasterId);
                }
            }

            // Customer Product
            if (!empty($this->tr_bean->ci_customeritems_tr_technicalrequests_1ci_customeritems_ida)) {
                $this->customer_product = BeanFactory::getBean('CI_CustomerItems', $this->tr_bean->ci_customeritems_tr_technicalrequests_1ci_customeritems_ida);
            }

            // Get R & D Manager
            $this->rdManagerInfo = (object)[];
            $rdManagerBean = TRWorkingGroupHelper::getWorkgroupUser($this->tr_bean, 'RDManager'); // User Bean if exists and FALSE if otherwise

            $this->rdManagerInfo->id = ($rdManagerBean) ? $rdManagerBean->id : "";
            $this->rdManagerInfo->name = ($rdManagerBean) ? $rdManagerBean->name : "";
            $this->rdManagerInfo->title = ($rdManagerBean) ? $rdManagerBean->title : "";
            $this->rdManagerInfo->email = ($rdManagerBean) ? $rdManagerBean->emailAddress->getPrimaryAddress($rdManagerBean) : "";
            $this->rdManagerInfo->phone_work = ($rdManagerBean) ? $rdManagerBean->phone_work : "";
          
            
        }

        public function generatePDF()
        {

            define ('CUSTOM_PDF_MARGIN_TOP', 5);
            define ('CUSTOM_PDF_PAGE_ORIENTATION', 'P');
            ob_end_clean();

            $pdf = new MYPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
            

            // set document information
            $pdf->SetCreator('Empower');
            $pdf->SetAuthor('Empower');
            
            // remove default header/footer
            $pdf->setPrintHeader(false);
            

            // set header and footer fonts
            // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_DATA));
            // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            //var_dump(PDF_MARGIN_LEFT);
            $pdf->SetMargins(8, CUSTOM_PDF_MARGIN_TOP, 8);
            // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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

            TechnicalRequestHelper::handleCoverLetterPdfUploadOnGenerate($pdf, $this->tr_bean);
            $docName = "TR-{$this->tr_bean->technicalrequests_number_c}-Cover-Letter.pdf";
            $pdf->Output($docName, 'I'); // Change 2nd param to 'D' if on click, PDF should force download

        }

        public function formatHTML($page = 1) 
        {
            global $app_list_strings, $log;

            $date = Carbon::today()->toFormattedDateString();
            $upload_dir = $GLOBALS['sugar_config']['upload_dir'];

            // Retrieve file extension and image signature
            $extension = pathinfo(parse_url("{$upload_dir}{$this->rdManagerInfo->id}_e_signature_c", PHP_URL_PATH), PATHINFO_EXTENSION);
            $img = base64_encode(file_get_contents("{$upload_dir}{$this->rdManagerInfo->id}_e_signature_c"));
            
            $chromaCorpSite = $this->getChromaSiteAddress();

            $style = '
                <style>

                    th, td {
                        font-size: 12px;
                    }
                    td.label {
                        font-size: 11px;
                        font-weight: bold;
                        text-align: right;
                    }

                </style>';

                $mainTable = '
                <table cellspacing="1" cellpadding="8">
                    <tr>
                        <th></th>
                        <th style="text-align:right;"><img src="custom/include/images/chroma-color-logo.jpg" border="0" height="60" width="130" /></th>
                    </tr>
                    <tr>
                        <th colspan="2">'.$date.'</th>
                    </tr>
                    <tr>
                        <th style="text-align:left;"><span style="word-wrap: break-word"><span style="font-weight: bold;">'.$this->tr_bean->contact_c.'</span><br>'.$this->related_account_bean->name.'<br>'
                                .$this->related_account_bean->shipping_address_country.'<br>'
                                .$this->related_account_bean->shipping_address_street.'<br>'
                                .$this->related_account_bean->shipping_address_city.' '
                                .$this->related_account_bean->shipping_address_state.' '
                                .$this->related_account_bean->shipping_address_postalcode
                                .'</span>
                        </th>
                        <th style="text-align:right;">
                            <span style="word-wrap: break-word"><span style="font-weight: bold;">Chroma Colors Corp.</span><br>'.$chromaCorpSite.'</span>
                        </th>
                    </tr>
                </table>

                <table cellspacing="1" cellpadding="6">
                    <tr>
                        <td colspan="2">Technical Request Cover Letter:</td>
                        
                    </tr>
                    <tr>
                        <td colspan="2">Chroma Color is pleased to offer the enclosed suggested product(s) for your evaluation and approval.  The below product was developed based on the information you provided to your Chroma Color representative.  We have formulated this product based on our technical knowledge and experience to meet the criteria you provided. Please review the below information for accuracy.  As is noted below, you should conduct further investigation and testing to confirm that this product is suitable for use in your end-use application.</td>
                        
                    </tr>
                </table>
                <div></div>
                <table cellspacing="1" cellpadding="6" border="0" >
                    <tr>
                        <td></td>
                        <td bgcolor="#f7f4f3" align="center" colspan="2"> <table cellspacing="1" cellpadding="6" border="0">'.$this->trRows().'</table></td>
                        <td></td>
                    </tr>
                </table>
                <div></div>

                <table cellspacing="1" cellpadding="4">
                    <tr>
                        <td colspan="2">If you have any questions or require further technical assistance, please contact me at the email and phone below.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><br><br>'.'<img src="data:image/'.$extension.';base64,'.$img.'" border="0" height="60" width="130" /><br>'.$this->rdManagerInfo->name.'<br>'.$this->rdManagerInfo->title.'<br>'.$this->rdManagerInfo->phone_work.'<br>'.$this->rdManagerInfo->email.'
                        </td>
                    </tr>
                </table>
                <br>
               
                ';

                
                $content = $style . $mainTable;

            
            return $content;
        } // end of formatHTML

        private function trRows()
        {
            global $app_list_strings;

            $rowStr = "";
            $trDetails = [
                array(
                    'label' => 'Type',
                    'value' => $app_list_strings['tr_technicalrequests_type_dom'][$this->tr_bean->type],
                ),
                array(
                    'label' => 'Technical Request #',
                    'value' => $this->tr_bean->technicalrequests_number_c,
                ),
                array(
                    'label' => 'Product Code (Rematch)',
                    'value' => $this->product_master->product_number_c,
                ),
                array(
                    'label' => 'Product Item Code',
                    'value' =>  $this->tr_bean->name,
                ),
                array(
                    'label' => 'Product Description',
                    'value' =>  (!empty($this->customer_product)) ? $this->customer_product->description : $this->product_master->description,
                ),
                array(
                    'label' => 'Product Category',
                    'value' => $this->tr_bean->product_category_name_cstm,
                ),
                array(
                    'label' => 'Let Down Ratio/Percent',
                    'value' => $this->tr_bean->target_letdown_c,
                ),
                array(
                    'label' => 'Resin/Compound Type',
                    'value' => $app_list_strings['resin_type_list'][$this->tr_bean->resin_compound_type_c],
                ),
                array(
                    'label' => 'Match in Customer Resin',
                    'value' => $app_list_strings['match_in_customer_resin_list'][$this->tr_bean->match_in_customers_resin_c],
                ),
                array(
                    'label' => 'Application',
                    'value' => $this->tr_bean->application_c,
                ),
                array(
                    'label' => 'Chroma Sales Rep',
                    'value' => $this->related_account_bean->assigned_user_name,
                ),
            ];

            foreach ($trDetails as $index => $row) {
               $rowStr .= '<tr>';
               $rowStr .= '<td class="label" border="0">'.$row['label'].':</td>';
               $rowStr .= '<td style="text-align: center;" border="0">'.$row['value'].'</td>';
               $rowStr .= '</tr>';
            }

            return $rowStr;
        }
        

        private function getChromaSiteAddress()
        {
            switch ($this->tr_bean->site)
            {
                case 'Lambertville':
                    $chromaSiteAddress = "11 Kari Drive<br>Lambertville, NJ 08530<br>Phone: 609-397-8200";
                    break;
                case 'Leominster':
                    $chromaSiteAddress = "50 Francis Street<br>Leominster, MA 01453<br>Phone: 978-537-3538";
                    break;
                case 'McHenry':
                    $chromaSiteAddress = "3900 W Dayton St.<br>McHenry, IL 60050-8378<br>Main: 815-385-8100<br>Phone: 877-385-8777";
                    break;
                case 'Salisbury':
                    $chromaSiteAddress = "100 East 17th Street<br>Salisbury, NC 28144<br>Phone: 704-637-7000";
                    break;
                case 'Asheboro':
                    $chromaSiteAddress = "1134 NC Highway 49 South<br>Asheboro, NC 27205<br>Phone: 800-247-7428";
                    break;
                    
                default:
                    $chromaSiteAddress = "";
            }
            
            return $chromaSiteAddress;
        }
    }
    

  

?>  
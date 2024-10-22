<?php
    require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    class OpportunityPipelineReportXLS{
        
        private $spreadsheet;
        private $data;
        private $fullYearAmountTotal;
        private $fullYearAmountTotalWeighted;

        private $styleCenter = array(
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'font' => array(
                'bold' => true,
            ),
        );

        const FILE_TYPE = 'xlsx';
        const FILE_NAME = 'Consolidated_Sales_Pipeline';

        function __construct(){
            $this->spreadsheet = new Spreadsheet();
            $this->data = array();
        }

        private function prepare(){
            global $app_list_strings, $sugar_config;

            $opportunityPipelineReportQuery = array(
                'select' => getSelectQueryForOpportunityPipeline(), 
                'from' => getFromQueryrForOpportunityPipeline(),
                'where' => '',
                'order_by' => '',
            );

            if(isset($_SESSION['OpportunityPipelineReportQuery']) && !empty($_SESSION['OpportunityPipelineReportQuery']))
            {
                $opportunityPipelineReportQuery = $_SESSION['OpportunityPipelineReportQuery'];
            }

            $query = $opportunityPipelineReportQuery['select'] . $opportunityPipelineReportQuery['from'] . $opportunityPipelineReportQuery['where'] . 
                $opportunityPipelineReportQuery['order_by'];

            $db = DBManagerFactory::getInstance();

            $result = $db->query($query);
            $fullYearAmountTotal = 0;
            $fullYearAmountTotalWeighted = 0;

            while($row = $db->fetchByAssoc($result)){ 
                $fullYearAmountTotal += $row['full_year_amount'];
                $fullYearAmountTotalWeighted += $row['full_year_amount_weighted'];
                $row['opportunity_link'] = $sugar_config['site_url'] . '/index.php?module=Opportunities&action=DetailView&record=' . $row['opportunity_id'];
                $row['amount_value'] = $row['full_year_amount'];
                $row['amount_weighted_value'] = $row['full_year_amount_weighted'];
                $row['full_year_amount'] = convert_to_money($row['full_year_amount']);
                $row['next_step'] = $row['next_step'];
                $row['status'] = $row['sales_stage'] && $row['status'] ? OpportunitiesHelper::get_status($row['sales_stage'])[$row['status']] : '';
            
                $row['date_closed'] = $row['date_closed'] . '&nbsp;(' . $row['date_closed_type'] . ')';
            
                if ( in_array( $row['sales_stage'], ['Closed Won', 'Closed Lost', 'ClosedRejected'] ) ) {
                    $row['date_closed'] = $row['closed_date_c'] ? $row['closed_date_c'] . '&nbsp;(' . $row['date_closed_type'] . ')' : '';
                }
            
                $row['sales_stage'] = get_dropdown_index("sales_stage_dom", 
                    $app_list_strings['sales_stage_dom'][$row['sales_stage']]) - 1; //get_dropdown_index starts at index 1

                $this->data[] = $row;
            }

            $salesStageAcronyms = [];
            foreach ($app_list_strings["sales_stage_dom"] as $key => $value) {
                    if(preg_match_all('/\b(\w)/',strtoupper($value),$matches)) {
                            switch ($key) {
                                    case 'Sampling':
                                            array_push($salesStageAcronyms, 'SP');
                                            break;
                                    case 'ProductionTrialOrder':
                                            array_push($salesStageAcronyms, 'PO');
                                            break;
                                    default:
                                            array_push($salesStageAcronyms, implode('', $matches[1]));
                                            break;
                            }
                    }    
            }

            $this->fullYearAmountTotal = convert_to_money($fullYearAmountTotal);
            $this->fullYearAmountTotalWeighted = convert_to_money($fullYearAmountTotalWeighted);


        }

        private function format(){
            global $app_list_strings;

            $prev_sales_person = '';
            $active_sheet = -1;
            $sheet = array();
            $start_detail_index = 8;
            $subTotal = 0;
            $subTotalWeighted = 0;
            $rowCtr = 0;
            foreach($this->data as $row){
                ++$rowCtr;

                if($prev_sales_person != $row['sales_rep']){
                    ++$active_sheet;

                    if( $prev_sales_person != '') {
                        $this->appendTotal($sheet, $start_detail_index, $subTotal, $subTotalWeighted);
                    }

                    $start_detail_index = 8; //After the Column Title
                    $prev_sales_person = $row['sales_rep'];

                    //Create new Sheet
                    $this->spreadsheet->createSheet();
                    $this->spreadsheet->setActiveSheetIndex($active_sheet);
                    $sheet = $this->spreadsheet->getActiveSheet();
                    $row['sales_rep'] = ($row['sales_rep'] <> '[N/A]') ? $row['sales_rep'] : 'NA';
                    $sheet->setTitle($row['sales_rep']);
                    $this->setSheetHeader($sheet);

                    //if($rowCtr < count($this->data)){
                        $subTotal = 0;
                        $subTotalWeighted = 0;
                    //}

                    //convert_to_money($subTotal)
                }

                $subTotal += $row['amount_value'];
                $subTotalWeighted += $row['amount_weighted_value'];

                $align_style = array(
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                );

                $sheet->setCellValue('A' . $start_detail_index, $row['opportunity_id_num']);
                $sheet->getStyle('A' . $start_detail_index)->getAlignment()->setVertical('top');
                $sheet->getStyle('A' . $start_detail_index)->getAlignment()->setHorizontal('right');
                $sheet->setCellValue('B' . $start_detail_index, $row['opportunity_name']);
                $sheet->getStyle('B' . $start_detail_index)->applyFromArray($align_style);
                $sheet->getStyle('B' . $start_detail_index)->getAlignment()->setWrapText(true);
                $sheet->setCellValue('C' . $start_detail_index, $row['account_c']);
                $sheet->getStyle('C' . $start_detail_index)->applyFromArray($align_style);
                $sheet->getStyle('C' . $start_detail_index)->getAlignment()->setWrapText(true);
                $sheet->setCellValue('D' . $start_detail_index, $row['status']);
                $sheet->getStyle('D' . $start_detail_index)->applyFromArray($align_style);
                $sheet->setCellValue('E' . $start_detail_index, $row['full_year_amount']);
                $sheet->getStyle('E' . $start_detail_index)->getAlignment()->setVertical('top');
                $sheet->getStyle('E' . $start_detail_index)->getAlignment()->setHorizontal('right');
                $sheet->setCellValue('F' . $start_detail_index, $row['created_date']);
                $sheet->getStyle('F' . $start_detail_index)->applyFromArray($align_style);

                $date_closed_str = str_replace('&nbsp;', ' ', $row['date_closed']);
                $sheet->setCellValue('G' . $start_detail_index, $date_closed_str);
                $sheet->getStyle('G' . $start_detail_index)->applyFromArray($align_style);

                $letters = range('H', 'R');
                for($i = 0; $i < count($app_list_strings["sales_stage_dom"]); $i++){
                    $sales_stage_temp = array_values($app_list_strings["sales_stage_dom"])[$i];

                    if(!empty($row['sales_stage'])){
                        $sals_stage_val = array_values($app_list_strings["sales_stage_dom"])[$row['sales_stage']];

                        if($sals_stage_val == $sales_stage_temp){
                            if($i <= 7){
                                $sheet->getStyle($letters[$i] . $start_detail_index)
                                ->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('7DC2FA');
                            }
                            elseif ($i == 8) {
                                $sheet->getStyle($letters[$i] . $start_detail_index)
                                ->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('80B440');
                            }
                            elseif ($i == 9) {
                                $sheet->getStyle($letters[$i] . $start_detail_index)
                                ->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('FF0000');
                            }
                            elseif ($i == 10) {
                                $sheet->getStyle($letters[$i] . $start_detail_index)
                                ->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('FFA500');
                            }
                        }
                        else{
                            $sheet->setCellValue($letters[$i] . $start_detail_index, '-');
                            $sheet->getStyle($letters[$i] . $start_detail_index)->applyFromArray($align_style);
                        }
                    }
                }

                $sheet->setCellValue('S' . $start_detail_index, $this->formatNextStep($row['next_step']));
                $sheet->getStyle('S' . $start_detail_index)->getAlignment()->setWrapText(true);
                $sheet->getStyle('S' . $start_detail_index)->getAlignment()->setVertical('top');

                if($rowCtr == count($this->data)){
                    $this->appendTotal($sheet, ($start_detail_index + 1), $subTotal, $subTotalWeighted);
                }

                $start_detail_index++;
            }
        }

        private function print(){
            $cls_date = new DateTime();
            $now = $cls_date->format('d-m-Y');
            $writer = new Xlsx($this->spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode(self::FILE_NAME . '_' . $now . '.' . self::FILE_TYPE).'"');
            $writer->save('php://output');
        }

        public function export(){
            $this->prepare();
            $this->format();
            $this->print();
        }

        private function formatNextStep($next_step){
            $result = '';

            if(!empty($next_step)){
                $result = new PhpOffice\PhpSpreadsheet\RichText\RichText();
                $next_step = str_replace('<div>', '', $next_step);
                $next_step = str_replace('</div>', '', $next_step);
                $next_step = str_replace('<div style="font-size:10px;">', '<break>', $next_step);
                $next_step = str_replace('<div style="font-size: 10px;">', '<break>', $next_step);
                $next_step = strip_tags(html_entity_decode(htmlspecialchars_decode($next_step), ENT_QUOTES, 'UTF-8'));
                $result->createTextRun($next_step);
            }

            return $result;
        }

        private function appendTotal($sheet, $start_detail_index, $subTotal, $subTotalWeighted){
            $subTotalStyleArray = array(
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'font' => array(
                    'bold' => true,
                ),
            );

            $subTotalWeightedStyleArray = array(
                'font' => array(
                    'bold' => true,
                ),
            );

            $sheet->setCellValue('D' . $start_detail_index, 'Subtotal:');
            $sheet->setCellValue('E' . $start_detail_index, convert_to_money($subTotal));
            $sheet->getStyle('D' . $start_detail_index . ':E' . $start_detail_index)->applyFromArray($subTotalStyleArray);
            $sheet->setCellValue('D' . ($start_detail_index + 1), 'SubTotal (Weighted):');
            $sheet->getStyle('D' . $start_detail_index . ':E' . $start_detail_index)->getAlignment()->setVertical('top');
            $sheet->getStyle('D' . $start_detail_index . ':E' . $start_detail_index)->getAlignment()->setHorizontal('right');
            $sheet->setCellValue('E' . ($start_detail_index + 1), convert_to_money($subTotalWeighted));
            $sheet->getStyle('D' . ($start_detail_index + 1)  . ':E' . ($start_detail_index + 1))->applyFromArray($subTotalWeightedStyleArray);
            $sheet->getStyle('D' . ($start_detail_index + 1)  . ':E' . ($start_detail_index + 1))->getAlignment()->setVertical('top');
            $sheet->getStyle('D' . ($start_detail_index + 1)  . ':E' . ($start_detail_index + 1))->getAlignment()->setHorizontal('right');
        }

        private function cellColor(&$sheet, $cells, $color){
            global $objPHPExcel;
        
            $sheet->getStyle($cells)->getFill()->applyFromArray(array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startcolor' => array(
                     'rgb' => $color
                )
            ));
        }

        private function setSheetHeader($sheet){
            //$sheet = $this->spreadsheet->getActiveSheet();
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(20);
            $sheet->getColumnDimension('H')->setWidth(3);
            $sheet->getColumnDimension('I')->setWidth(3);
            $sheet->getColumnDimension('J')->setWidth(3);
            $sheet->getColumnDimension('K')->setWidth(3);
            $sheet->getColumnDimension('L')->setWidth(3);
            $sheet->getColumnDimension('M')->setWidth(3);
            $sheet->getColumnDimension('N')->setWidth(3);
            $sheet->getColumnDimension('O')->setWidth(3);
            $sheet->getColumnDimension('P')->setWidth(3);
            $sheet->getColumnDimension('Q')->setWidth(3);
            $sheet->getColumnDimension('R')->setWidth(3);
            $sheet->getColumnDimension('S')->setWidth(50);

            $sheet->setCellValue('A1', 'Pipeline Total');
            $sheet->mergeCells("A1:B1");
            $sheet->getStyle('A1')->applyFromArray($this->styleCenter);
            

            $sheet->setCellValue('C1', $this->fullYearAmountTotal);
            $sheet->setCellValue('A2', 'Pipeline Total (Weighted)');
            $sheet->mergeCells("A2:B2");
            $sheet->getStyle('A2')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('C2', $this->fullYearAmountTotalWeighted);

            //headers
            $sheet->setCellValue('A6', 'Opp ID#');
            $sheet->mergeCells("A6:A7");
            $sheet->getStyle('A6')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('B6', 'Opportunity');
            $sheet->mergeCells("B6:B7");
            $sheet->getStyle('B6')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('C6', 'Account');
            $sheet->mergeCells("C6:C7");
            $sheet->getStyle('C6')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('D6', 'Status');
            $sheet->mergeCells("D6:D7");
            $sheet->getStyle('D6')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('E6', 'Full-Year Value');
            $sheet->mergeCells("E6:E7");
            $sheet->getStyle('E6')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('F6', 'Created Date');
            $sheet->mergeCells("F6:F7");
            $sheet->getStyle('F6')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('G6', 'Close Date');
            $sheet->mergeCells("G6:G7");
            $sheet->getStyle('G6')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('H6', 'Sales Stage*');
            $sheet->mergeCells("H6:R6");
            $sheet->getStyle('H6')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('H7', 'IO');
            $sheet->getStyle('H7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('I7', 'UR');
            $sheet->getStyle('I7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('J7', 'SD');
            $sheet->getStyle('J7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('K7', 'QP');
            $sheet->getStyle('K7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('L7', 'SP');
            $sheet->getStyle('L7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('M7', 'PO');
            $sheet->getStyle('M7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('N7', 'AI');
            $sheet->getStyle('N7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('O7', 'C');
            $sheet->getStyle('O7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('P7', 'CW');
            $sheet->getStyle('P7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('Q7', 'CL');
            $sheet->getStyle('Q7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('R7', 'CR');
            $sheet->getStyle('R7')->applyFromArray($this->styleCenter);
            $sheet->setCellValue('S6', 'Next Actions, Status - specific, measurable, dates');
            $sheet->mergeCells("S6:S7");
            $sheet->getStyle('S6')->applyFromArray($this->styleCenter);
        }
    }

    $opportunityPipelineReportXLS = new OpportunityPipelineReportXLS();
    $opportunityPipelineReportXLS->export();

?>
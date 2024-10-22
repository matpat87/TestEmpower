<?php
    require_once('custom/modules/RRQ_RegulatoryRequests/helpers/RegulatoryRequestsReportHelper.php');

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    require 'vendor/autoload.php';

    use Carbon\Carbon;

    /**
     * Documentation: https://phpspreadsheet.readthedocs.io/en/latest/
     * API Documentation: https://phpoffice.github.io/PhpSpreadsheet/
     */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    class RegulatoryRequestReport
    {
        
        private $spreadsheet;
        private $data;
        protected $worksheets = [
            'By Month',
            'By User',
            'By Account'
        ];
        public $create_new_list_query = "";


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
        const FILE_NAME = 'Regulatory_Report';

        function __construct()
        {
            $this->spreadsheet = new Spreadsheet();
            $this->data = array();

            /*
                Used for current list view for "filtered" list and 'Select All' event as this does not pass the selected ID's via the $_REQUEST global variable
                Set in RegulatoryRequest > create_new_list_query()
            */
            if (isset($_SESSION['create_new_list_query'])) {
                $listViewQuery = $_SESSION['create_new_list_query'];
                $listViewQuery['join'] = $listViewQuery['join'] ?: "";

                $this->create_new_list_query = $listViewQuery['select'] . $listViewQuery['from'] . $listViewQuery['join'] . $listViewQuery['where'] . $listViewQuery['order_by'];
            }
        }

        private function generateWorksheets()
        {
            global $app_list_strings, $log;

            foreach ($this->worksheets as $sheetIndex => $worksheetName) {
                
                // create worksheets
                if ($this->spreadsheet->getSheetCount() == 1 && $sheetIndex == 0) {
                    $this->spreadsheet->getActiveSheet()->setTitle($worksheetName);
    
                } else {
                    $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($this->spreadsheet, $worksheetName);
                    $this->spreadsheet->addSheet($myWorkSheet);
    
                }

                $activeSheet = $this->spreadsheet->setActiveSheetIndexByName($worksheetName);
                $this->setSheetHeaderRow($activeSheet);
                $this->setRowData($activeSheet, $worksheetName);
            }

            $this->spreadsheet->setActiveSheetIndexByName($this->worksheets[0]); // reset the active sheet to the first worksheet of the leftmost sheet
            
        }

        private function handleQueryData()
        {
            global $log, $app_list_strings;

            foreach ($this->worksheets as $index => $worksheet) {
                // generate string index in snake_case form
                $key = str_replace(" ", "_", strtolower($worksheet));

                switch ($key) {
                    case 'by_month':
                        $this->data['by_month'] = RegulatoryRequestsReportHelper::handleGenerateReportQueryByMonth($this->create_new_list_query);
                        break;
                    case 'by_user':
                        $this->data['by_user']=  RegulatoryRequestsReportHelper::handleGenerateReportQueryByUser($this->create_new_list_query);
                        break;
                    case 'by_account':
                        $this->data['by_account'] = RegulatoryRequestsReportHelper::handleGenerateReportQueryByAccount($this->create_new_list_query);
                        break;
                    
                } // end of switch

                if (isset($queryStr))
                {
                    $db = DBManagerFactory::getInstance();
                    $results = $db->query($queryStr);
            
                    while ($row = $db->fetchByAssoc($results)) {
                        $this->data[$key][] = [
                            $app_list_strings['reg_req_statuses'][$row['status']],
                            $row['row_labels'],
                            $row['sum_of_total_requests'],
                        ];
                    }
                }
            } // End of foreach
            
        }

        private function setRowData($activeSheet, $worksheetName)
        {
            global $app_list_strings, $log;

            $key = str_replace(" ", "_", strtolower($worksheetName));
            
            // set column widths
            // $activeSheet->getColumnDimension('A')->setAutoSize(true); // Originally the Status column
            $activeSheet->getColumnDimension('A')->setAutoSize(true);
            $activeSheet->getColumnDimension('B')->setAutoSize(true);

            if (!empty($this->data[$key])) {
                $activeSheet->fromArray($this->data[$key], NULL, 'A2');
                
                // set autofilter range
                $rowCount = count($this->data[$key]);
                $activeSheet->setAutoFilter("A1:B{$rowCount}");

            }

        }

        private function print()
        {
            $cls_date = new DateTime();
            $now = $cls_date->format('d-m-Y');
            $writer = new Xlsx($this->spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode(self::FILE_NAME . '_' . $now . '.' . self::FILE_TYPE).'"');
            $writer->save('php://output');
        }

        public function export(){
            $this->handleQueryData();
            $this->generateWorksheets();
            $this->print();
        }

        private function setSheetHeaderRow($sheet)
        {
            //headers
            // $sheet->setCellValue('A1', 'Status');
            $sheet->setCellValue('A1', 'Row Labels');
            $sheet->setCellValue('B1', 'Sum of Total Requests');
            
        }
    }

    $regulatoryRequestReport = new RegulatoryRequestReport();
    $regulatoryRequestReport->export();

?>
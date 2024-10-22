<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require 'vendor/autoload.php';

/**
 * Documentation: https://phpspreadsheet.readthedocs.io/en/latest/
 * API Documentation: https://phpoffice.github.io/PhpSpreadsheet/
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class OpportunityAgingReportXLS
{
	const FILE_TYPE = 'xlsx';
    const FILE_NAME = 'OpportunityAgingReport';

	private $spreadsheet;
	private $data;

	function __construct()
	{
		$this->spreadsheet = new Spreadsheet();
		$this->data = [];
		$this->handleRetrieveReportData();
	}

	private function handleHeaders()
	{
		// Column Headers
		$columnHeaders = [
			'A3' => 'Opp ID #',
			'B3' => 'Opportunity',
			'C3' =>'Account',
			'D3' => 'Type',
			'E3' => 'Value',
			'F3' => 'Sales Stage',
			'F4' => '1',
			'G4' => '2',
			'H4' => '3',
			'I4' => '4',
			'J4' => '5',
			'K4' => '6',
			'L4' => '7',
			'M4' => 'Total'
		];

		$sheet = $this->spreadsheet->getActiveSheet();

		/* REPORT TITLE ROW */
		$sheet->setCellValue('A1', 'Opportunity Aging Report');
		$sheet->mergeCells("A1:M2"); // 13 columns
		$sheet->getStyle("A1:M2")->applyFromArray([
			'font' => [ 'size' => '15']
		]);
		$sheet->getStyle('A1:M4')->applyFromArray([
			'font' => [
				'bold' => true,
				'size' => '13'
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment:: VERTICAL_CENTER,
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '000000'],
				],
			],
		]);

		$sheet->getStyle('A3:M4')->applyFromArray([
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => [
					'argb' => 'FFA0A0A0',
				]
			],
		]);

		// Column Headers Format
		$sheet->mergeCells("A3:A4");
		$sheet->mergeCells("B3:B4");
		$sheet->mergeCells("C3:C4");
		$sheet->mergeCells("D3:D4");
		$sheet->mergeCells("E3:E4");
		$sheet->mergeCells("F3:M3");

		$sheet->getColumnDimension('B')->setWidth(40);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(25);

		foreach ($columnHeaders as $cell => $title) {
			$sheet->setCellValue($cell, $title);
		}
		
		
	}

	public function export()
	{

		$cls_date = new DateTime();
		$now = $cls_date->format('d-m-Y');
		$writer = new Xlsx($this->spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'. urlencode(self::FILE_NAME . '_' . $now . '.' . self::FILE_TYPE).'"');
		$writer->save('php://output');
	}

	private function handleRetrieveReportData()
	{
		global $app_list_strings, $sugar_config, $log;

		// Data retrieved from CustomOAR_OpportunityAgingReport - create_new_list_query function
		$query = $_SESSION['OpportunityAgingReportQuery'] ?? '';

		$db = DBManagerFactory::getInstance();
		$result = $db->query($query);

		$ctr = 1;
		$salesStageCtr = array();
		$salesStages = array();

		foreach ($app_list_strings["sales_stage_dom"] as $key => $value) {
			if (! in_array($key, ['Closed', 'ClosedWon', 'ClosedLost', 'ClosedRejected'])) {
				$salesStageCtr[] = $ctr;
				$salesStages[] = $value;
				$ctr++;
			}
		}

		$salesStageCtr['total_open_days'] = 'Total';
		
		while ($row = $db->fetchByAssoc($result)) { 
			$ctr = 1;
			$row['sales_stage_total'] = 0;
			$row['opportunity_value'] = convert_to_money($row['opportunity_value']);

			foreach ($salesStages as $key => $value) {
				$sales_stage_num = "sales_stage_{$ctr}";
				$row['sales_stage_total'] += $row[$sales_stage_num];
				$ctr++;
			}

			$this->data[$row['sales_rep']][] = $row;
			
		}
		$this->formatSheets();
	}

	private function formatSheets()
	{
		global $log;

		$sheetCounter = 0; // Worksheets index always starts at 0
		foreach ($this->data as $salesRepSection => $rowsArray) {
			// Set Default Sheet Name if no Sales Person key present
			$salesRepSection = (empty($salesRepSection)) ? "Sheet{$sheetCounter}" : $salesRepSection;

			//Create new Sheet: For Every Sales Person Data, create a separate sheet
			if ($sheetCounter > 0) {
				$this->spreadsheet->createSheet();
				$this->spreadsheet->setActiveSheetIndex($sheetCounter);
			}
			$activeSheet = $this->spreadsheet->getActiveSheet();
			$activeSheet->setTitle($salesRepSection);

			$this->handleHeaders();

			/* Row data into sheets */
			$rowCounter = 5; // Starts at Row 5
			foreach ($rowsArray as $row) {
				$count = count($row);
				$activeSheet->setCellValue("A{$rowCounter}", $row['opportunity_id_number']);
				$activeSheet->setCellValue("B{$rowCounter}", $row['opportunity_name']);
				$activeSheet->setCellValue("C{$rowCounter}", $row['account_name']);
				$activeSheet->setCellValue("D{$rowCounter}", $row['opportunity_type']);
				$activeSheet->setCellValue("E{$rowCounter}", $row['opportunity_value']);
				$activeSheet->setCellValue("F{$rowCounter}", $row['sales_stage_1']);
				$activeSheet->setCellValue("G{$rowCounter}", $row['sales_stage_2']);
				$activeSheet->setCellValue("H{$rowCounter}", $row['sales_stage_3']);
				$activeSheet->setCellValue("I{$rowCounter}", $row['sales_stage_4']);
				$activeSheet->setCellValue("J{$rowCounter}", $row['sales_stage_5']);
				$activeSheet->setCellValue("K{$rowCounter}", $row['sales_stage_6']);
				$activeSheet->setCellValue("L{$rowCounter}", $row['sales_stage_7']);
				$activeSheet->setCellValue("M{$rowCounter}", $row['sales_stage_total']);
				

				/* Row Specific Styling */
				$activeSheet->getStyle("E{$rowCounter}")->applyFromArray([
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
					],
				]);
				$rowCounter++;
			}
			$sheetCounter++;

			// Styles
			$activeSheet->getStyle("A1:M{$rowCounter}")->applyFromArray([
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['argb' => '000000'],
					],
				],
			]);
		}
		
	}

	


} // end of class

$OpportunityAgingReportXLS = new OpportunityAgingReportXLS();
$OpportunityAgingReportXLS->export();
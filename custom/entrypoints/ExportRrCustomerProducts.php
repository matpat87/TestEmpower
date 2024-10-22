<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require 'vendor/autoload.php';
require_once('include/ListView/ListViewSubPanel.php');
require_once 'include/SubPanel/SubPanelDefinitions.php' ;

/**
 * Documentation: https://phpspreadsheet.readthedocs.io/en/latest/
 * API Documentation: https://phpoffice.github.io/PhpSpreadsheet/
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExpoerRrCustomerProducts
{
	const FILE_TYPE = 'xlsx';
    const FILE_NAME = 'CustomerProductsExport';

	private $spreadsheet;
	private $data;
	protected $listView;
	protected $subpanel_defs;
	protected $thisPanel;
	protected $bean;
	protected $panelHeaders;

	function __construct()
	{

		$this->spreadsheet = new Spreadsheet();
		$this->data = [];
		
		$regulatoryRequestId = $_REQUEST['regulatory_request_id'];
		$this->bean = BeanFactory::getBean('RRQ_RegulatoryRequests', $regulatoryRequestId);
		
		$this->subpanel_defs = new SubPanelDefinitions($this->bean, 'RRQ_RegulatoryRequests', '');
		$this->thisPanel = $this->subpanel_defs->load_subpanel('rrq_regulatoryrequests_ci_customeritems_2'); // Previously 'rrq_regulatoryrequests_ci_customeritems_1' as this was the prev relationship definition of the module
		
		$this->handleHeaders();
		$this->handleRetrieveReportData();
	}

	private function handleHeaders()
	{
		global $log;
		
		$panelModStrings = $this->thisPanel->mod_strings; // Array of language definitions of this subpanel
		
		$this->panelHeaders = array_filter($this->thisPanel->panel_definition['list_fields'], function($val, $key) {
			return $key != 'edit_button' && $key != 'remove_button';
		}, ARRAY_FILTER_USE_BOTH);
		
		
		$sheet = $this->spreadsheet->getActiveSheet();
		

		$columnIndex = 1;
		foreach ($this->panelHeaders as $key => $attrs) {
			$headerName = translate($attrs['vname'],'CI_CustomerItems');
			$sheet->setCellValueByColumnAndRow($columnIndex, 1, $headerName); // setCellValueByColumnAndRow($col, $row, $value)
			$columnIndex++;
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
		global $db;
        
        $this->data = [];
        
		// This is to retrieve the specific subpanel query being used in the Customer Products subpanel
		$this->listView = new ListViewSubPanel();
		$listViewData = $this->listView->process_dynamic_listview('RRQ_RegulatoryRequests', $this->bean, $this->thisPanel, true); // returns array of listview data for the subpanel
        
        if (isset($listViewData['query'])) {
            $result = $db->query($listViewData['query']);
            while ($row = $db->fetchByAssoc($result)) {
			    $this->data[] = $row;
		    } // end while
        }

		$this->formatSheets();
	}

	private function formatSheets()
	{
		global $log;
	
		$rowIndex = 2; // Subpanel Data starts at row 2
        // Loops through the data retrieved from the subpanel query
		foreach ($this->data as $index => $rowData) {
			$columnIndex = 1; // Column index always starts at 1
			$activeSheet = $this->spreadsheet->getActiveSheet();

			// Loops through the $this->panelHeaders as the order of the keys in this array are sorted as displayed in the subpanel
			foreach (array_keys($this->panelHeaders) as $fieldName) {
				$activeSheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $rowData[$fieldName]);
				$columnIndex++;
			}
			$rowIndex++;
	
		}
		
	}

	


} // end of class


$OpportunityAgingReportXLS = new ExpoerRrCustomerProducts();
$OpportunityAgingReportXLS->export();
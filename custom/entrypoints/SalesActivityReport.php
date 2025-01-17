<?php
	require_once('custom/include/TCPDF/tcpdf.php');
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Html;
	use PhpOffice\PhpSpreadsheet\Reader\Html as HTMLReader;

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

	global $app_list_strings;

	$exportType  = $_REQUEST['export_type'];
	$trHTML = '';
	$salesActivityReportQuery = new SalesActivityReportQuery();
	$salesActivityReportQuery = array('select' => $salesActivityReportQuery->get_select_query(), 'from' => $salesActivityReportQuery->get_from_query(), 
		'where' => '');
	$oder_by = '';


	if(isset($_SESSION['SalesActivityReportQuery']) && !empty($_SESSION['SalesActivityReportQuery']))
	{
		$salesActivityReportQuery = $_SESSION['SalesActivityReportQuery'];
	}

	$activitiesStringIDs = isset($_REQUEST['uid']) ? $_REQUEST['uid'] : '';

	if($activitiesStringIDs) {
		$activityArrayIDs = explode(',', $activitiesStringIDs);
		$stringActivityIDs = implode(', ', $activityArrayIDs);

		$newArray = [];
		foreach ($activityArrayIDs as $key => $value) {
	       array_push($newArray, "'" . $value . "'");
	    }

	    $newString = implode(', ', $newArray);
	    $andOrWhere = trim($salesActivityReportQuery['where']) ? 'AND' : 'WHERE';

		$salesActivityReportQuery['where'] .= $andOrWhere . ' (activity.id IN ('.$newString.')) ';
	}

	$query = $salesActivityReportQuery['select'] . $salesActivityReportQuery['from'] . $salesActivityReportQuery['where'] . $salesActivityReportQuery['order_by'];

	$db = DBManagerFactory::getInstance();
	$result = $db->query($query);

	while( $row = $db->fetchByAssoc($result)){ 
		$date_start_c = '';

		if(!empty($row['date_start_c']))
		{
			$date_start_c = new DateTime($row['date_start_c']);
			$date_start_c = $date_start_c->format('m/d/Y');
		}

		$statusCol = $row['status_c'];
		if ($row['activity_name_c'] == 'Meetings' && $row['type_c_nondb'] != 'N/A') {
			$statusCol =  $row['activity_status_nondb'] != ""
				? "Meeting - {$app_list_strings['meeting_type_list'][$row['type_c_nondb']]} ({$row['activity_status_nondb']})"
				: $row['status_c'];
		}
		
		$trHTML .= '<tr style="">
			<td style="width: 10%">'. $statusCol .'</td>
			<td style="width: 10%">'. $row['assigned_to_name_c'] .'</td>
			<td style="width: 10%">'. $date_start_c .'</td>
			<td style="width: 31%">'. $row['name'] .'</td>
			<td style="width: 10%">'. $row['account_name_c'] .'</td>
			<td style="width: 10%">'. $row['shipping_address_city_c'] .'</td>
			<td style="width: 10%">'. $row['shipping_address_state_c'] .'</td>
			<td style="width: 10%">'. $row['related_to_c'] .'</td>';

			// New Column for Description when Export is to CSV
			if ($exportType == 'csv') {
				$trHTML.= '<td style="width: 10%">'. $row['description'] .'</td>';
				$trHTML.= '<td style="width: 10%">'. $row['management_update'] .'</td>';
			}

		$trHTML .='</tr>';

		// When export to pdf, new row for description should be created
		if(!empty($row['description']) && $exportType == 'pdf'){
			$trHTML .= '<tr>
				<td></td>
				<td colspan="7">'. $row['description'] .'</td>
			</tr>';
			

		}
		if(!empty($row['management_update']) && $exportType == 'pdf'){
			$trHTML .= '<tr>
				<td></td>
				<td colspan="7" style="text-align:center;">
					<span>****MANAGEMENT UPDATE****</span><br>
					<span>'. $row['management_update'] .'</span>
				</td>
			</tr>';
			

		}

	}

	// create some HTML content
	$html = '<table cellpadding="6" style="width: 100%">
	<thead>
		<tr>
			<th style="font-weight: bold; width: 10%">Status</th>
			<th style="font-weight: bold; width: 10%">Assigned To</th>
			<th style="font-weight: bold; width: 10%">Date</th>
			<th style="font-weight: bold; width: 31%">Subject</th>
			<th style="font-weight: bold; width: 10%">Account</th>
			<th style="font-weight: bold; width: 10%">City</th>
			<th style="font-weight: bold; width: 10%">State</th>
			<th style="font-weight: bold; width: 10%">Related To</th>';
	$html .= ($exportType == 'csv') 
				? '<th style="font-weight: bold; width: 20%">Description</th><th style="font-weight: bold; width: 20%">Management Update</th>'
				: '';
			
	$html .= '</tr></thead><tbody>'. $trHTML .'</tbody></table>';
	

	//die();
if ($exportType == 'pdf') {
	define ('CUSTOM_PDF_MARGIN_TOP', 20);
	define ('CUSTOM_PDF_PAGE_ORIENTATION', 'L');

	$pdf = new TCPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Empower');
	$pdf->SetTitle('Sales Activity Report');
	$pdf->SetSubject('TCPDF Tutorial');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

	// set default header data
	$pdf->SetHeaderData('', 0, 'Sales Activity Report', '');

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, CUSTOM_PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//$pdf->setCellHeightRatio(2);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}

	// ---------------------------------------------------------

	// set font
	$pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);

	// add a page
	$pdf->AddPage();

	// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
	// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)


	// output the HTML content
	$pdf->writeHTML($html, true, false, true, false, '');

	// reset pointer to the last page
	$pdf->lastPage();

	// ---------------------------------------------------------

	//Close and output PDF document
	$pdf->Output('SalesActivityReport' . date('Y-m-d') . strtotime(date('h:i:s')) . '.pdf', 'D');
} else {
	// https://phpspreadsheet.readthedocs.io/en/latest/topics/reading-and-writing-to-file/#csv-comma-separated-values

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="SalesActivityReport.csv"');
	header('Cache-Control: max-age=0');

	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

	$reader = new HTMLReader();
	$spreadsheet = $reader->loadFromString($html);

	$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
	$writer->save('php://output');
}

?>
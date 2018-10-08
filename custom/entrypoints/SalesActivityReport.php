<?php
	require_once('custom/include/TCPDF/tcpdf.php');

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

	$salesActivityReportQuery = new SalesActivityReportQuery();
	$trHTML = '';
	$salesActivityReportQuery = array('select' => $salesActivityReportQuery->get_select_query(), 'from' => $salesActivityReportQuery->get_from_query(), 
		'where' => '');
	$oder_by = '';


	if(isset($_SESSION['SalesActivityReportQuery']) && !empty($_SESSION['SalesActivityReportQuery']))
	{
		$salesActivityReportQuery = $_SESSION['SalesActivityReportQuery'];
	}

	// $activitiesStringIDs = $_REQUEST['uid'];
	// $activityArrayIDs = explode(',', $activitiesStringIDs);
	// $stringActivityIDs = implode(', ', $activityArrayIDs);

	// $newArray = [];
	// foreach ($activityArrayIDs as $key => $value) {
 //       array_push($newArray, "'" . $value . "'");
 //    }

 //    $newString = implode(', ', $newArray);
 //    $andOrWhere = trim($salesActivityReportQuery['where']) ? 'AND' : 'WHERE';

	//$salesActivityReportQuery['where'] .= $andOrWhere . ' (activity.id IN ('.$newString.')) ';
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

		$trHTML .= '<tr style="">
			<td style="width: 13%">'. $row['status_c'] .'</td>
			<td style="width: 15%">'. $row['assigned_to_name_c'] .'</td>
			<td style="width: 13%">'. $date_start_c .'</td>
			<td style="width: 31%">'. $row['name'] .'</td>
			<td style="width: 13%">'. $row['account_name_c'] .'</td>
			<td style="width: 15%">'. $row['related_to_c'] .'</td>
		</tr>';

		if(!empty($row['description'])){
			$trHTML .= '<tr>
				<td></td>
				<td></td>
				<td colspan="4">'. $row['description'] .'</td>
			</tr>';
		}
	}

	

	//die();

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

// create some HTML content
$html = '<table cellpadding="6" style="width: 100%">
	<thead>
		<tr>
			<th style="font-weight: bold; width: 13%">Status</th>
			<th style="font-weight: bold; width: 15%">Assigned To</th>
			<th style="font-weight: bold; width: 13%">Date</th>
			<th style="font-weight: bold; width: 31%">Subject</th>
			<th style="font-weight: bold; width: 13%">Account</th>
			<th style="font-weight: bold; width: 15%">Related To</th>
		</tr>
	</thead>
	<tbody>
		'. $trHTML .'
	</tbody>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('SalesActivityReport' . date('Y-m-d') . strtotime(date('h:i:s')) . '.pdf', 'D');
?>
<?php
	require_once('custom/include/TCPDF/tcpdf.php');

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

	global $current_user;

	$salesActivityStatisticQuery = new SalesActivityStatisticsQuery();
	$trHTML = '';
	$salesActivityStatisticQuery = array('select' => $salesActivityStatisticQuery->get_select_query(), 'from' => $salesActivityStatisticQuery->get_from_query(), 
		'where' => '');
	$oder_by = '';


	if(isset($_SESSION['SalesActivityStatisticQuery']) && !empty($_SESSION['SalesActivityStatisticQuery']))
	{
		$salesActivityStatisticQuery = $_SESSION['SalesActivityStatisticQuery'];
	}

	$query = $salesActivityStatisticQuery['select'] . $salesActivityStatisticQuery['from'] . $salesActivityStatisticQuery['where'] . $salesActivityStatisticQuery['order_by'];

	$db = DBManagerFactory::getInstance();
	$result = $db->query($query);

	while( $row = $db->fetchByAssoc($result)){ 

		$trHTML .= '
		<tr style="">
			<td style="width: 7.5%">'. $row['user_non_db'] .'</td>
			<td style="width: 7.5%">'.  $row['leads_non_db'] .'</td>
			<td style="width: 7.5%">'.  $row['accounts_non_db'] .'</td>
			<td style="width: 7.5%">'.  $row['contacts_non_db'] .'</td>
			<td style="width: 8.33%">'.  $row['cases_non_db'] .'</td>
			<td style="width: 8.33%">'.  $row['opportunities_non_db'] .'</td>
			<td style="width: 8.33%">'.  $row['tr_technicalrequests_non_db'] .'</td>
			<td style="width: 7.5%">'.  $row['project_non_db'] .'</td>
			<td style="width: 7.5%">'.  $row['notes_non_db'] .'</td>
			<td style="width: 7.5%">'.  $row['calls_non_db'] .'</td>
			<td style="width: 7.5%">'.  $row['meetings_non_db'] .'</td>
			<td style="width: 7.5%">'.  $row['tasks_non_db'] .'</td>
			<td style="width: 7.5%">'.  $row['emails_non_db'] .'</td>
		</tr>';
	}

define ('CUSTOM_PDF_MARGIN_TOP', 20);
define ('CUSTOM_PDF_PAGE_ORIENTATION', 'L');

$currentUserName = $current_user->first_name . ' ' . $current_user->last_name;

$pdf = new TCPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Empower');
$pdf->SetTitle('Sales Activity Statistic for ' . $currentUserName);
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('', 0, 'Sales Activity Statistic for ' . $currentUserName, '');

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
$pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<table cellpadding="6" style="width: 100%">
	<thead>
		<tr>
			<th style="font-weight: bold; width: 7.5%">User</th>
			<th style="font-weight: bold; width: 7.5%">Leads</th>
			<th style="font-weight: bold; width: 7.5%">Accounts</th>
			<th style="font-weight: bold; width: 7.5%">Contacts</th>
			<th style="font-weight: bold; width: 8.33%">Customer Issues</th>
			<th style="font-weight: bold; width: 8.33%">Opportunities</th>
			<th style="font-weight: bold; width: 8.33%">Technical Requests</th>
			<th style="font-weight: bold; width: 7.5%">Projects</th>
			<th style="font-weight: bold; width: 7.5%">Notes</th>
			<th style="font-weight: bold; width: 7.5%">Calls</th>
			<th style="font-weight: bold; width: 7.5%">Meetings</th>
			<th style="font-weight: bold; width: 7.5%">Tasks</th>
			<th style="font-weight: bold; width: 7.5%">Emails</th>
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
$pdf->Output('SalesActivityStatistic' . date('Y-m-d') . strtotime(date('h:i:s')) . '.pdf', 'D');
?>
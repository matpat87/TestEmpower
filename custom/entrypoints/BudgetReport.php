<?php
	require_once('custom/include/TCPDF/tcpdf.php');

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

	$budgetReportQuery = new BudgetReportQuery();
	$trHTML = '';
	$budgetReportQuery = array('select' => $budgetReportQuery->get_select_query(), 'from' => $budgetReportQuery->get_from_query(), 
		'where' => '');
	$oder_by = '';


	if(isset($_SESSION['BudgetReportQuery']) && !empty($_SESSION['BudgetReportQuery']))
	{
		$budgetReportQuery = $_SESSION['BudgetReportQuery'];
	}

	$query = $budgetReportQuery['select'] . $budgetReportQuery['from'] . $budgetReportQuery['where'] . $budgetReportQuery['order_by'];
	$db = DBManagerFactory::getInstance();
	$result = $db->query($query);

	while( $row = $db->fetchByAssoc($result)){ 
		$trHTML .= '<tr>
			<td style="width: 6.66%" align="left">'. $row['account_name_non_db'] .'</td>
			<td style="width: 6.66%" align="center">'. $row['customer_number_non_db'] .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['january_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['february_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['march_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['april_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['may_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['june_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['july_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['august_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['september_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['october_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['november_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['december_non_db'], 2) .'</td>
			<td style="width: 6.66%" align="right">$'. number_format($row['total_budget_non_db'], 2) .'</td>
		</tr>';
	}

	$budgetReportQuerySum = $_SESSION['BudgetReportQuerySum'];
	if($budgetReportQuerySum) {
		$trHTML .= '<tr height="20">
            <td style="font-weight: bold; width: 13.32%" align="left">TOTAL PER MONTH</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[0].'</td>     
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[1].'</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[2].'</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[3].'</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[4].'</td> 
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[5].'</td> 
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[6].'</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[7].'</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[8].'</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[9].'</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[10].'</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[11].'</td>
            <td style="font-weight: bold; width: 6.66%" align="right">$'.$budgetReportQuerySum[12].'</td>
        </tr>';
	}

	//die();

define ('CUSTOM_PDF_MARGIN_TOP', 20);
define ('CUSTOM_PDF_PAGE_ORIENTATION', 'L');

$pdf = new TCPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Empower');
$pdf->SetTitle('Budget Report');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('', 0, 'Budget Report', '');

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
$pdf->SetFont(PDF_FONT_NAME_MAIN, '', 7.75);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<table cellpadding="6" style="width: 100%">
	<thead>
		<tr>
			<th style="font-weight: bold; width: 6.66%" align="left">Account Name</th>
			<th style="font-weight: bold; width: 6.66%" align="center">Customer Number</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Jan $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Feb $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Mar $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Apr $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">May $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Jun $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Jul $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Aug $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Sept $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Oct $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Nov $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Dec $</th>
			<th style="font-weight: bold; width: 6.66%" align="right">Total Budget</th>
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
$pdf->Output('BudgetReport' . date('Y-m-d') . strtotime(date('h:i:s')) . '.pdf', 'I');
?>
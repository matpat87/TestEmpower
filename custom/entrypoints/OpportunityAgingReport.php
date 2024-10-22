<?php

require_once('custom/include/TCPDF/tcpdf.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $app_list_strings, $sugar_config;

// Data retrieved from CustomOAR_OpportunityAgingReport - create_new_list_query function
$query = $_SESSION['OpportunityAgingReportQuery'] ?? '';

$db = DBManagerFactory::getInstance();
$result = $db->query($query);
$data = array();

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

	$data[] = $row;
}

$html = '<table>';

$html .= '
	<tr style="width: 100%">
		<td style="vertical-align: top; font-weight: bold; font-size: 18px; text-align: center">
			Opportunity Aging Report
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<table style="width: 100%;">
                <thead>
					<tr>
						<th rowspan="2" style="width: 5% !important; text-align: center; border: 1px solid black;">Opp ID #</th>
						<th rowspan="2" style="width: 17.6% !important; text-align: center; border: 1px solid black;">Opportunity</th>
						<th rowspan="2" style="width: 17.6% !important; text-align: center; border: 1px solid black;">Account</th>
	                    <th rowspan="2" style="width: 17.6% !important; text-align: center; border: 1px solid black;">Type</th>
	                    <th rowspan="2" style="width: 10.2%; text-align: center; border: 1px solid black;">Value</th>
	                    <th rowspan="1" colspan="8" style="width: 32%; border: 1px solid black; text-align: center;">Sales Stage*</th>
                    </tr>
					
					<tr>';
					foreach($salesStageCtr as $ctr) {
$html .= 				'<th style="width: 4%; padding: 0%; border: 1px solid black; text-align: center;">'.$ctr.'</th>';
					}
$html .= 			'</tr>
                </thead>
                <tbody>';
                		$salesPersonName = $data[0]['sales_rep'];
						
                		foreach ($data as $key => $rowData) {
                			if($salesPersonName != $rowData['sales_rep']) {
                				$salesPersonName = $rowData['sales_rep'];
                			}
											
							$previousKey = $key > 0 ? $key - 1 : $key;
							
							if ($key == 0 || $key > 0 && $data[$key]['sales_rep'] != $data[$previousKey]['sales_rep']) {
								$html .= '<tr>';
									$html .= '<td colspan="20" class="border-cell" style="text-align: left; background-color: white; border: 1px solid black;">';
										$html .= "<h4>&nbsp;{$salesPersonName}</h4>";
									$html .= '</td>';
								$html .= '</tr>';
							}

							$html .= '<tr>';
								$html .= '<td style="border: 1px solid black; text-align: center;"><div style="margin-left: 5px;">&nbsp;'. $rowData['opportunity_id_number'] .'</div></td>';
								$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">&nbsp;'. $rowData['opportunity_name'] .'</div></td>';
								$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">&nbsp;'. $rowData['account_name'] .'</div></td>';
								$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">&nbsp;'. $rowData['opportunity_type'] .'</div></td>';
								$html .= '<td style="text-align: right; border: 1px solid black;"><div style="margin-right: 5px;">'. $rowData['opportunity_value'] .'&nbsp;&nbsp;</div></td>';

								foreach ($salesStageCtr as $key => $value) {
									if (end($salesStageCtr) == $value) {
										$html .= '<td style="border: 1px solid black; text-align: center;">'. $rowData['sales_stage_total'].'</td>';
									} else {
										$html .= '<td style="border: 1px solid black; text-align: center;">'. $rowData["sales_stage_{$value}"].'</td>';
									}
								}
                			$html .= '</tr>';
                		}

                $html .='</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" style="font-size: 11px;">* Sales Stages (NOTE: Some stages may occur out of order or not at all):</td>
	</tr>
	<tr>
		<td colspan="3">
			<table>';				
$html .= 		'<tr>';
					foreach ($salesStages as $key => $value) {
						$html .= '<td style="font-size: 11px;">'. ($key + 1) . ') ' . $value .'</td>';
					}
$html .= 		'</tr>';
$html .= 	'</table>
		</td>
	</tr>
	';

$html .= "</table>";


define ('CUSTOM_PDF_MARGIN_TOP', 20);
define ('CUSTOM_PDF_PAGE_ORIENTATION', 'L');
$pdf = new TCPDF(CUSTOM_PDF_PAGE_ORIENTATION, PDF_UNIT, 'FOOLSCAP', true, 'UTF-8', false);

	// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Empower');
$pdf->SetTitle('Opportunity Aging Report');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('', 0, 'Opportunity Aging Report', '');

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

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('OpportunityAgingReport.pdf', 'I');

?>
<?php

require_once('custom/include/TCPDF/tcpdf.php');
require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $app_list_strings, $sugar_config;

$opportunityPipelineReportQuery = array('select' => getSelectQueryForOpportunityPipeline(), 
	'from' => getFromQueryrForOpportunityPipeline(),
	'where' => '',
);

if(isset($_SESSION['OpportunityPipelineReportQuery']) && !empty($_SESSION['OpportunityPipelineReportQuery']))
{
	$opportunityPipelineReportQuery = $_SESSION['OpportunityPipelineReportQuery'];
}

$query = $opportunityPipelineReportQuery['select'] . $opportunityPipelineReportQuery['from'] . $opportunityPipelineReportQuery['where'] . 
	$opportunityPipelineReportQuery['order_by'];

$db = DBManagerFactory::getInstance();
$result = $db->query($query);
$data = array();
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

	$row['sales_stage'] = get_dropdown_index("sales_stage_dom", $app_list_strings['sales_stage_dom'][$row['sales_stage']]);

	$data[] = $row;
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

$fullYearAmountTotal = convert_to_money($fullYearAmountTotal);
$fullYearAmountTotalWeighted = convert_to_money($fullYearAmountTotalWeighted);

$html = '<table>';

$html .= '<tr>
	<td style="width: 33.6%; border: 1px solid black; height: 80px;">
        <table>
            <tr>
                <td style="border: 1px solid black; width: 50%;">&nbsp;Pipeline Total</td>
                <td style="border: 1px solid black; width: 50%; text-align: right"><div style="margin-right: 20px;">'. $fullYearAmountTotal .'&nbsp;&nbsp;</div></td>
						</tr>
						<tr>
                <td style="border: 1px solid black; width: 50%;">&nbsp;Pipeline Total (Weighted)</td>
                <td style="border: 1px solid black; width: 50%; text-align: right"><div style="margin-right: 20px;">'. $fullYearAmountTotalWeighted .'&nbsp;&nbsp;</div></td>
            </tr>
        </table>
	</td>
	<td style="width: 33.3%;vertical-align: top; text-align: center; border: 1px solid black;">
        <table>
            <tr>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
               <td style="font-weight: bold; font-size: 18px;">
                   Consolidated Sales Pipeline
               </td> 
            </tr>
        </table>
	</td>
	<td style="width: 33.3%;vertical-align: top; text-align: right; font-weight: bold; font-size: 16px; border: 1px solid black;">CONFIDENTIAL&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<table style="width: 100%;">
                <thead>
					<tr>
						<th rowspan="2" style="width: 5% !important; text-align: center; border: 1px solid black;">Opp ID #</th>
						<th rowspan="2" style="width: 10% !important; text-align: center; border: 1px solid black;">Opportunity</th>
						<th rowspan="2" style="width: 10% !important; text-align: center; border: 1px solid black;">Account</th>
	                    <th rowspan="2" style="width: 10% !important; text-align: center; border: 1px solid black;">Status</th>
	                    <th rowspan="2" style="width: 10%; text-align: center; border: 1px solid black;">Full-Year Value</th>
	                    <th rowspan="2" style="width: 9%; text-align: center; border: 1px solid black;">Created Date</th>
	                    <th rowspan="2" style="width: 9%; text-align: center; border: 1px solid black;">Close Date</th>
	                    <th rowspan="1" colspan="11" style="width: 22%; border: 1px solid black; text-align: center;">Sales Stage*</th>
	                    <th rowspan="2" style="width: 15%; border: 1px solid black; text-align: center;"><font style="word-wrap:break-word;">&nbsp;Next Actions, Status - specific, measurable, dates</font></th>
                    </tr>
										<tr>';
foreach ($salesStageAcronyms as $acronym) {
	$html .= 						'<th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">'.$acronym.'</th>';
}
$html .= 						'</tr>
                </thead>
                <tbody>';
										$subTotal = 0;
										$subTotalWeighted = 0;
                		$salesPersonName = $data[0]['sales_rep'];
                		foreach ($data as $key => $rowData) {

                			if($salesPersonName != $rowData['sales_rep'])
                			{
		                		$html .= '<tr>
																		<td colspan="5" class="border-cell" style="text-align: right; background-color: white; border: 1px solid black;">
																				<font style="color: black;">SubTotal:&nbsp;</font>
																				<strong style="margin-right: 10px">'. convert_to_money($subTotal) .'&nbsp;&nbsp;</strong>
																		</td>

																		<td colspan="16" class="border-cell" style="text-align: left; background-color: white; border: 1px solid black;">
																				<font style="color: black;">&nbsp;&nbsp;SubTotal (Weighted):&nbsp;</font>
																				<strong>'. convert_to_money($subTotalWeighted) .'</strong>
																		</td>
																</tr>';

                				$salesPersonName = $rowData['sales_rep'];
                				$subTotal = 0;
                				$subTotalWeighted = 0;
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
												$html .= '<td style="border: 1px solid black; text-align: center;"><div style="margin-left: 5px;">&nbsp;'. $rowData['opportunity_id_num'] .'</div></td>';
												$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">&nbsp;'. $rowData['opportunity_name'] .'</div></td>';
												$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">&nbsp;'. $rowData['account_c'] .'</div></td>';
												$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">&nbsp;'. $rowData['status'] .'</div></td>';
												$html .= '<td style="text-align: right; border: 1px solid black;"><div style="margin-right: 5px;">'. $rowData['full_year_amount'] .'&nbsp;&nbsp;</div></td>';
												$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">&nbsp;'. $rowData['created_date']  .'</div></td>';
												$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">&nbsp;'. $rowData['date_closed'] .'</div></td>';

												$salesStage = array();
												for($i = 1; $i <= count($app_list_strings["sales_stage_dom"]); $i++)
												{
														$salesStage[] = $i;
												}

												foreach ($salesStage as $key => $value) {
													if($rowData['sales_stage']) {
														if ($value == $rowData['sales_stage']) {
															if ($value <= 8) {
																$html .= '<td class="border-cell" style="background-color: #7dc2fa; text-align: center;">X</td>';
															} elseif ($rowData['sales_stage'] == 9) {
																$html .= '<td class="border-cell" style="background-color: #80B440; text-align: center;">X</td>';
															} elseif ($rowData['sales_stage'] == 10) {
																$html .= '<td class="border-cell" style="background-color: red; text-align: center;">X</td>';
															} elseif ($rowData['sales_stage'] == 11) {
																$html .= '<td class="border-cell" style="background-color: orange; text-align: center;">X</td>';
															}
														} else {
															$html .= '<td style="border: 1px solid black; text-align: center;">-</td>';
														}
														
													}
												}
												
												$rowData['next_step'] = strip_tags(html_entity_decode(htmlspecialchars_decode($rowData['next_step']), ENT_QUOTES, 'UTF-8'));
												$rowData['next_step'] = str_replace('div', 'span', $rowData['next_step']);
												$rowData['next_step'] = str_replace('</span>', '</span> <br>&nbsp;', $rowData['next_step']);

												$html .= '<td style="border: 1px solid black;">&nbsp;'. $rowData['next_step'] .'</td>';
                			$html .= '</tr>';

                			$subTotal += $rowData['amount_value'];
                			$subTotalWeighted += $rowData['amount_weighted_value'];
                		}

            			if($subTotal > 0 || $subTotalWeighted > 0)
            			{
										$html .= '<tr>
													<td colspan="5" class="border-cell" style="text-align: right; background-color: white; border-right: 1px solid black; border: 1px solid black;">
															<font style="color: black;">SubTotal:&nbsp;</font>
															<strong style="margin-right: 10px">'. convert_to_money($subTotal) .'&nbsp;&nbsp;</strong>
													</td>

													<td colspan="16" class="border-cell" style="text-align: left; background-color: white; border: 1px solid black;">
															<font style="color: black;">&nbsp;&nbsp;SubTotal (Weighted):&nbsp;</font>
															<strong>'. convert_to_money($subTotalWeighted) .'</strong>
													</td>
											</tr>';

            				$salesPersonName = $rowData['sales_rep'];
										$subTotal = 0;
										$subTotalWeighted = 0;
            			}
									
                		$html .= '<tr>
                           <td colspan="5" class="border-cell" style="text-align: right; background-color: black; height:30px; line-height: 25px;">
																<font style="color: white;">CONSOLIDATED TOTAL:&nbsp;</font>
																<strong style="color: white; margin-right: 10px">'. $fullYearAmountTotal .'&nbsp;&nbsp;</strong>
														</td>
														
														<td colspan="16" class="border-cell" style="text-align: left; background-color: black; height:30px; line-height: 25px;">
																<font style="color: white;">&nbsp;&nbsp;CONSOLIDATED TOTAL (WEIGHTED):&nbsp;</font>
																<strong style="color: white; margin-right: 10px">'. $fullYearAmountTotalWeighted .'</strong>
                            </td>
														</tr>';

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

			$i = 0;
			$html .= '<tr>';
			foreach ($app_list_strings['sales_stage_dom'] as $key => $salesStage) {
				$html .= '<td style="font-size: 11px;">'. ($i + 1) . ') ' . $salesStage .'</td>';
				$i++;
			}
			$html .= '</tr>';
			

			$html .= '</table>
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
$pdf->SetTitle('Opportunity Pipeline Report');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('', 0, 'Opportunity Pipeline Report', '');

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
$pdf->Output('OpportunityPiplelineReport.pdf', 'I');

?>
<?php

require_once('custom/include/TCPDF/tcpdf.php');

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

while($row = $db->fetchByAssoc($result)){ 
	$fullYearAmountTotal += $row['full_year_amount'];
	$row['opportunity_link'] = $sugar_config['site_url'] . '/index.php?module=Opportunities&action=DetailView&record=' . $row['opportunity_id'];
	$row['amount_value'] = $row['full_year_amount'];
	$row['full_year_amount'] = convert_to_money($row['full_year_amount']);
	$row['next_step'] = htmlspecialchars_decode($row['next_step']);
	$row['sales_stage'] = get_dropdown_index("sales_stage_dom", $row['sales_stage']);

	$data[] = $row;
}

$fullYearAmountTotal = convert_to_money($fullYearAmountTotal);

$html = '<table>';

$html .= '<tr>
	<td style="width: 30%; border: 1px solid black; height: 80px;">
        <table>
            <tr>
                <td style="border: 1px solid black; width: 30%;">Pipeline Total</td>
                <td style="border: 1px solid black; width: 60%; text-align: right"><div style="margin-right: 20px;">'. $fullYearAmountTotal .'</div></td>
            </tr>
        </table>
	</td>
	<td style="vertical-align: top; text-align: center; border: 1px solid black;">
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
	<td style="vertical-align: top; text-align: right; font-weight: bold; font-size: 16px; border: 1px solid black;">CONFIDENTIAL</td>
	</tr>
	<tr>
		<td colspan="3">
			<table style="width: 100%;">
                <thead>
                    <tr>
	                    <th rowspan="2" style="width: 15% !important; text-align: center; border: 1px solid black;">Account</th>
	                    <th rowspan="2" style="width: 15% !important; text-align: center; border: 1px solid black;">Opportunity</th>
	                    <th rowspan="1" colspan="10" style="width: 20%; border: 1px solid black; text-align: center;">Sales Stage*</th>
	                    <th rowspan="2" style="width: 10%; text-align: center; border: 1px solid black;">Sales Rep</th>
	                    <th rowspan="2" style="width: 10%; text-align: center; border: 1px solid black;">Full-Year Value</th>
	                    <th rowspan="2" style="width: 10%; text-align: center; border: 1px solid black;">Initial Order Date</th>
	                    <th rowspan="2" style="width: 20%; border: 1px solid black; text-align: center;"><font style="word-wrap:break-word;">Next Actions, Status - specific, measurable, dates</font></th>
                    </tr>
                    <tr>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">1</th>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">2</th>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">3</th>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">4</th>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">5</th>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">6</th>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">7</th>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">8</th>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">9</th>
	                    <th style="width: 2%; padding: 0%; border: 1px solid black; text-align: center;">10</th>
                    </tr>
                </thead>
                <tbody>';
                		$subTotal = 0;
                		$salesPersonName = $data[0]['sales_rep'];
                		foreach ($data as $key => $rowData) {

                			if($salesPersonName != $rowData['sales_rep'])
                			{
		                		$html .= '<tr>
		                           <td colspan="12" class="border-cell" style="text-align: right; background-color: white; border: 1px solid black;">
		                                <font style="color: black;">SubTotal &nbsp;</font>
		                            </td>
		                            <td colspan="4" class="border-cell" style="text-align: left; background-color: white; border: 1px solid black;">
		                                <font style="font-weight: bold; color: black;">'. convert_to_money($subTotal) .'</font>
		                            </td>
		                            </tr>';

                				$salesPersonName = $rowData['sales_rep'];
                				$subTotal = 0;
                			}

                			$html .= '<tr>';
                			$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">'. $rowData['account_c'] .'</div></td>';
                			$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">'. $rowData['opportunity_name'] .'</div></td>';

                			for($i = 1; $i <= 10; $i++)
                			{
                				if($i == ($rowData['sales_stage'] + 1) )
                				{
                					$html .= '<td class="border-cell" style="background-color: #80B440; text-align: center;">X</td>';
                				}
                				else{
                					$html .= '<td style="border: 1px solid black; text-align: center;">-</td>';
                				}
                			}

                			$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">'. $rowData['sales_rep'] .'</div></td>';
                			$html .= '<td style="text-align: right; border: 1px solid black;"><div style="margin-right: 5px;">'. $rowData['full_year_amount'] .' &nbsp;</div></td>';
                			$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">'. $rowData['date_closed']  .'</div></td>';
                			$html .= '<td style="border: 1px solid black;"><div style="margin-left: 5px;">'. $rowData['next_step'] .'</div></td>';
                			$html .= '</tr>';

                			$subTotal += $rowData['amount_value'];
                		}

            			if($subTotal > 0)
            			{
	                		$html .= '<tr>
	                           <td colspan="12" class="border-cell" style="text-align: right; background-color: white; border-right: 1px solid black; border: 1px solid black;">
	                                <font style="color: black;">SubTotal &nbsp;</font>
	                            </td>
	                            <td colspan="4" class="border-cell" style="text-align: left; background-color: white; border: 1px solid black;">
	                                <font style="font-weight: bold; color: black;">'. convert_to_money($subTotal) .'</font>
	                            </td>
	                            </tr>';

            				$salesPersonName = $rowData['sales_rep'];
            				$subTotal = 0;
            			}

                		$html .= '<tr>
                           <td colspan="12" class="border-cell" style="text-align: right; background-color: black; height:30px; line-height: 25px;">
                                <font style="color: white; font-size: 14px;">CONSOLIDATED TOTAL</font>
                            </td>
                            <td colspan="4" class="border-cell" style="text-align: left; background-color: black; height:30px; line-height: 25px;">
                                <font style="font-weight: bold; color: white; font-size: 14px;">'. $fullYearAmountTotal .'</font>
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
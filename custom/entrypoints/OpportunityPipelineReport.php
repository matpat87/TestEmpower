<?php

require_once('custom/include/TCPDF/tcpdf.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$html = "<table>";

$html .= '<tr>
	<td style="width: 30%">
        <table>
            <tr>
                <td style="border: 1px solid black; width: 30%;">Pipeline Total</td>
                <td style="border: 1px solid black; width: 60%; text-align: right"><div style="margin-right: 20px;">{$fullYearAmountTotal}</div></td>
            </tr>
        </table>
	</td>
	<td style="vertical-align: top; text-align: center;">
        <table>
            <tr>
                <td style="text-align: center;"><img style="margin-top: 20px;" src="themes/default/images/company_logo.png" /></td>
            </tr>
            <tr>
               <td style="font-weight: bold; font-size: 18px;">
                   Consolidated Sales Pipeline
               </td> 
            </tr>
        </table>
	</td>
	<td style="vertical-align: top; text-align: right; font-weight: bold; font-size: 16px">CONFIDENTIAL</td>
	</tr>
	<tr>
		<td colspan="3">
			<table style="width: 100%;">
                <thead>
                    <tr>
	                    <th rowspan="2" style="width: 15% !important; text-align: center; border: 1px solid black;">Account</th>
	                    <th rowspan="2" style="width: 15% !important; text-align: center; border: 1px solid black;">Opportunity</th>
	                    <th rowspan="2" style="width: 5% !important; text-align: center; border: 1px solid black;">Status</th>
	                    <th rowspan="2" style="width: 10%; text-align: center; border: 1px solid black;">Sales Rep</th>
	                    <th rowspan="2" style="width: 10%; text-align: center; border: 1px solid black;">Full-Year Value</th>
	                    <th rowspan="2" style="width: 10%; text-align: center; border: 1px solid black;">Initial Order Date</th>
	                    <th rowspan="1" colspan="10" style="width: 20%; border: 1px solid black; text-align: center;">Sales Stage*</th>
	                    <th rowspan="2" style="width: 15%; border: 1px solid black; text-align: center;"><font style="word-wrap:break-word;">Next Actions, Status - specific, measurable, dates</font></th>
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
                <tbody>
                	<tr>
                		<td style="border: 1px solid black;"><div style="margin-left: 5px;">{$rowData.ACCOUNT_C}</div></td>
                		<td style="border: 1px solid black;"><div style="margin-left: 5px;">{$rowData.OPPORTUNITY_NAME}</div></td>
                		<td style="border: 1px solid black;"></td>
                		<td style="border: 1px solid black;"><div style="margin-left: 5px;">{$rowData.SALES_REP}</div></td>
                		<td style="text-align: right; border: 1px solid black;"><div style="margin-right: 5px;">{$rowData.FULL_YEAR_AMOUNT}</div></td>
                		<td style="border: 1px solid black;"><div style="margin-left: 5px;">{$rowData.DATE_CLOSED}</div></td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black; text-align: center;">-</td>
                		<td style="border: 1px solid black;"><div style="margin-left: 5px;">{$rowData.NEXT_STEP}</div></td>
                	</tr>
                </tbody>
			</table>
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

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('OpportunityPiplelineReport.pdf', 'I');

?>
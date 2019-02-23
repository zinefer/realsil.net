<?php include('../include/auth.php');

$selectFormInfo = "select column_name as 'name', column_comment as 'desc', character_maximum_length as 'len' from information_schema.columns where table_name='_form_demographic'";
$formInfo = array();
if($result = mysql_query($selectFormInfo))
{
	while($row = mysql_fetch_assoc($result))
	{	
		$formInfo[] = $row;
	}
}else{ echo mysql_error(); }

// build data arrays for the page
$fields = array();
foreach($formInfo as $field)
{
	if($field['desc'] == null) continue;
	$fields[$field['name']] = array('desc'=>$field['desc'], 'len'=>$field['len']);
}

?>

<style type="text/css">
	h1 { text-align:center; font-size:large; }
</style>

<h1>Real Independant Living</h1>
<h1>Supervised Independent Living Program</h1>
<h1>Placement Outline/Demographic Form</h1>

<table style="border: solid 1px black; background-color:eee;">
	<tr>
		<td style="text-align:center;"><b>General Information</b></td>
	</tr>
	<tr>
		<td>
			<table cellpadding=5 cellspacing=5>
				<tr>
					<td style="border: solid 1px black">Client Name: James Kiefer</td>
					<td style="border: solid 1px black">SIL Entry Date: 19-25-2010</td>
				</tr>
				<tr>
					<td style="border: solid 1px black">Birthdate: 19-25-2010</td>
					<td style="border: solid 1px black">Social Security Number: 119-25-2010</td>
				</tr>
				<tr>
					<td style="border: solid 1px black">DHS Case Number: 15K698LM</td>
					<td style="border: solid 1px black">Court Case Number: 1195</td>
				</tr>
				<tr>
					<td colspan=2>
						<table cellpadding=5 cellspacing=5>
							<tr>
								<td style="border: solid 1px black">Legal Status: Legal</td>
								<td style="border: solid 1px black">County of Origin: Macomb</td>
								<td style="border: solid 1px black">SIL Caseworker: John Brooks</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>


<?


exit();
//============================================================+
// File name   : example_061.php
// Begin       : 2010-05-24
// Last Update : 2010-08-08
//
// Description : Example 061 for TCPDF class
//               XHTML + CSS
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com s.r.l.
//               Via Della Pace, 11
//               09044 Quartucciu (CA)
//               ITALY
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XHTML + CSS
 * @author Nicola Asuni
 * @since 2010-05-25
 */

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RealSIL.net');
$pdf->SetTitle('Demographic Form');
//$pdf->SetSubject('');
//$pdf->SetKeywords('');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

$name = "James Kiefer";
 
// define some HTML content with style
$html = file_get_contents('demographic.htm');

$formFileData = file_get_contents('demographic-template');
$formFileData = explode("\n", $formFileData);

$formData = array();
foreach($formFileData as $d)
{
	$tmp = explode("~", $d);
	$formData['regex'][] = $tmp[0];
	$formData['value'][] = trim(str_replace(": ?[_]+/s", "", $tmp[0]), "/") . ": <span class=\"ans\">" . $tmp[1] . "</span> ";
}

$html = preg_replace($formData['regex'], $formData['value'], $html, 1);

//var_dump($formData);

//exit;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// *******************************************************************
// HTML TIPS & TRICKS
// *******************************************************************

// REMOVE CELL PADDING
//
// $pdf->SetCellPadding(0);
// 
// This is used to remove any additional vertical space inside a 
// single cell of text.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// REMOVE TAG TOP AND BOTTOM MARGINS
//
// $tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
// $pdf->setHtmlVSpace($tagvs);
// 
// Since the CSS margin command is not yet implemented on TCPDF, you
// need to set the spacing of block tags using the following method.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// SET LINE HEIGHT
//
// $pdf->setCellHeightRatio(1.25);
// 
// You can use the following method to fine tune the line height
// (the number is a percentage relative to font height).

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// CHANGE THE PIXEL CONVERSION RATIO
//
// $pdf->setImageScale(0.47);
// 
// This is used to adjust the conversion ratio between pixels and 
// document units. Increase the value to get smaller objects.
// Since you are using pixel unit, this method is important to set the
// right zoom factor.
// 
// Suppose that you want to print a web page larger 1024 pixels to 
// fill all the available page width.
// An A4 page is larger 210mm equivalent to 8.268 inches, if you 
// subtract 13mm (0.512") of margins for each side, the remaining 
// space is 184mm (7.244 inches).
// The default resolution for a PDF document is 300 DPI (dots per 
// inch), so you have 7.244 * 300 = 2173.2 dots (this is the maximum 
// number of points you can print at 300 DPI for the given width).
// The conversion ratio is approximatively 1024 / 2173.2 = 0.47 px/dots
// If the web page is larger 1280 pixels, on the same A4 page the 
// conversion ratio to use is 1280 / 2173.2 = 0.59 pixels/dots

// *******************************************************************

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_061.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+

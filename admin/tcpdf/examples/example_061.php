<?php
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

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

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

// define some HTML content with style
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->

<html>



<head>

<meta http-equiv=Content-Type content="text/html; charset=windows-1252">

<meta name=Generator content="Microsoft Word 14 (filtered)">

<style type="text/css">
  p.c4 {font-weight: bold}
  span.c3 {font-size:12.0pt;line-height:115%}
  p.c2 {font-weight: bold; text-align: center}
  span.c1 {font-size:14.0pt;line-height:115%}
  span.ans {text-decoration:underline;}
</style>



    <p class="MsoNormal c2"><span class='c1'>REAL Independent Living</span></p>

    <p class="MsoNormal c2"><span class='c1'>Supervised Independent Living
    Program</span></p>

    <p class="MsoNormal c2"><span class='c1'>Placement Outline/Demographic
    Form</span></p>

    <p class="MsoNormal"><span class='c1'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Client Name:
    <span class="ans">              James Kiefer           </span> SIL Entry Date: _______________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Birthdate: __________________ Social
    Security Number:_______________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>DHS Case Number:_________________ Court Case
    Number: _____________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Legal Status:________ County of
    Origin:_____________ SIL Caseworker:__________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>DHS Worker Name:__________________________
    Load Number:__________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Branch Office:___________
    Address:_______________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Phone Number:___________________
    E-mail:_____________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>DHS Supervisor
    Name:_____________________________ Phone Number:________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Placement/Living Situation prior to SIL
    placement:____________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Placement Type: __Phase I or __Phase II Home
    Provider Name:_______________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Street
    Address:__________________________________
    City/Zip:_______________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Phone Number:____________________________
    E-mail:______________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Client Physical Description:</span></p>

    <p class="MsoNormal c4"><span class='c3'>Gender:____________
    Ethnicity:____________________ Tribal Affiliation:_______________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Language:________________Height: ___ft
    ___in, Weight:_______lbs, Build:______________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Hair color:____________ Eye
    color:_____________ Complexion:__________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Unusual Marks, scars, tattoos,
    etc:_________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Education(highest grade completed):________
    Previous School:________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Currrent
    School:___________________________________Phone:_______________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Address:_____________________________
    City/zip:_________________________ Grade:___</span></p>

    <p class="MsoNormal c4"><span class='c3'>Special Education: Yes or No
    Designation:_________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Emergency Contact
    Person/Relationship:____________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Address:_____________________________
    City/State/Zip:_____________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Phone:_________________
    E-mail:_________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Currently employed?:_________
    Employer:_________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>Address:____________________________________________
    Phone:____________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Type of
    business/work:____________________________ Supervisor:____________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Date of last physical exam:______________
    dental exam:___________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Doctor
    Name/address/phone:_____________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Dentist
    Name/address/phone:____________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Current Medical
    concerns:________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Current
    Medication/dosage:______________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Medicaid Recipient Id:_________________
    Other insurance:____________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Biological/Adoptive Parents: Not necessary
    if parental rights are terminated</span></p>

    <p class="MsoNormal c4"><span class='c3'>Mother
    name:_________________________________ Date of Birth:_________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>Address:___________________________________City/State/Zip:_______________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Phone Number:_______________ SS
    #:________________________ Marital
    status:_______&Acirc;&shy;&Acirc;&shy;&Acirc;&shy;__</span></p>

    <p class="MsoNormal c4"><span class='c3'>Father
    name:___________________________________ Date of Birth:_________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>Address:___________________________________City/State/Zip:_______________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Phone Number:_______________ SS
    #:________________________ Marital status:_________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Siblings Names, Date of birth/age,
    Placement/whereabouts:____________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Offspring Name, Date of birth/age,
    Placement/whereabouts:___________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Significant others name, relationship to
    client, phone number:__________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Pertinent Medical Information/Family Medical
    History:________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Circumstances Leading to SIL
    placement:____________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>Previous out of home
    placements:_________________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>Immediate Needs/services
    required:_______________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class=
    'c3'>______________________________________________________________________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>SIL Caseworker
    signature:___________________________________ Date:________________</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>

    <p class="MsoNormal c4"><span class='c3'>&nbsp;</span></p>
EOF;

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

<?php

ob_start();
require_once '../Views/resume-template.php';
$html = ob_get_contents();
ob_end_clean();


require '../TCPDF/tcpdf.php';
$pdf = new TCPDF();
$pdf->AddPage();
// remove the button from the html before printing
$html = preg_replace('/<div class="pdf-button">.*<\/div>/s', '', $html);
$pdf->writeHTML($html);
// add css to the pdf
$stylesheet = file_get_contents('Style/resume.css');
//print in the console the $stylesheet
echo $stylesheet;
$pdf->writeHTML($stylesheet, 1);

$pdf->Output('resume.pdf', 'I');
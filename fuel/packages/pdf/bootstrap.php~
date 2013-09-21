<?php
/**
 * PDF FuelPHP package - Driver based PDF generation
 *
 * This package is based on https://github.com/TJS-Technology/fuel-pdf
 *
 * @package    Fuel
 * @version    1.0
 * @author     Harro "WanWizard" Verton
 * @license    MIT License
 * @copyright  2012 - Exite Development Services
 * @link       http://exite.eu
 */

Autoloader::add_core_namespace('Pdf');

Autoloader::add_classes(array(
	// loader class
	'Pdf\\Pdf'           => __DIR__ . '/classes/pdf.php',

	// driver classes
	'Pdf\\Pdf_Tcpdf'     => __DIR__ . '/classes/pdf/tcpdf.php',
	'Pdf\\Pdf_Dompdf'    => __DIR__ . '/classes/pdf/dompdf.php',
	'Pdf\\Pdf_Mpdf'      => __DIR__ . '/classes/pdf/mpdf.php',
	'Pdf\\Pdf_Fpdf'      => __DIR__ . '/classes/pdf/fpdf.php',
));

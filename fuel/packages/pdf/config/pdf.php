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


return array(
	/**
	 * Default driver to load if none is specified
	 */
	'driver'	=> 'dompdf',

	/**
	 * Available PDF engines. Include paths are relative to the vendor folder
	 */
	'drivers'			=> array(

		/**
		 */
		'tcpdf'		=> array(
			'includes'	=> array(
				'tcpdf/config/lang/eng.php',
				'tcpdf/tcpdf.php',
			),
			'defaults' => array(
				'P',
				'mm',
				'A4',
				true,
				'UTF-8',
				false
			),
		),

		/**
		 */
		'dompdf'	=> array(
			'includes'	=> array(
				'dompdf/dompdf_config.inc.php',
			),
		),

		/**
		 */
		'fpdf'	=> array(
			'includes'	=> array(
				'fpdf/fpdf.php',
			),
		),

		/**
		 */
		'mpdf'	=> array(
			'includes'	=> array(
				'mpdf/mpdf.php',
			),
		),
	),
);

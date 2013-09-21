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

namespace Pdf;

class Pdf_Tcpdf extends \TCPDF
{
	/**
	 * @var array	configuration information for this driver
	 */
	 protected $config = array();

	/**
	 * @var string	path to a background image to be used for the PDF
	 */
	protected $background_image = false;

	/**
	 * @var bool	internal flag to prevent unwanted pagebreaks
	 */
	private $disable_page_breaks = false;

	/**
	 */
	public function __construct(Array $config = array())
	{
		// store the configuration
		$this->config = $config;

		// do we have any defaults to pass on to the engine's constructor?
		if ( empty($config['defaults']) )
		{
			// call the parent constructor
			parent::__construct();
		}
		else
		{
			// call the parent constructor
			call_user_func_array('parent::__construct', $config['defaults']);
		}
	}

	/**
	 * magic method to deal with different method naming methods
	 * (FuelPHP style, camelCase, CamelCase)
	 *
	 * @access	public
	 * @param	string	method
	 * @param	array	arguments
	 * @return	mixed
	 */
	public function __call($method, $arguments)
	{
		// store already detected alternatives
		static $cache = array();

		// define some alternative spellings
		if (in_array($method, $cache))
		{
			$alternatives = array($cache[$method]);
		}
		else
		{
			$alternatives = array(
				\Inflector::camelize($method),
				lcfirst(\Inflector::camelize($method)),
				\Inflector::underscore($method),
				\Inflector::words_to_upper($method),
			);
		}

		// see if these exist
		foreach($alternatives as $alternative)
		{
			if (method_exists($this, $alternative))
			{
				// store in the cache for reuse
				$cache[$method] = $alternative;

				// and call the method found
				return call_user_func_array(array($this, $alternative), $arguments);
			}
		}

		\Debug::dump($method, $alternatives);
		\Debug::dump(func_get_args());
		die('PDF::alternative methods: method called could not be determined!');
	}

	/**
	 * capture calls to Error because in FuelPHP we like to throw things
	 */
	public function Error($msg)
	{
		// unset all class variables
		$this->_destroy(true);

		// throw the error
		throw new PdfException($msg);
	}

	/**
	 * set the image to be used as the page background
	 *
	 * @param	string	filename of an image to be used as background. null/false will disable the background
	 * @return	void
	 */
	public function set_background_image($file = null)
	{
		if ($file and is_file($file))
		{
			// get the current page break margin
			$margin = $this->get_break_margin();

			// get current auto-page-break mode
			$auto_page_break = $this->AutoPageBreak;

			// disable auto-page-break
			$this->set_auto_page_break(false, 0);

			// set bacground image
			$this->image($file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

			// restore auto-page-break status
			$this->set_auto_page_break($auto_page_break, $margin);

			// set the starting point for the page content
			$this->set_page_mark();
		}
	}

	/**
	 * write a full line to the PDF
	 *
	 * @param	string	text to be written to the PDF
	 * @param	int		number of extra lines to add after this one
	 */
	public function write_line($text, $extra_lines = 0)
	{
		// write the link
		$this->write(0, $text, '', 0, '', true, 0);

		// add extra lines if needed
		$extra_lines > 0 and $this->ln($extra_lines);
	}

	/**
	 * write a cell to the PDF
	 *
	 * @param	string		left column text
	 * @param	string		right column text
	 * @param	int			indentation in px
	 */
	public function write_cells($left, $right, $left_width = 40)
	{
		$page_start = $this->getPage();
		$y_start = $this->GetY();

		$this->MultiCell($left_width, 0, $left, 0, 'L', 0, 2, $this->GetX() ,$y_start, true, 0);

		$page_end_1 = $this->getPage();
		$y_end_1 = $this->GetY();

		$this->setPage($page_start);

		$this->MultiCell(0, 0, ': '.$right, 0, 'L', 0, 1, $this->GetX() ,$y_start, true, 0);

		$page_end_2 = $this->getPage();
		$y_end_2 = $this->GetY();

		// set the new row position by case
		if (max($page_end_1,$page_end_2) == $page_start) {
			$ynew = max($y_end_1, $y_end_2);
		} elseif ($page_end_1 == $page_end_2) {
			$ynew = max($y_end_1, $y_end_2);
		} elseif ($page_end_1 > $page_end_2) {
			$ynew = $y_end_1;
		} else {
			$ynew = $y_end_2;
		}

		$this->setPage(max($page_end_1,$page_end_2));
		$this->SetXY($this->GetX(),$ynew);
	}
}

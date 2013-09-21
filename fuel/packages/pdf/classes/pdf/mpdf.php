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

class Pdf_Mpdf extends \mPDF
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
}

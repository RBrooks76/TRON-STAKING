<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * CI_Loader
	 *
	 * @var	CI_Loader
	 */
	public $load;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');

		 $lang_url		=	$this->uri->segment(1);

		
		if($lang_url=='en' || $lang_url=='ja' || $lang_url=='hi' || $lang_url=='ve' || $lang_url=='fil' || $lang_url=='ca' || $lang_url=='ne' || $lang_url=='bn' || $lang_url == 'fr' || $lang_url=='gd' || $lang_url=='ru' || $lang_url=='es' || $lang_url=='th' || $lang_url=='pt' )
		{
			if($lang_url=='en')
			{
				$language_name	=	'English';
			}
			else if($lang_url=='ja')
			{
				$language_name	=	'Japanese';
			}
			else if($lang_url=='hi')
			{
				$language_name	=	'Hindi';
			}
			else if($lang_url=='ve')
			{
				$language_name	=	'Vietnamese';
			}
			else if($lang_url=='fil')
			{
				$language_name	=	'Filipino';
			}
			else if($lang_url=='ca')
			{
				$language_name	=	'Chinese';
			}
			else if($lang_url=='ne')
			{
				$language_name	=	'Nepali';
			}
			else if($lang_url=='bn')
			{
				$language_name	=	'Bengali';
			}
			else if($lang_url=='fr')
			{
				$language_name	=	'French';
			}
			else if($lang_url=='gd')
			{
				$language_name	=	'German';
			}
			else if($lang_url=='ru')
			{
				$language_name	=	'Russian';
			}
			else if($lang_url=='es')
			{
				$language_name	=	'Spanish';
			}
			else if($lang_url=='th')
			{
				$language_name	=	'Thai';
			}
			else if($lang_url=='pt')
			{
				$language_name	=	'Portuguese';
			}
			$this->config->set_item('language', $language_name);
			include(APPPATH.'language/'.$language_name.'/app_lang.php');

			global 	$myVAR;
			
			$myVAR	= $lang;
		}

	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

}

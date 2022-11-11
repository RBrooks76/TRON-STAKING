	<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n
// version 10 - May 10, 2012

class MY_Lang extends CI_Lang  {


	// languages
	var $languages = array(
		'en' 	=> 	'English',
		'ja'	=>	'Japanese',
		'hi'	=>	'Hindi',
		've'	=>	'Vietnamese',
		'fil'	=>	'Filipino',
		'ca'	=>	'Chinese',
		'ne'	=>	'Nepali',
		'bn'	=>	'Bengali',
		'fr'	=>	'French',
		'gd'	=>	'German',
		'ru'	=>	'Russian',
		'es'	=>	'Spanish',
		'th'	=>	'Thai',
		'pt'	=>	'Portuguese',
		);

	

	// special URIs (not localized)
	var $special = array (
		""
	);
	
	// where to redirect if no language in URI
	var $default_uri = ''; 

	/**************************************************/
	
	
	function __construct()
	{

		parent::__construct();		
	
		global $CFG;
		global $URI;
		global $RTR;

		$country_language = array(
		'IN' 	=> 	'en',
		'JA'	=>	'ja',
		'HI'	=>	'hi',
		'VE'	=>	've',
		'FIL'	=>	'fil',
		'CA'	=>	'ca',
		'NE'	=>	'ne',
		'BN'	=>	'bn',
		'FR'	=>	'fr',
		'GD'	=>	'gd',
		'RU'	=>	'ru',
		'ES'	=>	'es',
		'TH'	=>	'th',
		'PT'	=>	'pt',
		);
	
		$language = array(
		'en' 	=> 	'English',
		'ja'	=>	'Japanese',
		'hi'	=>	'Hindi',
		've'	=>	'Vietnamese',
		'fil'	=>	'Filipino',
		'ca'	=>	'Chinese',
		'ne'	=>	'Nepali',
		'bn'	=>	'Bengali',
		'fr'	=>	'French',
		'gd'	=>	'German',
		'ru'	=>	'Russian',
		'es'	=>	'Spanish',
		'th'	=>	'Thai',
		'pt'	=>	'Portuguese',
		);
 
		$ip 	=	$_SERVER['SERVER_ADDR'];
		$country = "IN";

		$segment_two 	=	$URI->segment(2);
		$segment 		= 	$URI->segment(1);
		$url_base 		= 	$URI->config->config['base_url'];

		
		$url_func 		= 	$URI->uri_string;
		

			if (($found = file_exists(APPPATH.'config/user_agents.php')))
			{
				include(APPPATH.'config/user_agents.php');

				$routes	=	include(APPPATH.'config/routes.php');


				if (isset($route))
				{
					$ro 	=	array();
					foreach ($route as $key => $value) {
						$ro[]	= str_replace(array('/(:any)','/edit_pair'), array('',''), $key);
					}
				}
				$ctr = array_merge($ctr,$ro);
				if (isset($ctr))
				{
					if (in_array($URI->segment(1), $ctr) || in_array($URI->segment(2), $ctr))
					{
							
					}
					else if($URI->segment(2)=="exchange" || $URI->segment(3)==ADMINURL)
					{
						
						header("Location: ".$url_base. substr($url_func,'3') , TRUE, 302); exit;
					}
					else if (isset($language[$segment]))	
					{

						$language = $language[$segment];
						$CFG->set_item('language', $language);
					}
					else if($this->is_special($segment))
					{
						if (!array_key_exists($country,$country_language)){
							$country = 'IN';
						}
						$load_language = $country_language[$country];
						$language = $language[$load_language];
						$CFG->set_item('language', $language);
						
						header("Location: ".$url_base.$load_language , TRUE, 302);
						return;
					}
					else
					{
						if (!array_key_exists($country,$country_language)){
							$country = 'IN';
						}
						$load_language = $country_language[$country];
						$language = $language[$load_language];
						$CFG->set_item('language', $language);
						header("Location: ".$url_base.$load_language."/". $url_func , TRUE, 302); exit;
					}
				}
			}
			else
			{
				echo 'sdfsdfsd'; die;
			}

			
		
	}
	
	
	function lang()
	{
		global $CFG;		
		$language = $CFG->item('language');
		
		$lang = array_search($language, $this->languages);
		if ($lang)
		{
			return $lang;
		}
		
		return NULL;	// this should not happen
	}
	
	function is_special($uri)
	{
		$exploded = explode('/', $uri);
		if (in_array($exploded[0], $this->special))
		{
			return TRUE;
		}
		if(isset($this->languages[$uri]))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	function switch_uri($lang)
	{
		$CI =& get_instance();

		$uri = $CI->uri->uri_string();
		if ($uri != "")
		{
			$exploded = explode('/', $uri);
			if($exploded[0] == $this->lang())
			{
				$exploded[0] = $lang;
			}
			$uri = implode('/',$exploded);
		}
		return $uri;
	}
	
	// is there a language segment in this $uri?
	function has_language($uri)
	{
		$first_segment = NULL;
		
		$exploded = explode('/', $uri);
		if(isset($exploded[0]))
		{
			if($exploded[0] != '')
			{
				$first_segment = $exploded[0];
			}
			else if(isset($exploded[1]) && $exploded[1] != '')
			{
				$first_segment = $exploded[1];
			}
		}
		
		if($first_segment != NULL)
		{
			return isset($this->languages[$first_segment]);
		}
		
		return FALSE;
	}
	
	// default language: first element of $this->languages
	function default_lang()
	{
		foreach ($this->languages as $lang => $language)
		{
			return $lang;
		}
	}
	
	// add language segment to $uri (if appropriate)
	function localized($uri)
	{
		if($this->has_language($uri)
				|| $this->is_special($uri)
				|| preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri))
		{
			
		}
		else
		{
			$uri = $this->lang() . '/' . $uri;
		}
		
		return $uri;
	}
	
}


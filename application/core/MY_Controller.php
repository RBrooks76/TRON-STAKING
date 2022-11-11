<?php
/**
 * The base controller which is used by the Front and the Admin controllers
 */
class Base_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

		$this->output->set_header("Pragma: no-cache");

		$this->load->library(array('__CONFIG', 'user_agent', 'session', 'email', 'form_validation', 'limiter'));

		$this->load->helper(array('url', 'file', 'string', 'form', 'html', 'language', 'security', 'security', 'common', 'captcha', 'cookie'));

		$agent = $this->agent;

		$ip = getRealIpAddr();

		$req_data['user_agent'] = $agent->agent;

		$req_data['user_ip'] = $ip;

		$this->load->model(array('common'));

		$this->load->database();

		$this->limiter->add_user_data($ip);

		$abort = $this->limiter->limit($ip, 18000);

		if ($abort) {

			die;
		}

		require APPPATH . 'config/manifest.php';

		spl_autoload_register(function ($class) use ($classes) {

			if (isset($classes[$class])) {
				include ($classes[$class]);
			}
		});

		insert_data(UC, $req_data);

		if (empty($agent->is_browser) && $agent->agent != 'OP') {
			die;
		} else if (!empty($agent->is_browser)) {

			if ($agent->is_browser != 'OP-YES') {
				die;
			}
		}

		if (config_item('ssl_support') && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off')) {
			$CI = &get_instance();

			$CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);

			redirect($CI->uri->uri_string());
		}

		/*$ip 	  = get_client_ip();

			$admin_ip = FS::Common()->getTableData(ADMINIP, array('ip_address' => $ip,'status' => 1));

			$ad_ip 	  = $admin_ip->num_rows();

			$urls = $this->uri->segment('1');

			if($urls == ADMINURL && $ad_ip == 0)
			{
				$this->load->view('maintenance/notfound');

			}

			$ip = get_client_ip();
			$user_ip = FS::Common()->getTableData(USERIP, array('ip_address' => $ip,'status' => 1));
			$us_ip 	  = $user_ip->num_rows();
			 if($us_ip == 1)
			 {
				$this->load->view('maintenance/notfound');

		*/

	}
} //end Base_Controller

class Front_Controller extends Base_Controller {
	function __construct() {

		parent::__construct();

		$lang_url = FS::uri()->segment(1);

		$getLanguage = @get_data(LANG, array('status' => 1, 'lang_code' => $lang_url))->row();

		if (empty($getLanguage)) {
			redirect('en/basic');
		}

		$this->load->library(array('__CONFIG', 'user_agent'));

		$user_htpwd = get_data(SITE, array('id' => 1), 'user_htpwd')->row()->user_htpwd;

		if (!empty($user_htpwd)) {
			$agent = $this->agent->is_browser;

			if ($agent == 'OP-YES') {
				if ($_SERVER['HTTP_HOST'] == 'www.trongoogol.io') {
					$adminuser = 'WQwZTK4R';
					$adminpass = 'WAksagWC';

					if (!isset($_SERVER['PHP_AUTH_USER']) || (isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_USER'] != $adminuser || $_SERVER['PHP_AUTH_PW'] != $adminpass))) {
						header('WWW-Authenticate: Basic realm=" Auth"');
						header('HTTP/1.0 401 Unauthorized');

						//echo $_SERVER['HTTP_HOST'] . ' = Authentications Failed = ' . $agent;exit;

						echo 'Authentications Failed';exit;
					}

				}
			}
		}

		$site_maintenance = @get_data(SITE, array('id' => 1), 'site_maintenance')->row()->site_maintenance;

		if (!empty($site_maintenance)) {
			$this->load->view('maintenance/index');
		}

		$this->load->helper(array('date'));
	}

	function view($view, $vars = array(), $string = false) {
		if ($string) {
			$result = $this->load->view(strtolower(CI_MODEL) . '/common/header', $vars, true);
			$result .= $this->load->view($view, $vars, true);
			$result .= $this->load->view(strtolower(CI_MODEL) . '/common/footer', $vars, true);

			return $result;
		} else {
			$this->load->view(strtolower(CI_MODEL) . '/common/header', $vars);
			$this->load->view($view, $vars);
			$this->load->view(strtolower(CI_MODEL) . '/common/footer', $vars);
		}
	}

	function bview($view, $vars = array(), $string = false) {
		if ($string) {
			$result = $this->load->view(strtolower(CI_MODEL) . '/common/login_header', $vars, true);
			$result .= $this->load->view($view, $vars, true);
			$result .= $this->load->view(strtolower(CI_MODEL) . '/common/login_footer', $vars, true);

			return $result;
		} else {
			$this->load->view(strtolower(CI_MODEL) . '/common/login_header', $vars);
			$this->load->view($view, $vars);
			$this->load->view(strtolower(CI_MODEL) . '/common/login_footer', $vars);
		}
	}

	function cview($view, $vars = array(), $string = false) {
		if ($string) {
			$result = $this->load->view(strtolower(CI_MODEL) . '/common/inner_header', $vars, true);
			$result = $this->load->view(strtolower(CI_MODEL) . '/common/sidebar', $vars, true);
			$result .= $this->load->view($view, $vars, true);
			$result .= $this->load->view(strtolower(CI_MODEL) . '/common/inner_footer', $vars, true);

			return $result;
		} else {
			$this->load->view(strtolower(CI_MODEL) . '/common/inner_header', $vars);
			$this->load->view(strtolower(CI_MODEL) . '/common/sidebar', $vars);
			$this->load->view($view, $vars);
			$this->load->view(strtolower(CI_MODEL) . '/common/inner_footer', $vars);
		}
	}

//for referral section

	function mview($view, $vars = array(), $string = false) {
		if ($string) {
			$result = $this->load->view(strtolower(CI_MODEL) . '/profile_header', $vars, true);
			$result .= $this->load->view($view, $vars, true);
			$result .= $this->load->view(strtolower(CI_MODEL) . '/script', $vars, true);

			return $result;
		} else {
			$this->load->view(strtolower(CI_MODEL) . '/profile_header', $vars);
			$this->load->view($view, $vars);
			$this->load->view(strtolower(CI_MODEL) . '/script', $vars);
		}
	}

	function rview($view, $vars = array(), $string = false) {
		if ($string) {
			$result = $this->load->view(strtolower(CI_MODEL) . '/cms_header', $vars, true);
			$result .= $this->load->view($view, $vars, true);
			$result .= $this->load->view(strtolower(CI_MODEL) . '/script', $vars, true);
			return $result;
		} else {
			$this->load->view(strtolower(CI_MODEL) . '/cms_header', $vars);
			$this->load->view($view, $vars);
			$this->load->view(strtolower(CI_MODEL) . '/script', $vars);
		}
	}

	function sview($view, $vars = array(), $string = false) {
		if ($string) {
			$result = $this->load->view(strtolower(CI_MODEL) . '/setup_header', $vars, true);
			$result .= $this->load->view($view, $vars, true);
			$result .= $this->load->view(strtolower(CI_MODEL) . '/setup_footer', $vars, true);

			return $result;
		} else {
			$this->load->view(strtolower(CI_MODEL) . '/setup_header', $vars);
			$this->load->view($view, $vars);
			$this->load->view(strtolower(CI_MODEL) . '/setup_footer', $vars);
		}
	}

	function partial($view, $vars = array(), $string = false) {
		if ($string) {
			return $this->load->view($view, $vars, true);
		} else {
			$this->load->view($view, $vars);
		}
	}
}

class Admin_Controller extends Base_Controller {

	private $template;

	function __construct() {
		parent::__construct();

		if (!empty(admin_id())) {
			user_access();

		}
	}

	function view($view, $vars = array(), $string = false) {
		$template = 'admin';

		if ($string) {
			$result = $this->load->view($template . '/common/head', $vars, true);
			$result = $this->load->view($template . '/common/sidebar', $vars, true);
			$result = $this->load->view($template . '/common/navbar', $vars, true);
			$result .= $this->load->view($template . '/' . $view, $vars, true);
			$result .= $this->load->view($template . '/common/footer', $vars, true);

			return $result;
		} else {
			$this->load->view($template . '/common/head', $vars);
			$this->load->view($template . '/common/sidebar', $vars);
			$this->load->view($template . '/common/navbar', $vars);
			$this->load->view($template . '/' . $view, $vars);
			$this->load->view($template . '/common/footer', $vars);
		}
	}

	function basicview($view, $vars = array(), $string = false) {
		$template = 'admin';

		if ($string) {
			$result = $this->load->view($template . '/basic/basic_header', $vars, true);
			$result .= $this->load->view($template . '/' . $view, $vars, true);
			$result .= $this->load->view($template . '/basic/basic_footer', $vars, true);

			return $result;
		} else {
			$this->load->view($template . '/basic/basic_header', $vars);
			$this->load->view($template . '/' . $view, $vars);
			$this->load->view($template . '/basic/basic_footer', $vars);
		}
	}

	/* Template is a temporary prefix that lasts only for the next call to view */
	function set_template($template) {
		$this->template = $template;
	}

	function partial($view, $vars = array(), $string = false) {
		if ($string) {
			return $this->load->view('admin/' . $view, $vars, true);
		} else {
			$this->load->view('administrator/' . $view, $vars);
		}
	}
}
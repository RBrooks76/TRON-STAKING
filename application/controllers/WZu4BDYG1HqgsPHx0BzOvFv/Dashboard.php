<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		if ( empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}
		
		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('1',$user_view))
		{
			admin_url_redirect('', 'refresh');
		}
		else
		{
			$data['title']		=	"Dashboard";

			$this->view('pages/dashboard', $data);
		}
	}
}

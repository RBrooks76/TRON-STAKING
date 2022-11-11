<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral extends Admin_Controller {

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
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view 				=	$this->config->item('user_view');

		if(!in_array('25',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		$data['title'] 			= 	'Referral Link Management';

		$data['result'] 		= 	@get_data(RL,array('status'=>1))->result_array();

		$this->view('pages/Referral/manage', $data); 
	}

	public function updateTree()
 	{
 		if(!empty(\FS::input()->post()))
 		{
	 		$tree_data['tree_id'] 			=	\FS::input()->post('tree_id');

	 		$tree_data['referral_link'] 	=	AlphaNumeric(10);

	 		$insert_data 					=	insert_data(RL,$tree_data);

	 		if($insert_data)
	 		{
	 			$bdata['status']			=	1;		
	 		}
	 		else
	 		{
	 			$bdata['status']			=	0;		
	 		}
 		}
 		else
 		{
 			$bdata['status']				=	2;
 		}

 		echo json_encode($bdata);
 	} 
}
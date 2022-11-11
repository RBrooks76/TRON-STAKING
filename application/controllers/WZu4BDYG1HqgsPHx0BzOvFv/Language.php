<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends Admin_Controller {

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

		$data['title'] 			= 	'Language Manage';

		$data['result']			=	$getLanguage	=	@get_data(LANG)->result();

		$this->view('pages/Language/manage', $data);
	}

	public function languageupdate($id)
	{
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		$languageupdate 		=	@get_data(LANG,array('id'=>$id))->row();

		if(!empty($languageupdate))
		{
			$languagestatus		=	$languageupdate->status == 1 ? 0 : 1 ;

			$update_data['status']		=	$languagestatus;

			update_data(LANG,$update_data,array('id'=>$id));

			FS::session()->set_flashdata('success' , "Language status updated succesfully !!!");

			admin_redirect('language', 'refresh');
		}
		else
		{
			admin_redirect('language', 'refresh');
		}
	}

	public function updatelanguage($id)
	{
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		if(!empty($this->input->post()))
		{
			$language 					=	escapeString(strip_tags($this->input->post('language')));

			$config['upload_path'] 		= 	FCPATH.'application/language/'.strtolower($language);

			$config['allowed_types'] 	= 	'php';

			$config['overwrite'] 		= 	TRUE;

			$ext 						=	pathinfo($_FILES['new_lang']['name'], PATHINFO_EXTENSION);

			$config['file_name'] 		= 	'app_lang' . '.' . $ext;

			

			$this->load->library('upload', $config);

			$this->upload->initialize($config);

			if (!$this->upload->do_upload('new_lang')) {

				$error = array('error' => $this->upload->display_errors());

				$this->session->set_flashdata('error', $error['error']);

				admin_redirect('language', 'refresh');

			} else {

				$d = $this->upload->data();

				$this->session->set_flashdata('success', "New Language Updated Succesfully !!!");

				admin_redirect('language', 'refresh');
			}
		}
		else
		{
			$lang_name 			=	@get_data(LANG,array('id'=>insep_decode($id)),'lang_name')->row()->lang_name;

			if(!empty($lang_name))
			{
				$data['title'] 		=	'Update Language Content';

				$data['lang_name'] 	=	$lang_name;

				$this->view('pages/Language/edit', $data);
			}
			else
			{
				admin_redirect('language', 'refresh');
			}
		}
	}

	function file_download($language)
    {
    	
        $this->load->helper('download');

        $data 		= 	file_get_contents(FCPATH.'application/language/'.$language."/app_lang.php");

        $name 		=	'app_lang.php';

        force_download($name, $data);
	}
}

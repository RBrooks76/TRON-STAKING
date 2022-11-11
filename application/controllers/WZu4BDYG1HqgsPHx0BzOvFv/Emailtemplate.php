<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailtemplate extends Admin_Controller {

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
		echo "Gfgf";
	}


	function emailmanage() 
	{

		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('7',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

			$data['title'] 			= 	'Email Manage';

			$data['email'] 	=	FS::Common()->getTableData(ET)->result();
						
			$this->view('pages/Emailtemplate/emailmanage', $data);
		
	}


	// Edit page
	function editemail($id='') {

		user_access();
		$user_view = $this->config->item('user_view');
		if(!in_array('7',$user_view)){
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$email_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('emailtemplate', 'refresh');

		}
		$isValid = FS::Common()->getTableData(ET, array('id' => $email_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('emailtemplate', 'refresh');
 
		}
		// Form validation
		$this->form_validation->set_rules('name', 'name', 'required|xss_clean');
		$this->form_validation->set_rules('subject', 'subject', 'required|xss_clean');
		$this->form_validation->set_rules('content_description', 'content', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$updateData = array();
				$name = escapeString(strip_tags($this->input->post('name')));
				$subject = escapeString(strip_tags($this->input->post('subject')));
				$template = escapeString(strip_tags($this->input->post('content_description')));
				$language = escapeString(strip_tags($this->input->post('language')));

				$updateData['name'] = $name;
				$updateData['subject'] = $subject;
				$updateData['template'] = $template;
				$updateData['language'] = $language;
				$condition = array('id' => $email_id);
				
				$update = FS::Common()->updateTableData(ET, $condition, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'Emailtemplate has been updated successfully!');
					admin_redirect('emailtemplate', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this Emailtemplate');
					admin_redirect('emailedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this Emailtemplate');
				admin_redirect('emailedit/' . $id, 'refresh');
			}

		}
		
		$data['action'] 		= 	base_url() . 'editemail';
		$data['title'] 			= 	'Edit Email';
		$data['email'] 	=	FS::Common()->getTableData(ET, array('id' => $email_id))->row();
		$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();		
		$this->view('pages/Emailtemplate/editemail', $data);
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends Admin_Controller {

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


	function videomanage() 
	{
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('14',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

			$data['title'] 			= 	'VIDEO Manage';

			$data['video'] 	=	FS::Common()->getTableData(VIDEO, '', '', '', '', '', '','', array('id', 'DESC'))->result();

			$this->view('pages/Video/videomanage', $data);
		
	}


	// Edit page
	function editvideo($id='') {
		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('14',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$video_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('video', 'refresh');

		}
		$isValid = FS::Common()->getTableData(VIDEO, array('id' => $video_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('video', 'refresh');

		}
		// Form validation
		$this->form_validation->set_rules('title', 'title', 'required|xss_clean');
		$this->form_validation->set_rules('code', 'code', 'required|xss_clean');
		$this->form_validation->set_rules('link', 'link', 'required|xss_clean');
		$this->form_validation->set_rules('status', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$updateData = array();
				$title    = $this->input->post('title');
				$code     = $this->input->post('code');
				$link     = $this->input->post('link');
				$status   = $this->input->post('status');
				$language = $this->input->post('language');
				$updateData['title'] = $title;
				$updateData['code'] = $code;
				$updateData['link'] = $link;
				$updateData['status'] = $status;
				$updateData['language'] = $language;
				$updateData['updated_at'] =  date('Y-m-d H:i:s');;

				$condition = array('id' => $video_id);
				
				$update = FS::Common()->updateTableData(VIDEO, $condition, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'video has been updated successfully!');
					admin_redirect('video', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this video');
					admin_redirect('videoedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this video');
				admin_redirect('videoedit/' . $id, 'refresh');
			}

		}
			$data['action'] 		= 	base_url() . 'editvideo';
			
			$data['title'] 			= 	'Edit video';

			$data['mode'] 			= 	'Edit';

			$data['video'] 	=	FS::Common()->getTableData(VIDEO, array('id' => $video_id))->row();
			$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();

			$this->view('pages/Video/editvideo', $data);
	}



	function deletevideo($id) {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('14',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$video_id = insep_decode($id);

		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('video', 'refresh');
		}
		$isValid = FS::Common()->getTableData(VIDEO, array('id' => $video_id))->num_rows();
		if ($isValid > 0) {
			// Check is valid
			$condition = array('id' => $video_id);
			$delete = FS::Common()->deleteTableData(VIDEO, $condition);
			
			if ($delete) {
				// True // Delete success
				FS::session()->set_flashdata('success', 'video deleted successfully');
				admin_redirect('video', 'refresh');
			} else {
				//False
				FS::session()->set_flashdata('error', 'Problem occure with video deletion');
					admin_redirect('video', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('video', 'refresh');
		}
	}


	function addvideo() {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('14',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Form validation
		$this->form_validation->set_rules('addtitlep', 'title', 'required|xss_clean');
		$this->form_validation->set_rules('addcode', 'code', 'required|xss_clean');
		$this->form_validation->set_rules('addlink', 'link', 'required|xss_clean');
		$this->form_validation->set_rules('addstatus', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('addlanguage', 'addlanguage', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$insertData = array();
				
				$insertData['title'] = $this->input->post('addtitle');				
				$insertData['code'] = $this->input->post('addcode');
				$insertData['link'] = $this->input->post('addlink');
				$insertData['status'] = $this->input->post('addstatus');
				$insertData['language'] = $this->input->post('addlanguage');
				$insertData['created_at'] = strtotime("now");

				$insert = FS::Common()->insertTableData(VIDEO, $insertData);
				if ($insert) {
					FS::session()->set_flashdata('success', 'video has been added successfully!');
				admin_redirect('video', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to add the new video !');
				admin_redirect('video', 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Some data are missing!');
				admin_redirect('video', 'refresh');
			}

		}
		$data['action'] 		= 	base_url() . 'video';
			
		$data['title'] 			= 	'Add video';

		$data['mode'] 			= 	'Add';

		$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();

		$this->view('pages/Video/editvideo', $data);

	}
}

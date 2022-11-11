<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FAQ extends Admin_Controller {

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


	function faqmanage() 
	{
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('5',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

			$data['title'] 			= 	'FAQ Manage';

			$data['faq'] 	=	FS::Common()->getTableData(FAQ, '', '', '', '', '', '','', array('id', 'DESC'))->result();

			$this->view('pages/FAQ/faqmanage', $data);
		
	}


	// Edit page
	function editfaq($id='') {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('5',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$faq_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('faq', 'refresh');

		}
		$isValid = FS::Common()->getTableData(FAQ, array('id' => $faq_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('faq', 'refresh');

		}
		// Form validation
		$this->form_validation->set_rules('question', 'question', 'required|xss_clean');
		$this->form_validation->set_rules('answer', 'answer', 'required|xss_clean');
		$this->form_validation->set_rules('status', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {

				$updateData = array();
				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/FAQ';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['faq_img']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["faq_img"]["name"] != '') {
					if (!$this->upload->do_upload('faq_img')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('faqedit/' . $id, 'refresh');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$configs['maintain_ratio'] = TRUE;
							$configs['width'] = 480;
							$configs['height'] = 315;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->clear();
							$updateData['faq_img'] = $d['file_name'];
						}
					}
				}

				if(!empty($this->input->post('YoutubeLink')))
				{
					$updateData['youtubeLink'] = $this->input->post('YoutubeLink');
				}

				$question =$this->input->post('question');
				$answer = $this->input->post('answer');
				$status = escapeString(strip_tags($this->input->post('status')));
				$language = escapeString(strip_tags($this->input->post('language')));
				$updateData['question'] = $question;
				$updateData['answer'] = $answer;
				$updateData['status'] = $status;
				$updateData['language'] = $language;
				$condition = array('id' => $faq_id);
				
				$update = FS::Common()->updateTableData(FAQ, $condition, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'FAQ has been updated successfully!');
					admin_redirect('faq', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this FAQ');
					admin_redirect('faqedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this FAQ');
				admin_redirect('faqedit/' . $id, 'refresh');
			}

		}
			$data['action'] 		= 	base_url() . 'editfaq';
			
			$data['title'] 			= 	'Edit FAQ';

			$data['mode'] 			= 	'Edit';

			$data['faq'] 	=	FS::Common()->getTableData(FAQ, array('id' => $faq_id))->row();
			$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();
			
			$this->view('pages/FAQ/editfaq', $data);
	}



	function deletefaq($id) {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('5',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$faq_id = insep_decode($id);

		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('faq', 'refresh');
		}
		$isValid = FS::Common()->getTableData(FAQ, array('id' => $faq_id))->num_rows();
		if ($isValid > 0) {
			// Check is valid
			$condition = array('id' => $faq_id);
			$delete = FS::Common()->deleteTableData(FAQ, $condition);
			
			if ($delete) {
				// True // Delete success
				FS::session()->set_flashdata('success', 'Faq deleted successfully');
				admin_redirect('faq', 'refresh');
			} else {
				//False
				FS::session()->set_flashdata('error', 'Problem occure with faq deletion');
					admin_redirect('faq', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('faq', 'refresh');
		}
	}


	function addfaq() {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('5',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Form validation
		$this->form_validation->set_rules('addquestion', 'question', 'required|xss_clean');
		$this->form_validation->set_rules('addanswer', 'answer', 'required');
		$this->form_validation->set_rules('addstatus', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('addlanguage', 'addlanguage', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$insertData = array();
				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/FAQ';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['add_faq_img']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["add_faq_img"]["name"] != '') {
					if (!$this->upload->do_upload('add_faq_img')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('faqedit/' . $id, 'refresh');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$configs['maintain_ratio'] = False;
							$configs['width'] = 480;
							$configs['height'] = 315;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->resize();
							$this->image_lib->clear();
							$insertData['faq_img'] = $d['file_name'];
						}
					}
				}

				if(!empty($this->input->post('addYoutubeLink')))
				{
					$insertData['youtubeLink'] = $this->input->post('addYoutubeLink');
				}

				
				$insertData['question'] = escapeString(strip_tags($this->input->post('addquestion')));				
				$insertData['answer'] = escapeString(strip_tags($this->input->post('addanswer')));
				$insertData['status'] = escapeString(strip_tags($this->input->post('addstatus')));
				$insertData['language'] = escapeString(strip_tags($this->input->post('addlanguage')));
				
				$insert = FS::Common()->insertTableData(FAQ, $insertData);
				if ($insert) {
					FS::session()->set_flashdata('success', 'FAQ has been added successfully!');
				admin_redirect('faq', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to add the new FAQ !');
				admin_redirect('faq', 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Some data are missing!');
				admin_redirect('faq', 'refresh');
			}

		}
		$data['action'] 		= 	base_url() . 'addfaq';
			
		$data['title'] 			= 	'Add FAQ';

		$data['mode'] 			= 	'Add';

		$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();

		$this->view('pages/FAQ/editfaq', $data);

	}
}

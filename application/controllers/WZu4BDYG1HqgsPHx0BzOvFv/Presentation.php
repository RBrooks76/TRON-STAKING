<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presentation extends Admin_Controller {

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


	function presen_manage() 
	{
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('11',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

			$data['title'] 			= 	'Presentation Manage';

			$data['presentation'] 	=	FS::Common()->getTableData(PRESEN, '', '', '', '', '', '','', array('id', 'DESC'))->result();

			$this->view('pages/Presentation/presen_manage', $data);
		
	}


	// Edit page
	function editpresen($id='') {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('11',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$presen_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('presentation', 'refresh');

		}
		$isValid = FS::Common()->getTableData(PRESEN, array('id' => $presen_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('presentation', 'refresh');
		}
		// Form validation
		$this->form_validation->set_rules('title', 'title', 'required|xss_clean');
		
		$this->form_validation->set_rules('status', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$updateData = array();
				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/Presentation/img';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['presen_img']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["presen_img"]["name"] != '') {
					if (!$this->upload->do_upload('presen_img')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('presentation', 'refresh');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$configs['maintain_ratio'] = TRUE;
							$configs['width'] = 200;
							$configs['height'] = 200;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->clear();
							$insertData['image'] = $d['file_name'];
						}
					}
				}


				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/Presentation/doc';
				$config['allowed_types'] = 'doc|pdf|docx|ppt';
				$ext = pathinfo($_FILES['presen_doc']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["presen_doc"]["name"] != '') {
					if (!$this->upload->do_upload('presen_doc')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('presentation', 'refresh');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$insertData['document'] = $d['file_name'];
						}
					}
				}

				$title = escapeString(strip_tags($this->input->post('title')));
				$status = escapeString(strip_tags($this->input->post('status')));
				$language = escapeString(strip_tags($this->input->post('language')));
				$updateData['title'] = $title;
				$updateData['status'] = $status;
				$updateData['language'] = $language;
				$updateData['updated_at'] =  date('Y-m-d H:i:s');;

				$condition = array('id' => $presen_id);
				
				$update = FS::Common()->updateTableData(PRESEN, $condition, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'Presentation has been updated successfully!');
					admin_redirect('presentation', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this Presentation');
					admin_redirect('presen_edit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this Presentation');
				admin_redirect('presen_edit/' . $id, 'refresh');
			}

		}
			$data['action'] 		= 	base_url() . 'editpresen';
			
			$data['title'] 			= 	'Edit Presentation';

			$data['mode'] 			= 	'Edit';

			$data['presen'] 	=	FS::Common()->getTableData(PRESEN, array('id' => $presen_id))->row();
			$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();
			
			$this->view('pages/Presentation/editpresen', $data);
	}



	function deletepresen($id) {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('11',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$presen_id = insep_decode($id);

		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('presentation', 'refresh');
		}
		$isValid = FS::Common()->getTableData(PRESEN, array('id' => $presen_id))->num_rows();
		if ($isValid > 0) {
			// Check is valid
			$condition = array('id' => $presen_id);
			$delete = FS::Common()->deleteTableData(PRESEN, $condition);
			
			if ($delete) {
				// True // Delete success
				FS::session()->set_flashdata('success', 'Presentation deleted successfully');
				admin_redirect('presentation', 'refresh');
			} else {
				//False
				FS::session()->set_flashdata('error', 'Problem occure with Presentation deletion');
					admin_redirect('presentation', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('presentation', 'refresh');
		}
	}


	function addpresen() {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('11',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Form validation
		$this->form_validation->set_rules('addtitle', 'title', 'required|xss_clean');
		$this->form_validation->set_rules('addstatus', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('addlanguage', 'addlanguage', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {

				$insertData = array();
				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/Presentation/img';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['addpresen_img']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["addpresen_img"]["name"] != '') {
					if (!$this->upload->do_upload('addpresen_img')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('presentation', 'refresh');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$configs['maintain_ratio'] = TRUE;
							$configs['width'] = 200;
							$configs['height'] = 200;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->clear();
							$insertData['image'] = $d['file_name'];
						}
					}
				}


				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/Presentation/doc';
				$config['allowed_types'] = 'doc|pdf|docx|ppt';
				$ext = pathinfo($_FILES['addpresen_doc']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["addpresen_doc"]["name"] != '') {
					if (!$this->upload->do_upload('addpresen_doc')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('presentation', 'refresh');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$insertData['document'] = $d['file_name'];
						}
					}
				}
				
				$insertData['title'] = escapeString(strip_tags($this->input->post('addtitle')));				
				$insertData['status'] = escapeString(strip_tags($this->input->post('addstatus')));
				$insertData['language'] = escapeString(strip_tags($this->input->post('addlanguage')));
				$insertData['created_at'] = strtotime("now");

				$insert = FS::Common()->insertTableData(PRESEN, $insertData);
				if ($insert) {
					FS::session()->set_flashdata('success', 'Presentation has been added successfully!');
				admin_redirect('presentation', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to add the new Presentation !');
				admin_redirect('presentation', 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Some data are missing!');
				admin_redirect('presentation', 'refresh');
			}

		}

		$data['action'] 		= 	base_url() . 'addpresen';
			
		$data['title'] 			= 	'Add Presentation';

		$data['mode'] 			= 	'Add';

		$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();

		$this->view('pages/Presentation/editpresen', $data);

	}
}

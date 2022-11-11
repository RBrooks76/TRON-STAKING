<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends Admin_Controller {

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


	function bannermanage() 
	{
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('13',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

			$data['title'] 			= 	'Banner Banner';

			$data['banner'] 	=	FS::Common()->getTableData(BANNER, '', '', '', '', '', '','', array('id', 'DESC'))->result();

			$this->view('pages/Banner/bannermanage', $data);
		
	}


	// Edit page
	function editbanner($id='') {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('13',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$ban_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('banner', 'refresh');

		}
		$isValid = FS::Common()->getTableData(BANNER, array('id' => $ban_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('banner', 'refresh');

		}
		// Form validation
		$this->form_validation->set_rules('link', 'link', 'required|xss_clean');
		$this->form_validation->set_rules('title', 'title', 'required|xss_clean');
		$this->form_validation->set_rules('status', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {

				$updateData = array();
				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/Banner';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['banner_img']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["banner_img"]["name"] != '') {
					if (!$this->upload->do_upload('banner_img')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('banneredit/' . $id, 'refresh');

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
							$updateData['image'] = $d['file_name'];
						}
					}
				}


				
				$link = escapeString(strip_tags($this->input->post('link')));
				$title = escapeString(strip_tags($this->input->post('title')));
				$status = escapeString(strip_tags($this->input->post('status')));
				$language = escapeString(strip_tags($this->input->post('language')));
				$updateData['link'] = $link;
				$updateData['title'] = $title;
				$updateData['status'] = $status;
				$updateData['language'] = $language;
				$updateData['updated_at'] =  date('Y-m-d H:i:s');;
				$condition = array('id' => $ban_id);
				
				$update = FS::Common()->updateTableData(BANNER, $condition, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'Banner has been updated successfully!');
					admin_redirect('banner', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this Banner');
					admin_redirect('banneredit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this Banner');
				admin_redirect('banneredit/' . $id, 'refresh');
			}

		}
			$data['action'] 		= 	base_url() . 'editbanner';
			
			$data['title'] 			= 	'Edit Banner';

			$data['mode'] 			= 	'Edit';

			$data['banner'] 	=	FS::Common()->getTableData(BANNER, array('id' => $ban_id))->row();
			$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();
			
			$this->view('pages/Banner/editbanner', $data);
	}



	function deletebanner($id) {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('13',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$ban_id = insep_decode($id);

		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('banner', 'refresh');
		}
		$isValid = FS::Common()->getTableData(BANNER, array('id' => $ban_id))->num_rows();
		if ($isValid > 0) {
			// Check is valid
			$condition = array('id' => $ban_id);
			$delete = FS::Common()->deleteTableData(BANNER, $condition);
			
			if ($delete) {
				// True // Delete success
				FS::session()->set_flashdata('success', 'Banner deleted successfully');
				admin_redirect('banner', 'refresh');
			} else {
				//False
				FS::session()->set_flashdata('error', 'Problem occure with banner deletion');
					admin_redirect('banner', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('banner', 'refresh');
		}
	}


	function addbanner() {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('13',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Form validation
		$this->form_validation->set_rules('addtitle', 'question', 'required|xss_clean');
		$this->form_validation->set_rules('addlink', 'answer', 'required');
		$this->form_validation->set_rules('addstatus', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('addlanguage', 'addlanguage', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$insertData = array();
				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/Banner';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['addbanner_img']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["addbanner_img"]["name"] != '') {
					if (!$this->upload->do_upload('addbanner_img')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('banner', 'refresh');

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

				
				$insertData['title'] = escapeString(strip_tags($this->input->post('addtitle')));				
				$insertData['link'] = escapeString(strip_tags($this->input->post('addlink')));
				$insertData['status'] = escapeString(strip_tags($this->input->post('addstatus')));
				$insertData['language'] = escapeString(strip_tags($this->input->post('addlanguage')));
				$insertData['created_at'] = strtotime("now");

				
				$insert = FS::Common()->insertTableData(BANNER, $insertData);
				if ($insert) {
					FS::session()->set_flashdata('success', 'Banner has been added successfully!');
				admin_redirect('banner', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to add the new banner !');
				admin_redirect('banner', 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Some data are missing!');
				admin_redirect('banner', 'refresh');
			}

		}
		$data['action'] 		= 	base_url() . 'addbanner';
			
		$data['title'] 			= 	'Add Banner';

		$data['mode'] 			= 	'Add';

		$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();

		$this->view('pages/Banner/editbanner', $data);

	}
}
